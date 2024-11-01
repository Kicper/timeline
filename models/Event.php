<?php
class Event
{
    private $conn;
    private $table_name = "music_events";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getEventsByGenre($genreId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE genre_id = :genre_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':genre_id', $genreId);
        $stmt->execute();
        return $stmt;
    }

    public function getEventById($eventId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $eventId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createEvent($name, $description, $startDate, $endDate, $imageUrl, $genreId)
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $startDate = $_POST['start_date'];
        $endDate = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
        $imageUrl = $_POST['image_url'];
        $genreId = $_POST['genre'];

        if (empty($name) || empty($startDate) || empty($genreId)) {
            die("Error: Event name, start date, and genre are required fields.");
        }

        if ($endDate && $startDate > $endDate) {
            die("Error: Start date must be earlier than end date.");
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, start_date, end_date, image_url, genre_id)
                VALUES (:name, :description, :start_date, :end_date, :image_url, :genre_id)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':image_url' => $imageUrl,
            ':genre_id' => $genreId
        ])) {
            header('Location: index.php?action=timeline');
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            die("Error: Could not insert event. " . $errorInfo[2]);
        }
    }
}
