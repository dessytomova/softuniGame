<?php
namespace SoftUni\Models\View;

class PlayerProfileViewModel
{
    private $id;
    private $username;
    private $islands;
    private $islandResources;
    private $buildings;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
    public function getIslands()
    {
        return $this->islands;
    }

    /**
     * @param mixed $islands
     */
    public function setIslands($islands)
    {
        $this->islands = $islands;
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
    public function getBuildings()
    {
        return $this->buildings;
    }

    /**
     * @param mixed $buildings
     */
    public function setBuildings($buildings)
    {
        $this->buildings = $buildings;
    }

}