<?php
namespace SoftUni\Services;

interface ResponseServiceInterface
{
    public function redirect($controller, $action, array $params = []);
    public function redirect_static($static_page);
}