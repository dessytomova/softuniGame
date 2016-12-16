<?php
namespace SoftUni\Controllers;

use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Core\ViewInterface;
use SoftUni\Models\Binding\Players\PlayerLoginBindingModel;
use SoftUni\Models\Binding\Players\PlayerProfileEditBindingModel;
use SoftUni\Models\Binding\Players\PlayerRegisterBindingModel;
use SoftUni\Models\View\ApplicationViewModel;
use SoftUni\Models\View\PlayerProfileEditViewModel;
use SoftUni\Models\View\PlayerProfileViewModel;
use SoftUni\Services\AuthenticationServiceInterface;
use SoftUni\Services\BuildingServicesInterface;
use SoftUni\Services\IslandServiceInterface;
use SoftUni\Services\ResourceServiceInterface;
use SoftUni\Services\ResponseServiceInterface;
use SoftUni\Services\PlayerService;
use SoftUni\Services\PlayerServiceInterface;
use SoftUni\Services\ShipServicesInterface;

class PlayersController
{
    const MIN_X = 1;
    const MAX_X  = 10000;
    const MIN_Y = 1;
    const MAX_Y  = 10000;
    const RADIUS = 10;
    const START_PLANETS = 3;
    const INITIAL_RESOURCES = 400;
    const BUILDING_START_LVL = 0;
    const SHIP_START_AMOUNT = 0;

    private $view;
    private $playerService;
    private $responseService;
    private $authenticationService;
    private $session;
    private $islandService;
    private $resourceService;
    private $buildingServices;
    private $shipServices;


    public function __construct(
        ViewInterface $view,
        PlayerServiceInterface $playerService,
        ResponseServiceInterface $responseService,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        IslandServiceInterface $islandService,
        ResourceServiceInterface $resourceService,
        BuildingServicesInterface $buildingServices,
        ShipServicesInterface $shipServices)
    {
        $this->view = $view;
        $this->playerService = $playerService;
        $this->responseService = $responseService;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->islandService = $islandService;
        $this->resourceService = $resourceService;
        $this->buildingServices = $buildingServices;
        $this->shipServices = $shipServices;
    }

    public function login()
    {
        $this->view->render();
    }

    public function loginPost(PlayerLoginBindingModel $bindingModel )
    {
        $username = $bindingModel->getUsername();
        $password = $bindingModel->getPassword();

        if ($this->playerService->login($username, $password)) {

            $activeIsland = $this->islandService->firstAdded($this->session->get('id'));

            if($activeIsland){
                $this->session->set('activeIsland',$activeIsland);
            }else{
                $this->session->set("error","Island Information Is Missing!" );
                $this->responseService->redirect("players","login");
            }

            $this->responseService->redirect("players", "profile");
        }

        $this->session->set("error","Wrong Username Or Password!");
        $this->responseService->redirect("players","login");
    }

    public function register(ViewInterface $view)
    {
        $viewModel = new ApplicationViewModel("Game");
        $view->render($viewModel);
    }

