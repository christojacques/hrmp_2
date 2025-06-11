<?php
include_once 'header.php';
include_once 'private/employee_function.php';
$getempid=base64_decode($_GET['id']);
?>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les employées / Rapport mensuel /</span> Journal d'Heures Bureau </h4>
    <div class="card" id="printableDiv">
      <div class="card-body">
        <h4 class="card-title">Journal d'Heures Bureau</h4>
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
              <input type="submit"  name="searchas" id="searchts" class="btn btn-primary btn-sm" value="Rechercher">
               <button  id="printbnt" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning btn-sm" >Télécharger en PDF</button>
            </div>
          </div>
        </form>
         <?php
            if (isset($_POST['searchas'])) {
            $start=$_POST['start'];
            $end=$_POST['end'];
            echo ' <a href="doc-attendence.php?id='.base64_encode($getempid).'&start='.$start.'&end='.$end.'" class="btn btn-warning btn-sm" >Télécharger en Word</a>';
            echo $result=$employee->attendencesheetreport($start,$end,$getempid);
             $data='<h1 class="text-center text-black">Rapport sur la feuille de présence</h1>';
            $data.=$employee->attendencesheetreport($start,$end,$getempid);

            }else{
              echo '<table class="table table-bordered">
          <thead>
            <tr>
              <th>Nom du garde</th>
              <th>Date</th>
              <th>Heure d entrée</th>
              <th>Heure de sortie</th>
              <th>Heure au bureau</th>
              <th>Statut</th>
              
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
      <h4 class="text-center text-primary">Voulez-vous télécharger ce rapport de la feuille de présence ?</h4>
      <form method="post" action="pdf/index.php">
        <textarea name="data" hidden><?=$data?></textarea>
        <input type="hidden" name="filename" value="attendence-sheet-<?=date('d-m-Y');?>.pdf">
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