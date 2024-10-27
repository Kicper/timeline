<?php
require_once __DIR__ . '/../models/Artist.php';

class ArtistController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getArtistsByGenre($genreId) {
        $artist = new Artist($this->conn);
        $result = $artist->getArtistsByGenre($genreId);
        return $result;
    }

    public function getArtistById($artistId) {
        $artist = new Artist($this->conn);
        return $artist->getArtistById($artistId);
    }
}
