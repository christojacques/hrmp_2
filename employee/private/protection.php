<?php
include_once 'db.php';
session_start();

if (!isset($_SESSION['employee_role']) && isset($_COOKIE['employee_role'])) {
    $_SESSION['employee_role'] = $_COOKIE['employee_role'];
    $_SESSION['employeidno'] = $_COOKIE['employeidno'];
    $_SESSION['email'] = $_COOKIE['email'];
}

if (!isset($_SESSION['employee_role'])) {
    header("location:login");
}



$employeeid=$_SESSION['employeidno'];
$employee_query=mysqli_query($db,"SELECT * FROM `employees` WHERE `eid`='$employeeid'");
if (mysqli_num_rows($employee_query)>0) {
$fetch_employee=mysqli_fetch_assoc($employee_query);
$_SESSION['employeeFname']=$fetch_employee['fname'];
$_SESSION['employeeLname']=$fetch_employee['lname'];
}


// Profile Picture====================>
if (!empty($fetch_employee['profile_picture'])) {
$img=$fetch_employee['profile_picture'];
}else{
$img="employee_images/demo-avther.png";
}
// Profile Picture====================>
date_default_timezone_set('Africa/Kinshasa');


$currentURL = $_SERVER['REQUEST_URI'];
$parts = parse_url($currentURL);
$path = $parts['path'];
$filenamepage = basename($path);






$modulesquery=mysqli_query($db,"SELECT * FROM `modules`");
$lm_module=null;
$ts_module=null;
if (mysqli_num_rows($modulesquery)>0) {
    while( $fetchmodule=mysqli_fetch_assoc($modulesquery)){
            if ($fetchmodule['mf_id']==6) {
                if ($fetchmodule['module_status']==0 && $_SESSION['employee_role']=='employee') {
                    header('location:signout');
                }elseif($fetchmodule['module_status']==0){
                     //header('location:../administrator/');
                }
            }
            if ($fetchmodule['mf_id']==7) {
                $lm_module=$fetchmodule['module_status'];
            }
            if ($fetchmodule['mf_id']==8) {
                $ts_module=$fetchmodule['module_status'];
            }


    }
}

$filepagenm=null;
if ($filenamepage=='vacation-calendar') {
   $filepagenm='true'; 
}elseif($filenamepage=='apply-for-leave'){
   $filepagenm='true';
}


if ($lm_module!=1 && $filepagenm=='true') {
    header('location:index');
}


?>