<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Details</title>
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
        .artist-bio {
            font-size: 1.2em;
            margin-top: 20px;
        }
        .artist-icon {
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
    </style>
</head>
<body>
    <div class="top-right-corner">
        <a href="index.php"><button class="return-button">Back to timeline</button></a>
    </div>

    <h1><?= htmlspecialchars($artist['name']) ?></h1>
    <p class="artist-bio"><?= htmlspecialchars($artist['bio']) ?></p>
    <?php if (!empty($artist['image_url'])): ?>
        <img src="<?= htmlspecialchars($artist['image_url']) ?>" alt="Artist Icon" class="artist-icon">
    <?php endif; ?>
</body>
</html>