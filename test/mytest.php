<?php
require_once '../Services/PlayerServiceInterface.php';
require_once '../Controllers/PlayersController.php';
require_once '../Models/Binding/Players/PlayerLoginBindingModel.php';

class PlayerServiceFake implements \SoftUni\Services\PlayerServiceInterface
{
    public function login($username, $password): bool
    {
        return false;
    }

    public function register($username, $password): bool
    {
        return false;
    }
}

$controller = new \SoftUni\Controllers\PlayersController();
try {
        $controller->loginPost(
            new \SoftUni\Models\Binding\Players\PlayerLoginBindingModel(),
            new PlayerServiceFake()
        );
} catch (Exception $e) {
    echo "Test passed. Failed to login with wrong username and password";
}
