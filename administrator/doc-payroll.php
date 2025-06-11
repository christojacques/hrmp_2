<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Download Doc File Payroll Slipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-fluid">
<?php
include_once 'private/protection.php';
include_once 'private/payroll_function.php';
$getpayempid=base64_decode($_GET['id']);

//$month=$_GET['month'];
$Sdate=$_GET['Sdate'];//date('d-m-Y',strtotime($month));
$Edate=$_GET['Edate'];//date('t-m-Y',strtotime($month));
$month=date('M',strtotime($Sdate));
$payempinfoA=$payrolls->payrollslipA($Sdate,$Edate,$getpayempid);
$payempinfoB=$payrolls->payrollslipB($Sdate,$Edate,$getpayempid);
$empinfopayroll=$payrolls->payrollemployeeinfo($getpayempid);


$filename = $empinfopayroll['fname'].' '.$empinfopayroll['fname'] . '-' .$month. '-timesheet-' . date('d-M-Y') . '.doc';
header("Content-Type: application/vnd.ms-word");
header('Content-Type: image/png');
header("Content-Disposition: attachment; filename=\"$filename\"");



?>



  <div class="card" id="printableDiv" style="border-radius: 0px 0px 10px 10px;">
      <div class="card-body">
        <h3>UG PDSS</h3>
        <div class="row"><h6 style="text-align: right;">Date : <?=date('d-m-Y');?></h6></div>
        <?php if (isset($_POST['month'])) {
        echo '<h4 class="text-center mb-5">Payroll: '.date('M-Y',strtotime($_POST["month"])).'</h4>';
        } ?>
        
        <div class="row text-left">
          <div class="col-md-6">
            <h4 class="card-title" style="text-align: left;">A. Informations générales</h4>
            <table class="table mb-4">
              <tbody>
                <tr>
                  <td>Numéro de contact:</td>
                  <td><?=$empinfopayroll['contract_no']?></td>
                </tr>
                <tr>
                  <td>Prénom:</td>
                  <td><?=$empinfopayroll['fname']?></td>
                  
                </tr>
                <tr>
                  <td>Nom de famille :</td>
                  <td><?=$empinfopayroll['lname']?></td>
                  
                </tr>
                <tr>
                  <td>Date de naissance :</td>
                  <td><?=$empinfopayroll['dob']?></td>
                  
                </tr>
                <tr>
                  <td>Département :</td>
                  <td><?=$empinfopayroll['department']?></td>
                  
                </tr>
                <tr>
                  <td>Titre du poste :</td>
                  <td><?=$empinfopayroll['job_title']?></td>
                  
                </tr>
                <tr>
                  <td>Attribution du projet :</td>
                  <td><?=$empinfopayroll['project_assign']?></td>
                  
                </tr>
                <tr>
                  <td>Type de contrat :</td>
                  <td><?=$empinfopayroll['contract_type']?></td>
                </tr>
                
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <td>Début du contrat :</td>
                  <td><?=date('M-Y',strtotime($empinfopayroll['contract_start']));?></td>
                </tr>
                 <?php
                  $start_date = new DateTime($empinfopayroll['contract_start']);
                  $end_date = new DateTime($empinfopayroll['contract_end']);
                  // Calculate the difference
                  $interval = $start_date->diff($end_date);
                  // Get the total number of months
                  $total_months = $interval->format('%m');
                  ?>
                <tr>
                  <td>Durée du contrat :</td>
                  <td><?=$total_months;?> Months</td>
                </tr>
                <tr>
                  <td>Fin du contrat:</td>
                  <td><?=date('M-Y',strtotime($empinfopayroll['contract_end']));?></td>
                </tr>
              </tbody>
            </table>
          </div>
          
        </div>
        
        
        <?php if(isset($payempinfoB)){echo $payempinfoB;}?>
        
        
      </div>
    </div>

    </div>
  </body>
  </html>