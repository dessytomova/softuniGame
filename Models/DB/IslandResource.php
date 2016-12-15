<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/14/2016
 * Time: 12:18 AM
 */

namespace SoftUni\Models\DB;


class IslandResource
{
    private $island_id;
    private $resource_id;
    private $amount;
    private $name;

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