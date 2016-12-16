<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/16/2016
 * Time: 4:39 AM
 */

namespace SoftUni\Services;


interface ShipServicesInterface
{
    public function findAll():\Generator;

    public function add($island_id, $ship_id, $amount): bool;

    public function findAllShips($island_id):\Generator;

}