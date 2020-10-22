<?php
require('../../controllers/loginController.php');
$lc = new LoginController();
$lc->Logout();
Header("Location: ../index.php");
