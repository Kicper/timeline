<?php
class Event
{
    private $conn;
    private $table_name = "music_events";

    // Constructor function to initialize the database connection for the Event class
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Retrieves all events that belong to a specified genre
    public function getEventsByGenre($genreId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE genre_id = :genre_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':genre_id', $genreId);
        $stmt->execute();
        return $stmt;
    }

    // Retrieves a single event by its unique ID
    public function getEventById($eventId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $eventId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Inserts a new event into the database with specified details
    public function createEvent($name, $description, $startDate, $endDate, $imageUrl, $genreId)
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $startDate = $_POST['start_date'];
        $endDate = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
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

    // Updates an existing event's details in the database
    public function updateEvent($id, $data)
    {
        if (empty($data['name']) || empty($data['start_date']) || empty($data['genre_id'])) {
            die("Error: Event name, start date and genre are required fields.");
        }

        if ($data['end_date'] && $data['start_date'] > $data['end_date']) {
            die("Error: Start date must be earlier than end date.");
        }

        $query = "UPDATE " . $this->table_name . "
                SET name = :name, description = :description, start_date = :start_date, end_date = :end_date, 
                    image_url = :image_url, genre_id = :genre_id
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':image_url' => $data['image_url'],
            ':genre_id' => $data['genre_id']
        ]);
    }

    // Deletes an event from the database based on its ID
    public function deleteEvent($eventId)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            echo "Error deleting event: " . $errorInfo[2];
            return false;
        }
        return true;
    }
}
