<?php
require_once __DIR__ . '/../models/Event.php';

class EventController
{
    private $conn;

    // Constructor to initialize the database connection for EventController
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Retrieves all events within a specified genre by genre ID
    public function getEventsByGenre($genreId)
    {
        $event = new Event($this->conn);
        $result = $event->getEventsByGenre($genreId);
        return $result;
    }

    // Retrieves a single event's details by event ID
    public function getEventById($eventId)
    {
        $event = new Event($this->conn);
        return $event->getEventById($eventId);
    }

    // Creates a new event record in the database
    public function createEvent($data)
    {
        $event = new Event($this->conn);

        $imagePath = '';
        if (!empty($_FILES['cover_image']['name'])) {
            $targetDir = __DIR__ . "/../images/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $imagePath = $targetDir . basename($_FILES['cover_image']['name']);
            if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $imagePath)) {
                die("Error: Unable to upload cover image.");
            }
            $imagePath = "images/" . basename($_FILES['cover_image']['name']);
        }
        return $event->createEvent(
            $data['name'],
            $data['description'],
            $data['start_date'],
            $data['end_date'],
            $imagePath,
            $data['genre']
        );
    }

    // Updates an existing event's details in the database
    public function updateEvent($id, $data)
    {
        $event = new Event($this->conn);
        $existingEvent = $event->getEventById($id);

        $imagePath = $existingEvent['image_url'];

        if (!empty($_FILES['cover_image']['name'])) {
            $targetDir = __DIR__ . "/../images/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $imagePath = $targetDir . basename($_FILES['cover_image']['name']);
            if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $imagePath)) {
                die("Error: Unable to upload cover image.");
            }
            $imagePath = "images/" . basename($_FILES['cover_image']['name']);
        }

        $data['image_url'] = $imagePath;

        return $event->updateEvent($id, $data);
    }

    // Deletes an event record from the database by event ID
    public function deleteEvent($eventId)
    {
        $event = new Event($this->conn);
        return $event->deleteEvent($eventId);
    }
}
