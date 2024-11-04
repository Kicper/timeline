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
    <title>Edit Event</title>
    <style>
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
    <h1>Edit Event Details</h1>
    <form action="index.php?action=updateEvent&id=<?= htmlspecialchars($event['id']) ?>" method="post" enctype="multipart/form-data">
        <label for="name">Event Title:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4"><?= htmlspecialchars($event['description']) ?></textarea>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($event['start_date']) ?>">

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($event['end_date']) ?>">

        <label for="cover_image">Event Image:</label>
        <input type="file" id="cover_image" name="cover_image" accept="image/*">

        <label for="genres">Genre:</label>
        <select id="genre_id" name="genre_id" required>
            <option value="" disabled selected>Select a genre</option>
            <?php while ($genre = $genres->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= htmlspecialchars($genre['id']) ?>" <?= $event['genre_id'] == $genre['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($genre['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <div class="button-container">
            <button type="submit" class="save-button">Save</button>
            <a href="index.php?action=showEvent&id=<?= htmlspecialchars($event['id']) ?>">
                <button type="button" class="cancel-button">Cancel</button>
            </a>
        </div>
    </form>
</body>

</html>