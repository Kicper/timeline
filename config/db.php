<?php
class Database
{
    private $host = "localhost";
    private $db_name = "kicper";
    private $username = "kicper";
    private $password = "Kipulet6!!";
    public $conn;

    // Create connection with the database
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
