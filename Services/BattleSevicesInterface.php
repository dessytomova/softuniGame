<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/18/2016
 * Time: 2:51 AM
 */

namespace SoftUni\Services;


interface BattleSevicesInterface
{
    public function compareFleets($attackedIslandId,$islandId,$battleStartPostBindingModel);
    public function insertBattleResult($attacker_id, $attacked_id, $result):bool;
    public function updateBattleAward($attackerIsland_id, $attackedIsland_id, $resultFromBattle);
    public function getBattleResults($island_id):\Generator;

    }