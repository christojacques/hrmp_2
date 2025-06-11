<?php
include_once 'header.php';
?>

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="card mb-4">
					<h5 class="card-header">Profile Details</h5>
					<!-- Account -->
					<div class="card-body">
						<div class="d-flex align-items-start align-items-sm-center gap-4">
							<img src="guard_images/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
						</div>
					</div>
					<hr class="my-0">
					<div class="card-body">
						<form id="formAccountSettings" method="POST">
							<div class="row">
								<div class="mb-3 col-md-6">
									<label for="firstName" class="form-label">Guard Name</label>
									<input class="form-control" type="text" id="firstName"  value="John" disabled>
								</div>
								<div class="mb-3 col-md-6">
									<label for="lastName" class="form-label">Guard ID</label>
									<input class="form-control" type="text" value="35545677" disabled>
								</div>
								<div class="mb-3 col-md-6">
									<label for="lastName" class="form-label">Guard Image</label>
									<input class="form-control" type="file" name="guard_image">
								</div>
								<div class="mb-3 col-md-6">
									<label for="lastName" class="form-label">Change Password</label>
									<div class="input-group">
										<span class="input-group-text">Password</span>
										<input type="text"  class="form-control" placeholder="New Password" name="newpass">
										<input type="text"  class="form-control" placeholder="Confirm Password" name="conpass">
									</div>
									
								</div>
								
								
							</div>
							<div class="mt-2">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
								Save changes
								</button>
							</div>
							<!-- Button trigger modal -->
							<!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Password</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div>
												<label for="firstName" class="form-label">Current Password</label>
												<input class="form-control" type="password" name="
												password"  required>
											</div>
										</div>
										<div class="modal-footer">
											
											<button type="submit" class="btn btn-primary">Confirmed</button>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
 
	<?php
	include_once 'footer.php';
	?>