<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/controllers/GenreController.php';
require_once __DIR__ . '/controllers/UserController.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Determine the action to be taken based on the "action" query parameter
$action = isset($_GET['action']) ? $_GET['action'] : 'showMainPage';

switch ($action) {
    case 'login':
        // Display login view for the user
        require __DIR__ . '/views/login_view.php';
        break;

    case 'logout':
        // End the user session, log out, and redirect to the main page
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
        break;

    case 'changePassword':
        // Process password change if the user is logged in
        session_start();
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: index.php?action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController = new UserController($db);
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                $errorMessage = "New password and confirmation do not match.";
            } elseif (!$userController->changePassword($_SESSION['username'], $currentPassword, $newPassword)) {
                $errorMessage = "Current password is incorrect.";
            } else {
                header('Location: index.php');
                exit();
            }
        }
        require __DIR__ . '/views/change_password_view.php';
        break;

    case 'createEvent':
        // Process event creation when form is submitted
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

    case 'editEvent':
        // Display edit event form for a specific event if user is logged in
        session_start();
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: index.php?action=login');
            exit();
        }

        $eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $eventController = new EventController($db);
        $event = $eventController->getEventById($eventId);
        require __DIR__ . '/views/edit_event_view.php';
        break;

    case 'updateEvent':
        // Process event update when form is submitted
        session_start();
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: index.php?action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $eventId = (int)$_GET['id'];
            $eventData = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'image_url' => $_POST['image_url'],
                'genre_id' => $_POST['genre_id']
            ];

            $eventController = new EventController($db);
            if ($eventController->updateEvent($eventId, $eventData)) {
                header("Location: index.php?action=showEvent&id=" . $eventId);
                exit();
            } else {
                echo "Error updating event.";
            }
        }
        break;

    case 'deleteEvent':
        // Delete a specific event if user is logged in
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_GET['id'])) {
            $eventId = (int)$_GET['id'];
            $eventController = new EventController($db);
            if ($eventController->deleteEvent($eventId)) {
                header('Location: index.php');
                exit();
            } else {
                echo "Error deleting event.";
            }
        } else {
            echo "Not logged in or no event ID.";
            header('Location: index.php?action=login');
            exit();
        }
        break;

    case 'createArtist':
        // Process artist creation if form is submitted
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

    case 'editArtist':
        // Display edit form for an artist if user is logged in
        session_start();
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: index.php?action=login');
            exit();
        }

        $artistId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $artistController = new ArtistController($db);
        $artist = $artistController->getArtistById($artistId);
        require __DIR__ . '/views/edit_artist_view.php';
        break;

    case 'updateArtist':
        // Process artist update when form is submitted
        session_start();
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: index.php?action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $artistId = (int)$_GET['id'];
            $artistData = [
                'name' => $_POST['name'],
                'bio' => $_POST['bio'],
                'birth_date' => $_POST['birth_date'],
                'death_date' => $_POST['death_date'],
                'genre' => $_POST['genre'],
                'image_url' => $_POST['image_url']
            ];

            $artistController = new ArtistController($db);
            if ($artistController->updateArtist($artistId, $artistData)) {
                header("Location: index.php?action=showArtist&id=" . $artistId);
                exit();
            } else {
                echo "Error updating artist.";
            }
        }
        break;

    case 'deleteArtist':
        // Delete an artist if user is logged in and artist ID is provided
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_GET['id'])) {
            $artistId = (int)$_GET['id'];
            $artistController = new ArtistController($db);
            if ($artistController->deleteArtist($artistId)) {
                header('Location: index.php');
                exit();
            } else {
                echo "Error deleting artist.";
            }
        } else {
            echo "Not logged in or no artist ID.";
            header('Location: index.php?action=login');
            exit();
        }
        break;

    case 'createAlbum':
        // Process album creation if form is submitted
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

    case 'editAlbum':
        // Display edit form for an album if user is logged in
        session_start();
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: index.php?action=login');
            exit();
        }

        $albumId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $albumController = new AlbumController($db);
        $album = $albumController->getAlbumById($albumId);
        require __DIR__ . '/views/edit_album_view.php';
        break;

    case 'updateAlbum':
        // Process album update when form is submitted
        session_start();
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: index.php?action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $albumId = (int)$_GET['id'];
            $albumData = [
                'title' => $_POST['title'],
                'release_date' => $_POST['release_date'],
                'genre_id' => $_POST['genre_id'],
                'artist_id' => $_POST['artist_id'],
                'cover_image_url' => $_POST['cover_image_url'],
                'description' => $_POST['description']
            ];

            $albumController = new AlbumController($db);
            if ($albumController->updateAlbum($albumId, $albumData)) {
                header("Location: index.php?action=showAlbum&id=" . $albumId);
                exit();
            } else {
                echo "Error updating album.";
            }
        }
        break;

    case 'deleteAlbum':
        // Delete an album if user is logged in and album ID is provided
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_GET['id'])) {
            $albumId = (int)$_GET['id'];
            $albumController = new AlbumController($db);
            if ($albumController->deleteAlbum($albumId)) {
                header('Location: index.php');
                exit();
            } else {
                echo "Error deleting album.";
            }
        } else {
            echo "Not logged in or no album ID.";
            header('Location: index.php?action=login');
            exit();
        }
        break;

    case 'showGenre':
        // Display a specific genre's details
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
        // Display details for a specific album
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
        // Display details for a specific artist
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
        // Display details for a specific event
        $eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $eventController = new EventController($db);
        $event = $eventController->getEventById($eventId);
        if ($event) {
            require __DIR__ . '/views/event_view.php';
        } else {
            echo "Event not found.";
        }
        break;

    case 'updateGenreColor':
        // Update genre color if user is logged in
        session_start();
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: index.php?action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id']) && isset($_POST['color'])) {
            $genreId = (int)$_GET['id'];
            $newColor = $_POST['color'];
            $genreController = new GenreController($db);

            if ($genreController->updateGenreColor($genreId, $newColor)) {
                header("Location: index.php?action=showGenre&id=" . $genreId);
                exit();
            } else {
                echo "Error updating color.";
            }
        }
        break;

    case 'showMainPage':
    default:
        // Show main page with all genres and their albums, artists, and events
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
