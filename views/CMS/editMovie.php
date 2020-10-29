<?php
session_start();

if (isset($_SESSION['isLoggedIn'])) {
    if (!isset($_GET['movieID'])) {
        Header("Location: 404.php");
    } else {
        require('../../controllers/movieController.php');
        require('../../controllers/genreController.php');
        require('../../scripts/helper_functions.php');
        $id = $_GET['movieID'];
        $c = new MovieController();

        $movie = $c->getMovieByID($id);

        if (!is_object($movie)) {
            Header("Location: 404.php");
        }
    }
} else {
    Header("Location: 403.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Trismovies | EDIT MOVIES</title>
    <link rel="icon" href="../../assets/img/TM.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../../assets/stylesheets/styles.css">
    <script type="text/javascript" src="../../scripts/script.js"></script>
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

    <div class="container pt-5">

        <h1 class="font-weight-bold text-uppercase text-center">Wanna change a <span style="color: #FEC728">Tris</span>movie?</h1>
        <p class="font-weight-bold text-uppercase text-center">Edit it in the form below!!</p>

        <form class="pt-4 pb-5" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="txtName" class="font-weight-bold text-uppercase">Movie name</label>
                <input type="text" class="form-control" name="txtName" value="<?php echo $movie->title; ?>" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="dpDate" class="font-weight-bold text-uppercase">Release date</label>
                <input type="date" class="form-control" value="<?php echo $movie->release_date; ?>" name="dpDate">
            </div>

            <div class="form-group">
                <label for="txtDescription" class="font-weight-bold text-uppercase">Description</label>
                <textarea class="form-control" placeholder="Overview" name="txtDescription" rows="3"><?php echo $movie->description; ?></textarea>
            </div>

            <div class="form-group">
                <label for="txtTrailer" class="font-weight-bold text-uppercase">Trailer url</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">https://www.youtube.com/embed</span>
                    </div>
                    <input type="text" name="txtTrailer" class="form-control" value="<?php echo $movie->trailer_url; ?>" placeholder="Trailer path">
                </div>
            </div>

            <div class="form-group">
                <label for="txtDuration" class="font-weight-bold text-uppercase">Duration</label>
                <input type="number" placeholder="Duration in minutes" value="<?php echo $movie->duration; ?>" class="form-control" name="txtDuration">
            </div>

            <div class="form-group">
                <label for="cbGenre" class="font-weight-bold text-uppercase">Genre</label>
                <select class="form-control" name="cbGenre">
                    <?php
                    $gc = new GenreController();
                    $genres = $gc->listGenres();
                    foreach ($genres as $genre) {
                        if ($genre['id'] == $movie->genreID) {
                            echo "<option value='" . $genre["id"] . "' selected>" . $genre["name"] . "</option>";
                        } else {
                            echo "<option value='" . $genre["id"] . "'>" . $genre["name"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="row pb-3">
                <div class="col">
                    <label for="dpFrom" class="font-weight-bold text-uppercase">Startdate</label>
                    <input type="date" name="dpFrom" value="<?php echo $movie->in_theatre_from; ?>" class="form-control">
                </div>
                <div class="col">
                    <label for="dpUntil" class="font-weight-bold text-uppercase">Enddate</label>
                    <input type="date" name="dpUntil" value="<?php echo $movie->in_theatre_until; ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="posterFile" class="font-weight-bold text-uppercase">Poster</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="posterFile" name="posterFile">
                    <label class="custom-file-label" for="posterFile">Poster</label>
                </div>
                <img id="img-poster-preview" class="pt-3 pb-3" src="<?php echo "data:image/jpeg;base64," . base64_encode($movie->poster) . ""; ?>" width="400" height="550">
            </div>

            <div class="form-group">
                <label for="backgroundFile" class="font-weight-bold text-uppercase">Background image</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="backgroundFile" id="backgroundFile">
                    <label class="custom-file-label" for="backgroundFile">Background</label>
                </div>
                <img id="img-bg-preview" class="pt-3 pb-3" src="<?php echo "data:image/jpeg;base64," . base64_encode($movie->background) . ""; ?>" width="900" height="400">
            </div>

            <div class="form-group">
                <input class="movie-form-button btn btn-block text-uppercase font-weight-bold" type="submit" name="btnSubmit" value="Submit">
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
                    Please fill in all fields before editing a movie
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
        $duration = $_POST['txtDuration'];
        $genre = $_POST['cbGenre'];
        $release = $_POST['dpDate'];
        $trailer = $_POST['txtTrailer'];
        $startdate = $_POST['dpFrom'];
        $enddate = $_POST['dpUntil'];


        $formArray = array('txtName', 'txtDescription', 'txtDuration', 'cbGenre', 'dpDate', 'txtTrailer', 'dpFrom', 'dpUntil');


        if (!checkFormEmpty($formArray, $_FILES['posterFile'], $_FILES['backgroundFile'])) {
            $poster = addslashes(file_get_contents($_FILES['posterFile']['tmp_name']));
            $poster_naam = addslashes($_FILES['posterFile']['name']);

            $background = addslashes(file_get_contents($_FILES['backgroundFile']['tmp_name']));
            $background_naam = addslashes($_FILES['backgroundFile']['name']);

            $c->editMovie($id, $name, $release, $poster, $background, $trailer, $desc, $duration, $genre);
        } else {
    ?>
            <script>
                $("#formEmptyPopup").modal('show');
            </script>
    <?php
        }
    }
    ?>


    <footer class="trismovies-footer page-footer font-small">
        <div class="text-center text-white text-uppercase font-weight-bold py-2">
            <img src="../../assets/img/TM.png" width="30" height="30" class="d-inline-block align-top">
            <span style="color: #FEC728">Tris</span>movies
        </div>
    </footer>

    <script>
        function displayPoster(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#img-poster-preview').attr('src', event.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function displayBackground(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#img-bg-preview').attr('src', event.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#posterFile").change(function() {
            displayPoster(this);
        });

        $("#backgroundFile").change(function() {
            displayBackground(this);
        });
    </script>


</body>

</html>