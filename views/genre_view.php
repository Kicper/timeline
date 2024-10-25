<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Timeline</title>
    <style>
        .genre-pool {
            height: 50px;
            margin-top: 5px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Music Timeline</h1>

    <div>
        <a href="index.php?action=login"><button>Login</button></a>
    </div>

    <h2>List of Genres</h2>
    <ul>
        <?php
        while ($row = $genres->fetch(PDO::FETCH_ASSOC)) {
            $genreName = htmlspecialchars($row['name']);
            $genreColor = htmlspecialchars($row['color']);

            echo "<div>$genreName</div>";
            echo "<div class='genre-pool' style='background-color: $genreColor;'></div>";
        }
        ?>
    </ul>
</body>
</html>
