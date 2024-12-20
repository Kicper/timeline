<?php
class Album
{
    private $conn;
    private $table_name = "albums";

    // Constructor function to initialize the database connection for the Album class
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Retrieves all albums that belong to a specified genre
    public function getAlbumsByGenre($genreId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE genre_id = :genre_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':genre_id', $genreId);
        $stmt->execute();
        return $stmt;
    }

    // Retrieves a single album by its unique ID
    public function getAlbumById($albumId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $albumId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Inserts a new album into the database with specified details
    public function createAlbum($title, $releaseDate, $genreId, $artistId, $imageUrl, $description)
    {
        $title = $_POST['title'];
        $releaseDate = $_POST['release_date'];
        $genreId = $_POST['genre_id'];
        $artistId = $_POST['artist_id'];
        $description = $_POST['description'];

        if (empty($title) || empty($releaseDate) || empty($genreId) || empty($artistId)) {
            die("Error: Album title, release date, genre and artist are required fields.");
        }

        $query = "INSERT INTO " . $this->table_name . " (title, release_date, genre_id, artist_id, cover_image_url, description)
                VALUES (:title, :release_date, :genre_id, :artist_id, :cover_image_url, :description)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([
            ':title' => $title,
            ':release_date' => $releaseDate,
            ':genre_id' => $genreId,
            ':artist_id' => $artistId,
            ':cover_image_url' => $imageUrl,
            ':description' => $description
        ])) {
            header('Location: index.php?action=timeline');
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            die("Error: Could not insert album. " . $errorInfo[2]);
        }
    }

    // Updates an existing album's details in the database
    public function updateAlbum($id, $data)
    {
        $query = "UPDATE " . $this->table_name . "
                SET title = :title, release_date = :release_date, genre_id = :genre_id, artist_id = :artist_id, 
                    cover_image_url = :cover_image_url, description = :description
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':release_date' => $data['release_date'],
            ':genre_id' => $data['genre_id'],
            ':artist_id' => $data['artist_id'],
            ':cover_image_url' => $data['cover_image_url'],
            ':description' => $data['description']
        ]);
    }

    // Deletes an album from the database based on its ID
    public function deleteAlbum($albumId)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $albumId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            echo "Error deleting album: " . $errorInfo[2];
            return false;
        }
        return true;
    }
}
