<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/16/2016
 * Time: 4:14 AM
 */

namespace SoftUni\Controllers;


use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Core\ViewInterface;
use SoftUni\Models\Binding\Ships\ShipsBuyBindingModel;
use SoftUni\Models\DB\IslandResource;
use SoftUni\Models\View\ShipBuyViewModel;
use SoftUni\Services\AuthenticationServiceInterface;
use SoftUni\Services\BuildingServicesInterface;
use SoftUni\Services\IslandServiceInterface;
use SoftUni\Services\ResourceService;
use SoftUni\Services\ResourceServiceInterface;
use SoftUni\Services\ResponseServiceInterface;
use SoftUni\Services\ShipServicesInterface;


class ShipController
{
    const MAX_SHIP_QUALITY = 15;
    private $session;
    private $authenticationService;
    private $responseService;
    private $view;
    private $shipServices;
    private $islandService;
    private $buildingServices;
    private $resourceService;


    public function __construct(AuthenticationServiceInterface $authenticationService,
                                SessionInterface $session,
                                ResponseServiceInterface  $responseService,
                                ViewInterface $view, ShipServicesInterface $shipServices,
                                IslandServiceInterface $islandService,
                                BuildingServicesInterface $buildingServices,
                                ResourceServiceInterface $resourceService)
    {

        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->view = $view;
        $this->shipServices = $shipServices;
        $this->islandService = $islandService;
        $this->buildingServices = $buildingServices;
        $this->resourceService = $resourceService;

        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");

        }

    }

    public function add($ship_id, $name){

        $check = $this->shipServices->checkId($ship_id);

        if($check['res'] < 1){
            $this->session->set("error","Not Existing Ship Category");
            $this->responseService->redirect("players", "profile");
        }


        $costs = $this->shipServices->getShipCost($ship_id);
        $island_id = $this->session->get('activeIsland');
        $resourcesForIsland = $this->islandService->findIslandResources($island_id);
        $buildingRequirements = $this->shipServices->getBuildingRequirements($ship_id);

        $viewModel = new ShipBuyViewModel();
        $viewModel->setId($ship_id);
        $viewModel->setBuildingResources($buildingRequirements);
        $viewModel->setName($name);
        $viewModel->setIslandResources($resourcesForIsland);
        $viewModel->setCost($costs);

        $this->view->render($viewModel);

    }

    public function addPost(ShipsBuyBindingModel $bindingModel){

        if($this->shipServices->checkId($bindingModel->getShipId())['res'] < 1){
            $this->session->set("error","Not Existing Ship Category");
            $this->responseService->redirect("players", "profile");
        }
        if($bindingModel->getQuality() > 15 or $bindingModel->getQuality() < 1){
            $this->session->set("error","Incorrect Ship Amount");
            $this->responseService->redirect("players", "profile");
        }


        $islandID = $this->session->get('activeIsland');
        $buildingRequirements = $this->shipServices->getBuildingRequirements($bindingModel->getShipId());

        //check if we have buildings at desiered levels
        foreach ($buildingRequirements as $buildingR){

            $buildingID = $buildingR->getBuildingId();
            $minBuildingLevel = $buildingR->getLevel();

            $buildingLevelMatch = $this->buildingServices->checkBuildingLevel($islandID,$buildingID,$minBuildingLevel);

            if(!$buildingLevelMatch){
                $this->session->set("error",$buildingR->getBuildingName()." is not at expected level!");
                $this->responseService->redirect("players", "profile");
            }
        }

        $costs = $this->shipServices->getShipCost($bindingModel->getShipId());

        $enoughtResources =[];
        $updatedAmount = []; //keep new amount
        $oldAmount = []; //keep previous amount

        foreach ($costs as $cost){

            $resourceID = $cost->getResourceId();
            $price = $cost->getAmount();
            $priceCalc = $price * $bindingModel->getQuality();

            $availableResource = $this->islandService->availableAmountResource($islandID,$resourceID);

            if($availableResource['amount']>=$priceCalc){
                $enoughtResources[$resourceID]= true;
                $updatedAmount[$resourceID] = $availableResource['amount'] - $priceCalc;
                $oldAmount[$resourceID] = $availableResource['amount'];
            }
            else{
                $enoughtResources[$resourceID] = false;
            }
        }

        $hasResource = !(in_array(false,$enoughtResources)); //we have all resources

        if(!$hasResource){
            $this->session->set("error","Not Enougth Resource");
            $this->responseService->redirect("players", "profile");
        }



        foreach ($updatedAmount as $k=>$uAmount){

            $updateStatus = $this->resourceService->updateResources($islandID,$k,$uAmount);

            if(!$updateStatus){
                $this->resourceService->updateResources($islandID,$k,$oldAmount[$k]);
                $this->session->set("error","Update Issue Occured!");
                $this->responseService->redirect("players", "profile");
            }
        }

        if($this->shipServices->updateShips($bindingModel->getQuality(),$islandID, $bindingModel->getShipId())){
            $this->responseService->redirect("players","profile");
        }
        else{
            $this->session->set("error","Update corrupted");
            $this->responseService->redirect("players", "profile");
        }


    }
}