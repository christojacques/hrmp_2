<?php 
include_once 'header.php';
include_once 'private/user_function.php';
 ?>
<!-- Content wrapper -->
<div class="content-wrapper">
	<!-- Content -->
	<div class="container-xxl flex-grow-1 container-p-y">
		<div class="card">

			<div class="card-body">

				<div class="row">
					<ul class="nav nav-pills flex-column flex-md-row mb-3">
						<li class="nav-item">
							<button type="button" class="nav-link active"  data-bs-toggle="modal" data-bs-target="#largeModal">
							<i class="bx bx-user me-1"></i> Add User
							</button>
						</li>
					</ul>
					<h4 class="card-title mt-2">Manage Users</h4>
					<table id="example" class="display" style="width:100%">
						<thead>
							<tr>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>User Role</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $users->showusers(); ?>
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
						<h5 class="modal-title" id="exampleModalLabel3">Add New User</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post">
					<div class="modal-body">
						<div class="row">
							<div class="col mb-3">
								<label for="nameLarge" class="form-label">First Name</label>
								<input type="text" name="fname" class="form-control" placeholder="Enter First Name">
							</div>
							<div class="col mb-3">
								<label for="nameLarge" class="form-label">Last Name</label>
								<input type="text" name="lname" class="form-control" placeholder="Enter Last Name">
							</div>
						</div>
						<div class="row g-2">
							<div class="col mb-0">
								<label for="emailLarge" class="form-label">Email</label>
								<input type="email" name="email" class="form-control" placeholder="xxxx@xxx.xx">
							</div>
							<div class="col mb-0">
								<label for="phone" class="form-label">Phone</label>
								<input type="text"  name="phone" class="form-control" placeholder="+1 XXXX-XXX-XXX">
							</div>
						</div>
						<div class="row g-2">
							<div class="col mb-0">
								<label for="emailLarge" class="form-label">User Role</label>
								<select name="user_role" id="" class="form-control">
									<option title>Select User Role</option>
									<option value="Treasurer">Treasurer</option>
									<option value="DRH">DRH</option>
									<option value="CEO">CEO</option>
									<option value="FINANCIAL DIRECTOR">FINANCIAL DIRECTOR</option>
								</select>
								
							</div>
							<div class="col mb-0">
								<label for="Password" class="form-label">Password</label>
								<input type="password" name="Password" class="form-control" placeholder="*********">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						
						<button type="submit" name="add_user" class="btn btn-primary">Registar User</button>
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
	$('#example').DataTable( {
	order: [[ 3, 'desc' ], [ 0, 'asc' ]]
	} );
	} );
	</script>
	<?php include_once 'footer.php'; ?>