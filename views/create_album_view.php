<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

if (!$isLoggedIn) {
    header('Location: index.php?action=login');
    exit();
}

// Include the GenreController and ArtistController to fetch the necessary data
require_once __DIR__ . '/../controllers/GenreController.php';
$genreController = new GenreController($db);
$genres = $genreController->getAllGenres();
$artistController = new ArtistController($db);
$artists = $artistController->getAllArtists();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Album</title>
    <style>
        /* General page styling for layout, font, and colors */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form styling to make it look neat */
        .album-form {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: left;
        }

        label {
            font-size: 1.1em;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="url"],
        textarea,
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
            appearance: none;
        }

        /* Custom styling for the file input button */
        input[type="file"]::-webkit-file-upload-button {
            background-color: #007bff;
            margin: 10px 0 20px;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Ensure the textarea can't be resized */
        textarea {
            resize: none;
        }

        select {
            background-color: #f9f9f9;
            color: #333;
            cursor: pointer;
        }

        select:hover,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Styling for the form submission button */
        .submit-button {
            width: 100%;
            font-size: 1.1em;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }

        /* Styling for the "Back to timeline" button in the top-right corner */
        .return-button {
            font-size: 1em;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .return-button:hover {
            background-color: #0056b3;
        }

        .top-right-corner {
            position: absolute;
            top: 10px;
            right: 20px;
        }
    </style>
</head>

<body>
    <!-- Button to return to the main timeline page, positioned at the top-right corner -->
    <div class="top-right-corner">
        <a href="index.php"><button class="return-button">Back to timeline</button></a>
    </div>

    <h1>Create New Album</h1>

    <!-- Album creation form starts here -->
    <div class="album-form">
        <div id="error-message" style="color: red; margin-bottom: 15px;"></div>

        <form action="index.php?action=createAlbum" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <label for="title">Album Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="release_date">Release Date:</label>
            <input type="date" id="release_date" name="release_date" required>

            <label for="genres">Genre:</label>
            <select id="genre_id" name="genre_id" required>
                <option value="" disabled selected>Select a genre</option>
                <?php while ($genre = $genres->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?= htmlspecialchars($genre['id']) ?>"><?= htmlspecialchars($genre['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="artists">Artist:</label>
            <select id="artist_id" name="artist_id" required>
                <option value="" disabled selected>Select an artist</option>
                <?php while ($artist = $artists->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?= htmlspecialchars($artist['id']) ?>"><?= htmlspecialchars($artist['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="cover_image">Album Cover Image:</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*">

            <label for="description">Album Description:</label>
            <textarea id="description" name="description" rows="4"></textarea>

            <button type="submit" class="submit-button">Add Album</button>
        </form>
    </div>
</body>

</html>