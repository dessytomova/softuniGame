<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/17/2016
 * Time: 9:20 PM
 */

namespace SoftUni\Models\DB;


class IslandBattle
{
    private $island_id;
    private $x;
    private $y;
    private $name;
    private $player_id;
    private $distance;

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
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y)
    {
        $this->y = $y;
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
    public function getPlayerId()
    {
        return $this->player_id;
    }

    /**
     * @param mixed $player_id
     */
    public function setPlayerId($player_id)
    {
        $this->player_id = $player_id;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }


}