<?php

class GenreController
{
    public function __construct()
    {
        $conn = new PDO("mysql:host=localhost;dbname=trismovies;", "root", "");
        $this->conn = $conn;
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

    public function listGenres()
    {
        $query = "SELECT * FROM `genre`";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchall(PDO::FETCH_ASSOC);
            return $result;
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
}
