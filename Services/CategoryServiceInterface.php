<?php


namespace SoftUni\Services;


use SoftUni\Models\Binding\Categories\CategoryAddBindingModel;

interface CategoryServiceInterface
{
    public function add(CategoryAddBindingModel $model): bool;

    public function findAll();
}