<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <title>Trismovies | 403</title>
    <link rel="icon" href="../../assets/img/TM.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../../assets/stylesheets/styles.css">
    <script type="text/javascript" src="../../scripts/script.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
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
                <a class="nav-item nav-link active" href="../index.php">Home</a>
                <a class="nav-item nav-link" href="../movies.php">Movies</a>
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

    <header style="height: 100vh;" class="forbidden-403 align-items-center d-flex">
        <div class="container">
            <div class="row">
                <div class="col-12 m-auto text-uppercase font-weight-bold text-center">
                    <h1><span style="color: #FEC728">403 </span> forbidden</h1>
                    <p>Please login as an admin to view this page</p>
                </div>
            </div>
        </div>
    </header>


    <footer class="trismovies-footer page-footer font-small">
        <div class="text-center text-white text-uppercase font-weight-bold py-2">
            <img src="../../assets/img/TM.png" width="30" height="30" class="d-inline-block align-top">
            <span style="color: #FEC728">Tris</span>movies
        </div>
    </footer>
</body>