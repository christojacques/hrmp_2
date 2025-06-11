<?php 

session_start();
session_unset();
session_destroy();
setcookie("login_id", "", time() - 3600, "/"); // Expire cookie
setcookie("guardid", "", time() - 3600, "/"); // Expire cookie
header("location:login");
 ?>