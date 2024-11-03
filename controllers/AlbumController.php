<?php
require_once __DIR__ . '/../models/Album.php';

class AlbumController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAlbumsByGenre($genreId)
    {
        $album = new Album($this->conn);
        $result = $album->getAlbumsByGenre($genreId);
        return $result;
    }

    public function getAlbumById($albumId)
    {
        $album = new Album($this->conn);
        return $album->getAlbumById($albumId);
    }

    public function createAlbum($data)
    {
        $album = new Album($this->conn);

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

        return $album->createAlbum(
            $data['title'],
            $data['release_date'],
            $data['genre_id'],
            $data['artist_id'],
            $imagePath,
            $data['description']
        );
    }

    public function updateAlbum($id, $data)
    {
        $album = new Album($this->conn);
        $existingAlbum = $album->getAlbumById($id);

        $imagePath = $existingAlbum['cover_image_url'];

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

        $data['cover_image_url'] = $imagePath;

        return $album->updateAlbum($id, $data);
    }

    public function deleteAlbum($albumId)
    {
        $album = new Album($this->conn);
        return $album->deleteAlbum($albumId);
    }
}
