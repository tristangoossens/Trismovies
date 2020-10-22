<?php
class LoginController
{
    private $conn;

    public function __construct()
    {
        session_start();
        $conn = new PDO("mysql:host=localhost;dbname=trismovies;", "root", "");
        $this->conn = $conn;
    }

    public function Login($username, $password)
    {
        $query = "SELECT * FROM user WHERE username = :username";

        $stm = $this->conn->prepare($query);
        $stm->bindparam(":username", $username);

        if ($stm->execute()) {
            if ($stm->rowCount() != 0) {
                $result = $stm->fetch(PDO::FETCH_OBJ);

                if (password_verify($password, $result->password)) {
                    $_SESSION['isLoggedIn'] = TRUE;
                    $_SESSION['user'] = $result->username;

                    Header("Location: ../index.php");
                } else {
                    echo "<p class='text-center pt-1'>Your login details are incorrect</p>";
                }
            }
        }
    }

    public function Logout()
    {
        session_destroy();
    }
}
