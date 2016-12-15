<?php
namespace SoftUni\Services;

use SoftUni\Adapter\DatabaseInterface;
use SoftUni\Models\Binding\Categories\CategoryAddBindingModel;
use SoftUni\Models\DB\Category;

class CategoryService implements CategoryServiceInterface
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }


    public function add(CategoryAddBindingModel $model): bool
    {
        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$model->getName()]);
    }

    /**
     * @return \Generator
     */
    public function findAll()
    {
        $query = "SELECT id, name FROM categories ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();


        while ($result = $stmt->fetchObject(Category::class)) {
            yield $result;
        }
    }
}