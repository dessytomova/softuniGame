<?php
/**
 * Created by PhpStorm.
 * User: desi
 * Date: 12/13/2016
 * Time: 8:11 PM
 */

namespace SoftUni\Services;


use SoftUni\Models\DB\Resource;

interface ResourceServiceInterface
{
    public function findAll():\Generator;
    public function addResources($island_id,$resource_id,$amount): bool;
    public function updateResources($island_id,$resource_id,$amount): bool;
}