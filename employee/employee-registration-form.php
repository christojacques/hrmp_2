<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Employee Registration Form</title>
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
  </head>
  <style>
    input.form-control {
    background: #e9e9e9de;
    border-radius: 10px;
}
select.form-select-lg.col-12 {
  background: #e9e9e9de;
  border-radius: 10px;
  border:none;
}
  </style>
  <body>
    <?php
    include_once 'private/employee_registration.php';
    ?>
    <div class="main-panel" style="width: calc(100%);">
      <div class="content-wrapper">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4"><a href="../employee" class="btn btn-primary btn-sm">Retour</a></div>
                <div class="col-4"><h2 class=" text-center">Formulaire de demande d'inscription pour les employés</h2></div>
                <div class="col-4"></div>
              </div>
              <hr class="p-0">
              <form class="form-sample" method="post">
                <p class="card-description">
                  Informations personnelles
                </p>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Prénom <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" name="fname" required class="form-control" value="<?= isset($_POST['fname']) ? $_POST['fname'] : '' ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Nom de famille <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" name="lname" required class="form-control" value="<?= isset($_POST['lname']) ? $_POST['lname'] : '' ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Courrier électronique <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" name="email" required class="form-control" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Téléphone <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" name="phone" required class="form-control" value="<?= isset($_POST['phone']) ? $_POST['phone'] : '' ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Date de naissance <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="date" name="dob" required  class="form-control" value="<?= isset($_POST['dob']) ? $_POST['dob'] : '' ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Fonction <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" name="jobtitle" required class="form-control" value="<?= isset($_POST['jobtitle']) ? $_POST['jobtitle'] : '' ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Numéro de contrat</label>
                      <div class="col-sm-9">
                        <input type="text" name="contractno"  class="form-control" value="<?= isset($_POST['contractno']) ? $_POST['contractno'] : '' ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Date de début de contrat <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="month" name="contractstart" required class="form-control" value="<?= isset($_POST['contractstart']) ? $_POST['contractstart'] : '' ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Date de fin de contrat</label>
                      <div class="col-sm-9">
                        <input type="month" name="contractend"  class="form-control" value="<?= isset($_POST['contractend']) ? $_POST['contractend'] : '' ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Type de contrat <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" name="contracttype" required class="form-control" value="<?= isset($_POST['contracttype']) ? $_POST['contracttype'] : '' ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Département <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" name="department" required class="form-control" value="<?= isset($_POST['department']) ? $_POST['department'] : '' ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Attribution du projet</label>
                      <div class="col-sm-9">
                        <input type="text" name="assignproject"  class="form-control" value="<?= isset($_POST['assignproject']) ? $_POST['assignproject'] : '' ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Affectation de l'unité</label>
                      <div class="col-sm-9">
                        <input type="text" name="assigunit"  class="form-control" value="<?= isset($_POST['assigunit']) ? $_POST['assigunit'] : '' ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Nom de la banque</label>
                      <div class="col-sm-9">
                        <input type="text" name="bankname"  class="form-control" value="<?= isset($_POST['bankname']) ? $_POST['bankname'] : '' ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Numéro de compte bancaire</label>
                      <div class="col-sm-9">
                        <input type="text" name="bankaccount"  class="form-control" value="<?= isset($_POST['bankaccount']) ? $_POST['bankaccount'] : '' ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Préférence pour le paiement</label>
                      <div class="col-sm-9">
                        <select name="paymentmethod"  class="form-select-lg col-12 ">
                          <option selected>Supprimer la préférence pour le paiement</option>
                          <option value="Check">Chèque</option>
                          <option value="Bank">Banque</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group row" style="align-items: center;">
                    <label class="col-sm-4 col-form-label">Mot de passe <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                      <input type="password" required name="password" pattern="[0-9]{6}" title="Veuillez saisir un mot de passe numérique à 6 chiffres" maxlength="6" minlength="6" class="form-control mb-3" placeholder="Type your password">
                      <input type="password" name="cpassword" pattern="[0-9]{6}" title="Veuillez saisir un mot de passe numérique à 6 chiffres" maxlength="6" minlength="6" class="form-control" required placeholder="Confirm your password">
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col">
                    <input type="submit" name="add_employee" class="btn btn-primary btn-sm" value="Demander un compte">
                  </div>
                </div>
                
              </form>
            </div>
            
          </div>
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="" target="_blank">Infinity Group Solutions</a>2024</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/dashboard.js"></script>
    <script src="js/data-table.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap4.js"></script>
    <!-- End custom js for this page-->
    <script src="js/jquery.cookie.js" type="text/javascript"></script>
  </body>
</html>