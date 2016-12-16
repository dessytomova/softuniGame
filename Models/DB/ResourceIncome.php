<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/15/2016
 * Time: 8:40 PM
 */

namespace SoftUni\Models\DB;


class ResourceIncome
{
    private $island_id;
    private $building_id;
    private $level;
    private $resource_id;

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


}