<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/13/2016
 * Time: 1:07 AM
 */

namespace SoftUni\Services;

use SoftUni\Adapter\DatabaseInterface;
use SoftUni\Models\DB\Island;
use SoftUni\Models\DB\IslandResource;

class IslandService implements IslandServiceInterface
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }


    public function add($x,$y,$name,$player_id): bool
    {
        $query = "INSERT INTO island(x,y,name,player_id) VALUES(?,?,?,?) ";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$x,$y,$name,$player_id]);
    }

    public function lastCoordinates(){

        $query = "SELECT x, y from island
                  ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result;
    }

    public function checkCoordinates($x,$y){

        $query = "SELECT id as c from island
                 WHERE x = ? and y = ? 
                 LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$x,$y]);

        $result = $stmt->fetch();
        return $result;

    }

    public function findAllIslands($player_id):\Generator
    {
        $query = "SELECT * FROM island
                  WHERE player_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$player_id]);


        while ($result = $stmt->fetchObject(Island::class)) {
            yield $result;
        }
    }

    public function lastAdded($player_id):string{

        $query = "SELECT id  from island
                 WHERE player_id = ?
                 ORDER BY id DESC
                 LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$player_id]);

        $result = $stmt->fetch();
        return $result['id'];
    }


    public function firstAdded($player_id):string{

        $query = "SELECT id  from island
                 WHERE player_id = ?
                 ORDER BY id ASC
                 LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$player_id]);

        $result = $stmt->fetch();
        return $result['id'];
    }


    public function findIslandResources($island_id):\Generator
    {
        $query = "SELECT island_id, resource_id, amount, name FROM island_resources 
                  INNER JOIN resources ON resources.id = island_resources.resource_id
                  WHERE island_resources.island_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$island_id]);

        while ($result = $stmt->fetchObject(IslandResource::class)) {
            yield $result;
        }

    }

    public function availableAmountResource($island_id, $resource_id):array
    {
        $query = "SELECT resource_id, amount  FROM island_resources 
                  WHERE island_resources.island_id = ?
                  AND island_resources.resource_id = ? 
                  ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$island_id,$resource_id]);
        $result = $stmt->fetch();
        if(!$result){
            return [];
        }
        else{
            return $result;
        }
    }



}