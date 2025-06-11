<?php
include_once 'header.php';
include_once 'private/leave_function.php';
?>
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="card table-responsive">
				<div class="card-body">
					<h4>Demande de congé</h4>
					<button type="button" class="btn btn-inverse-primary btn-rounded btn-icon mb-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
					<i class="mdi mdi-calendar-plus"></i>
					</button>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Type de congé </th>
								<th>Date de début</th>
								<th>Date de fin</th>
								<th>Nombre total de jours</th>
								<th>Raison</th>
								<th>Commentaires DRH </th>
								<th>Statut</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $leaves->showleaverequest(); ?>
						</tbody>
					</table>
					<!-- Button trigger modal -->
					<!-- Modal -->
					<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h1 class="modal-title fs-5" id="staticBackdropLabel">Formulaire de demande de congé</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<form method="post" enctype="multipart/form-data">
										<div class="row">
											<div class="col mb-3">
												<label for="nameBasic" class="form-label">Type</label>
												<select name="type" class="form-control col" id="type" required>
													
													<?=$leaves->showleavetypes(); ?>
												</select>
											</div>
											<div class="row">
												<div class="col-md-6">
													<label for="" class="form-label">Date de début</label>
													<input type="text" id="start" name="starts" class="form-control col" placeholder="dd-mm-yyyy" required>
													<select name="startwhen" class="form-control col" id="startwhen" required>
														<option value="Morning">Matin</option>
														<option value="Afternoon">Après-midi</option>
													</select>
												</div>
												<div class="col-md-6">
													<label for="" class="form-label">Date de fin</label>
													<input type="text" id="end" name="ends" class="form-control col" placeholder="dd-mm-yyyy">
													<select name="endwhen" class="form-control col" id="endwhen" required>
														<option value="Lunchtime">Heure du déjeuner</option>
														<option value="End Of Day">Fin de journée</option>
													</select>
												</div>
												
												
												
											</div>
											<div class="row">
												<div class="col">
													<label for="" class="form-label mt-3">Raison</label>
													<textarea name="reason" class="form-control" id="reason" cols="30" rows="5" required></textarea>
												</div>
												
											</div>
											<div class="row">
												<div class="col">
													<label for="" class="form-label">Documents joints</label>
													<input type="file" name="documents" class="form-control">
													<textarea name="days" class="form-control" id="totalday"  required hidden></textarea>
												</div>
												
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<h6 id="days">Prend 0 jours à partir de l'allocation.</h6>
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
										<button type="submit" name="sendrequest" id="sendrequest" class="btn btn-primary">Envoyer une demande</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content text-center p-4" style="align-items: center;">
      <div class="spinner-border text-primary mb-3" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p>Veuillez patienter...</p>
    </div>
  </div>
</div>

	<script src="date/jquery-3.7.0.js"></script>
	<script src="date/jquery-ui.min.js"></script>
	<script >
	$.noConflict();
	jQuery(document).ready(function($) {
	$("#start").datepicker({
	dateFormat: "dd-mm-yy"
	});
	$("#end").datepicker({
	dateFormat: "dd-mm-yy"
	});
	// $("#start").on('change', function() {
	//     var start = $(this).val();
	//     //console.log(start);
	// });
	$("#end").on('change', function() {
		var starts = $("#start").val();
		var whens = $("#startwhen").val();
		var whene = $("#endwhen").val();
		var ends = $(this).val();
	$.ajax({
		url: 'private/leave_function.php',
		type: 'POST',
		data: {start: starts, end: ends, ws: whens, we: whene},
		success:function (data) {
			//console.log(data);
			
				var da="Prend "+data+" jours à partir de l'allocation.";
				//console.log(da);
				$("#days").html(da);
				$("#totalday").html(data);
			
			
		}
	});
	
	
	});
	function whenchnage(){
		var starts = $("#start").val();
		var whens = $("#startwhen").val();
		var whene = $("#endwhen").val();
		var ends = $("#end").val();
	$.ajax({
		url: 'private/leave_function.php',
		type: 'POST',
		data: {start: starts, end: ends, ws: whens, we: whene},
		success:function (data) {
			//console.log(data);
			
				var da="Takes "+data+" day from allowance.";
				//console.log(da);
				$("#days").html(da);
				$("#totalday").html(data);
			
			
		}
	});
	}
	// $("#start").on('change', function() {
		// 	whenchnage();
	// });
	$("#startwhen").on('change', function() {
		whenchnage();
	});
	$("#endwhen").on('change', function() {
		whenchnage();
	});
	});
	</script>

	<script>
    // Add event listener to the delete links
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior (i.e., navigating to the URL)

            const gid = this.getAttribute('data-ltid'); // Retrieve the 'gid' attribute value

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: "Confirmation de suppression Êtes-vous sûr de vouloir supprimer votre demande ? Cette action est irréversible.",
                showCancelButton: true,
                confirmButtonText: "Confirmer",
                cancelButtonText: "Annuler",
                icon: "warning",
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms deletion, proceed with navigating to the deletion URL
                    window.location.href = this.href + "&gid=" + gid;
                } else {
                    // If user cancels deletion, do nothing
                    // Alternatively, you can display a message or perform other actions
                }
            });
        });
    });
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('staticBackdrop');
    const submitButton = document.getElementById('sendrequest');

    form.addEventListener('submit', function () {
        // Show the progress modal
        const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
        progressModal.show();

        // Hide the form modal (if it's still open)
        const formModalEl = document.getElementById('staticBackdrop');
        const formModal = bootstrap.Modal.getInstance(formModalEl);
        if (formModal) formModal.hide();
    });
});
</script>







	<?php include_once 'footer.php'; ?>