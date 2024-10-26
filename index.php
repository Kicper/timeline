<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/controllers/GenreController.php';
require_once __DIR__ . '/controllers/UserController.php';

$database = new Database();
$db = $database->getConnection();

$action = isset($_GET['action']) ? $_GET['action'] : 'showGenres';

switch ($action) {
    case 'login':
        require __DIR__ . '/views/login_view.php';
        break;
    case 'showGenres':
    default:
        $genreController = new GenreController($db);
        $genres = $genreController->showGenres();
        $genreData = [];

        while ($genre = $genres->fetch(PDO::FETCH_ASSOC)) {
            $genreId = $genre['id'];
            $genre['albums'] = $genreController->getAlbumsByGenre($genreId);
            $genre['artists'] = $genreController->getArtistsByGenre($genreId);
            $genre['events'] = $genreController->getEventsByGenre($genreId);
            $genreData[] = $genre;
        }

        require __DIR__ . '/views/genre_view.php';
        break;
}