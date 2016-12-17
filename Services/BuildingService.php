<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/14/2016
 * Time: 3:04 AM
 */

namespace SoftUni\Services;


use SoftUni\Adapter\DatabaseInterface;
use SoftUni\Controllers\ResourcesController;
use SoftUni\Core\ViewInterface;
use SoftUni\Models\DB\Building;
use SoftUni\Models\DB\BuildingCost;
use SoftUni\Models\DB\IslandBuildings;

class BuildingService implements BuildingServicesInterface
{
    private $db;
    private $resourceService;


    public function __construct(DatabaseInterface $db, ResourceServiceInterface $resourceService)
    {
        $this->db = $db;
        $this->resourceService = $resourceService;
    }

    public function add($island_id, $building_id, $level): bool
    {
        $query = "INSERT INTO island_buldings(island_id,building_id,level) VALUES(?,?,?) ";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$island_id,$building_id,$level]);
    }

    public function findAll():\Generator
    {
        $query = "SELECT id, name FROM buildings ORDER BY id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($result = $stmt->fetchObject(Building::class)) {
            yield $result;
        }
    }

    public function findAllBuildings($island_id):\Generator
    {
        $query = "SELECT island_buldings.id,island_id,building_id,level,buildings.name FROM island_buldings
                  INNER JOIN buildings on buildings.id = island_buldings.building_id
                  WHERE island_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$island_id]);


        while ($result = $stmt->fetchObject(IslandBuildings::class)) {
            yield $result;
        }
    }

    public function getBuildingCost($building_id):\Generator{
        $query = "SELECT building_cost_resources.resource_id, building_cost_resources.amount, buildings.name as building_name, resources.name as resource_name FROM building_cost_resources
        INNER JOIN buildings ON buildings.id = building_cost_resources.building_id
        INNER JOIN resources ON resources.id = building_cost_resources.resource_id
        WHERE building_cost_resources.building_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$building_id]);

        while ($result = $stmt->fetchObject(BuildingCost::class)) {
            yield $result;
        }
    }

    public function findBuildingName($building_id):string
    {
        $query = "SELECT buildings.name FROM  buildings 
                  WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$building_id]);
        $result = $stmt->fetch();

        if(!$result){
            return '';
        }
        return $result['name'];
    }

    public function checkValidBuild($playerId, $island_id,$building_id,$nextLevel):array{
        $prevLevel = $nextLevel -1;
        $query = "SELECT count(island_buldings.id) as buildingExists FROM island
                INNER JOIN island_buldings ON island_buldings.island_id = island.id
                WHERE island.player_id  = ?
                AND island_buldings.building_id = ?
                AND island_buldings.island_id = ?
                AND level = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$playerId,$building_id,$island_id,$prevLevel]);
        $result = $stmt->fetch();

        return $result;

    }

    public function updateBuilding($island_id, $building_id, $level): bool
    {

        $this->resourceService->updateAllResources();

        $query = "UPDATE  island_buldings SET level = ?
                  WHERE island_buldings.island_id = ? 
                  and island_buldings.building_id = ?  ";
        $stmt = $this->db->prepare($query);


        return $stmt->execute([$level, $island_id,$building_id]);
    }

    public function checkBuildingLevel($island_id,$building_id,$level):bool{

        $query = "SELECT count(id) as res FROM island_buldings 
                WHERE island_buldings.island_id = ?
                AND island_buldings.building_id = ?
                AND island_buldings.`level` >= ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$island_id,$building_id,$level]);

        $result = $stmt->fetch();

        if($result['res'] >=1){
            return true;
        }
        else{
            return false;
        }



    }
}