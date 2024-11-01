<?php
class Artist
{
    private $conn;
    private $table_name = "artists";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllArtists()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getArtistsByGenre($genreId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE genre_id = :genre_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':genre_id', $genreId);
        $stmt->execute();
        return $stmt;
    }

    public function getArtistById($artistId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $artistId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createArtist($name, $bio, $birthDate, $deathDate, $genreId, $imageUrl)
    {
        $name = $_POST['name'];
        $bio = $_POST['bio'];
        $birthDate = $_POST['birth_date'];
        $deathDate = !empty($_POST['death_date']) ? $_POST['death_date'] : null;
        $genreId = $_POST['genre'];
        $imageUrl = $_POST['image_url'];

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
}
