<?php include_once 'private/protection.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Panel collaborateur</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="date/jquery-ui.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <style>
iframe#\:1\.container {
    display: none !important;
}
  </style>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
          <a class="navbar-brand brand-logo" href="index">
            <h5>Panel collaborateur</h5>
          </a>
          <a class="navbar-brand brand-logo-mini" href="index">
          
          </a>
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-sort-variant"></span>
          </button>
        </div>  
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav navbar-nav-right">
         
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
              <img src="<?=$img;?>" alt="profile"/>
              <span class="nav-profile-name"><?=$fetch_employee['fname'];?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="my-profile">
                <i class="mdi mdi-account text-primary"></i>
               Voir le profil
              </a>
              <a href="signout" class="dropdown-item">
                <i class="mdi mdi-logout text-primary"></i>
                Déconnexion
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <?php if ($ts_module!=0) {?>
          <li class="nav-item">
            <a class="nav-link" href="index">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Feuille de temps</span>
            </a>
          </li>
        <?php } ?>
          <?php if($_SESSION['employee_role']=='DRH'){
            echo '<li class="nav-item">
            <a class="nav-link" href="../administrator">
              <i class="mdi mdi-account-convert menu-icon"></i>
              <span class="menu-title">Panel d’administration</span>
            </a>
          </li>';
          }elseif($_SESSION['employee_role']=='CEO'){
              echo '<li class="nav-item">
            <a class="nav-link" href="../administrator">
              <i class="mdi mdi-account-convert menu-icon"></i>
              <span class="menu-title">Panel d’administration</span>
            </a>
          </li>';
          }elseif($_SESSION['employee_role']=='Treasurer'){
              echo '<li class="nav-item">
            <a class="nav-link" href="../administrator">
              <i class="mdi mdi-account-convert menu-icon"></i>
              <span class="menu-title">Panel d’administration</span>
            </a>
          </li>';
          }elseif($_SESSION['employee_role']=='FINANCIAL DIRECTOR'){
              echo '<li class="nav-item">
            <a class="nav-link" href="../administrator">
              <i class="mdi mdi-account-convert menu-icon"></i>
              <span class="menu-title">Panel d’administration</span>
            </a>
          </li>';
          }

          if ($lm_module!=0) {
           ?>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="mdi mdi-calendar-blank menu-icon"></i>
              <span class="menu-title">Vacances</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu list-unstyled">
                <li class="nav-item"><a class="nav-link" href="vacation-calendar">Calendrier</a></li>
                <li class="nav-item"> <a class="nav-link" href="apply-for-leave">Demande de congé</a></li>
              </ul>
            </div>
          </li>
        <?php } ?>
         
        </ul>
      </nav>
      <!-- partial -->