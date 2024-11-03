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

        $imagePath = '';
        if (!empty($_FILES['cover_image']['name'])) {
            $targetDir = __DIR__ . "/../images/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $imagePath = $targetDir . basename($_FILES['cover_image']['name']);
            if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $imagePath)) {
                die("Error: Unable to upload cover image.");
            }
            $imagePath = "images/" . basename($_FILES['cover_image']['name']);
        }

        return $artist->createArtist(
            $data['name'],
            $data['bio'],
            $data['birth_date'],
            $data['death_date'],
            $data['genre'],
            $imagePath
        );
    }

    public function updateArtist($id, $data)
    {
        $artist = new Artist($this->conn);
        $existingArtist = $artist->getArtistById($id);

        $imagePath = $existingArtist['image_url'];

        if (!empty($_FILES['cover_image']['name'])) {
            $targetDir = __DIR__ . "/../images/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $imagePath = $targetDir . basename($_FILES['cover_image']['name']);
            if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $imagePath)) {
                die("Error: Unable to upload cover image.");
            }
            $imagePath = "images/" . basename($_FILES['cover_image']['name']);
        }

        $data['image_url'] = $imagePath;

        return $artist->updateArtist($id, $data);
    }

    public function deleteArtist($artistId)
    {
        $artist = new Artist($this->conn);
        return $artist->deleteArtist($artistId);
    }
}
