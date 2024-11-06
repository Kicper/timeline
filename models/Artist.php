<?php
class Artist
{
    private $conn;
    private $table_name = "artists";

    // Constructor function to initialize the database connection for the Artist class
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Retrieves all artists from the database
    public function getAllArtists()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Retrieves all artists that belong to a specified genre
    public function getArtistsByGenre($genreId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE genre_id = :genre_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':genre_id', $genreId);
        $stmt->execute();
        return $stmt;
    }

    // Retrieves a single artist by its unique ID
    public function getArtistById($artistId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $artistId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Inserts a new artist into the database with specified details
    public function createArtist($name, $bio, $birthDate, $deathDate, $genreId, $imageUrl)
    {
        $name = $_POST['name'];
        $bio = $_POST['bio'];
        $birthDate = $_POST['birth_date'];
        $deathDate = !empty($_POST['death_date']) ? $_POST['death_date'] : null;
        $genreId = $_POST['genre'];

        if (empty($name) || empty($birthDate) || empty($genreId)) {
            die("Error: Artist name, birth date and genre are required fields.");
        }

        if ($deathDate && $birthDate > $deathDate) {
            die("Error: Start date must be earlier than end date.");
        }

        $query = "INSERT INTO " . $this->table_name . " (name, bio, birth_date, death_date, genre_id, image_url)
                VALUES (:name, :bio, :birth_date, :death_date, :genre_id, :image_url)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([
            ':name' => $name,
            ':bio' => $bio,
            ':birth_date' => $birthDate,
            ':death_date' => $deathDate,
            ':genre_id' => $genreId,
            ':image_url' => $imageUrl
        ])) {
            header('Location: index.php?action=timeline');
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            die("Error: Could not insert artist. " . $errorInfo[2]);
        }
    }

    // Updates an existing artist's details in the database
    public function updateArtist($id, $data)
    {
        if (empty($data['name']) || empty($data['birth_date']) || empty($data['genre'])) {
            die("Error: Artist name, birth date and genre are required fields.");
        }

        if ($data['death_date'] && $data['birth_date'] > $data['death_date']) {
            die("Error: Birth date must be earlier than death date.");
        }

        $query = "UPDATE " . $this->table_name . "
            SET name = :name, bio = :bio, birth_date = :birth_date, death_date = :death_date, 
                genre_id = :genre_id, image_url = :image_url
            WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':bio' => $data['bio'],
            ':birth_date' => $data['birth_date'],
            ':death_date' => $data['death_date'],
            ':genre_id' => $data['genre'],
            ':image_url' => $data['image_url']
        ]);
    }

    // Deletes an artist from the database based on its ID
    public function deleteArtist($artistId)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $artistId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            echo "Error deleting artist: " . $errorInfo[2];
            return false;
        }
        return true;
    }
}
