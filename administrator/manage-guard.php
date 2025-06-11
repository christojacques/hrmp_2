<?php 
include_once 'header.php';
include_once 'private/guard_function.php';
 ?>


<!-- Content wrapper -->
<div class="content-wrapper">
	<!-- Content -->
	<div class="container-xxl flex-grow-1 container-p-y">
		 <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer la garde /</span> Liste des gardiens</h4>
		<div class="card">
			<div class="card-body">
				<div class="row">
					<ul class="nav nav-pills flex-column flex-md-row mb-3">
						<li class="nav-item">
							<button type="button" class="nav-link active"  data-bs-toggle="modal" data-bs-target="#largeModal">
							<i class='menu-icon bx bx-user-voice me-1'></i> Ajouter un gardien
							</button>
						</li>
					</ul>
					<h4 class="card-title">Gérer les gardiens</h4>
					<table id="example" class="display" style="width:100%">
						<thead>
							<tr>
								<th>Nom du gardien</th>
								<th>ID du gardien</th>
								<th>Statut</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $guard->showguard();?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- Add User Model -->
		<div class="modal fade" id="largeModal" tabindex="-1" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel3">Ajouter un garde</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post">
						<div class="row">
							<div class="col mb-3">
								<label for="nameLarge" class="form-label">Nom du gardien</label>
								<input type="text" name="guardname" class="form-control" placeholder="Saisir le nom" required>
							</div>
						</div>
						<div class="row g-2">
							<div class="col mb-0">
								<label for="emailLarge" class="form-label">Numéro d'identification du garde</label>
								<input type="number" name="idno" class="form-control" placeholder="123456" required>
							</div>
							<div class="col mb-0">
								<label for="password" class="form-label">Mot de passe</label>
								<input type="password" name="password" pattern="[0-9]{6}" title="Veuillez saisir un mot de passe numérique à 6 chiffres" maxlength="6" minlength="6" class="form-control" placeholder="******" required>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						
						<button type="submit" name="add_guard" class="btn btn-primary">Registre</button>
					</div>
				</form>
				</div>
			</div>
		</div>
		<!-- End Add User Model -->
	</div>
	<!-- / Content -->
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



	<script>
    // Add event listener to the delete links
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior (i.e., navigating to the URL)

            const gid = this.getAttribute('data-gid'); // Retrieve the 'gid' attribute value

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
	<?php include_once 'footer.php'; ?>