<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Guard Panel Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <link rel="stylesheet" type="text/css" href="vendors/mdi/css/materialdesignicons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <?php include_once 'private/users-authentication.php'; ?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <h4><a href="../" class="btn btn-sm  btn-warning" >🔙 Retour</a> CONNEXION DU GARDIEN</h4>
                
              </div>
              <h4>Bonjour ! Commençons</h4>
              <h6 class="font-weight-light">Connectez-vous pour continuer.</h6>
              <form class="pt-3" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="guardid" placeholder="ID du gardien" required>
                </div>
                <div class="form-group input-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Mot de passe" required>
                  <span class="input-group-text cursor-pointer" id="togglePassword" onclick="togglePasswordVisibility()"><i class='mdi mdi-eye-off'></i></span>
                </div>
                <div class="mt-3">
                  <button type="submit" name="checkguard" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" >SE CONNECTER</button>

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
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
