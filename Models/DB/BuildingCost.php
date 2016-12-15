<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/14/2016
 * Time: 5:19 PM
 */

namespace SoftUni\Models\DB;


class BuildingCost
{
    private $resource_id;
    private $amount;
    private $building_name;
    private $resource_name;



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
    public function getBuildingName()
    {
        return $this->building_name;
    }

    /**
     * @param mixed $building_name
     */
    public function setBuildingName($building_name)
    {
        $this->building_name = $building_name;
    }

    /**
     * @return mixed
     */
    public function getResourceName()
    {
        return $this->resource_name;
    }

    /**
     * @param mixed $resource_name
     */
    public function setResourceName($resource_name)
    {
        $this->resource_name = $resource_name;
    }


}