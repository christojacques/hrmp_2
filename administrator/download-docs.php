<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Download Doc File Payroll Slip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-fluid">
<?php
session_start();
require_once 'private/docs_function.php';
 

$empglanceid = base64_decode($_GET['id']);
$start = $_SESSION['start_date'];
$end = $_SESSION['end_date'];

$getinfos=$ataglance->getempinfos($empglanceid,$start,$end);
$getdetailsatt=$ataglance->getworkingtimes($empglanceid,$start,$end);

// Generate HTML content for the DOCX file
echo '<div class="card table-responsive" id="printableDiv">
      <div class="card-body">
        <h4 class="card-title">Rapport Complet de Présence</h4>
       '.$getinfos.'<div class="row">
          <h5>4. Detail Presence</h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>Exit Time</th>
                <th>Office Stay</th>
                <th>Time Worked</th>
                <th >Ex. Working Time</th>
                <th>Work Time Diff.</th>
                <th>Justification</th>
              </tr>
            </thead>
            <tbody>
              '.$getdetailsatt.'
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>';

?>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
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
  box-shadow: none;
  border: none;
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
   table{
  text-wrap: nowrap !important;
  }
  .row tr td {
    color: black;
    font-size: 14px;
    font-weight: 600;
}

  }
   table{
  text-wrap: nowrap;
  }
  .row tr td {
    color: black;
    font-size: 14px;
    font-weight: 600;
}
  
</style>
