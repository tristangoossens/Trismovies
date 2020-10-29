<?php
session_start();

if (isset($_SESSION['isLoggedIn'])) {
    if (!isset($_GET['movieID'])) {
        Header("Location: 404.php");
    }
    require("../../scripts/helper_functions.php");
    require("../../controllers/movieController.php");
    require("../../controllers/languageController.php");
    $mc = new MovieController();
    $lc = new LanguageController();

    $id = $_GET['movieID'];
} else {
    Header("Location: 403.php");
}

$id = $_GET['movieID'];
$movie = $mc->getMovieByID($id);
?>

<!doctype html>
<html lang="en">

<head>
    <title>Trismovies | ADD TRANSLATION</title>
    <link rel="icon" href="../../assets/img/TM.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../../assets/stylesheets/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

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

                <a class="nav-item nav-link" href="../CMS/addMovie.php">Add movie</a>
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

    <div class="container pt-5">

        <h1 class="font-weight-bold text-uppercase text-center">Please add a translation for <span style="color: #FEC728"><?php echo $movie->title ?></span></h1>
        <p class="font-weight-bold text-uppercase text-center">Fill in the form below</p>

        <form class="pt-4 pb-5" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="txtName" class="font-weight-bold text-uppercase">Movie name</label>
                <input type="text" class="form-control" name="txtName" placeholder="Title">
            </div>

            <div class="form-group">
                <label for="txtDescription" class="font-weight-bold text-uppercase">Description</label>
                <textarea class="form-control" placeholder="Overview" name="txtDescription" rows="3"></textarea>
            </div>


            <div class="form-group">
                <label for="cbLang" class="font-weight-bold text-uppercase">Genre</label>
                <select class="form-control" name="cbLang">
                    <?php
                    $lc->getUnusedLanguages($id);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <input class="movie-form-button btn btn-block text-uppercase font-weight-bold" type="submit" name="btnSubmit" data-target="formEmptyPopup" value="Submit">
            </div>
        </form>
    </div>

    <div class="modal fade" id="formEmptyPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Empty fields!!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Please fill in all fields before adding a translation
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['btnSubmit'])) {
        $name = $_POST['txtName'];
        $desc = $_POST['txtDescription'];
        $genre = $_POST['cbLang'];

        $formArray = array('txtName', 'txtDescription', 'cbLang');


        if (!checkTranslationFormEmpty($formArray)) {
            $lc->addMovieLanguage($name, $desc, $id, $genre);
            echo ("<script>location.href = 'addTranslation.php?movieID=$id';</script>");
        } else {
    ?>
            <script>
                $("#formEmptyPopup").modal('show');
            </script>
    <?php
        }
    }
    ?>
</body>

</html>