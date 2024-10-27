<?php
class Event {
    private $conn;
    private $table_name = "music_events";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getEventsByGenre($genreId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE genre_id = :genre_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':genre_id', $genreId);
        $stmt->execute();
        return $stmt;
    }

    public function getEventById($eventId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $eventId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}