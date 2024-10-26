<?php
require_once __DIR__ . '/../models/Event.php';

class EventController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getEventsByGenre($genreId) {
        $event = new Event($this->conn);
        $result = $event->getEventsByGenre($genreId);
        return $result;
    }
}
