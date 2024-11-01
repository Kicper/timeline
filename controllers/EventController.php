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
        return $event->createEvent(
            $data['name'],
            $data['description'],
            $data['start_date'],
            $data['end_date'],
            $data['image_url'],
            $data['genre']
        );
    }

    public function updateEvent($id, $data)
    {
        $event = new Event($this->conn);
        return $event->updateEvent($id, $data);
    }
}
