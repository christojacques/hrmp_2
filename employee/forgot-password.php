<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Employee Admin Panel Login</title>
		<!-- plugins:css -->
		<link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
		<link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
		<!-- endinject -->
		<!-- plugin css for this page -->
		<!-- End plugin css for this page -->
		<!-- inject:css -->
		<link rel="stylesheet" href="css/style.css">
		<!-- endinject -->
		<link rel="shortcut icon" href="images/favicon.png" />
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	</head>
	<body>
		<?php include_once 'private/forgotpassword_function.php'; ?>
		<div class="container-scroller">
			<div class="container-fluid page-body-wrapper full-page-wrapper">
				<div class="content-wrapper d-flex align-items-center auth px-0">
					<div class="row w-100 mx-0">
						<div class="col-lg-4 mx-auto">
							<div class="auth-form-light text-left py-5 px-4 px-sm-5">
								<div class="brand-logo">
									<!-- <img src="images/logo.svg" alt="logo"> -->
									<h3>Employee Password Reset</h3>
								</div>
								<h4>Hello! let's get started</h4>
								<h6 class="font-weight-light">Write your email address  to continue.</h6>
								<form class="pt-4" method="POST">
									
										<div class="form-group">
											<input type="text" class="form-control form-control-lg" id="emailaddress" name="emailaddress" placeholder="Enter You Email" >
										<div class="mt-3">
											<button type="submit" name="checkemail" id="onclick" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Next</button>
										</div>
										
									</div>
									<!-- <div class="formpassword">
										<div class="form-group">
											<input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" >
										</div>
										<div class="mt-3">
											<button type="submit" name="checkuser" id="onclick" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
										</div>
										
									</div> -->
								</div>
							</div>
							
							
							
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- content-wrapper ends -->
	</div>
	<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<!-- endinject -->
</body>
</html>