<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $conn;

    // Constructor to initialize the database connection for UserController
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Authenticates a user by verifying their username and password
    public function login($username, $password)
    {
        $user = new User($this->conn);
        return $user->login($username, $password);
    }

    // Changes the user's password if the current password is correct
    public function changePassword($username, $currentPassword, $newPassword)
    {
        $user = new User($this->conn);
        return $user->updatePassword($username, $currentPassword, $newPassword);
    }
}
