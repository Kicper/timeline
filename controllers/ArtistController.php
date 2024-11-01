<?php
require_once __DIR__ . '/../models/Artist.php';

class ArtistController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllArtists()
    {
        $artist = new Artist($this->conn);
        $result = $artist->getAllArtists();
        return $result;
    }

    public function getArtistsByGenre($genreId)
    {
        $artist = new Artist($this->conn);
        $result = $artist->getArtistsByGenre($genreId);
        return $result;
    }

    public function getArtistById($artistId)
    {
        $artist = new Artist($this->conn);
        return $artist->getArtistById($artistId);
    }

    public function createArtist($data)
    {
        $artist = new Artist($this->conn);
        return $artist->createArtist(
            $data['name'],
            $data['bio'],
            $data['birth_date'],
            $data['death_date'],
            $data['genre'],
            $data['image_url']
        );
    }

    public function updateArtist($id, $data)
    {
        $artist = new Artist($this->conn);
        return $artist->updateArtist($id, $data);
    }
}
