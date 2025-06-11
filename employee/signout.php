<?php 

session_start();
session_unset();
session_destroy();
setcookie("employee_role", "", time() - 3600, "/"); // Expire cookie
setcookie("employeidno", "", time() - 3600, "/"); // Expire cookie
setcookie("email", "", time() - 3600, "/"); // Expire cookie
header("location:login");
 ?>