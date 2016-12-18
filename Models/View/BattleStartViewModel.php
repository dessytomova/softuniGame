<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/17/2016
 * Time: 11:22 PM
 */

namespace SoftUni\Models\View;


class BattleStartViewModel
{
    private $name;
    private $shipsForIsland;
    private $resourcesForIsland; //getIslandResources
    private $attackedId;

    /**
     * @return mixed
     */
    public function getShipsForIsland()
    {
        return $this->shipsForIsland;
    }

    /**
     * @param mixed $shipsForIsland
     */
    public function setShipsForIsland($shipsForIsland)
    {
        $this->shipsForIsland = $shipsForIsland;
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
        return $this->resourcesForIsland;
    }

    /**
     * @param mixed $resourcesForIsland
     */
    public function setResourcesForIsland($resourcesForIsland)
    {
        $this->resourcesForIsland = $resourcesForIsland;
    }

    /**
     * @return mixed
     */
    public function getAttackedId()
    {
        return $this->attackedId;
    }

    /**
     * @param mixed $attackedId
     */
    public function setAttackedId($attackedId)
    {
        $this->attackedId = $attackedId;
    }


}