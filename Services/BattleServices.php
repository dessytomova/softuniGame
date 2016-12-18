<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/18/2016
 * Time: 2:50 AM
 */

namespace SoftUni\Services;


use SoftUni\Adapter\DatabaseInterface;
use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Models\DB\BattleReport;

class BattleServices implements BattleSevicesInterface
{
    const BATTEL_WIN_COEFFICIENT = 0.5;
    private $db;
    private $shipServices;
    private $islandService;
    private $resourceService;
    private $responseService;
    private $session;

    public function __construct(DatabaseInterface $db,
                                ShipServicesInterface $shipServices,
                                IslandServiceInterface $islandService,
                                ResourceServiceInterface $resourceService,
                                SessionInterface $session,
                                ResponseServiceInterface $responseService)
    {
        $this->db = $db;
        $this->shipServices = $shipServices;
        $this->islandService = $islandService;
        $this->resourceService = $resourceService;
        $this->responseService = $responseService;
        $this->session = $session;
    }

    public function compareFleets($attackedIslandId,$islandId,$battleStartPostBindingModel){

        $attackerFleetHealth = 0;
        $attackerFleetDemage = 0;
        $attackedFleetHealth = 0;
        $attackedFleetDemage = 0;

        foreach($battleStartPostBindingModel->getShips() as $shipId =>$amount){
            $shipInfo = $this->shipServices->getShipInfo($shipId);

            foreach ($shipInfo as $ship){

                $attackerFleetHealth = $attackerFleetHealth + $amount*$ship->getHealth();
                $attackerFleetDemage = $attackerFleetDemage + $amount*$ship->getDemage();
            }
        }

        $attackedShips = $this->shipServices->findAllShips($attackedIslandId);
        foreach ($attackedShips as $attackedShip){
            $attackedFleetHealth = $attackedFleetHealth + $attackedShip->getAmount()*$attackedShip->getHealth();
            $attackedFleetDemage = $attackedFleetDemage + $attackedShip->getAmount()*$attackedShip->getDemage();
        }

        if($attackerFleetDemage ==0){
            $this->session->set("error","Select at least one ship!");
            $this->responseService->redirect("players","profile");

        }
        if($attackerFleetDemage >= $attackedFleetHealth){

            return "Win";
        }
        else if($attackedFleetDemage >= $attackerFleetHealth){

            return "Loss";
        }

        return "Equality";

    }

    public function insertBattleResult($attacker_id, $attacked_id, $result):bool{

        $now = date('Y-m-d H:i:s');

        $query = "INSERT INTO battle_result  (battle_result.attacker_id, battle_result.attacked_id, battle_result.result ,battle_date)
                VALUES (?,?,?,?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$attacker_id, $attacked_id, $result,$now]);

    }

    public function updateBattleAward($attackerIsland_id, $attackedIsland_id, $resultFromBattle){


        $now = date('Y-m-d H:i:s');

        if($resultFromBattle == "Win"){
            $loserIslandId = $attackedIsland_id;
            $winnedIslandId = $attackerIsland_id;
        }
        elseif($resultFromBattle == "Loss"){
            $loserIslandId = $attackerIsland_id;
            $winnedIslandId = $attackedIsland_id;
        }
        else{
            return [];
        }

        $resourcesForAward = $this->islandService->findIslandResources($loserIslandId);

        $updateResult = [];

        foreach($resourcesForAward as $r){

          $winResource = SELF::BATTEL_WIN_COEFFICIENT * $r->getAmount();
            $updateResult[] = $this->resourceService->updateResourceIncome($winnedIslandId,$r->getResourceId(),$winResource,$now);
            $updateResult[] = $this->resourceService->updateResourceIncome($loserIslandId,$r->getResourceId(), ($winResource * (- 1)),$now);
        }


        if(in_array(false,$updateResult)){
            return false;
        }
        return [$winnedIslandId,$loserIslandId];

    }

    public function getBattleResults($island_id):\Generator{

        $query = "SELECT attacker_id,attacked_id,result, battle_date
                    FROM battle_result 
                    WHERE battle_result.attacker_id = ?
                    OR battle_result.attacked_id = ?
                    ORDER BY id DESC
                ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$island_id,$island_id]);


        while ($result = $stmt->fetchObject(BattleReport::class)) {
            yield $result;
        }
    }

    public function updateBattleShips($updateBattleRes,$battleStartPostBindingModel)
    {
        //$winnedIslandId = $updateBattleRes[0];
        $loserIslandId = $updateBattleRes[1];
        $attackerShips = $battleStartPostBindingModel->getShips();

        $attackedShips = $this->shipServices->findAllShips($loserIslandId);

        $res = [];
        foreach ($attackedShips as $attackedShip){
            $res[] = $this->shipServices->updateShipsBattle(0,$loserIslandId,$attackedShip->getShipId());
        }

        if(!in_array(false,$res)){
            return true;
        }
        return false;

    }
}