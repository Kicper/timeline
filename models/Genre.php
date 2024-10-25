<?php
class Genre {
    private $conn;
    private $table_name = "genres";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllGenres() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}