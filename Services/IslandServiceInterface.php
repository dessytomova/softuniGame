<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/13/2016
 * Time: 1:07 AM
 */

namespace SoftUni\Services;


use SoftUni\Models\DB\Island;

interface IslandServiceInterface
{
    public function add($x,$y,$name,$player_id);
    public function checkCoordinates($x,$y);
    public function lastCoordinates();
    public function findAllIslands($player_id):\Generator;
    public function lastAdded($player_id):string;
    public function firstAdded($player_id):string;
    public function findIslandResources($island_id):\Generator;
    public function availableAmountResource($island_id, $resource_id):array;

}