<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/14/2016
 * Time: 3:03 AM
 */

namespace SoftUni\Services;


interface BuildingServicesInterface
{
    public function add($island_id, $building_id, $level): bool;
    public function findAll():\Generator;
    public function findAllBuildings($island_id):\Generator;
    public function getBuildingCost($building_id):\Generator;
    public function findBuildingName($building_id):string;
    public function checkValidBuild($playerId, $island_id,$building_id,$nextLevel):array;
    public function updateBuilding($island_id, $building_id, $level): bool;
    public function checkBuildingLevel($island_id,$building_id,$level):bool;

    }