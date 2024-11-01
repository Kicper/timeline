<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/controllers/GenreController.php';
require_once __DIR__ . '/controllers/UserController.php';

$database = new Database();
$db = $database->getConnection();

$action = isset($_GET['action']) ? $_GET['action'] : 'showMainPage';

switch ($action) {
    case 'login':
        require __DIR__ . '/views/login_view.php';
        break;

    case 'logout':
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
        break;

    case 'createEvent':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventController = new EventController($db);
            $result = $eventController->createEvent($_POST);

            if ($result) {
                echo "Event created successfully!";
                header('Location: index.php');
                exit();
            } else {
                echo "Error creating event. Please check your input.";
            }
        } else {
            require __DIR__ . '/views/create_event_view.php';
        }
        break;

    case 'createArtist':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $artistController = new ArtistController($db);
            $result = $artistController->createArtist($_POST);

            if ($result) {
                echo "Artist created successfully!";
                header('Location: index.php');
                exit();
            } else {
                echo "Error creating artist. Please check your input.";
            }
        } else {
            require __DIR__ . '/views/create_artist_view.php';
        }
        break;

    case 'createAlbum':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $albumController = new AlbumController($db);
            $result = $albumController->createAlbum($_POST);

            if ($result) {
                echo "Album created successfully!";
                header('Location: index.php');
                exit();
            } else {
                echo "Error creating album. Please check your input.";
            }
        } else {
            require __DIR__ . '/views/create_album_view.php';
        }
        break;

    case 'showGenre':
        $genreId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $genreController = new GenreController($db);
        $genre = $genreController->getGenreById($genreId);
        if ($genre) {
            require __DIR__ . '/views/genre_view.php';
        } else {
            echo "Genre not found.";
        }
        break;

    case 'showAlbum':
        $albumId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $albumController = new AlbumController($db);
        $album = $albumController->getAlbumById($albumId);
        if ($album) {
            require __DIR__ . '/views/album_view.php';
        } else {
            echo "Album not found.";
        }
        break;

    case 'showArtist':
        $artistId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $artistController = new ArtistController($db);
        $artist = $artistController->getArtistById($artistId);
        if ($artist) {
            require __DIR__ . '/views/artist_view.php';
        } else {
            echo "Artist not found.";
        }
        break;

    case 'showEvent':
        $eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $eventController = new EventController($db);
        $event = $eventController->getEventById($eventId);
        if ($event) {
            require __DIR__ . '/views/event_view.php';
        } else {
            echo "Event not found.";
        }
        break;

    case 'showMainPage':
    default:
        $genreController = new GenreController($db);
        $genres = $genreController->getAllGenres();
        $genreData = [];

        while ($genre = $genres->fetch(PDO::FETCH_ASSOC)) {
            $genreId = $genre['id'];
            $genre['albums'] = $genreController->getAlbumsByGenre($genreId);
            $genre['artists'] = $genreController->getArtistsByGenre($genreId);
            $genre['events'] = $genreController->getEventsByGenre($genreId);
            $genreData[] = $genre;
        }

        require __DIR__ . '/views/main_view.php';
        break;
}
