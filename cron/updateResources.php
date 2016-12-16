<?php

use SoftUni\Controllers\ResourcesController;
session_start();

spl_autoload_register(function($class) {
    $class = str_replace("SoftUni\\", "", $class);
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require_once $class . '.php';
});
$updateR = new ResourcesController();
$updateR->updateResources();
echo "yoooo";