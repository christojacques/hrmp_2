<?php include_once 'private/protection.php'; ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Guard Panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <!-- <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css"> -->
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="vendors/mdi/css/materialdesignicons.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Include DataTables CSS and JS -->
  <link rel="stylesheet" href="css/jquery.dataTables.min.css"/>
  <style>
    .main-panel {
    width: 100% !important;
  }
  </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo mr-5" href=""><img src="images/logo.svg" class="mr-2" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" href=""><img src="images/logo-mini.svg" alt="logo"/></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <ul class="navbar-nav mr-lg-2">
            
          </ul>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item">
             <a href="signout" class="dropdown-item">
                  <i class="ti-power-off text-primary"></i>
                  Se déconnecter
                </a>
            </li>
          </ul>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">