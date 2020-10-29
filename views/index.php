<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
   <title>Trismovies | HOME</title>
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
            <a class="nav-item nav-link active" href="index.php">Home</a>
            <a class="nav-item nav-link" href="movies.php">Movies</a>
            <?php
            if (isset($_SESSION['isLoggedIn'])) { ?>
               <a class="nav-item nav-link" href="CMS/addMovie.php">Add movie</a>
            <?php } ?>
         </div>
         <?php
         if (isset($_SESSION['isLoggedIn'])) { ?>
            <div class="navbar-nav right">
               <span style="color: #fec728!important;" class="navbar-text text-white pr-2">User: <?php echo $_SESSION['user']; ?></span>
               <a class="nav-item nav-link" href="user/logout.php">Logout</a>
            </div>
         <?php
         } else { ?>
            <div class="navbar-nav right">
               <a class="nav-item nav-link" href="user/login.php">Login</a>
            </div>
         <?php
         }
         ?>

      </div>
   </nav>
   <header class="home-header d-flex align-items-center">
      <div class="container">
         <div class="row">
            <div class="home-header-content col-12 col-md-8 m-auto text-center bg-transparent">
               <h1 style="font-size: 4rem;" class="text-white text-uppercase font-weight-bold"><span style="color: #FEC728;">Tris</span>movies</h1>
               <p class="text-white text-uppercase font-weight-bold pt-1">The best movies in the world</p>
               <form method="POST" autocomplete="off">
                  <div class="input-group pb-5 mb-3">
                     <input type="text" name="txtSearch" class="form-control" placeholder="Search movies">
                     <div class="input-group-append">
                        <input type="submit" value="Search" name="btnSearch" class="btn" style="background-color: #FEC728">
                     </div>
                  </div>
               </form>
               <div class="home-header-arrow">
                  <p class="font-weight-bold">Popular Movies</p>
                  <a href="#info"><img src="../assets/img/arrow.png" height="30"></a>
               </div>
            </div>
         </div>
   </header>

   <?php
   if (isset($_POST['btnSearch'])) {
      $query = $_POST['txtSearch'];

      Header("Location: API/APIindex.php?name=$query");
   }
   ?>


   <main id="info">
      <div class="container pb-5">
         <h1 class="text-center text-uppercase pt-5 pb-5 font-weight-bold">Most popular <span style="color: #FEC728;">movies!</span></h1>
         <div class="row justify-content-center">
            <?php
            require('../controllers/apiController.php');

            $c = new APIController();
            $response = $c->getMostPopularMovies();

            foreach ($response as $v) {
               if (is_array($v) || is_object($v)) {
                  foreach ($v as $vv) {
                     $poster = $vv['poster_path'];
                     $id = $vv['id'];
            ?>
                     <div class="home-movie-card mb-3 mt-3 pl-3 col-3">
                        <a href="API/APImovieinfo.php?movieID=<?php echo $id; ?>"><img class="home-movie-card-image img-fluid" src="<?php echo "https://image.tmdb.org/t/p/w500$poster" ?>"></a>
                     </div>

            <?php
                  }
               }
            }
            ?>
         </div>
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