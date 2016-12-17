<?php
use SoftUni\Adapter\Database;
use SoftUni\Config\DbConfig;

$dbInstanceName = 'default';

spl_autoload_register(function($class) {
    $class = str_replace("SoftUni\\", "", $class);
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require_once "../".$class . '.php';
});

date_default_timezone_set(\SoftUni\Config\TimezoneConfig::TIMEZONE);

Database::setInstance(DbConfig::DB_HOST, DbConfig::DB_USER, DbConfig::DB_PASS, DbConfig::DB_NAME, $dbInstanceName);

$resourceService = new \SoftUni\Services\ResourceService(Database::getInstance($dbInstanceName));

$incomes = $resourceService->updateAllResources();
/*
foreach ($incomes as $inc){

    $incomePerHour = $resourceService->calculateIncomePerHour($inc->getLevel());
    $lastUpdated = $resourceService->getUpdateTime($inc->getIslandId(), $inc->getResourceId());

    $lastUpdatedS = strtotime($lastUpdated['updated_on']);
    $now = date('Y-m-d H:i:s');

    $differenceInSeconds = strtotime($now) -  $lastUpdatedS ;

    $incomePerSeconds = ($incomePerHour/3600)* $differenceInSeconds;
    $incomePerSeconds = round($incomePerSeconds,3);

    if($differenceInSeconds > 120 && $incomePerSeconds>=0) {
       $res= $resourceService->updateResourceIncome($inc->getIslandId(),$inc->getResourceId(),$incomePerSeconds, $now);
    }

}
*/