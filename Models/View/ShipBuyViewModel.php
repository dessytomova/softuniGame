<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/16/2016
 * Time: 11:02 PM
 */

namespace SoftUni\Models\View;


class ShipBuyViewModel
{
    private $id;
    private $buildingResources;
    private $name;
    private $islandResources;
    private $cost;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBuildingResources()
    {
        return $this->buildingResources;
    }

    /**
     * @param mixed $buildingResources
     */
    public function setBuildingResources($buildingResources)
    {
        $this->buildingResources = $buildingResources;
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

    /**
     * @return mixed
     */
    public function getIslandResources()
    {
        return $this->islandResources;
    }

    /**
     * @param mixed $islandResources
     */
    public function setIslandResources($islandResources)
    {
        $this->islandResources = $islandResources;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

}