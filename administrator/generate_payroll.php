<?php
include_once 'header.php';
include_once 'private/payroll_function.php';
?>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestion de la rémunération /</span> Générer fiche de paie</h4>
   
    <div class="card table-responsive">
      <div class="card-body">
        <h4 class="card-title">Liste des collaborateurs</h4>
        <div class="row">
          <table id="example" class="display table" style="width:100%">
            <thead>
              <tr>
                <th>Collaborateurs</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Fonction</th>
                <th>Numéro de contrat</th>
                <th>Date de naissance</th>
                <th>Effectué par le comptable</th>
                <th>Révisé par la DRH</th> 
                <th>Action</th>
                
              </tr>
            </thead>
            <tbody>
               <?php $payrolls->payrollemployee(); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
   <script src="js/jquery-3.7.0.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            order: [[ 3, 'desc' ], [ 0, 'asc' ]],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'  // URL for French translations
            }
        });
    });
</script>

  <!-- / Content -->
  <?php include_once 'footer.php'; ?>