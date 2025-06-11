<?php 
include_once 'db.php';
session_start();

if (!isset($_SESSION['login_id']) && isset($_COOKIE['login_id'])) {
    $_SESSION['login_id'] = $_COOKIE['login_id']; // Auto-login from cookie
    $_SESSION['guardid'] = $_COOKIE['guardid']; // Auto-login from cookie
}

if (!isset($_SESSION['login_id'])) {
	header("location:login");
}




$gardid=$_SESSION['guardid'];
$getgardinfo=mysqli_query($db,"SELECT * FROM `guard` WHERE `gid`='$gardid'");
if (mysqli_num_rows($getgardinfo)>0) {
	$gardfetch=mysqli_fetch_assoc($getgardinfo);
}


$modulessql=mysqli_query($db,"SELECT * FROM `modules` WHERE `mf_id`=1");
if (mysqli_num_rows($modulessql)>0) {
	$fetchmodule=mysqli_fetch_assoc($modulessql);
}

if ($fetchmodule['module_status']=='0') {
	echo '<script>
	alert("404 Page Not Found.Please Try Again!");
	window.location.href="../";
	</script>';
}

 ?>