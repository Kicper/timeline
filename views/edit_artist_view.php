<?php
require_once __DIR__ . '/../controllers/GenreController.php';
$genreController = new GenreController($db);
$genres = $genreController->getAllGenres();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artist</title>
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
    <h1>Edit Artist Details</h1>
    <!-- Form to edit the artist, with action to update artist details -->
    <form action="index.php?action=updateArtist&id=<?= htmlspecialchars($artist['id']) ?>" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($artist['name']) ?>" required>

        <label for="bio">Biography:</label>
        <textarea id="bio" name="bio" rows="4"><?= htmlspecialchars($artist['bio']) ?></textarea>

        <label for="birth_date">Birth Date:</label>
        <input type="date" id="birth_date" name="birth_date" value="<?= htmlspecialchars($artist['birth_date']) ?>">

        <label for="death_date">Death Date:</label>
        <input type="date" id="death_date" name="death_date" value="<?= htmlspecialchars($artist['death_date']) ?>">

        <label for="genres">Genre:</label>
        <select id="genre" name="genre" required>
            <option value="" disabled selected>Select a genre</option>
            <?php while ($genre = $genres->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= htmlspecialchars($genre['id']) ?>" <?= $artist['genre_id'] == $genre['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($genre['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="image_url">Artist Image:</label>
        <input type="file" id="image_url" name="image_url" accept="image/*">

        <div class="button-container">
            <button type="submit" class="save-button">Save</button>
            <a href="index.php?action=showArtist&id=<?= htmlspecialchars($artist['id']) ?>">
                <button type="button" class="cancel-button">Cancel</button>
            </a>
        </div>
    </form>
</body>

</html>