    public function registerPost(PlayerRegisterBindingModel $bindingModel)
    {
        $username = $bindingModel->getUsername();
        $password = $bindingModel->getPassword();

        if ($this->playerService->register($username, $password)) {

            /////////////////////////////////////////////////////

           $pID = $this->playerService->findByName($username)->getId();

            for($i = 1; $i<=self::START_PLANETS; $i++){

                do {
                    $lastCoordinates = $this->islandService->lastCoordinates(); // get last registered coordinates

                    if(!isset($lastCoordinates['x'])) {
                        $lastCoordinates['x'] = rand(self::MIN_X, self::MAX_X);
                    }
                    if(!isset($lastCoordinates['y'])) {
                        $lastCoordinates['y'] = rand(self::MIN_Y, self::MAX_Y);
                    }

                    do {
                       $x =  intval($lastCoordinates['x'] + self::RADIUS * cos(rand()));
                    } while ($x > self::MAX_X || $x < self::MIN_X);

                    do {
                        $y =  intval($lastCoordinates['y'] + self::RADIUS * sin(rand()));
                    } while ($y > self::MAX_Y || $y < self::MIN_Y);

                    $arr = $this->islandService->checkCoordinates($x, $y);
                }
               while($arr['c']!==null);

                //initiate island
                $name = $username."_".$i;
                $islandCreated = $this->islandService->add($x,$y,$name,$pID);

                if(!$islandCreated){
                    $this->session->set("error","Island Not Created Correctly!" );
                    $this->responseService->redirect("players","login");
                }

                //initiate resources
                $resources = $this->resourceService->findAll();
                $islandID = $this->islandService->lastAdded($pID);

                foreach ($resources as $res){
                    $resourcesCreated = $this->resourceService->addResources($islandID,$res->getId(),self::INITIAL_RESOURCES);
                    if(!$resourcesCreated){
                        $this->session->set("error","Resource Not Created Correctly!" );
                        $this->responseService->redirect("players","login");
                    }
                }

                //initiate buildings
                $buildings = $this->buildingServices->findAll();

                foreach ($buildings as $b){
                    $buildingsCreated = $this->buildingServices->add($islandID,$b->getId(),self::BUILDING_START_LVL);

                    if(!$buildingsCreated){
                        $this->session->set("error","Resource Not Created Correctly!" );
                        $this->responseService->redirect("players","login");
                    }
                }

                $ships = $this->shipServices->findAll();
                //initiate ships
                foreach ($ships as $s){
                    $shipsCreated = $this->shipServices->add($islandID,$s->getId(),self::SHIP_START_AMOUNT);

                    if(!$shipsCreated){
                        $this->session->set("error","Resource Not Created Correctly!" );
                        $this->responseService->redirect("players","login");
                    }
                }

            }
///////////////////////////////////////////////

            $this->responseService->redirect("players", "login");
        }

        $this->session->set("error","Registration Failed!");
        $this->responseService->redirect("players", "register");
    }

    public function profile()
    {
        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");
        }
        $id = $this->authenticationService->getUserId();

        $user = $this->playerService->findOne($id);

        $islands = $this->islandService->findAllIslands($id);
        $island_id = $this->session->get('activeIsland');
        $resourcesForIsland = $this->islandService->findIslandResources($island_id);
        $buildingsForIsland = $this->buildingServices->findAllBuildings($island_id);
        $shipsForIsland = $this->shipServices->findAllShips($island_id);

        $viewModel = new PlayerProfileViewModel();
        $viewModel->setUsername($user->getUsername());
        $viewModel->setId($id);
        $viewModel->setIslands($islands);
        $viewModel->setIslandResources($resourcesForIsland);
        $viewModel->setBuildings($buildingsForIsland);
        $viewModel->setShips($shipsForIsland);


        $this->view->render($viewModel);


    }

    public function profileEdit($id)
    {
        $currentUserId = $this->authenticationService->getUserId();
        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");
        }

        if ($currentUserId !== $id) {

            $this->session->set("error","You're Not Allowed To Edit This Profile!");
            $this->responseService->redirect("players", "profileEdit", [$currentUserId]);
        }

        $user = $this->playerService->findOne($id);

        $viewModel = new PlayerProfileEditViewModel(
            $id,
            $user->getUsername(),
            $user->getPassword(),
            false
        );

        return $this->view->render($viewModel);
    }

    public function profileEditPost($id, PlayerProfileEditBindingModel $bindingModel)
    {
        $currentUserId = $this->authenticationService->getUserId();

        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");
        }

        if ($currentUserId !== $id) {

            $this->responseService->redirect("players", "profileEdit", [$currentUserId]);
        }

        $bindingModel->setId($id);

        $this->playerService->edit($bindingModel);

        $this->responseService->redirect("players", "profile", [$id]);
    }
}