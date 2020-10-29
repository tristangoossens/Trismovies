<?php
session_start();

if (isset($_SESSION['isLoggedIn'])) {
    if (!isset($_GET['movieID'])) {
        Header("Location: 404.php");
    } else {
        require("../../controllers/movieController.php");
        require("../../controllers/languageController.php");

        $mc = new MovieController();
        $lc = new LanguageController();
        $id = $_GET['movieID'];

        $movie = $mc->getMovieByID($id);

        if (!is_object($movie)) {
            Header("Location: 404.php");
        } else {
            $mc->deleteMovie($id);
            $mc->deleteMovieBroadcasts($id);
            $lc->deleteMovieTranslations($id);
            Header("Location: ../movies.php");
        }
    }
} else {
    Header("Location: 403.php");
}
