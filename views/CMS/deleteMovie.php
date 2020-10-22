<?php
session_start();

if (isset($_SESSION['isLoggedIn'])) {
    if (!isset($_GET['movieID'])) {
        Header("Location: 404.php");
    } else {
        require("../../controllers/movieController.php");

        $mc = new MovieController();
        $id = $_GET['movieID'];

        $movie = $mc->getMovieByID($id);

        if (!is_object($movie)) {
            Header("Location: 404.php");
        } else {
            $mc->deleteMovie($id);
        }
    }
} else {
    Header("Location: 403.php");
}
