<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/14/2016
 * Time: 4:42 AM
 */

namespace SoftUni\Controllers;

use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Core\ViewInterface;
use SoftUni\Models\DB\BuildingCost;
use SoftUni\Models\View\BuildingAddViewModel;
use SoftUni\Services\AuthenticationServiceInterface;
use SoftUni\Services\BuildingServicesInterface;
use SoftUni\Services\IslandServiceInterface;
use SoftUni\Services\ResourceServiceInterface;
use SoftUni\Services\ResponseServiceInterface;

class BuildingsController
{
    const COEFFICIENT = 0.1;

    private $session;
    private $authenticationService;
    private $responseService;
    private $view;
    private $buildingServices;
    private $islandService;
    private $resourceService;

    public function __construct(AuthenticationServiceInterface $authenticationService,
                                SessionInterface $session,
                                ResponseServiceInterface  $responseService,
                                ViewInterface $view,
                                BuildingServicesInterface $buildingServices,
                                IslandServiceInterface $islandService,ResourceServiceInterface $resourceService)
    {

        $this->authenticationService = $authenticationService;;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->view = $view;
        $this->buildingServices = $buildingServices;
        $this->islandService = $islandService;
        $this->resourceService = $resourceService;

        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");
        }

    }

    public function add($building_id,$level)
    {
        $island_id = $this->session->get('activeIsland');
        $costPerBuilding = $this->buildingServices->getBuildingCost($building_id);
        $name = $this->buildingServices->findBuildingName($building_id);
        $resourcesForIsland = $this->islandService->findIslandResources($island_id);
        $nextLevel = $level + 1;

        $resourcesUpdated = [];
        foreach ($costPerBuilding as $cost){
            $priceCalculated = new BuildingCost();
            $price = $this->calculatePrice($cost->getAmount(),$nextLevel);
            $priceCalculated->setAmount($price);
            $priceCalculated->setResourceName($cost->getResourceName());
            $priceCalculated->setBuildingName($cost->getBuildingName());
            $priceCalculated->setResourceId($cost->getResourceId());
            $resourcesUpdated[] = $priceCalculated;
        }


        $viewModel = new BuildingAddViewModel();
        $viewModel->setCostPerBuiling($resourcesUpdated);
        $viewModel->setName($name);
        $viewModel->setIslandResources($resourcesForIsland);
        $viewModel->setLevel($nextLevel);
        $viewModel->setBuildingId($building_id);
        $viewModel->setIslandId($island_id);

        $this->view->render($viewModel);

    }

    private function calculatePrice($basicPrice,$level){
        return $price = $basicPrice*($level + $level * self::COEFFICIENT);
    }

    public function addPost($building_id,$level){

        $island_id = $this->session->get('activeIsland');
        $playerId = $this->authenticationService->getUserId();
        $buildingExists = $this->buildingServices->checkValidBuild($playerId,$island_id,$building_id,$level);

        if($buildingExists['buildingExists']>0){ //if has permissions to update

            $basicPrice = $this->buildingServices->getBuildingCost($building_id); //get resources needed
            $enoughtResources = []; //resoure_id => amount
            $updatedAmount = []; //keep new amount
            $oldAmount = []; //keep previous amount

            foreach ($basicPrice as $b){
                $resourceID = $b->getResourceId();
                $basicP = $b->getAmount();
                $price = $this->calculatePrice($basicP,$level);
                $availableResource = $this->islandService->availableAmountResource($island_id,$resourceID,$price);


                if($availableResource['amount']>=$price){
                    $enoughtResources[$resourceID]= true;
                    $updatedAmount[$resourceID] = $availableResource['amount'] - $price;
                    $oldAmount[$resourceID] = $availableResource['amount'];
                }
                else{
                    $enoughtResources[$resourceID] = false;
                }
            }

            $hasResource = !(in_array(false,$enoughtResources)); //we have all resources

            if($hasResource){

                foreach ($updatedAmount as $k=>$uAmount){

                    $updateStatus = $this->resourceService->updateResources($island_id,$k,$uAmount);

                    if(!$updateStatus){
                        $this->resourceService->updateResources($island_id,$k,$oldAmount[$k]);
                        $this->session->set("error","Update Issue Occured!");
                        $this->responseService->redirect("players", "profile");
                    }
                }

                if($this->buildingServices->updateBuilding($island_id,$building_id,$level)){

                  //  $this->resourceService->updateResourceUpdateTime($island_id,$resourceID);
                    // TO DO update resource up time
                    $this->responseService->redirect("players","profile");
                }
                else{
                    $this->session->set("error","Update corrupted");
                    $this->responseService->redirect("players", "profile");
                }
            }
            else{
                $this->session->set("error","Not Enougth Resource");
                $this->responseService->redirect("players", "profile");
            }
        }
        else{
            $this->session->set("error","No Permissions To Upgrade");
            $this->responseService->redirect("players", "profile");
        }
    }
}