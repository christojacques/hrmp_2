<?php
include_once 'header.php';
include_once 'private/payroll_function.php';
$getpayempid=base64_decode($_GET['id']);
if (isset($_POST['search'])) {
$month=$_POST['month'];
$Sdate=date('d-m-Y',strtotime($month));
$Edate=date('t-m-Y',strtotime($month));
$_SESSION['Sdate']=$Sdate;
$_SESSION['Edate']=$Edate;

$docbtn='<a  href="doc-payroll.php?id='.$_GET['id'].'&Sdate='.$Sdate.'&Edate='.$Edate.'" class="btn btn-warning btn-sm" >Télécharger en Word</a>';

$payempinfoA=$payrolls->payrollslipA($Sdate,$Edate,$getpayempid);
$payempinfoB=$payrolls->payrollslipB($Sdate,$Edate,$getpayempid);

}else{
  $docbtn='';
}
$empinfopayroll=$payrolls->payrollemployeeinfo($getpayempid);

?>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les salaires /</span> Générer fiche de paie</h4>
    <div class="card"style="border-radius: 10px 10px 0px 0px;">
      <div class="card-body">
        <form method="post" class="mb-5">
          <div class="row mt-3">
            <h4 class="mb-5"> Rechercher la fiche de paie mensuelle</h4>
            <div class="col-md-3 text-center">
              <label for="" class="form-label">Mois</label>
              <input type="month" name="month" class="form-control-sm">
            </div>
            <div class="col-md-4">
              <input type="submit"  name="search" id="search" class="btn btn-primary btn-sm" value="Générer">
              <!-- <button  id="printbnt" onclick="window.print()" class="btn btn-warning btn-sm" >Print</button> -->
              <button  id="printbnt" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning btn-sm" >Télécharger en PDF</button>
              <?php echo $docbtn; ?>
            </div>
          </div>
        </form>
      </div>
    </div>
    

    
<?php 

$data='<div class="card" id="printableDiv" style="border-radius: 0px 0px 10px 10px;">
      <div class="card-body">
        <h3>UG PDSS</h3>';
        $data.='<div class="row"><h6 style="text-align: right;">Date : '.date('d-m-Y').'</h6></div>';
         if (isset($_POST['month'])) {
        $data.='<h4 class="text-center mb-5">Rémunération: '.date('M-Y',strtotime($_POST["month"])).'</h4>';
        }?>

        <?php 
          $data.='<div class="row"><div class="col-md-6">
            <h4 class="card-title" style="text-align: left;">A. Informations générales</h4>
            <table class="table mb-4">
              <tbody>
                <tr>
                  <td>Numéro ou référence de contrat :</td>
                  <td>'.$empinfopayroll['contract_no'].'</td>
                </tr>
                <tr>
                  <td>Prénom :</td>
                  <td>'.$empinfopayroll['fname'].'</td>
                  
                </tr>
                <tr>
                  <td>Nom de famille :</td>
                  <td>'.$empinfopayroll['lname'].'</td>
                  
                </tr>
                <tr>
                  <td>Date de naissance :</td>
                  <td>'.$empinfopayroll['dob'].'</td>
                  
                </tr>
                <tr>
                  <td>Département :</td>
                  <td>'.$empinfopayroll['department'].'</td>
                  
                </tr>
                <tr>
                  <td>Fonction :</td>
                  <td>'.$empinfopayroll['job_title'].'</td>
                  
                </tr>
                <tr>
                  <td>Attribution du projet  :</td>
                  <td>'.$empinfopayroll['project_assign'].'</td>
                  
                </tr>
                <tr>
                  <td>Type de contrat :</td>
                  <td>'.$empinfopayroll['contract_type'].'</td>
                </tr>
                
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <td>Début du contrat :</td>
                  <td>'.date('M-Y',strtotime($empinfopayroll['contract_start'])).'</td>
                  
                </tr>
                <tr>';

$join_date = new DateTime($empinfopayroll['contract_start']);
$exit_date = new DateTime($empinfopayroll['contract_end']);

// Calculate the difference between the two dates
$interval = $join_date->diff($exit_date);

// Calculate the total number of months
$total_months = ($interval->y * 12) + $interval->m;





                  
                  $data.='<td>Durée du contrat :</td>
                  <td>'.$total_months.' mois</td>
                </tr>
                <tr>
                  <td>Fin du contrat :</td>
                  <td>'.date('M-Y',strtotime($empinfopayroll['contract_end'])).'</td>
                </tr>
                
              </tbody>
            </table>
          </div>
          </div>
          
        ';
        
        
         if(isset($payempinfoB)){$data.=$payempinfoB;}
        
        
      $data.='</div>
    </div>';
echo $data;



if (isset($_POST["month"])) {
  $finm='Payroll-slip-'.$empinfopayroll['fname'].' '.$empinfopayroll['lname'].'-'.date('M-Y',strtotime($_POST["month"])).'.pdf';
}else{
  $finm='Payroll-slip-'.$empinfopayroll['fname'].' '.$empinfopayroll['lname'].'-'.date('M-Y').'.pdf';
}


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
      <h4 class="text-center text-primary">Voulez-vous télécharger cette “fiche de paie” ?</h4>
      <form method="post" action="pdf/index.php">
        <textarea name="data" hidden><?=$data?></textarea>
        <input type="hidden" name="filename" value="<?=$finm?>">
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
  display: none !important;
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
/*   #approved{
     display: none;
  } */
  }
  
  @media print {
  @page {
  size: A4 portrait;
  scale: 0.5;
  }
  }
  table tr td{
  border: none;
  }
  </style>
  <!-- / Content -->
  <?php include_once 'footer.php'; ?>