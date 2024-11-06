<?php
class User
{
    private $conn;
    private $table_name = "users";

    // Constructor function to initialize the database connection for the User class
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Logs in a user by verifying the username and password
    public function login($username, $password)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }

    // Updates an existing user's password in the database
    public function updatePassword($username, $currentPassword, $newPassword)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['password'])) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE " . $this->table_name . " SET password = :newPassword WHERE username = :username";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':newPassword', $newPasswordHash);
            $updateStmt->bindParam(':username', $username);
            return $updateStmt->execute();
        }
        return false;
    }
}
