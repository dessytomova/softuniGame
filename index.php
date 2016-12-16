<?php
use SoftUni\Adapter\Database;
use SoftUni\Config\DbConfig;

session_start();

spl_autoload_register(function($class) {
    $class = str_replace("SoftUni\\", "", $class);
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require_once $class . '.php';
});

date_default_timezone_set(\SoftUni\Config\TimezoneConfig::TIMEZONE);

$uri = $_SERVER['REQUEST_URI'];
$self = $_SERVER['PHP_SELF'];
$self = str_replace("index.php", "", $self);
$uri = str_replace($self, "", $uri);
$args = explode("/", $uri);
$controllerName = array_shift($args);
$actionName = array_shift($args);

$actionName = ($actionName===null)?'':$actionName;

$dbInstanceName = 'default';

Database::setInstance(DbConfig::DB_HOST, DbConfig::DB_USER, DbConfig::DB_PASS, DbConfig::DB_NAME, $dbInstanceName);


$mvcContext = new \SoftUni\Core\MVC\MVCContext($controllerName, $actionName, $self, $args);

$responseService = new \SoftUni\Services\ResponseService($mvcContext);

$app = new \SoftUni\Core\Application($mvcContext,$responseService);

$app->addClass(\SoftUni\Core\MVC\MVCContextInterface::class, $mvcContext);

$app->addClass(\SoftUni\Adapter\DatabaseInterface::class, Database::getInstance($dbInstanceName));

$app->addClass(\SoftUni\Core\MVC\SessionInterface::class, new \SoftUni\Core\MVC\Session($_SESSION));

$app->registerDependency(\SoftUni\Core\ViewInterface::class, \SoftUni\Core\View::class);
$app->registerDependency(\SoftUni\Services\PlayerServiceInterface::class, \SoftUni\Services\PlayerService::class);
$app->registerDependency(\SoftUni\Services\EncryptionServiceInterface::class, \SoftUni\Services\BCryptEncryptionService::class);
$app->registerDependency(\SoftUni\Services\AuthenticationServiceInterface::class, \SoftUni\Services\AuthenticationService::class);
$app->registerDependency(\SoftUni\Services\ResponseServiceInterface::class, \SoftUni\Services\ResponseService::class);
$app->registerDependency(\SoftUni\Services\IslandServiceInterface::class,\SoftUni\Services\IslandService::class);
$app->registerDependency(\SoftUni\Services\ResourceServiceInterface::class,\SoftUni\Services\ResourceService::class);
$app->registerDependency(\SoftUni\Services\BuildingServicesInterface::class,\SoftUni\Services\BuildingService::class);
$app->registerDependency(\SoftUni\Services\ShipServicesInterface::class,\SoftUni\Services\ShipServices::class);
$app->start();







