<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/13/2016
 * Time: 12:53 AM
 */

namespace SoftUni\Controllers;


use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Services\AuthenticationServiceInterface;
use SoftUni\Services\IslandServiceInterface;
use SoftUni\Services\ResponseServiceInterface;

class IslandController
{
    private $x;
    private $y;
    private $name;
    private $session;
    private $authenticationService;
    private $islandService;
    private $responseService;

    /**
     * IslandController constructor.
     */
    public function __construct(AuthenticationServiceInterface $authenticationService,
                                IslandServiceInterface $islandService,
                                SessionInterface $session,
                                ResponseServiceInterface  $responseService)
    {

        $this->authenticationService = $authenticationService;
        $this->islandService = $islandService;
        $this->session = $session;
        $this->responseService = $responseService;

        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");
        }

    }

    public function changeIsland($islandId){

        $this->session->set('activeIsland',$islandId);
        $this->responseService->redirect("players","profile");
    }



}