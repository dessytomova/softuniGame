<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/17/2016
 * Time: 11:00 PM
 */

namespace SoftUni\Controllers;


use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Core\ViewInterface;
use SoftUni\Models\Binding\Battle\BattleResultsReportBindingModel;
use SoftUni\Models\Binding\Battle\BattleStartPostBindingModel;
use SoftUni\Models\View\BattleResultsViewModel;
use SoftUni\Models\View\BattleStartViewModel;
use SoftUni\Services\AuthenticationServiceInterface;
use SoftUni\Services\BattleSevicesInterface;
use SoftUni\Services\IslandServiceInterface;
use SoftUni\Services\ResponseServiceInterface;
use SoftUni\Services\ShipServicesInterface;

class BattleController
{

    private $authenticationService;
    private $session;
    private $responseService;
    private $view;
    private $shipServices;
    private $islandService;
    private $battleSevices;

    public function __construct(AuthenticationServiceInterface $authenticationService,
                                SessionInterface $session,
                                ResponseServiceInterface  $responseService,
                                ViewInterface $view,
                                ShipServicesInterface $shipServices,
                                IslandServiceInterface $islandService,
                                BattleSevicesInterface $battleSevices)
    {

        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->view = $view;
        $this->shipServices = $shipServices;
        $this->islandService = $islandService;
        $this->battleSevices = $battleSevices;


        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");

        }
    }

    public function start($attackingIsland, $attackedId){

        $shipsForIsland = $this->shipServices->findAllShips($attackingIsland);
        $resourcesForIsland = $this->islandService->findIslandResources($attackingIsland);

        $viewModel = new BattleStartViewModel();
        $viewModel->setName("Start Battle");
        $viewModel->setShipsForIsland($shipsForIsland);
        $viewModel->setResourcesForIsland($resourcesForIsland);
        $viewModel->setAttackedId($attackedId);


        $this->view->render($viewModel);
    }

    public function startPost(BattleStartPostBindingModel $battleStartPostBindingModel){

        $attackedIslandId = $battleStartPostBindingModel->getAttackedId();



        if(!$this->islandService->checkId($attackedIslandId)){
            $this->session->set("error"," Island Not Existing");
            $this->responseService->redirect("players", "profile");
        }

        $islandId = $this->session->get('activeIsland');

        foreach($battleStartPostBindingModel->getShips() as $shipId =>$amount){

            if($this->shipServices->checkId($shipId)['res'] < 1){
                $this->session->set("error"," Ship Not Existing");
                $this->responseService->redirect("players", "profile");
            }

           if(!$this->shipServices->checkShipAvailability($islandId, $shipId, $amount)){
               $this->session->set("error","Sending more ships than existing!");
               $this->responseService->redirect("players", "profile");
           }
        }
        $resultFromBattle = $this->battleSevices->compareFleets($attackedIslandId,$islandId,$battleStartPostBindingModel);

        if(!$this->battleSevices->insertBattleResult($islandId,$attackedIslandId,$resultFromBattle)){
            $this->session->set("error","Battle result not inserted!");
            $this->responseService->redirect("players", "profile");
        }

        $updateBattleRes = $this->battleSevices->updateBattleAward($islandId, $attackedIslandId, $resultFromBattle);

        if($updateBattleRes===false){
            $this->session->set("error","Resourses not updated");
            $this->responseService->redirect("players", "profile");
        }

        $updateShips = $this->battleSevices->updateBattleShips($updateBattleRes,$battleStartPostBindingModel);

        if(!$updateShips){
            $this->session->set("error","Ships not updated");
            $this->responseService->redirect("players", "profile");
        }


        $this->session->set("error","Battle Finished!");

        $this->responseService->redirect("battle","viewReport");

    }

    public function viewReport(){

        $islandId = $this->session->get("activeIsland");
        $battleReport = $this->battleSevices->getBattleResults($islandId);


        $viewModel = new BattleResultsViewModel();
        $viewModel->setName("Battle Report");
        $viewModel->setBattleReport($battleReport);


        $this->view->render($viewModel);
    }
}