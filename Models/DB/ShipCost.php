<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/17/2016
 * Time: 12:43 AM
 */

namespace SoftUni\Models\DB;


class ShipCost
{
    private $ship_id;
    private $resource_id;
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
    public function getResourceId()
    {
        return $this->resource_id;
    }

    /**
     * @param mixed $resource_id
     */
    public function setResourceId($resource_id)
    {
        $this->resource_id = $resource_id;
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