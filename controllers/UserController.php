<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($username, $password)
    {
        $user = new User($this->conn);
        return $user->login($username, $password);
    }

    public function changePassword($username, $currentPassword, $newPassword)
    {
        $user = new User($this->conn);
        return $user->updatePassword($username, $currentPassword, $newPassword);
    }
}
