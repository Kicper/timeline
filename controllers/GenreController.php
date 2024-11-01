<?php
require_once __DIR__ . '/../models/Genre.php';
require_once __DIR__ . '/../controllers/AlbumController.php';
require_once __DIR__ . '/../controllers/ArtistController.php';
require_once __DIR__ . '/../controllers/EventController.php';

class GenreController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllGenres()
    {
        $genre = new Genre($this->conn);
        $result = $genre->getAllGenres();
        return $result;
    }

    public function getGenreById($genreId)
    {
        $genre = new Genre($this->conn);
        return $genre->getGenreById($genreId);
    }

    public function updateGenreColor($genreId, $color)
    {
        $genre = new Genre($this->conn);
        return $genre->updateGenreColor($genreId, $color);
    }

    public function getAlbumsByGenre($genreId)
    {
        $albumController = new AlbumController($this->conn);
        return $albumController->getAlbumsByGenre($genreId);
    }

    public function getArtistsByGenre($genreId)
    {
        $artistController = new ArtistController($this->conn);
        return $artistController->getArtistsByGenre($genreId);
    }

    public function getEventsByGenre($genreId)
    {
        $eventController = new EventController($this->conn);
        return $eventController->getEventsByGenre($genreId);
    }
}
