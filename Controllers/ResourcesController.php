<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/15/2016
 * Time: 5:19 AM
 */

namespace SoftUni\Controllers;


use SoftUni\Config\TimezoneConfig;
use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Core\ViewInterface;
use SoftUni\Services\AuthenticationServiceInterface;
use SoftUni\Services\ResourceService;
use SoftUni\Services\ResourceServiceInterface;
use SoftUni\Services\ResponseServiceInterface;

class ResourcesController
{

    private $authenticationService;
    private $session;
    private $responseService;
    private $resourceService;
    private $view;

    public function __construct(AuthenticationServiceInterface $authenticationService,
                                SessionInterface $session,
                                ResponseServiceInterface  $responseService,
                                ResourceServiceInterface $resourceService,
                                ViewInterface $view)
    {

        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->resourceService = $resourceService;
        $this->view = $view;

        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");
        }

    }

    public function updateResources(){

        $incomes = $this->resourceService->getIncomeBase();

        foreach ($incomes as $inc){

            $incomePerHour = $this->resourceService->calculateIncomePerHour($inc->getLevel());
            $lastUpdated = $this->resourceService->getUpdateTime($inc->getIslandId(), $inc->getResourceId());
            $lastUpdatedS = strtotime($lastUpdated['updated_on']);
            $now = date('Y-m-d H:i:s');

            $differenceInSeconds = strtotime($now) -  $lastUpdatedS ;
            $incomePerSeconds = ($incomePerHour/3600)* $differenceInSeconds;
            $incomePerSeconds = round($incomePerSeconds,3);

            if($differenceInSeconds > 120 && $incomePerSeconds>0) {
                $res= $this->resourceService->updateResourceIncome($inc->getIslandId(),$inc->getResourceId(),$incomePerSeconds, $now);
            }

        }

    }

}