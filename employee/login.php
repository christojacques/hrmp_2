<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Employee Admin Panel Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <?php 

  include_once 'private/users-authentication.php';

   ?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <!-- <img src="images/logo.svg" alt="logo"> -->
                <h3><a href="../" class="btn btn-sm  btn-warning" >🔙 Retour</a> Compte Collaborateur</h3>
              </div>
              <h4>Bonjour, cher collaborateur !</h4>
              <h6 class="font-weight-light">Veuillez vous authentifier pour continuer.</h6>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="emailaddress" name="emailaddress" placeholder="Veuillez entrer votre adresse mail" >
                </div>
                <div class="input-group input-group-merge mb-5">
                  <input type="password"  class="form-control form-control-lg" id="password" name="password" placeholder="Veuillez entrer votre mot de passe" >
                  <span class="input-group-text cursor-pointer" id="togglePassword" onclick="togglePasswordVisibility()"><i class='mdi mdi-eye-off'></i></span>
                </div>
                <a href="forgot-password" class="auth-link text-black mt-3">Mot de passe oublié ?</a>
                <div class="mt-3">
                  <button type="submit" name="checkuser" id="onclick" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Se connecter</button>
                  <a href="employee-registration-form" class="btn btn-block btn-warning btn-lg text-right">Créer un compte</a>
                </div>       
             
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
   <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const togglePasswordButton = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePasswordButton.innerHTML = "<i class='mdi mdi-eye'>";
            } else {
                passwordInput.type = "password";
                togglePasswordButton.innerHTML = "<i class='mdi mdi-eye-off'></i>";
            }
        }
    </script>
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
</body>

</html>
