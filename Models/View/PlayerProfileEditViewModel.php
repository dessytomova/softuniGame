<?php
namespace SoftUni\Models\View;

class PlayerProfileEditViewModel
{
    private $id;
    private $username;
    private $password;
   /* private $email;
    private $birthday;
    private $isForeignEdit;*/

    /**
     * PlayerProfileEditViewModel constructor.
     * @param $username
     * @param $password
     * @param $email
     * @param $birthday
     */
    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        /*$this->email = $email;
        $this->birthday = $birthday;
        $this->isForeignEdit = $isForeignEdit;*/
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

 

}