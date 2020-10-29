<?php

class LanguageController
{

    public function __construct()
    {
        $conn = new PDO("mysql:host=localhost;dbname=trismovies;", "root", "");
        $this->conn = $conn;
    }

    public function addMovieLanguage($movieTitle, $movieDescription, $movieID, $languageID)
    {
        $query = "INSERT INTO movie_language VALUES(0, '$movieTitle' , '$movieDescription', '$movieID' , '$languageID')";
        $stm = $this->conn->prepare($query);
        if (!$stm->execute()) {
            print_r($stm->errorInfo());
        }
    }

    public function editTranslation($movieTitle, $movieDescription, $movieID, $languageID)
    {
        $mt = $this->getMovieTranslation($languageID, $movieID);
        $movietranslationid = $mt->id;
        $query = "UPDATE movie_language SET movietitle='$movieTitle', moviedescription='$movieDescription' WHERE id = $movietranslationid AND movieID = $movieID AND languageID = $languageID";

        $stm = $this->conn->prepare($query);
        if (!$stm->execute()) {
            print_r($stm->errorInfo());
        }
    }

    public function deleteMovieTranslations($movieID)
    {
        $query = "DELETE FROM `movie_language` WHERE `movieid` = $movieID";

        $stm = $this->conn->prepare($query);
        if (!$stm->execute()) {
            print_r($stm->errorInfo());
        }
    }

    public function getMovieTranslation($languageID, $movieID)
    {
        $query = "SELECT * FROM `movie_language` WHERE languageID = $languageID AND movieID = $movieID";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetch(PDO::FETCH_OBJ);
            return $result;
        }
    }

    public function getAllLanguages()
    {
        $query = "SELECT * FROM `language`";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $allLanguages = $stm->fetchAll(PDO::FETCH_OBJ);
            return $allLanguages;
        }
    }

    public function setLanguage($id)
    {
        $_SESSION['LANG'] = $id;
    }

    public function getUnusedLanguages($movieID)
    {
        $usedquery = "SELECT ml.languageID AS id, l.country, l.abbreviation FROM movie_language ml INNER JOIN language l ON l.id=ml.languageID WHERE ml.movieID = $movieID";
        $stm = $this->conn->prepare($usedquery);
        if ($stm->execute()) {
            $usedLanguages = $stm->fetchAll(PDO::FETCH_OBJ);
        }

        $query = "SELECT id, country, abbreviation FROM language";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $allLanguages = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($allLanguages as $aLanguage) {
                if (!in_array($aLanguage, $usedLanguages)) {
                    echo "<option value='" . $aLanguage->id . "'> " . $aLanguage->country  . " - " . $aLanguage->abbreviation .  "</option>";
                }
            }
        }
    }
}
