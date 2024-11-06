<?php
require_once __DIR__ . '/../models/Genre.php';
require_once __DIR__ . '/../controllers/AlbumController.php';
require_once __DIR__ . '/../controllers/ArtistController.php';
require_once __DIR__ . '/../controllers/EventController.php';

class GenreController
{
    private $conn;

    // Constructor to initialize the database connection for GenreController
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Retrieves all genres from the database
    public function getAllGenres()
    {
        $genre = new Genre($this->conn);
        $result = $genre->getAllGenres();
        return $result;
    }

    // Retrieves a single genre's details by genre ID
    public function getGenreById($genreId)
    {
        $genre = new Genre($this->conn);
        return $genre->getGenreById($genreId);
    }

    // Updates the colour attribute of a genre by genre ID
    public function updateGenreColor($genreId, $color)
    {
        $genre = new Genre($this->conn);
        return $genre->updateGenreColor($genreId, $color);
    }

    // Retrieves all albums that belong to a specified genre by genre ID
    public function getAlbumsByGenre($genreId)
    {
        $albumController = new AlbumController($this->conn);
        return $albumController->getAlbumsByGenre($genreId);
    }

    // Retrieves all artists that belong to a specified genre by genre ID
    public function getArtistsByGenre($genreId)
    {
        $artistController = new ArtistController($this->conn);
        return $artistController->getArtistsByGenre($genreId);
    }

    // Retrieves all events that belong to a specified genre by genre ID
    public function getEventsByGenre($genreId)
    {
        $eventController = new EventController($this->conn);
        return $eventController->getEventsByGenre($genreId);
    }
}
