<?php
class Genre
{
    private $conn;
    private $table_name = "genres";

    // Constructor function to initialize the database connection for the Genre class
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Retrieves all genres from the database
    public function getAllGenres()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Retrieves a single genre by its unique ID
    public function getGenreById($genreId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $genreId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Updates an existing genre's colour in the database
    public function updateGenreColor($genreId, $color)
    {
        $query = "UPDATE " . $this->table_name . " SET color = :color WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':id', $genreId);
        return $stmt->execute();
    }
}
