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
use SoftUni\Services\AuthenticationServiceInterface;
use SoftUni\Services\ResponseServiceInterface;

class ShipController
{
    private $session;
    private $authenticationService;
    private $responseService;
    private $view;


    public function __construct(AuthenticationServiceInterface $authenticationService,
                                SessionInterface $session,
                                ResponseServiceInterface  $responseService,
                                ViewInterface $view)
    {

        $this->authenticationService = $authenticationService;;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->view = $view;

        if(!$this->authenticationService->isAuthenticated()) {

            $this->session->set("error","You Have To Login First!");
            $this->responseService->redirect("players", "login");
        }

    }
}