<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
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

        .event-description {
            font-size: 1.2em;
            margin-top: 20px;
        }

        .event-icon {
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
        }

        .event-details {
            margin-top: 5px;
            font-size: 1.1em;
            color: #555;
        }

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
</head>

<body>
    <div class="top-right-corner">
        <a href="index.php"><button class="return-button">Back to timeline</button></a>
    </div>

    <h1><?= htmlspecialchars($event['name']) ?></h1>

    <div class="event-details">
        <p><strong>Start date of an event:</strong> <?= htmlspecialchars($event['start_date']) ?></p>
        <p><strong>End date of an event:</strong> <?= htmlspecialchars($event['end_date']) ?></p>
    </div>

    <p class="event-description"><?= htmlspecialchars($event['description']) ?></p>

    <?php if (!empty($event['image_url'])): ?>
        <img src="<?= htmlspecialchars($event['image_url']) ?>" alt="Event Icon" class="event-icon">
    <?php endif; ?>

    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        <div class="top-left-corner">
            <a href="index.php?action=editEvent&id=<?= htmlspecialchars($event['id']) ?>">
                <button class="edit-button">Edit</button>
            </a>
        </div>
    <?php endif; ?>
</body>

</html>