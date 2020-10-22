<?php
session_start();
require('../../controllers/apiController.php');
$ac = new APIController();

$moviename = $_GET['name'];

$r = $ac->getMovies($moviename);
?>

<!doctype html>
<html lang="en">

<head>
    <title>Trismovies | MOVIES</title>
    <link rel="icon" href="../../assets/img/TM.png">
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../assets/stylesheets/styles.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript" src="../../scripts/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body class="movie-index">
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

    <div class="movie-index-items container pt-5 pb-5">
        <h1 class="text-center text-uppercase pt-5 pb-5 font-weight-bold">Search result for <span style="color: #FEC728;">"<?php echo $moviename ?>"</span></h1>
        <?php
        foreach ($r as $v) {
            if (is_array($v) || is_object($v)) {
                foreach ($v as $vv) {
                    if ($vv['vote_count'] >= 0) {
                        $poster = $vv['poster_path'];
                        $id = $vv['id'];
        ?>
                        <div class="movie-index-items-card card border-0 shadow-lg">
                            <div class="row no-gutters">
                                <div class="col-auto">
                                    <img class="APImovieIMG" onerror="ifPosterNotFoundOverview(this);" src="<?php echo "https://image.tmdb.org/t/p/w500$poster" ?>" class="img-fluid" width="200px" height="300px">
                                </div>
                                <div class="col pl-3 pt-2">
                                    <div class="card-block px-2">
                                        <h4 class="card-title"><?php echo $vv['title']; ?></h4>
                                        <p class="card-text"><?php echo $vv['overview']; ?></p>
                                        <a class="stretched-link btn" href="<?php echo "APImovieinfo.php?movieID=$id" ?>" style="background-color: #FEC728">View more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
        <?php
                    }
                }
            }
        }
        ?>
    </div>

    <footer class="trismovies-footer page-footer font-small">
        <div class="text-center text-white text-uppercase font-weight-bold py-2">
            <img src="../../assets/img/TM.png" width="30" height="30" class="d-inline-block align-top">
            <span style="color: #FEC728">Tris</span>movies
        </div>
    </footer>
</body>

</html>