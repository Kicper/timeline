<?php
require_once __DIR__ . '/../models/Genre.php';

class GenreController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function showGenres() {
        $genre = new Genre($this->conn);
        $result = $genre->getAllGenres();
        return $result;
    }
}
