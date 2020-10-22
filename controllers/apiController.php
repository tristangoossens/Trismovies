<script type="text/javascript" src="../../scripts/script.js"></script>

<?php
class APIController
{

    public function getMovies($query)
    {
        $key = "";

        $url = "https://api.themoviedb.org/3/search/movie?api_key=$key&language=en-EN&query=$query&page=1&include_adult=false";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);

        if (is_array($response) || is_object($response)) {
            return $response;
        }
    }

    public function getMostPopularMovies()
    {
        $url = "https://api.themoviedb.org/3/movie/popular?api_key=&language=en-EN&page=1";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);

        if (is_array($response) || is_object($response)) {
            return $response;
        }
    }

    public function getMovieByID($id)
    {

        $url = "https://api.themoviedb.org/3/movie/$id?api_key=&append_to_response=videos, images, similar, credits&include_image_language=null&language=en-EN";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);

        if (is_array($response) || is_object($response)) {
            return $response;
        }
    }

    public function checkMovieHomepage($movie)
    {
        if ($movie['homepage'] == null) {
            return "../index.php";
        } else {
            $home = $movie['homepage'];
            return "$home";
        }
    }

    public function checkBackground($movie)
    {
        if ($movie['backdrop_path'] == null) {
            return "../../assets/img/background.jpg";
        } else {
            $bg = $movie['backdrop_path'];
            return "//image.tmdb.org/t/p/w1920_and_h800_multi_faces$bg";
        }
    }
}
?>