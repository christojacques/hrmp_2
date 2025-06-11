<?php 

include_once 'header.php';
include_once 'private/employee_function.php';



 ?>
<!-- Content wrapper -->
<div class="content-wrapper">
	<!-- Content -->
	<div class="container-xxl flex-grow-1 container-p-y">
		<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les Collaborateurs /</span> Comptes des Collaborateurs</h4>
		<div class="card table-responsive">
			<div class="card-body">
				<h4 class="card-title">Gérer les Collaborateurs</h4>
				<div class="row">
<?php 
if ($lm_module!=0) { ?>
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
          <button type="button" class="nav-link active"  data-bs-toggle="modal" data-bs-target="#exampleModal"  >Réinitialisation des congés annuels</button>
        </li>
    </ul>
<?php   
}
 ?>
				

					<table id="example" class="display table" style="width:100%;text-wrap: nowrap;">
						<thead>
							<tr>
								<th><input type="checkbox" class="form-check-input" id="allempcheck"></th>
								<th>Collaboratrur</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Titre du poste</th>
                <th>Numéro de contrat</th>
                <th>Date de naissance</th>
                <th>Statut</th>
                <th>Action</th>
								
							</tr>
						</thead>
						<tbody>
							<?php $employee->showemployeerequest(); ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Réinitialisation des congés annuels</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body BO">
       <h4 class="card-title text-primary">En confirmant cette action, les congés annuels des collaborateurs sélectionnés seront réinitialisés à leur allocation initiale. Cela signifie que leur solde de congés sera ajusté pour correspondre au nombre de jours de congé qui leur avaient été attribués lors de leur inscription sur la plateforme. <br>Cette opération est généralement réalisée en début d’année, le 1er janvier, pour aligner les droits de congé avec les politiques de l’entreprise.</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#passwordModel">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="passwordModel" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmez votre mot de passe</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <label for="password" class="form-label">TTapez votre mot de passe</label>
      <input class="form-control" type="password" name="mypassword" id="passowrd" placeholder="Saisissez votre mot de passe pour mettre à jour les détails de l'employé."  required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="resetButton">Confirmer</button>
      </div>
    </div>
  </div>
</div>



	</div>
	<!-- / Content -->
	<script src="js/jquery-3.7.0.js"></script>
	<script>
	$(document).ready(function() {
	$('#example').DataTable( {
	order: [[ 3, 'desc' ], [ 0, 'asc' ]]
	} );
	} );
	</script>
	<script>
    // Add event listener to the delete links
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior (i.e., navigating to the URL)

            const gid = this.getAttribute('data-eid'); // Retrieve the 'gid' attribute value

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
$(document).ready(function () {
  // Select all checkboxes when "Select All" is clicked
  $('#allempcheck').on('change', function () {
    $('.singlempcheck').prop('checked', this.checked);
  });

  // Uncheck "Select All" if any single checkbox is unchecked
  $('.singlempcheck').on('change', function () {
    if (!this.checked) {
      $('#allempcheck').prop('checked', false);
    }
  });

  // Reset button functionality
  $('#resetButton').on('click', function () {
    const selectedEmployees = $('.singlempcheck:checked').map(function () {
      return this.value;
    }).get();

    let password = $('#passowrd').val();

$.ajax({
  url: 'verify_password.php',
  type: 'POST',
  data: { password: password },
  success: function (response) {
    // Trim the response to avoid whitespace issues
    if (response.trim() == 'valid') {
      
      let passwordModal = bootstrap.Modal.getInstance(document.getElementById('passwordModel'));
      passwordModal.hide();
      if (selectedEmployees.length > 0) {

      // Send AJAX request to reset annual leave balances
        $.ajax({
          url: 'reset_leave_balance.php',
          type: 'POST',
          data: { employee_ids: selectedEmployees },
          success: function (response) {
           if (response) {
        Swal.fire({
        title: "Félicitations",
        text: "Mise à jour réussie des congés annuels des employés.",
        icon: "success"
        }).then(function(){
          window.location.href='manage-employee';
        });
           }
          },
          error: function () {
            alert('Une erreur s est produite. Veuillez réessayer.');
          }
        });
    } else {
      alert('Veuillez sélectionner au moins un employé.');
    }



    } else {
      alert("Mot de passe incorrect ❌");
    }
  },
  error: function () {
    alert("Erreur lors de la vérification du mot de passe.");
  }
});

  });
});
</script>
	<?php include_once 'footer.php'; ?>