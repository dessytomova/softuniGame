<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/17/2016
 * Time: 9:26 PM
 */

namespace SoftUni\Models\View;


class IslandNearEnemiesViewModel
{
    private $islandId;
    private $playerId;
    private $nearestIslands;

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
    public function getPlayerId()
    {
        return $this->playerId;
    }

    /**
     * @param mixed $playerId
     */
    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;
    }

    /**
     * @return mixed
     */
    public function getNearestIslands()
    {
        return $this->nearestIslands;
    }

    /**
     * @param mixed $nearestIslands
     */
    public function setNearestIslands($nearestIslands)
    {
        $this->nearestIslands = $nearestIslands;
    }

}