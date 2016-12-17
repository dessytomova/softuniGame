<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/17/2016
 * Time: 2:07 AM
 */

namespace SoftUni\Models\Binding\Ships;



class ShipsBuyBindingModel
{
    private $ship_id;
    private $quality;

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
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param mixed $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }


}