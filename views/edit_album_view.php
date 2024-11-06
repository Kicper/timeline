<?php

// Include the GenreController and the ArtistController to handle genre-related actions and fetch genre data
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
    <title>Edit Album</title>
    <style>
        /* General styling for the body and html elements */
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

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: left;
        }

        label {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        /* Styling for form inputs, select boxes, and text areas */
        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
            appearance: none;
            background-color: #f9f9f9;
            color: #333;
        }

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

        /* Prevent resizing of the text area */
        textarea {
            resize: none;
        }

        select:hover,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        .button-container {
            display: flex;
            gap: 10px;
            width: 100%;
            justify-content: center;
            margin-top: 10px;
        }

        /* Styling for buttons */
        button {
            font-size: 1em;
            padding: 10px;
            width: 100px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .save-button {
            background-color: #28a745;
            color: #fff;
        }

        .save-button:hover {
            background-color: #218838;
        }

        .cancel-button {
            background-color: #6c757d;
            color: #fff;
        }

        .cancel-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <h1>Edit Album Details</h1>
    <!-- Form to edit the album, with action to update album details -->
    <form action="index.php?action=updateAlbum&id=<?= htmlspecialchars($album['id']) ?>" method="post" enctype="multipart/form-data">
        <label for="title">Album Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($album['title']) ?>" required>

        <label for="release_date">Release Date:</label>
        <input type="date" id="release_date" name="release_date" value="<?= htmlspecialchars($album['release_date']) ?>">

        <label for="genres">Genre:</label>
        <select id="genre_id" name="genre_id" required>
            <option value="" disabled selected>Select a genre</option>
            <?php while ($genre = $genres->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= htmlspecialchars($genre['id']) ?>" <?= $album['genre_id'] == $genre['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($genre['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="artist_id">Artist:</label>
        <select id="artist_id" name="artist_id" required>
            <option value="" disabled selected>Select an artist</option>
            <?php while ($artist = $artists->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= htmlspecialchars($artist['id']) ?>" <?= $album['artist_id'] == $album['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($artist['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="image_url">Album Cover Image:</label>
        <input type="file" id="image_url" name="image_url" accept="image/*">

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4"><?= htmlspecialchars($album['description']) ?></textarea>

        <div class="button-container">
            <button type="submit" class="save-button">Save</button>
            <a href="index.php?action=showAlbum&id=<?= htmlspecialchars($album['id']) ?>">
                <button type="button" class="cancel-button">Cancel</button>
            </a>
        </div>
    </form>
</body>

</html>