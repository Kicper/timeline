<?php
class Album {
    private $conn;
    private $table_name = "albums";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAlbumsByGenre($genreId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE genre_id = :genre_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':genre_id', $genreId);
        $stmt->execute();
        return $stmt;
    }
}