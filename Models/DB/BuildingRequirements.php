<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/16/2016
 * Time: 10:18 PM
 */

namespace SoftUni\Models\DB;


class BuildingRequirements
{

    private $ship_id;
    private $building_id;
    private $level;
    private $ship_name;
    private $building_name;

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
    public function getBuildingId()
    {
        return $this->building_id;
    }

    /**
     * @param mixed $building_id
     */
    public function setBuildingId($building_id)
    {
        $this->building_id = $building_id;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getShipName()
    {
        return $this->ship_name;
    }

    /**
     * @param mixed $ship_name
     */
    public function setShipName($ship_name)
    {
        $this->ship_name = $ship_name;
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





}