<?php
namespace SoftUni\Services;

use SoftUni\Adapter\DatabaseInterface;
use SoftUni\Models\DB\Resource;
use SoftUni\Models\DB\ResourceIncome;


class ResourceService implements ResourceServiceInterface {


    const COEFFICIENT_INCOME = 0.1;
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function findAll():\Generator
    {
        $query = "SELECT id, name FROM resources ORDER BY id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($result = $stmt->fetchObject(Resource::class)) {
            yield $result;
        }
    }

    public function addResources($island_id,$resource_id,$amount): bool
    {
        $query = "INSERT INTO island_resources(island_id,resource_id,amount) VALUES(?,?,?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$island_id,$resource_id,$amount]);
    }

    public function updateResources($island_id,$resource_id,$amount): bool
    {
        $query = "UPDATE island_resources SET amount = ? 
                  WHERE island_id =?
                  AND resource_id = ?";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([$amount,$island_id,$resource_id]);
    }

    public function getIncomeBase():\Generator{

        $query = "SELECT island_buldings.island_id as island_id, island_buldings.building_id as building_id, 
        island_buldings.level as level ,building_resource_income.resource_id as resource_id 
        FROM island_buldings
        INNER JOIN building_resource_income ON building_resource_income.building_id = island_buldings.building_id
        ORDER BY island_buldings.island_id ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($result = $stmt->fetchObject(ResourceIncome::class)) {
            yield $result;
        }
    }

    public function calculateIncomePerHour($level):float {
        return $income = $level+($level * self::COEFFICIENT_INCOME);
    }

    public function updateResourceIncome($island_id, $resource_id, $income,$date):bool{

        $query = "UPDATE island_resources SET updated_on = ?,
                  amount = (amount + ?)
                  WHERE island_resources.island_id = ?
                  AND island_resources.resource_id = ?
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $res = $stmt->execute([$date,$income,$island_id,$resource_id]);

        return $res;

    }

    public function getUpdateTime($island_id, $resource_id){

        $query = "SELECT updated_on FROM island_resources
                    WHERE island_resources.island_id = ?
                    AND island_resources.resource_id = ?
                    ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$island_id,$resource_id]);
        $res = $stmt->fetch();

        return $res;
    }

}