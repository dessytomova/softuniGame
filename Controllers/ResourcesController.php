<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/15/2016
 * Time: 5:19 AM
 */

namespace SoftUni\Controllers;


use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Services\AuthenticationServiceInterface;
use SoftUni\Services\ResourceService;
use SoftUni\Services\ResourceServiceInterface;
use SoftUni\Services\ResponseServiceInterface;

class ResourcesController
{
    const COEFFICIENT_INCOME = 0.1;

    private $authenticationService;
    private $session;
    private $responseService;
    private $resourceService;

    public function __construct(AuthenticationServiceInterface $authenticationService,
                                SessionInterface $session,
                                ResponseServiceInterface  $responseService,
                                ResourceServiceInterface $resourceService)
    {

        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->resourceService = $resourceService;

        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");
        }

    }

    public function add(){

        //var_dump($difference, $this->session->get('activeIsland'));

       /* if($difference > 120){

        }*/
    }

    private function calculateIncomePerHour($level){
        return $income = $level*($level * self::COEFFICIENT);
    }

}