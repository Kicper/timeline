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

        .event-description {
            font-size: 1.2em;
            margin-top: 20px;
        }

        .event-icon {
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

        /* Style for event detail text */
        .event-details {
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
        function confirmDelete(eventId) {
            if (confirm("Are you sure you want to delete this event?")) {
                window.location.href = "index.php?action=deleteEvent&id=" + eventId;
            }
        }
    </script>
</head>

<body>
    <!-- Button to return to the main timeline page, positioned at the top-right corner -->
    <div class="top-right-corner">
        <a href="index.php"><button class="return-button">Back to timeline</button></a>
    </div>

    <!-- Display the event details -->
    <h1><?= htmlspecialchars($event['name']) ?></h1>

    <?php if (!empty($event['image_url'])): ?>
        <img src="<?= htmlspecialchars($event['image_url']) ?>" alt="Event image is unavailable" class="event-icon">
    <?php endif; ?>

    <div class="event-details">
        <p><strong>Start date of an event:</strong> <?= htmlspecialchars($event['start_date']) ?></p>
        <p><strong>End date of an event:</strong> <?= htmlspecialchars($event['end_date']) ?></p>
    </div>

    <p class="event-description"><?= htmlspecialchars($event['description']) ?></p>

    <!-- Show edit and delete buttons if the user is logged in -->
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        <div class="top-left-corner">
            <a href="index.php?action=editEvent&id=<?= htmlspecialchars($event['id']) ?>">
                <button class="edit-button">Edit</button>
            </a>
            <button class="edit-button" onclick="confirmDelete(<?= htmlspecialchars($event['id']) ?>)">Delete Event</button>
        </div>
    <?php endif; ?>
</body>

</html>