<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/16/2016
 * Time: 5:01 AM
 */

namespace SoftUni\Models\DB;


class IslandShips
{
    private $ship_id;
    private $island_id;
    private $amount;
    private $name;

    /**
     * @return mixed
     */
    public function getShipId()
    {
        return $this->ship_id;
    }

    /**
     * @param mixed $ship_id
     */
    public function setShipId($ship_id)
    {
        $this->ship_id = $ship_id;
    }

    /**
     * @return mixed
     */
    public function getIslandId()
    {
        return $this->island_id;
    }

    /**
     * @param mixed $island_id
     */
    public function setIslandId($island_id)
    {
        $this->island_id = $island_id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}