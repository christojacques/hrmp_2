<?php include_once 'private/protection.php'; ?>
<!DOCTYPE html>
<html
  lang="fr"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
      <meta charset="UTF-8">
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Panel d’administration</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="assets/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="js/jquery-ui.min.css">
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <script src="assets/js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
<style>
input[type="search"] {
width: 300px;
height: 50px;
}
iframe#\:1\.container {
    display: none !important;
}
</style>
  <body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index" class="app-brand-link">
              <span class="app-brand-logo demo">
               Panel d’administration
              </span>
              
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item <?=($filenamepage=='index') ? 'active' :''?>">
              <a href="index" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Tableau de bord</div>
              </a>
            </li>
            <?php if ($ep_module!=0) { ?>
            <li class="menu-item">
              <a href="../employee/" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                
                <div data-i18n="Analytics">Mon panel Collaborateurs</div>
              </a>
            </li>
          <?php } ?>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Pages</span>
            </li>
            <?php if ( $_SESSION['employee_role']=="CEO"|| $_SESSION['employee_role']=="DRH") {?>
            <li class="menu-item
            <?php 

            if ($filenamepage=='manage-employee') {
              echo  'active open';
            }elseif($filenamepage=='view-employee.php'){
               echo  'active open';
            }elseif($filenamepage=='manage-weekly-work'){
               echo  'active open';
            }elseif($filenamepage=='view-weekly-submission.php'){
               echo  'active open';
            }elseif($filenamepage=='manage-monthly-report'){
               echo  'active open';
            }elseif($filenamepage=='monthly-ataglance.php'){
               echo  'active open';
            }elseif($filenamepage=='print-attendencesheet.php'){
               echo  'active open';
            }


            ?>

           ">
              <a class="menu-link menu-toggle">
                <i class='menu-icon bx bxs-briefcase-alt-2'></i>
                <div data-i18n="Manage Employee">Collaborateurs</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?=($filenamepage=='manage-employee') ? 'active open' :''?><?=($filenamepage=='view-employee.php') ? 'active open' :''?>">
                  <a href="manage-employee" class="menu-link">
                    <div data-i18n="Account">Gérer les Collaborateurs</div>
                  </a>
                </li>
                   <?php 
                    if ($ts_module!=0) { ?>
                <li class="menu-item <?=($filenamepage=='manage-weekly-work') ? 'active open' :''?><?=($filenamepage=='view-weekly-submission.php') ? 'active open' :''?>">
                  <a href="manage-weekly-work" class="menu-link">
                    <div data-i18n="Account">Rapports hebdomadaires</div>
                  </a>
                </li>
                <?php }
                 if ($ma_module!=0 || $ts_module!=0) { ?>
                 <li class="menu-item <?=($filenamepage=='manage-monthly-report') ? 'active open' :''?><?=($filenamepage=='monthly-ataglance.php') ? 'active open' :''?><?=($filenamepage=='print-attendencesheet.php') ? 'active open' :''?>">
                  <a href="manage-monthly-report" class="menu-link">
                    <div data-i18n="Account">Rapports mensuels</div>
                  </a>
                </li>

                <?php } ?>
              </ul>
            </li>
            <?php if ($ma_module!=0) { ?>

            <li class="menu-item
            <?php 
            if ($filenamepage=='manage-attendence') {
              echo  'active open';
            }elseif($filenamepage=='view-attendence.php'){
               echo  'active open';
            }
            ?>

           ">

              <a class="menu-link menu-toggle">
                <i class='menu-icon bx bxs-chart'></i>
                <div data-i18n="Manage Employee">Présence</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?=($filenamepage=='manage-attendence') ? 'active open' :''?><?=($filenamepage=='view-attendence.php') ? 'active open' :''?>">
                  <a href="manage-attendence" class="menu-link">
                    <div data-i18n="Account">Gérer les présences</div>
                  </a>
                </li>
              </ul>
            </li>
          <?php } }?>
             <?php if ( $_SESSION['employee_role']=="CEO"|| $_SESSION['employee_role']=="DRH") {?>
            <?php if ($lm_module!=0) { ?>
            <li class="menu-item 
            <?php 

            if ($filenamepage=='vacation-calendar') {
              echo  'active open';
            }elseif ($filenamepage=='leave-request') {
              echo  'active open';
            }elseif ($filenamepage=='manage-leave-type') {
              echo  'active open';
            }elseif ($filenamepage=='public_holiday') {
              echo  'active open';
            }

          ?>">
              <a class="menu-link menu-toggle">
                <i class='menu-icon bx bx-calendar-event'></i>
                <div data-i18n="Manage Employee">Gérer les vacances</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?=($filenamepage=='vacation-calendar') ? 'active open' :''?>">
                  <a href="vacation-calendar" class="menu-link">
                    <div data-i18n="Account">Calendrier des vacances</div>
                  </a>
                </li>
                <li class="menu-item <?=($filenamepage=='leave-request') ? 'active open' :''?>">
                  <a href="leave-request" class="menu-link">
                    <div data-i18n="Account">Demande de congé</div>
                  </a>
                </li>
                <li class="menu-item <?=($filenamepage=='manage-leave-type') ? 'active open' :''?>">
                  <a href="manage-leave-type" class="menu-link">
                    <div data-i18n="Account">Type de congé</div>
                  </a>
                </li>
                <li class="menu-item <?=($filenamepage=='public_holiday') ? 'active open' :''?>">
                  <a href="public_holiday" class="menu-link">
                    <div data-i18n="Account">Jours fériés</div>
                  </a>
                </li>
                
              </ul>
            </li>
          <?php } }?>

            <?php if ($_SESSION['employee_role']=="DRH" || $_SESSION['employee_role']=="CEO"|| $_SESSION['employee_role']=="Treasurer"|| $_SESSION['employee_role']=="FINANCIAL DIRECTOR") {?>
              
             <?php if ($mp_module!=0) { ?>
            <li class="menu-item
             <?php 
            if ($filenamepage=='generate_payroll') {
              echo  'active open';
            }elseif($filenamepage=='advance-salary.php'){
              echo  'active open';
            }elseif($filenamepage=='print_payroll-slip.php'){
              echo  'active open';
            }elseif($filenamepage=='pay-slip-perform'){
              echo  'active open';
            }elseif($filenamepage=='my-signature'){
              echo  'active open';
            }
            ?>

            ">

              <a class="menu-link menu-toggle">
                <i class='menu-icon bx bxl-paypal'></i>
                <div data-i18n="Manage Employee">Gestion de la rémunération</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?=($filenamepage=='generate_payroll') ? 'active open' :''?><?=($filenamepage=='advance-salary.php') ? 'active open' :''?><?=($filenamepage=='print_payroll-slip.php') ? 'active open' :''?>">
                  <a href="generate_payroll" class="menu-link">
                    <div data-i18n="Account">Générer fiche de paie</div>
                  </a>
                </li>
                <?php if ( $_SESSION['employee_role']=="CEO"|| $_SESSION['employee_role']=="Treasurer") {?>
                <li class="menu-item <?=($filenamepage=='pay-slip-perform') ? 'active open' :''?>">
                  <a href="pay-slip-perform" class="menu-link">
                    <div data-i18n="Account">Fiche de paie Perform</div>
                  </a>
                </li> 
                <?php }?>             
                <li class="menu-item <?=($filenamepage=='my-signature') ? 'active open' :''?>">
                  <a href="my-signature" class="menu-link">
                    <div data-i18n="Account">Ma signature</div>
                  </a>
                </li>
                
                
              </ul>
            </li>
            <?php } } ?>
           <?php if ( $_SESSION['employee_role']=="CEO"|| $_SESSION['employee_role']=="DRH") {?>
            <?php if ($gp_module!=0) { ?>
            <li class="menu-item <?=($filenamepage=='manage-guard') ? 'active open' :''?>">
              <a href="manage-guard" class="menu-link">
                <i class='menu-icon bx bx-user-voice'></i>
                <div data-i18n="Tables">Gérer les gardiens</div>
              </a>
            </li>
           <?php } } ?>
            <!-- Extended components -->
            
               
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../employee/<?=$img?>" alt class="w-px-40 h-auto rounded-circle" style="height: 40px !important;" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <span class="dropdown-item" style="background: none; color: none;">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../employee/<?=$img?>" alt class="w-px-40 h-auto rounded-circle" style="height: 40px !important;" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?=$fetch_employee["fname"]?></span>
                            <small class="text-muted"><?=$fetch_employee["employee_role"]?></small>
                          </div>
                        </div>
                      </span>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../employee/my-profile">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Mon profil</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="signout">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Se déconnecter</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->
