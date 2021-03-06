<?php
session_start();
require('../../controllers/apiController.php');
require('../../scripts/helper_functions.php');

$id = $_GET['movieID'];

$c = new APIController();
$movie = $c->getMovieByID($id);

?>



<!doctype html>
<html lang="en">

<head>
    <title>Trismovies | <?php echo $movie['title']; ?></title>
    <link rel="icon" href="../../assets/img/TM.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../../assets/stylesheets/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b397a42a01.js" crossorigin="anonymous"></script>


    <script type="text/javascript" src="../../scripts/script.js"></script>
</head>

<body class="movie-info">
    <nav class="trismovies-navbar navbar navbar-expand-lg">
        <button class="trismovies-navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand text-uppercase font-weight-bold" href="index.php">
            <img src="../../assets/img/TM.png" width="30" height="30" class="d-inline-block align-top">
            <span style="color: #FEC728">Tris</span>movies
        </a>

        <div class="collapse navbar-collapse text-uppercase font-weight-bold" id="navbarTogglerDemo03">
            <div class="navbar-nav mr-auto">
                <a class="nav-item nav-link" href="../index.php">Home</a>
                <a class="nav-item nav-link active" href="../movies.php">Movies</a>
                <?php
                if (isset($_SESSION['isLoggedIn'])) { ?>
                    <a class="nav-item nav-link" href="../CMS/addMovie.php">Add movie</a>
                <?php } ?>
            </div>
            <?php
            if (isset($_SESSION['isLoggedIn'])) { ?>
                <div class="navbar-nav right">
                    <span style="color: #fec728!important;" class="navbar-text text-white pr-2">User: <?php echo $_SESSION['user']; ?></span>
                    <a class="nav-item nav-link" href="../user/logout.php">Logout</a>
                </div>
            <?php
            } else { ?>
                <div class="navbar-nav right">
                    <a class="nav-item nav-link" href="../user/login.php">Login</a>
                </div>
            <?php
            }
            ?>

        </div>
    </nav>


    <header class="movie-info-header d-flex text-white pt-5" style="background-image: url(<?php echo $c->checkBackground($movie); ?>)">
        <div class="movie-info-header-details container py-5 m-auto">
            <div class="row">
                <div class="col-4">
                    <img class="movie-info-header-image img-fluid" width="500" height="750" onerror="ifPosterNotFoundOverview(this);" src="https://image.tmdb.org/t/p/w500<?php echo $movie['poster_path']; ?>">
                </div>
                <div class="col-8">
                    <div class="movie-info-header-details-title pt-5 pb-4">
                        <h2><?php echo $movie['title']; ?></h2>
                        <i class="fa fa-star"></i><span style="font-size: 1.2rem;"> <?php echo $movie['vote_average']; ?></span>
                        <span style="opacity: 0.8; font-size: 0.8rem;">(<?php echo $movie['vote_count']; ?>)</span>
                    </div>
                    <div class="movie-info-header-details-facts pb-5">
                        <i class="fa fa-calendar-week"></i><span> <?php echo $movie['release_date']; ?> &nbsp|&nbsp </span>
                        <i class="fa fa-video"></i><span> &nbsp<?php echo $movie['runtime']; ?>min &nbsp|&nbsp </span>
                        <?php if ($movie['genres'] != null) : ?><i class="fa fa-film"></i><span> &nbsp<?php echo $movie['genres'][0]['name']; ?></span><?php endif; ?>
                    </div>


                    <div class="movie-info-header-details-overview">
                        <h3>Overview</h3>
                        <?php echo $movie['overview']; ?>
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

                <?php

                $movievideos = $movie['videos'];
                if (count($movievideos['results']) != 0) {
                    foreach ($movievideos as $results) {
                        foreach ($results as $videos) {
                            $url = $videos['key'] ?>
                            <div class="col-12 col-md-6 pt-3">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="<?php echo "https://www.youtube.com/embed/$url"; ?>"></iframe>
                                </div>
                            </div>
                    <?php }
                    }
                } else {
                    ?>
                    <p class='pt-3 pb-3 text-uppercase font-weight-bold'>There were <span style='color: #FEC728;'>0 videos</span> found</p>
                <?php
                } ?>
            </div>
        </div>
    </section>

    <section class="movie-info-similar pb-2">
        <div class="container text-center my-3">
            <h1 class="pt-3 pb-3 text-white text-uppercase font-weight-bold">Similar <span style="color: #FEC728;">movies</span></h1>
            <div class="row justify-content-center">
                <?php
                $response = $movie['similar'];
                if (count($response['results']) != 0) {
                    foreach ($response as $v) {
                        if (is_array($v) || is_object($v)) {
                            foreach ($v as $key => $vv) {

                                $poster = $vv['poster_path'];
                                $id = $vv['id']; ?>

                                <div class="home-movie-card pb-3 pt-3 pl-3 col-3">
                                    <a href="APImovieinfo.php?movieID=<?php echo $id; ?>"><img width="300" height="450" class="home-movie-card-image img-fluid" onerror="ifPosterNotFoundOverview(this);" src="<?php echo "https://image.tmdb.org/t/p/w500$poster" ?>"></a>
                                </div>
                    <?php
                            }
                        }
                    }
                } else { ?>
                    <p class='pt-3 pb-3 text-white text-uppercase font-weight-bold'>There were <span style='color: #FEC728;'>0 similar movies</span> found</p>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <footer class="trismovies-footer page-footer font-small">
        <div class="text-center text-white text-uppercase font-weight-bold py-2">
            <img src="../../assets/img/TM.png" width="30" height="30" class="d-inline-block align-top">
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