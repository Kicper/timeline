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

    public function getGenreById($genreId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $genreId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}