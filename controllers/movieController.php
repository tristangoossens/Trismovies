<?php
class MovieController
{

    private $conn;

    public function __construct()
    {
        $conn = new PDO("mysql:host=localhost;dbname=trismovies;", "root", "");
        $this->conn = $conn;
    }

    public function addMovie($name, $releaseDate, $image, $background, $trailer, $description, $duration, $genreID)
    {
        $query = "INSERT into movie (title, release_date, poster, background, trailer_url,  description, duration, genreID)
        values ('$name', '$releaseDate', '$image', '$background', '$trailer', '$description', '$duration', '$genreID')";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            echo ("<script>location.href = '../movies.php';</script>");
        } else {
            print_r($stm->errorInfo());
        }
    }

    public function editMovie($id, $name, $releaseDate, $image, $background, $trailer, $description, $duration, $genreID)
    {
        $query = "UPDATE movie SET title='$name', release_date='$releaseDate', poster='$image', background='$background', trailer_url='$trailer', description='$description', duration='$duration', genreID='$genreID' 
                  WHERE id = $id";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            echo ("<script>location.href = '../movieInfo.php?movieID=$id';</script>");
        } else {
            print_r($stm->errorInfo());
        }
    }

    public function deleteMovie($id)
    {
        $query = "DELETE FROM `movie` WHERE `movie`.`id` = $id";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            Header("Location: ../movies.php");
        } else {
            print_r($stm->errorInfo());
        }
    }

    public function listGenres()
    {
        $query = "SELECT * FROM `genre`";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchall(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function printGenres()
    {

        $query = "SELECT * FROM `genre`";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            while ($result = $stm->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $result["id"] . "'> " . $result["name"] . "</option>";
            }
        }
    }

    public function getMovieGenre($genreID)
    {
        $query = "SELECT * FROM `genre` WHERE id = $genreID";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result->name;
        }
    }

    public function getMovieByID($id)
    {
        $query = "SELECT * FROM movie INNER JOIN genre ON movie.genreID=genre.id WHERE movie.id =:id";

        $stm = $this->conn->prepare($query);
        $stm->bindparam(":id", $id);
        if ($stm->execute()) {
            $result = $stm->fetch(PDO::FETCH_OBJ);
            return $result;
        }
    }

    public function searchMovies($search)
    {
        $query = "SELECT * FROM movie WHERE title LIKE '%$search%'";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }
    }

    public function getSimilarMovies($movieID, $genreID)
    {
        $query = "SELECT poster, id FROM movie WHERE id != $movieID AND genreID = $genreID";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }
    }

    public function listMovies()
    {
        $query = "SELECT * FROM movie";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
    }
}
