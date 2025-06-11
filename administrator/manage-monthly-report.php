<?php
include_once 'header.php';
include_once 'private/employee_function.php';
?>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les Collaborateurs /</span> Rapport mensuel</h4>
    <div class="card table-responsive">
      <div class="card-body">
        <h4 class="card-title">liste des collaborateurs</h4>
        <div class="row">
          <table id="example" class="display table" style="width:100%">
            <thead>
              <tr>
                <th>Collaborateurs</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Titre du poste</th>
                <th>Numéro de contrat</th>
                <th>Date de naissance</th>
                <th>Action</th>
                
              </tr>
            </thead>
            <tbody>
              <?php $employee->employeereport($ts_module,$ma_module,$lm_module); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="js/jquery-3.7.0.js"></script>
  <script>
  $(document).ready(function() {
  $('#example').DataTable( {
  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
  } );
  } );
  </script>
  <!-- / Content -->
  <?php include_once 'footer.php'; ?>