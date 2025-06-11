<?php

include_once 'header.php';
include_once 'private/ataglance_function.php';
$empglanceid=base64_decode($_GET['id']);
if (isset($_POST['search'])) {
$start=$_POST['start'];
$end=$_POST['end'];

$_SESSION['start_date']=$start;
$_SESSION['end_date']=$end;

$getinfos=$ataglance->getempinfos($empglanceid,$start,$end);
$getdetailsatt=$ataglance->getworkingtimes($empglanceid,$start,$end);

}else{
$getinfos='';
$getdetailsatt='';
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les collaborateurs / Rapport mensuel /</span> Rapport Complet de Présence</h4>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Rechercher</h4>
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
              <input type="submit"  name="search" id="search" class="btn btn-primary btn-sm" value="Rechercher">
              <!-- <button  id="printbnt" onclick="window.print()" class="btn btn-warning btn-sm" >Print</button> -->
               <button  id="printbnt" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning btn-sm" >Télécharger en PDF</button>
              <a  href="download-docs.php?id=<?=$_GET['id'];?>" class="btn btn-warning btn-sm" >Télécharger en Word</a>
            </div>
          </div>
        </form>
      </div>
    </div>
    
    <?php 
$data='<div class="card table-responsive" id="printableDiv">
      <div class="card-body">
        <h4 class="card-title">Rapport Complet de Présence</h4>
        '.$getinfos.'
        <div class="row">
          <h5>4. Détail des présence</h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Date</th>
                <th>Arrivée</th>
                <th>Départ</th>
                <th>Temps passé au bureau (Gardien)</th>
                <th>Temps de travail (Feuille de temps)</th>
                <th >Durée de travail requise</th>
                <th>Écart (Heures requises / Temps de travail)</th>
                <th>Justification</th>
              </tr>
            </thead>
            <tbody>
              '.$getdetailsatt.'
            </tbody>
          </table>
        </div>
      </div>
    </div>';
echo $data;
     ?>
     <!-- Model -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">Télécharger en PDF</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <h4 class="text-center text-primary">Voulez-vous télécharger ce rapport de présence?</h4>
      <form method="post" action="pdf/index.php">
        <textarea name="data" hidden><?=$data?></textarea>
        <input type="hidden" name="filename" value="month-report-<?=date('d-m-Y');?>.pdf">
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary" name="printed">Télécharger</button>
    </div>
    </form>
  </div>
</div>
</div>
<!-- Model -->
  </div>
  <style>
  /*  tbody tr td{
  border: 1px solid black;
  }
  tbody tr {
  border: 1px solid black;
  }
  thead tr {
  border: 1px solid black;
  }
  thead tr th {
  border: 1px solid black;
  } */
  table{
  text-wrap: nowrap;
  }
  </style>
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
  background: white !important;
  }
  .card{
  display: none;
  }
  .fw-bold{
  display: none;
  }
  .card-title{
  //text-align: center;
  }
  form{
  display: none;
  }

  .container-xxl{
    background: white !important;
  }

  }
  </style>
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
  <!-- / Content -->
  <?php include_once 'footer.php'; ?>