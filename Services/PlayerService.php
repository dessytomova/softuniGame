<?php
namespace SoftUni\Services;

use SoftUni\Adapter\Database;
use SoftUni\Adapter\DatabaseInterface;
use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Models\Binding\Players\PlayerProfileEditBindingModel;
use SoftUni\Models\DB\Player;

class PlayerService implements PlayerServiceInterface
{
    /**
     * @var Database
     */
    private $db;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var EncryptionServiceInterface
     */
    private $encryptionService;


    public function __construct(DatabaseInterface $db,
                                SessionInterface $session,
                                EncryptionServiceInterface $encryptionService)
    {
        $this->db = $db;
        $this->session = $session;
        $this->encryptionService = $encryptionService;

    }

    public function login($username, $password): bool
    {
        $query = "SELECT id, username, password FROM players 
          WHERE username = ?
          LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$username]);

        /** @var Player $user */
        $user = $stmt->fetchObject(Player::class);

        if ($user == null) {
            return false;
        }

        $hash = $user->getPassword();

        if ($this->encryptionService->verify($password, $hash)) {
            $this->session->set('id', $user->getId());
            return true;
        }

        return false;
    }

    public function register($username, $password): bool
    {
        $query = "INSERT INTO players (username, password) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);

        $res = $stmt->execute(
            [
                $username,
                $this->encryptionService->hash($password)
            ]
        );

        return $res;
    }

    public function findOne($id):Player
    {
        $query = "
          SELECT 
              id, username, password
          FROM 
            players 
          WHERE 
            id = ?
          LIMIT 1";


        $stmt = $this->db->prepare($query);
        $stmt->execute(
            [
                $id
            ]
        );

        /** @var Player $user */
        $user = $stmt->fetchObject(Player::class);

        return $user;
    }

    public function findByName($username):Player
    {
        $query = "
          SELECT 
              id, username, password
          FROM 
            players 
          WHERE 
            username = ?
          LIMIT 1";


        $stmt = $this->db->prepare($query);
        $stmt->execute(
            [
                $username
            ]
        );

        /** @var Player $user */
        $user = $stmt->fetchObject(Player::class);

        return $user;
    }

    public function edit(PlayerProfileEditBindingModel $model): bool
    {
        if ($model->getPassword() != $model->getConfirmPassword()){
            return false;
        }

        $query = "
           UPDATE players
           SET username = ?, password = ?
           WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);
        return $stmt->execute(
            [
                $model->getUsername(),
                $this->encryptionService->hash($model->getPassword()),
                $model->getId()
            ]
        );

    }
}