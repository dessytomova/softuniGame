<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/18/2016
 * Time: 6:09 AM
 */

namespace SoftUni\Models\View;


class BattleResultsViewModel
{
    private $name;
    private $battleReport;

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
    public function getBattleReport()
    {
        return $this->battleReport;
    }

    /**
     * @param mixed $battleReport
     */
    public function setBattleReport($battleReport)
    {
        $this->battleReport = $battleReport;
    }

}