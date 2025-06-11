<?php 
include_once 'db.php';
include_once 'before-end-month-email.php';
session_start();

if (!isset($_SESSION['employee_role']) && isset($_COOKIE['employee_role'])) {
    $_SESSION['employee_role'] = $_COOKIE['employee_role'];
    $_SESSION['employeidno'] = $_COOKIE['employeidno'];
    $_SESSION['email'] = $_COOKIE['email'];
}




if (!isset($_SESSION['employee_role'])) {
    header("location:login");  
}elseif($_SESSION['employee_role']=='DRH'){

}elseif($_SESSION['employee_role']=='CEO'){

}elseif($_SESSION['employee_role']=='Treasurer'){

}elseif($_SESSION['employee_role']=='FINANCIAL DIRECTOR'){

}elseif($_SESSION['employee_role']=='employee'){
    header("location: ../employee/");
}else{
    header("location:login");  
}

$employeeid=$_SESSION['employeidno'];

$employee_query=mysqli_query($db,"SELECT * FROM `employees` WHERE `eid`='$employeeid'");

if (mysqli_num_rows($employee_query)>0) {
    $fetch_employee=mysqli_fetch_assoc($employee_query);

}

// Profile Picture====================>
if (!empty($fetch_employee['profile_picture'])) {
$img=$fetch_employee['profile_picture'];
}else{
$img="employee_images/demo-avther.png";
}
// Profile Picture====================>

$currentURL = $_SERVER['REQUEST_URI'];
$parts = parse_url($currentURL);
$path = $parts['path'];
$filenamepage = basename($path);


$modulesquery=mysqli_query($db,"SELECT * FROM `modules`");
$gp_module=null;
$lm_module=null;
//$me_module=null;
$ma_module=null;
$mp_module=null;
$ep_module=null;
$elm_module=null;
$ts_module=null;
if (mysqli_num_rows($modulesquery)>0) {
    while( $fetchmodule=mysqli_fetch_assoc($modulesquery)){
            if ($fetchmodule['mf_id']==1) {
                $gp_module=$fetchmodule['module_status'];
            }
            // if ($fetchmodule['mf_id']==2) {
            //     $me_module=$fetchmodule['module_status'];
            // }
            if ($fetchmodule['mf_id']==3) {
                $ma_module=$fetchmodule['module_status'];
            }
            if ($fetchmodule['mf_id']==4) {
                $lm_module=$fetchmodule['module_status'];
            }
            if ($fetchmodule['mf_id']==5) {
                $mp_module=$fetchmodule['module_status'];
            }
            if ($fetchmodule['mf_id']==6) {
                $ep_module=$fetchmodule['module_status'];
            }
            if ($fetchmodule['mf_id']==7) {
                $elm_module=$fetchmodule['module_status'];
            }
            if ($fetchmodule['mf_id']==8) {
                $ts_module=$fetchmodule['module_status'];
            }
            

    }
}



$filepagenm=[];
$filepagenm1=[];
$filepagenm2=[];
if ($filenamepage=='vacation-calendar') {
   $filepagenm=[4]; 
}elseif($filenamepage=='manage-weekly-work'){
   $filepagenm=[8];
}elseif($filenamepage=='view-weekly-submission'){
   $filepagenm=[8];
}elseif($filenamepage=='manage-monthly-report'){
   $filepagenm1=[8];
   $filepagenm2=[3];
   
}elseif($filenamepage=='print-timesheet'){
   $filepagenm=[8];
}elseif($filenamepage=='monthly-ataglance'){
   $filepagenm=[8];
}elseif($filenamepage=='print-attendencesheet'){
   $filepagenm=[3];
}elseif($filenamepage=='manage-attendence'){
   $filepagenm=[3];
}elseif($filenamepage=='vacation-calendar'){
   $filepagenm=[4];
}elseif($filenamepage=='leave-request'){
   $filepagenm=[4];
}elseif($filenamepage=='manage-leave-type'){
   $filepagenm=[4];
}elseif($filenamepage=='public_holiday'){
   $filepagenm=[4];
}elseif($filenamepage=='generate_payroll'){
   $filepagenm=[5];
}elseif($filenamepage=='advance-salary'){
    $filepagenm=[5];
}elseif($filenamepage=='print_payroll-slip'){
    $filepagenm=[5];
}elseif($filenamepage=='my-signature'){
   $filepagenm=[5];
}elseif($filenamepage=='manage-guard'){
    $filepagenm=[1];
}elseif($filenamepage=='view-weekly-submission.php'){
    $filepagenm=[8];
}else{
     $filepagenm=[];
}







if($gp_module!=1 && in_array(1, $filepagenm)) { 
    header('location:index');
}

if($lm_module!=1 && in_array(4, $filepagenm)) { 
    header('location:index');
}

if($ma_module!=1 && in_array(3, $filepagenm)){
    header('location:index');
}
if($mp_module!=1 && in_array(5, $filepagenm)){
    header('location:index');
}
if($ts_module!=1 && in_array(8, $filepagenm1)){
    if($ma_module!=1 && in_array(3, $filepagenm2)){
        header('location:index');
    }
}






?>


