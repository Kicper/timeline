<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Details</title>
    <style>
        /* Style for the main layout, font, and color theme */
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

        .album-description {
            font-size: 1.2em;
            margin-top: 20px;
        }

        .album-icon {
            margin-top: 20px;
            width: 450px;
            height: auto;
        }

        /* Style for the button to go back to the main page */
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

        /* Position styling for elements */
        .top-right-corner {
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .top-left-corner {
            position: absolute;
            top: 10px;
            left: 20px;
        }

        /* Style for album detail text */
        .album-details {
            margin-top: 5px;
            font-size: 1.1em;
            color: #555;
        }

        /* Style for the edit button */
        .edit-button {
            font-size: 1em;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .edit-button:hover {
            background-color: #218838;
        }
    </style>
    <script>
        // Function to confirm album deletion with a user prompt
        function confirmDelete(albumId) {
            if (confirm("Are you sure you want to delete this album?")) {
                window.location.href = "index.php?action=deleteAlbum&id=" + albumId;
            }
        }
    </script>
</head>

<body>
    <!-- Button to return to the main timeline page, positioned at the top-right corner -->
    <div class="top-right-corner">
        <a href="index.php"><button class="return-button">Back to timeline</button></a>
    </div>

    <!-- Display the album details -->
    <h1><?= htmlspecialchars($album['title']) ?></h1>

    <?php if (!empty($album['cover_image_url'])): ?>
        <img src="<?= htmlspecialchars($album['cover_image_url']) ?>" alt="Album cover is unavailable" class="album-icon">
    <?php endif; ?>

    <div class="album-details">
        <p><strong>Release date of an album:</strong> <?= htmlspecialchars($album['release_date']) ?></p>
    </div>

    <p class="album-description"><?= htmlspecialchars($album['description']) ?></p>

    <!-- Show edit and delete buttons if the user is logged in -->
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        <div class="top-left-corner">
            <a href="index.php?action=editAlbum&id=<?= htmlspecialchars($album['id']) ?>">
                <button class="edit-button">Edit</button>
            </a>
            <button class="edit-button" onclick="confirmDelete(<?= htmlspecialchars($album['id']) ?>)">Delete Album</button>
        </div>
    <?php endif; ?>
</body>

</html>