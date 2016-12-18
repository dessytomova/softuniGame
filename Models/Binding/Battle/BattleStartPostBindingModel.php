<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/18/2016
 * Time: 12:31 AM
 */

namespace SoftUni\Models\Binding\Battle;


    class BattleStartPostBindingModel
    {
        private $ships;
        private $attackedId;


        /**
         * @return mixed
         */
        public function getShips()
        {
            return $this->ships;
        }

        /**
         * @param mixed $ships
         */
        public function setShips($ships)
        {
            $this->ships = $ships;
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
