<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/16/2016
 * Time: 4:39 AM
 */

namespace SoftUni\Services;


use SoftUni\Adapter\DatabaseInterface;
use SoftUni\Models\DB\IslandShips;
use SoftUni\Models\DB\Ship;

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
}