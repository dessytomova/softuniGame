<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/14/2016
 * Time: 4:04 AM
 */

namespace SoftUni\Models\DB;


class IslandBuildings
{
    private $id;
    private $island_id;
    private $building_id;
    private $level;
    private $name;

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