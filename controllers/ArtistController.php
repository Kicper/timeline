<?php
require_once __DIR__ . '/../models/Artist.php';

class ArtistController
{
    private $conn;

    // Constructor to initialize the database connection for ArtistController
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Retrieves all artists from the database
    public function getAllArtists()
    {
        $artist = new Artist($this->conn);
        $result = $artist->getAllArtists();
        return $result;
    }

    // Retrieves all artists within a specified genre by genre ID
    public function getArtistsByGenre($genreId)
    {
        $artist = new Artist($this->conn);
        $result = $artist->getArtistsByGenre($genreId);
        return $result;
    }

    // Retrieves a single artist's details by artist ID
    public function getArtistById($artistId)
    {
        $artist = new Artist($this->conn);
        return $artist->getArtistById($artistId);
    }

    // Creates a new artist record in the database
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

    // Updates an existing artist's details in the database
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

    // Deletes an artist record from the database by artist ID
    public function deleteArtist($artistId)
    {
        $artist = new Artist($this->conn);
        return $artist->deleteArtist($artistId);
    }
}
