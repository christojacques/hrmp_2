<?php 

include_once 'header.php';
include_once 'private/guard_function.php';

$guardid=base64_decode($_GET['id']);
$guard_info=$guard->singleguard($guardid);



if (isset($_POST['update'])) {
	$name=$_POST['guardname'];
	$guardidno=$_POST['guardid'];
	$gids=$_POST['gids'];
	$status=$_POST['status'];
	$pass=$_POST['password'];
	$new=$_POST['newpass'];
	$conf=$_POST['conpass'];
	if (!empty($new) && !empty($conf)) {
		if ($_POST['newpass']==$_POST['conpass']) {
			$password=password_hash($conf, PASSWORD_DEFAULT);
		}else{
			$password=$guard_info['password'];
			echo '<script>Swal.fire({
			title: "Le nouveau mot de passe et le mot de passe de confirmation ne correspondent pas",
			text: "Veuillez réessayer",
			icon: "question"
			});</script>';
		}
	}elseif(empty($new) && empty($conf)){
		$password=$guard_info['password'];
	}else{
		//$password=$guard_info['password'];
		echo '<script>alert("Les champs Nouveau mot de passe et Confirmer le mot de passe sont obligatoires.");</script>';


	}



	if (isset($password)) {
		if (password_verify($pass, $fetch_employee['password'])) {
		$success=$guard->updateguard($name,$guardidno,$gids,$status,$password);
		if ($success) {
			echo '<script>Swal.fire({
			title: "Félicitations!",
			text: "Les informations du gardien sont mises à jour avec succès",
			icon: "success"
			});</script>';
		}else{
			echo '<script>Swal.fire({
			title: "Please Try Again",
			text: "Faild To Updated Guard Information.",
			icon: "error"
			});</script>';
		}
		}else{
		echo '<script>Swal.fire({
			title: "Password Not Matched.",
			text: "Please Try Again With Your Correct Password.",
			icon: "question"
			});</script>';
		}
	}
	
	



}





?>

 <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
			<div class="col-md-12 grid-margin">
				<div class="card mb-4">
					<h5 class="card-header">Détail du profil</h5>
					<!-- Account -->
					<div class="card-body">
						<form id="formAccountSettings" method="POST">
							<div class="row">
								<div class="mb-3 col-md-6">
									<label for="firstName" class="form-label">Nom du gardien</label>
									<input class="form-control" type="text" name="guardname"  value="<?=$guard_info['guard_name'];?>">
									<input type="hidden" name="gids" value="<?=$guardid;?>">
								</div>
								<div class="mb-3 col-md-6">
									<label for="id" class="form-label">ID du gardien</label>
									<input class="form-control" name="guardid" type="text" value="<?=$guard_info['login_id'];?>" >
								</div>
								<div class="mb-3 col-md-6">
									<label for="status" class="form-label">Statut du compte</label>
									<select name="status" id="status" class="form-control">
										<?php 

										?>
										<!-- <option value="<?//=$guard_info['status'];?>"><?//=strtoupper($guard_info['status']);?></option> -->
										<option value="active">ACTIVE</option>
										<option value="inactive">INACTIVE</option>
									</select>
								</div>
								<div class="mb-3 col-md-6">
									<label for="password" class="form-label">Modifier le mot de passe</label>
									<div class="input-group">
										<span class="input-group-text">Mot de passe</span>
										<input type="password"  class="form-control" placeholder="Nouveau mot de passe" name="newpass">
										<input type="password"  class="form-control" placeholder="Confirmer le mot de passe" name="conpass">
									</div>
									
								</div>
								
								
							</div>
							<div class="mt-2">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
								Enregistrer
								</button>
							</div>
							<!-- Button trigger modal -->
							<!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Your Password</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div>
												<label for="firstName" class="form-label">Type your password</label>
												<input class="form-control" type="password" name="password"  required>
											</div>
										</div>
										<div class="modal-footer">
											
											<button type="submit" class="btn btn-primary" name="update">Confirmed</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<!-- /Account -->
				</div>
			</div>
		</div>
            </div>


<script>
	$(document).ready(function(){
		let gstatus="<?=$guard_info['status'];?>";
		$("#status").val(gstatus);
	});
</script>

<?php
include_once 'footer.php';
 ?>