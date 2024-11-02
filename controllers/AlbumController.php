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
        return $album->createAlbum(
            $data['title'],
            $data['release_date'],
            $data['genre_id'],
            $data['artist_id'],
            $data['cover_image_url'],
            $data['description']
        );
    }

    public function updateAlbum($id, $data)
    {
        $album = new Album($this->conn);
        return $album->updateAlbum($id, $data);
    }

    public function deleteAlbum($albumId)
    {
        $album = new Album($this->conn);
        return $album->deleteAlbum($albumId);
    }
}
