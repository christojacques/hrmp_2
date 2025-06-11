<?php
include_once 'header.php';
include_once 'private/weekly_work_function.php';
include_once 'private/timesheet_function.php';
$subid=base64_decode($_GET['id']);


// Weekly Submittion Enable

if (isset($_POST['enablesubmition'])) {
	$subweekid=$_POST['weekidsub'];
	$updateweeksub=mysqli_query($db,"UPDATE `week_submission` SET `ws_status`='DRH' WHERE `ws_id`='$subweekid'");
	include_once 'timesheetenable-email-template.php';
	if ($updateweeksub) {
echo '<script>Swal.fire({
title :  "Félicitations",
text : "Activation réussie de la soumission des feuilles de temps ",
icon :  "success"
}).then(function(){
	window.location.href="manage-weekly-work"
});</script>' ;
}else{
echo '<script>Swal.fire({
titre : " Veuillez réessayer ",
text : " Échec de l activation de la soumission de la feuille de temps ",
icon : " error "
}).then(function(){
	window.location.href="manage-weekly-work ";
});</script>' ;
	}
}

// Weekly Submittion Enable






?>
<!-- Content wrapper -->
<div class="content-wrapper">
	<!-- Content -->
	<div class="container-xxl flex-grow-1 container-p-y">
		<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Collaborateurs / Rapport hebdomadaire /</span> Observer la feuille de temps</h4>
		<div class="card">
			<form method="post">
				<input type="hidden" name="weeklysubid" value="<?=$subid;?>">
			<div class="card-body">
				<h4>Feuilles de temps hebdomadaires</h4>
				<table class="table table-bordered" id="example">
					<thead>
						<tr>
							<th>Titre de la tâche</th>
							<th>Commentaire</th>
							<th>Heures travaillées</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?=$weeklywork->submitiondetails($subid);?>
					</tbody>
				</table>
			</div>
			<div class="modal fade" id="updatetimesheet" tabindex="-1" style="display: none;" aria-hidden="ture">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Modifier la feuille de temps</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="editmodel">
            
          </div>
        </div>
      </div>
    </div>
		</div>
		<div class="card mt-4" id="printableDiv">
			<?php 
			$wempin=$weeklywork->empinfo($subid);
			$data='<div class="card-body" >
				<h4>Rapport hebdomadaire</h4>';
			$data.='<h4 class="text-center">'.$wempin['fname'].' '.$wempin['lname'].'</h4>';
			$data.=$weeklywork->daliyreports($subid,$ma_module,$ts_module);
			echo $data;
			$finm='Weekly-Report-'.$wempin['fname'].'-'.$wempin['lname'].date('-d-m-Y').'.pdf';
			 ?>


<!-- Print Table Data -->


			<div class="card-footer">
				<div class="row">
					<div class="col-md-4" style="text-align: left;"><button id="printbnt" class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" >Télécharger</button></div>
					<div class="col-md-4">
						<input type="submit" name="approved" id="approve" class="btn btn-primary" value="Approuver la feuille de temps hebdomadaire">

					</div>
					</form>
						
					<div class="col-md-4"  style="text-align: right;">
					<form method="post">
						<input type="hidden" name="weekidsub" value="<?=$subid;?>" hidden>
							<input type="submit" name="enablesubmition" id="enablesubmition" class="btn btn-danger" value="Autoriser une nouvelle soumission">
					</form>
					</div>
					
				
				</div>
			</div>
		</div>
		
	</div>

	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">Télécharger en PDF</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    
    <div class="modal-body">
    	<h4 class="text-center text-primary">Voulez-vous télécharger ce tableau hebdomadaire ?</h4>
    	<form action="pdf/index.php" method="post">
      <textarea name="data" hidden><?=$data?></textarea>
       <input type="hidden" name="filename" value="<?=$finm?>">
      <input type="submit" name="printed" class="btn btn-primary" value="Télécharger">
    </form>
	</div>
  </div>
</div>
</div>
	<script src="js/jquery-3.7.0.js"></script>
	<script>
	$(document).ready(function() {
	$('#example').DataTable( {
	order: [[ 3, 'desc' ], [ 0, 'asc' ]]
	});
	});

	 $(document).on("click", "#edit-time",function() {
    $("#updatetimesheet").show();
    var timesid=$(this).data("edit");
    $.ajax({
    url: 'edit-timesheet.php',
    type: 'post',
    data: {timeid: timesid},
    success: function (data) {
    console.log(data)
    $("#editmodel").html(data);
    }
    });
    })
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
		display: block;
	}
	.card{
		display: none;
	}
	.fw-bold{
		display: none;
	}
	#approve{
			display: none;
	}
	#enablesubmition{
		display: none;
	}
	}
	</style>
	<!-- / Content -->
	<?php include_once 'footer.php'; ?>