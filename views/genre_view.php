<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre Details</title>
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

        .genre-description {
            font-size: 1.2em;
            margin-top: 20px;
        }

        .genre-icon {
            margin-top: 20px;
            width: 150px;
            height: auto;
        }

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

        .top-left-corner {
            position: absolute;
            top: 10px;
            left: 20px;
            text-align: left;
        }

        .top-left-corner label {
            display: block;
            font-size: 1em;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .top-left-corner form {
            display: flex;
            align-items: center;
        }

        .top-left-corner input[type="color"] {
            margin-right: 10px;
            width: 40px;
            height: 40px;
            border: none;
            cursor: pointer;
        }

        .top-left-corner .update-button {
            font-size: 0.9em;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .top-left-corner .update-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="top-right-corner">
        <a href="index.php"><button class="return-button">Back to timeline</button></a>
    </div>

    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        <div class="top-left-corner">
            <label for="color">Choose a new color for this genre:</label>
            <form action="index.php?action=updateGenreColor&id=<?= $genre['id'] ?>" method="POST">
                <input type="color" id="color" name="color" value="<?= htmlspecialchars($genre['color']) ?>">
                <button type="submit" class="update-button">Update Color</button>
            </form>
        </div>
    <?php endif; ?>

    <h1><?= htmlspecialchars($genre['name']) ?></h1>
    <p class="genre-description"><?= htmlspecialchars($genre['description']) ?></p>
    <?php if (!empty($genre['icon_url'])): ?>
        <img src="<?= htmlspecialchars($genre['icon_url']) ?>" alt="Genre Icon" class="genre-icon">
    <?php endif; ?>
</body>

</html>