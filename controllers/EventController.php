<?php
require_once __DIR__ . '/../models/Event.php';

class EventController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getEventsByGenre($genreId)
    {
        $event = new Event($this->conn);
        $result = $event->getEventsByGenre($genreId);
        return $result;
    }

    public function getEventById($eventId)
    {
        $event = new Event($this->conn);
        return $event->getEventById($eventId);
    }

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

    public function deleteEvent($eventId)
    {
        $event = new Event($this->conn);
        return $event->deleteEvent($eventId);
    }
}
