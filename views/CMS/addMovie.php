<?php
session_start();

if (!isset($_SESSION['isLoggedIn'])) {
    Header("Location: 403.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Trismovies | ADD MOVIES</title>
    <link rel="icon" href="../../assets/img/TM.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../../assets/stylesheets/styles.css">
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

        <h1 class="font-weight-bold text-uppercase text-center">You got any new <span style="color: #FEC728">Tris</span>movies?</h1>
        <p class="font-weight-bold text-uppercase text-center">Add them in the form below!!</p>

        <form class="pt-4 pb-5" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="txtName" class="font-weight-bold text-uppercase">Movie name</label>
                <input type="text" class="form-control" name="txtName" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="dpDate" class="font-weight-bold text-uppercase">Release date</label>
                <input type="date" class="form-control" name="dpDate">
            </div>

            <div class="form-group">
                <label for="txtDescription" class="font-weight-bold text-uppercase">Description</label>
                <textarea class="form-control" placeholder="Overview" name="txtDescription" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="txtTrailer" class="font-weight-bold text-uppercase">Trailer</label>
                <input type="text" class="form-control" placeholder="https://www.youtube.com/embed" name="txtTrailer">
            </div>

            <div class="form-group">
                <label for="txtDuration" class="font-weight-bold text-uppercase">Duration</label>
                <input type="number" placeholder="Duration in minutes" class="form-control" name="txtDuration">
            </div>

            <div class="form-group">
                <label for="cbGenre" class="font-weight-bold text-uppercase">Genre</label>
                <select class="form-control" name="cbGenre">
                    <?php
                    require('../../controllers/movieController.php');
                    $c = new MovieController();
                    echo $c->printGenres();
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="txtDuration" class="font-weight-bold text-uppercase">Duration</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="posterFile" name="posterFile">
                    <label class="custom-file-label" for="posterFile">Poster</label>
                </div>
                <img id="img-poster-preview" class="pt-3 pb-3" src="../../assets/img/not-found.png" width="400" height="550">
            </div>

            <div class="form-group">
                <label for="backgroundFile" class="font-weight-bold text-uppercase">Background image</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="backgroundFile" id="backgroundFile">
                    <label class="custom-file-label" for="backgroundFile">Background</label>
                </div>
                <img id="img-bg-preview" class="pt-3 pb-3" src="../../assets/img/not-found.png" width="900" height="400">
            </div>

            <div class="form-group">
                <input class="movie-form-button btn btn-block text-uppercase font-weight-bold" type="submit" name="btnSubmit" value="Submit">
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['btnSubmit'])) {
        $name = $_POST['txtName'];
        $desc = $_POST['txtDescription'];
        $duration = $_POST['txtDuration'];
        $genre = $_POST['cbGenre'];
        $release = $_POST['dpDate'];
        $trailer = $_POST['txtTrailer'];

        $poster = addslashes(file_get_contents($_FILES['posterFile']['tmp_name']));
        $poster_naam = addslashes($_FILES['posterFile']['name']);

        $background = addslashes(file_get_contents($_FILES['backgroundFile']['tmp_name']));
        $background_naam = addslashes($_FILES['backgroundFile']['name']);

        $c->addMovie($name, $release, $poster, $background, $trailer, $desc, $duration, $genre);
    }
    ?>

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