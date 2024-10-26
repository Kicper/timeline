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

        .album, .event, .artist {
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
    <a href="index.php?action=login">
        <button class="login-button">Login</button>
    </a>

    <h1>Music Timeline</h1>

    <h2>List of Genres</h2>
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
        <div class="genre-name"><?= $genreName ?></div>
        <div class="genre-pool-container">
            <div class="genre-pool" style="background-color: <?= $genreColor ?>;">
                <?php foreach ($items as $item):
                    $leftPosition = $item['leftPosition'];
                    $width = $item['type'] == 'album' ? '20px' : ($item['width'] . '%');
                    $topOffset = $item['row'] * 22;
                    $itemClass = strtolower($item['type']);
                ?>
                    <div class="<?= $itemClass ?>" style="left: <?= $leftPosition ?>%; width: <?= $width ?>; height: 20px; top: <?= $topOffset ?>px;">
                        <?php if ($itemClass == 'artist'): ?>
                            <?= $item['name']; ?>
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
</body>
</html>