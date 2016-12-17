<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/16/2016
 * Time: 4:39 AM
 */

namespace SoftUni\Services;


use SoftUni\Adapter\DatabaseInterface;
use SoftUni\Models\DB\BuildingRequirements;
use SoftUni\Models\DB\IslandResource;
use SoftUni\Models\DB\IslandShips;
use SoftUni\Models\DB\Ship;
use SoftUni\Models\DB\ShipCost;

class ShipServices implements ShipServicesInterface
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function findAll():\Generator
    {
        $query = "SELECT id, name FROM ships ORDER BY id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($result = $stmt->fetchObject(Ship::class)) {
            yield $result;
        }
    }

    public function checkId($ship_id):array
    {
        $query = "SELECT count(id) as res FROM ships WHERE id = ? ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$ship_id]);

        return $result = $stmt->fetch();

    }

    public function add($island_id, $ship_id, $amount): bool
    {
        $query = "INSERT INTO islands_ships(island_id,ship_id,amount) VALUES(?,?,?) ";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$island_id,$ship_id,$amount]);
    }

    public function findAllShips($island_id):\Generator
    {
        $query = "SELECT ship_id,island_id,amount,ships.name FROM islands_ships     
				  INNER JOIN ships on ships.id = islands_ships.ship_id
                  WHERE island_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$island_id]);


        while ($result = $stmt->fetchObject(IslandShips::class)) {
            yield $result;
        }
    }

    public function getBuildingRequirements($island_id):\Generator
    {
        $query = "SELECT 
            ship_buildings.ship_id, ship_buildings.building_id, ship_buildings.level, 
            ships.name as ship_name, buildings.name  as building_name
            FROM ship_buildings
            INNER JOIN ships ON ship_buildings.ship_id =  ships.id
            INNER JOIN buildings ON buildings.id = ship_buildings.building_id
            WHERE ship_buildings.ship_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$island_id]);


        while ($result = $stmt->fetchObject(BuildingRequirements::class)) {
            yield $result;
        }

    }

    public function getShipCost($ship_id):\Generator{

        $query = "SELECT ship_id, resource_id, amount, name FROM ships_cost_resources
                INNER JOIN resources ON resources.id = ships_cost_resources.resource_id
                WHERE ship_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$ship_id]);

        while ($result = $stmt->fetchObject(ShipCost::class)) {
            yield $result;
        }
    }

    public function updateShips($amount, $island_id, $ship_id): bool
    {
        if($amount > 0){
            $query = "UPDATE  islands_ships SET islands_ships.amount = (amount+ ?)
                      WHERE islands_ships.island_id = ? 
                      and islands_ships.ship_id = ?  ";
            $stmt = $this->db->prepare($query);


            return $stmt->execute([$amount, $island_id, $ship_id]);
        }
        return false;
    }

}