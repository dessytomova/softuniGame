<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/18/2016
 * Time: 5:57 AM
 */

namespace SoftUni\Models\DB;


class BattleReport
{
    private $attacker_id;
    private $attacked_id;
    private $result;
    private $battle_date;

    /**
     * @return mixed
     */
    public function getAttackerId()
    {
        return $this->attacker_id;
    }

    /**
     * @param mixed $attacker_id
     */
    public function setAttackerId($attacker_id)
    {
        $this->attacker_id = $attacker_id;
    }

    /**
     * @return mixed
     */
    public function getAttackedId()
    {
        return $this->attacked_id;
    }

    /**
     * @param mixed $attacked_id
     */
    public function setAttackedId($attacked_id)
    {
        $this->attacked_id = $attacked_id;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getBattleDate()
    {
        return $this->battle_date;
    }

    /**
     * @param mixed $battle_date
     */
    public function setBattleDate($battle_date)
    {
        $this->battle_date = $battle_date;
    }


}