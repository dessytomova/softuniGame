<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/14/2016
 * Time: 5:05 AM
 */

namespace SoftUni\Models\View;


class BuildingAddViewModel
{
    private $id;
    private $costPerBuiling;
    private $name;
    private $islandResources;
    private $level;
    private $buildingId;
    private $islandId;

    /**
     * @return mixed
     */
    public function getIslandId()
    {
        return $this->islandId;
    }

    /**
     * @param mixed $islandId
     */
    public function setIslandId($islandId)
    {
        $this->islandId = $islandId;
    }


    /**
     * @return mixed
     */
    public function getBuildingId()
    {
        return $this->buildingId;
    }

    /**
     * @param mixed $buildingId
     */
    public function setBuildingId($buildingId)
    {
        $this->buildingId = $buildingId;
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
    public function getCostPerBuiling()
    {
        return $this->costPerBuiling;
    }

    /**
     * @param mixed $costPerBuiling
     */
    public function setCostPerBuiling($costPerBuiling)
    {
        $this->costPerBuiling = $costPerBuiling;
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