<?php
session_start();

if (isset($_SESSION['isLoggedIn'])) {
    Header("Location: ../index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Trismovies | LOGIN</title>
    <link rel="icon" href="../../assets/img/TM.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../../assets/stylesheets/styles.css">
    <script src="https://kit.fontawesome.com/b397a42a01.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
            </div>

            <div class="navbar-nav right">
                <a class="nav-item nav-link" href="#">Login</a>
            </div>
        </div>
    </nav>

    <header class="home-header d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-7">
                    <div class="login-card card border-0 rounded">
                        <div class="card-body">
                            <h3 class="card-title text-center">Sign in</h3>
                            <hr>
                            <form method="POST" autocomplete="off">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                        </div>
                                        <input type="text" name="txtUsername" class="form-control" placeholder="Enter username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                        </div>
                                        <input type="password" name="txtPassword" class="form-control" placeholder="******">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input class="login-card-button text-dark btn btn-block" type="submit" name="btnSubmit" value="Login">
                                </div>

                                <?php
                                if (isset($_POST['btnSubmit'])) {
                                    if (!empty($_POST['txtUsername']) && !empty($_POST['txtPassword'])) {
                                        require('../../controllers/loginController.php');

                                        $lc = new LoginController();

                                        $lc->Login($_POST['txtUsername'], $_POST['txtPassword']);
                                    }
                                }
                                ?>
                            </form>
                        </div>
                    </div>
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>