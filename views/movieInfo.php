<?php
session_start();
require('../controllers/movieController.php');
require('../controllers/languageController.php');
require('../scripts/helper_functions.php');
$id = $_GET['movieID'];

$c = new MovieController();
$lc = new LanguageController();
$movie = $c->getMovieByID($id);
$langs = $lc->getAllLanguages();

$movietitle = $movie->title;
$moviedesc = $movie->description;

if (isset($_GET['langID'])) {
    $lc->setLanguage($_GET['langID']);
}

if (isset($_SESSION['LANG'])) {
    $movietranslated = $lc->getMovieTranslation($_SESSION['LANG'], $id);

    $movietitle = $movietranslated->movietitle;
    $moviedesc = $movietranslated->moviedescription;
}

?>



<!doctype html>
<html lang="en">

<head>
    <title>Trismovies | <?php echo $movie->title ?></title>
    <link rel="icon" href="../assets/img/TM.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../assets/stylesheets/styles.css">
    <script type="text/javascript" src="../scripts/script.js"></script>

    <script src="https://kit.fontawesome.com/b397a42a01.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <nav class="trismovies-navbar navbar navbar-expand-lg">
        <button class="trismovies-navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand text-uppercase font-weight-bold" href="index.php">
            <img src="../assets/img/TM.png" width="30" height="30" class="d-inline-block align-top">
            <span style="color: #FEC728">Tris</span>movies
        </a>

        <div class="collapse navbar-collapse text-uppercase font-weight-bold" id="navbarTogglerDemo03">
            <div class="navbar-nav mr-auto">
                <a class="nav-item nav-link" href="index.php">Home</a>
                <a class="nav-item nav-link active" href="movies.php">Movies</a>
                <?php
                if (isset($_SESSION['isLoggedIn'])) { ?>
                    <a class="nav-item nav-link" href="CMS/addMovie.php">Add movie</a>
                <?php } ?>
            </div>
            <div class="navbar-nav right">
                <div class="dropdown pr-2">
                    <button class="btn btn-secondary dropdown-toggle text-uppercase font-weight-bold" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Language
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php foreach ($langs as $lang) {
                        ?>
                            <a class="dropdown-item text-dark" href="movieInfo.php?movieID=<?php echo $id ?>&langID=<?php echo $lang->id ?>"><?php echo $lang->country . " - " . $lang->abbreviation ?></a>
                        <?php
                        } ?>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['isLoggedIn'])) { ?>
                    <span style="color: #fec728!important;" class="navbar-text text-white pr-2">User: <?php echo $_SESSION['user']; ?></span>
                    <a class="nav-item nav-link" href="user/logout.php">Logout</a>

                <?php
                } else { ?>
                    <a class="nav-item nav-link" href="user/login.php">Login</a>
                <?php
                }
                ?>
            </div>

        </div>
    </nav>

    <header class="movie-info-header d-flex text-white pt-5" style="background-image: url(<?php echo "data:image/jpeg;base64," . base64_encode($movie->background) . ""; ?>)">
        <div class="movie-info-header-details container py-5 m-auto">
            <div class="row">
                <div class="col-4">
                    <img class="movie-info-header-image img-fluid" width="500" height="750" src="<?php echo "data:image/jpeg;base64," . base64_encode($movie->poster) . ""; ?>">
                </div>
                <div class="col-8">
                    <div class="movie-info-header-details-title pt-5 pb-4">
                        <h2><?php echo $movietitle; ?></h2>
                    </div>
                    <div class="movie-info-header-details-facts pb-5">
                        <i class="fa fa-calendar-week"></i><span> <?php echo $movie->release_date; ?> &nbsp|&nbsp </span>
                        <i class="fa fa-video"></i><span> &nbsp<?php echo $movie->duration; ?>min &nbsp|&nbsp </span>
                        <i class="fa fa-film"></i><span> &nbsp<?php echo $movie->name; ?></span>
                    </div>

                    <div class="movie-info-header-details-overview pb-5">
                        <h3>Overview</h3>
                        <?php echo $moviedesc; ?>
                    </div>

                    <div class="movie-info-header-details-cinema">
                        <i style="font-size: 1.1rem;" class="fa fa-ticket-alt"></i><b> In cinema from </b><span style="font-size: 1.2rem; opacity: 0.8;"><?php echo $movie->in_theatre_from; ?></span> <b>until</b> <span style="font-size: 1.2rem; opacity: 0.8;"><?php echo $movie->in_theatre_until; ?></span>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </header>

    <section class="movie-info-media">
        <div class="container text-center">
            <div class="row justify-content-center pt-3 pb-5">
                <div class="col-12">
                    <h1 class="pt-4 pb-3 font-weight-bold text-uppercase">Media</h1>
                </div>
                <div class="col-12 col-md-6 pt-3">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="<?php echo "https://www.youtube.com/embed/$movie->trailer_url"; ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="movie-info-reservation">
        <div class="container pb-5">
            <h1 class="text-center text-uppercase text-white font-weight-bold mt-5 pt-5 pb-5"><span style="color: #FEC728">Book</span> your seat now!!</h1>
            <h3 class="text-center text-uppercase text-white font-weight-bold pt-3 pb-2">Date and time selection</h3>
            <div class="row">
                <div class="col-12 text-center">
                    <?php
                    $shows = $c->getAllMoviePlaytimes($id);

                    foreach ($shows as $show) {
                        $day = $day = date('l', strtotime($show->date));
                    ?>
                        <p class="text-white text-uppercase font-weight-bold pb-1"><span style="color: #FEC728;">Date: </span><?php echo $day . " - " . $show->date  . "<br/>" ?><span style="color: #FEC728;">Time: </span><?php echo $show->starttime . " - " . calculateTime($show->starttime, $movie->duration) ?></p>

                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </section>

    <section class="movie-info-similar pb-2">
        <div class="container text-center my-3">
            <h1 class="pt-3 pb-3 text-uppercase font-weight-bold">Similar <span style="color: #FEC728;">movies</span></h1>
            <div class="row justify-content-center">
                <?php
                $movies = $c->getSimilarMovies($id, $movie->genreID);

                foreach ($movies as $m) {
                ?>
                    <div class="home-movie-card pb-3 pt-3 pl-3 col-3">
                        <a href="movieinfo.php?movieID=<?php echo $m->id; ?>"><img width="300" height="450" class="home-movie-card-image img-fluid" src="<?php echo "data:image/jpeg;base64," . base64_encode($m->poster) . ""; ?>"></a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <footer class="trismovies-footer page-footer font-small">
        <div class="text-center text-white text-uppercase font-weight-bold py-2">
            <img src="../assets/img/TM.png" width="30" height="30" class="d-inline-block align-top">
            <span style="color: #FEC728">Tris</span>movies
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>