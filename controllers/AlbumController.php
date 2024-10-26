<?php
require_once __DIR__ . '/../models/Album.php';

class AlbumController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAlbumsByGenre($genreId) {
        $album = new Album($this->conn);
        $result = $album->getAlbumsByGenre($genreId);
        return $result;
    }
}
