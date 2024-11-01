<?php
session_start();

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Timeline</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 40px 10px;
            text-align: center;
        }

        .filter-container {
            position: absolute;
            top: 20px;
            left: 20px;
            text-align: left;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .filter-title {
            font-size: 1.4em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-align: left;
        }

        .filter-option {
            display: block;
            font-size: 1.2em;
            padding: 8px 0;
            color: #007bff;
            cursor: pointer;
        }

        .filter-option input {
            margin-right: 10px;
            transform: scale(1.2);
            cursor: pointer;
        }

        h1 {
            font-size: 3em;
            margin: 0;
            padding: 20px 0;
        }

        h2 {
            font-size: 2em;
            margin: 0;
            padding: 20px 0 40px 0;
        }

        .login-button {
            font-size: 1.2em;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        .dropdown {
            position: absolute;
            top: 10px;
            right: 140px;
        }

        .dropdown-button {
            font-size: 1.2em;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .dropdown-button:hover {
            background-color: #0056b3;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #007bff;
            color: white;
        }

        .genre-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .genre-name {
            width: 10%;
            font-weight: bold;
            font-size: 2em;
            color: black;
            padding-left: 10px;
            text-align: left;
        }

        .genre-pool-container {
            width: 90%;
        }

        .genre-pool {
            height: 100px;
            width: 100%;
            position: relative;
            background-color: #ececec;
            border-radius: 4px;
            overflow: hidden;
        }

        .album,
        .event,
        .artist {
            position: absolute;
            padding: 2px;
            font-size: 0.9em;
            text-align: center;
            border-radius: 4px;
            overflow: hidden;
            box-sizing: border-box;
            height: 20px;
            white-space: nowrap;
            text-overflow: ellipsis;
            border: 1px solid #000;
            line-height: 15px;
        }

        .album {
            width: 20px;
            border-radius: 50%;
            line-height: 20px;
            background-color: #000;
        }

        .event {
            width: 40px;
            background-color: #fff;
        }

        .artist {
            width: 40px;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .year-scale {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 0.8em;
            color: #000;
        }
    </style>
</head>

<body>

    <?php if ($isLoggedIn): ?>
        <div class="dropdown">
            <button onclick="toggleDropdown()" class="dropdown-button">Create ▼</button>
            <div id="dropdownContent" class="dropdown-content">
                <a href="index.php?action=createEvent">Event</a>
                <a href="index.php?action=createArtist">Artist</a>
                <a href="index.php?action=createAlbum">Album</a>
            </div>
        </div>
        <a href="index.php?action=logout">
            <button class="login-button">Logout</button>
        </a>
    <?php else: ?>
        <a href="index.php?action=login">
            <button class="login-button">Login</button>
        </a>
    <?php endif; ?>

    <script>
        function toggleDropdown() {
            document.getElementById("dropdownContent").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-button')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>

    <h1>Music Timeline</h1>

    <h2>List of Genres</h2>

    <div class="filter-container">
        <h3 class="filter-title">Filter Options</h3>
        <label class="filter-option">
            <input type="checkbox" id="showEvents" checked> Show Events
        </label>
        <label class="filter-option">
            <input type="checkbox" id="showAlbums" checked> Show Albums
        </label>
        <label class="filter-option">
            <input type="checkbox" id="showArtists" checked> Show Artists
        </label>
    </div>

    <?php
    $globalMinYear = date('Y');
    $globalMaxYear = 1900;
    $genreItems = [];

    foreach ($genreData as $genre) {
        $genreName = $genre['name'];
        $albumItems = [];
        $artistItems = [];
        $eventItems = [];

        while ($album = $genre['albums']->fetch(PDO::FETCH_ASSOC)) {
            $year = (int) date('Y', strtotime($album['release_date']));
            $albumItems[] = $album;
            $globalMinYear = min($globalMinYear, $year);
            $globalMaxYear = max($globalMaxYear, $year);
        }

        while ($artist = $genre['artists']->fetch(PDO::FETCH_ASSOC)) {
            $birthYear = (int) date('Y', strtotime($artist['birth_date']));
            $deathYear = $artist['death_date'] ? (int) date('Y', strtotime($artist['death_date'])) : date('Y');
            $artistItems[] = $artist;
            $globalMinYear = min($globalMinYear, $birthYear);
            $globalMaxYear = max($globalMaxYear, $deathYear);
        }

        while ($event = $genre['events']->fetch(PDO::FETCH_ASSOC)) {
            $startYear = (int) date('Y', strtotime($event['start_date']));
            $endYear = $event['end_date'] ? (int) date('Y', strtotime($event['end_date'])) : $startYear;
            $eventItems[] = $event;
            $globalMinYear = min($globalMinYear, $startYear);
            $globalMaxYear = max($globalMaxYear, $endYear);
        }

        $genreItems[$genreName] = [
            'albumItems' => $albumItems,
            'artistItems' => $artistItems,
            'eventItems' => $eventItems
        ];
    }

    foreach ($genreData as $genre):
        $genreName = htmlspecialchars($genre['name']);
        $genreColor = htmlspecialchars($genre['color']);
        $items = [];
        $rows = [];

        $albumItems = $genreItems[$genreName]['albumItems'];
        $artistItems = $genreItems[$genreName]['artistItems'];
        $eventItems = $genreItems[$genreName]['eventItems'];

        foreach ($albumItems as $album) {
            $startYear = (int) date('Y', strtotime($album['release_date']));
            $endYear = $startYear;
            $items[] = ['name' => htmlspecialchars($album['title']), 'type' => 'album', 'startYear' => $startYear, 'endYear' => $endYear];
        }

        foreach ($artistItems as $artist) {
            $startYear = (int) date('Y', strtotime($artist['birth_date']));
            $endYear = $artist['death_date'] ? (int) date('Y', strtotime($artist['death_date'])) : date('Y');
            $items[] = ['name' => htmlspecialchars($artist['name']), 'type' => 'artist', 'startYear' => $startYear, 'endYear' => $endYear];
        }

        foreach ($eventItems as $event) {
            $startYear = (int) date('Y', strtotime($event['start_date']));
            $endYear = $event['end_date'] ? (int) date('Y', strtotime($event['end_date'])) : $startYear;
            $items[] = ['name' => htmlspecialchars($event['name']), 'type' => 'event', 'startYear' => $startYear, 'endYear' => $endYear];
        }

        foreach ($items as &$item) {
            $startYear = $item['startYear'];
            $endYear = $item['endYear'];
            $item['leftPosition'] = (($startYear - $globalMinYear) / ($globalMaxYear - $globalMinYear)) * 100;
            $item['width'] = (($endYear - $startYear) / ($globalMaxYear - $globalMinYear)) * 100;

            $row = 0;
            while (isset($rows[$row])) {
                foreach ($rows[$row] as $range) {
                    if ($startYear <= $range['end'] && $endYear >= $range['start']) {
                        $row++;
                        continue 2;
                    }
                }
                break;
            }
            $rows[$row][] = ['start' => $startYear, 'end' => $endYear];
            $item['row'] = $row;
        }
        unset($item);
    ?>

        <div class="genre-container">
            <div class="genre-name">
                <a href="index.php?action=showGenre&id=<?= urlencode($genre['id']) ?>"><?= htmlspecialchars($genre['name']) ?></a>
            </div>
            <div class="genre-pool-container">
                <div class="genre-pool" style="background-color: <?= $genreColor ?>;">
                    <?php foreach ($items as $item):
                        $leftPosition = $item['leftPosition'];
                        $width = $item['type'] == 'album' ? '20px' : ($item['width'] . '%');
                        $topOffset = $item['row'] * 22;
                        $itemClass = strtolower($item['type']);
                    ?>
                        <div class="<?= $itemClass ?>" style="left: <?= $leftPosition ?>%; width: <?= $width ?>; height: 20px; top: <?= $topOffset ?>px; cursor: pointer;">
                            <?php if ($itemClass == 'album'): ?>
                                <a href="index.php?action=showAlbum&id=<?= urlencode($album['id']) ?><?= htmlspecialchars($album['title']) ?>"
                                    style="display: block; height: 100%; width: 100%; border-radius: 50%; background-color: black;"></a>
                            <?php elseif ($itemClass == 'artist'): ?>
                                <a href="index.php?action=showArtist&id=<?= urlencode($artist['id']) ?><?= htmlspecialchars($artist['name']) ?>"
                                    style="display: flex; align-items: center; justify-content: center; height: 100%; width: 100%; background-color: rgba(0, 0, 0, 0.2); text-decoration: none;
                            color: black;"><?= htmlspecialchars($item['name']) ?></a>
                            <?php elseif ($itemClass == 'event'): ?>
                                <a href="index.php?action=showEvent&id=<?= urlencode($event['id']) ?><?= htmlspecialchars($event['name']) ?>"
                                    style="display: block; height: 100%; width: 100%; background-color: white;"></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="year-scale">
                    <?php for ($year = $globalMinYear; $year <= $globalMaxYear; $year += 10): ?>
                        <div><?= $year ?></div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <script>
        // Add event listeners directly to the checkbox elements
        document.getElementById("showEvents").addEventListener("change", toggleVisibility);
        document.getElementById("showAlbums").addEventListener("change", toggleVisibility);
        document.getElementById("showArtists").addEventListener("change", toggleVisibility);

        function toggleVisibility() {
            // Get the checked state of each checkbox
            const showEvents = document.getElementById("showEvents").checked;
            const showAlbums = document.getElementById("showAlbums").checked;
            const showArtists = document.getElementById("showArtists").checked;

            // Toggle visibility of events based on checkbox state
            document.querySelectorAll('.event').forEach(event => {
                event.style.display = showEvents ? 'block' : 'none';
            });

            // Toggle visibility of albums based on checkbox state
            document.querySelectorAll('.album').forEach(album => {
                album.style.display = showAlbums ? 'block' : 'none';
            });

            // Toggle visibility of artists based on checkbox state
            document.querySelectorAll('.artist').forEach(artist => {
                artist.style.display = showArtists ? 'block' : 'none';
            });
        }
    </script>
</body>

</html>