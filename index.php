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
        require __DIR__ . '/views/genre_view.php';
        break;
}