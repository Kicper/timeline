<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Details</title>
    <style>
        body, html {
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
        .album-details {
            margin-top: 5px;
            font-size: 1.1em;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="top-right-corner">
        <a href="index.php"><button class="return-button">Back to timeline</button></a>
    </div>

    <h1><?= htmlspecialchars($album['title']) ?></h1>

    <div class="album-details">
        <p><strong>Release date of an album:</strong> <?= htmlspecialchars($album['release_date']) ?></p>
    </div>

    <p class="album-description"><?= htmlspecialchars($album['description']) ?></p>
    
    <?php if (!empty($album['cover_image_url'])): ?>
        <img src="<?= htmlspecialchars($album['cover_image_url']) ?>" alt="Album Icon" class="album-icon">
    <?php endif; ?>
</body>
</html>