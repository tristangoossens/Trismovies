<?php
session_start();
require('../controllers/languageController.php');
$lc = new LanguageController();
$langs = $lc->getAllLanguages();

if (isset($_GET['run']) == true) {
   $lc->setLanguage($_GET['langID']);
}
?>

<!doctype html>
<html lang="en">

<head>
   <title>Trismovies | MOVIES</title>
   <link rel="icon" href="../assets/img/TM.png">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <link rel="stylesheet" href="../assets/stylesheets/styles.css">

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
                     <a class="dropdown-item text-dark" href="movies.php?run=true&langID=<?php echo $lang->id ?>"><?php echo $lang->country . " - " . $lang->abbreviation ?></a>
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

   <?php

   require('../controllers/movieController.php');
   $mc = new MovieController();
   $movies = $mc->listMovies();
   ?>

   <main>
      <div class="movie-index-items container pt-5 pb-5">
         <h1 class="text-center text-uppercase pt-5 pb-5 font-weight-bold">These are the current <span style="color: #FEC728;">"Trismovies"</span></h1>
         <form method="POST" autocomplete="off">
            <div class="input-group pb-5 pb-3">
               <input type="text" name="txtSearch" class="form-control" placeholder="Search movies">
               <div class="input-group-append">
                  <input type="submit" value="Search" name="btnSearch" class="btn" style="background-color: #FEC728">
               </div>
            </div>
         </form>
         <?php
         if (isset($_POST['btnSearch'])) {
            $movies = $mc->searchMovies($_POST['txtSearch']);
            $c = count($movies);
            echo "<h3 class='pt-3 pb-3 text-center text-uppercase font-weight-bold'>There were <span style='color: #FEC728;'>$c movie(s)</span> found</h3>";
         }


         if (is_array($movies) || is_object($movies)) {
            foreach ($movies as $movie) {
         ?>
               <div class="movie-index-items-card card border-0 shadow-lg">
                  <div class="row no-gutters">
                     <div class="col-auto">
                        <?php echo "<a href='movieInfo.php?movieID=$movie->id'><img src='data:image/jpeg;base64," . base64_encode($movie->poster) . "' width='200px' heigth='300px'></a>"; ?>
                     </div>
                     <div class="col pl-3 pt-3">
                        <div class="card-block px-2">
                           <?php if (isset($_SESSION['LANG'])) {
                              $translatedmovie = $lc->getMovieTranslation($_SESSION['LANG'], $movie->id);
                           ?>
                              <h4 class="card-title"><?php echo $translatedmovie->movietitle ?></h4>
                              <p class="card-text"><?php echo $translatedmovie->moviedescription ?></p>
                              <a class="stretched-link btn btn-secondary text-white" href="<?php echo "movieInfo.php?movieID=$movie->id" ?>">View more</a>
                           <?php
                           } else { ?>
                              <h4 class="card-title"><?php echo $movie->title ?></h4>
                              <p class="card-text"><?php echo $movie->description ?></p>
                              <a class="stretched-link btn btn-secondary text-white" href="<?php echo "movieInfo.php?movieID=$movie->id" ?>">View more</a>
                           <?php
                           }
                           ?>

                           <?php
                           if (isset($_SESSION['isLoggedIn'])) { ?>
                              <a class="btn text-white text-dark" style="background-color: #FEC728" href="CMS/editMovie.php?movieID=<?php echo $movie->id; ?>">Edit movie</a>
                              <a class="btn text-white text-dark" style="background-color: #FEC728" href="CMS/editTranslation.php?movieID=<?php echo $movie->id; ?>">Edit translations</a>
                              <a href="#deletePopup" class="btn btn-danger text-white" data-toggle="modal" data-target="#deletePopup-<?php echo $movie->id ?>">
                                 Delete movie
                              </a>
                           <?php
                           } ?>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="modal fade" id="deletePopup-<?php echo $movie->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Delete movie "<?php echo $movie->title ?>"?</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           Are you sure you want to delete this movie
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                           <a href="CMS/deleteMovie.php?movieID=<?php echo $movie->id; ?>" type="button" class="btn btn-danger">Confirm</a>
                        </div>
                     </div>
                  </div>
               </div>
         <?php
            }
         }
         ?>
      </div>
   </main>

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