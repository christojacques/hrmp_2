<?php
include_once 'header.php';
include_once 'private/employee_function.php';
$getempid=base64_decode($_GET['id']);
?>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les Collaborateurs  / Rapport mensuel /</span> Feuille de Temps par Projet </h4>
    <div class="card" id="printableDiv">
      <div class="card-body">
        <h4 class="card-title">Feuille de Temps par Projet</h4>
        <form method="post" class="mb-5">
          <div class="row mt-3">
            <div class="col-md-3">
              <label for="" class="form-label">Date de début</label>
              <input type="text" id="datepics" name="start" class="form-control-sm" placeholder="dd-mm-yyyy">
            </div>
            <div class="col-md-3">
              <label for="" class="form-label">Date de fin</label>
              <input type="text" id="datepice" name="end" class="form-control-sm" placeholder="dd-mm-yyyy">
            </div>
            <div class="col-md-3">
              <input type="submit"  name="searchts" id="searchts" class="btn btn-primary btn-sm" value="Rechercher">
              <button  id="printbnt" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning btn-sm" >Télécharger en PDF</button>
              
            </div>
          </div>
        </form>
         <?php
            if (isset($_POST['searchts'])) {
            $start=$_POST['start'];
            $end=$_POST['end'];
            echo ' <a href="doc-timesheet.php?id='.base64_encode($getempid).'&start='.$start.'&end='.$end.'" class="btn btn-warning btn-sm" >Télécharger en Word</a>';
            echo $result=$employee->timesheetreport($start,$end,$getempid);
            $data='<h1 class="text-center text-black">Feuille de temps</h1>';
            $data.=$employee->timesheetreport($start,$end,$getempid);
            }else{
              echo '<table class="table table-bordered">
          <thead>
            <tr>
              <th>Titre du projet</th>
              <th>Note de projet</th>
              <th>Heures de travail</th>
              <th>Date de travail</th>
            </tr>
          </thead>
          
          </table>';
            }
            ?>
        
      </div>
    </div>
  </div>
  <!-- Model -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">Télécharger en PDF</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <h4 class="text-center text-primary">Voulez-vous télécharger cette feuille de temps ?</h4>
      <form method="post" action="pdf/index.php">
        <textarea name="data" hidden><?=$data?></textarea>
        <input type="hidden" name="filename" value="time-sheet-<?=date('d-m-Y');?>.pdf">
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary" name="printed">Télécharger</button>
    </div>
    </form>
  </div>
</div>
</div>
<!-- Model -->
  <script src="js/jquery-3.7.0.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script>
  $.noConflict();
  jQuery(document).ready(function($) {
  $("#datepics").datepicker({
  dateFormat: "dd-mm-yy"
  });
  $("#datepice").datepicker({
  dateFormat: "dd-mm-yy"
  });
  });
  </script>
    <style>
    @media print {
  /* Styles specific for printing */
  .layout-navbar{
    display: none;
  }
  #printbnt{
      display: none;
  }
  #printableDiv{
    display: block !important;
  }
  .card{
    display: none;
  }
  .fw-bold{
    display: none;
  }
  .card-title{
    text-align: center;
  }
 form{
  display: none;
 }
  }
  </style>
  <!-- / Content -->
  <?php include_once 'footer.php'; ?>