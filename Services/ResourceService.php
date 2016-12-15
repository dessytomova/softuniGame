<?php
namespace SoftUni\Services;

use SoftUni\Adapter\DatabaseInterface;
use SoftUni\Models\DB\Resource;



class ResourceService implements ResourceServiceInterface {

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

}