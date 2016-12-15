<?php
namespace SoftUni\Services;

use SoftUni\Models\Binding\Players\PlayerProfileEditBindingModel;
use SoftUni\Models\DB\Player;

interface PlayerServiceInterface
{
    public function login($username, $password): bool;

    public function register($username, $password): bool;

    public function findOne($id): Player;

    public function findByName($username): Player;

    public function edit(PlayerProfileEditBindingModel $model): bool;

}