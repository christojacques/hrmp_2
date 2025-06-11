<?php
include_once 'private/db.php';
class changepassword{
	private  $db;
	public function __construct($db){
		$this->db=$db;
	}
	public function checkvalid($email,$password){
		$sql = "SELECT * FROM `employees` WHERE `email`=?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$user = $result->fetch_assoc();
			if ($user['email']==$email) {
				$pass=password_hash($password, PASSWORD_DEFAULT);
				$update="UPDATE `employees` SET`password`=? WHERE `eid`=?";
				$stml=$this->db->prepare($update);
				$stml->bind_param('ss',$pass,$user['eid']);
				if ($stml->execute()) {
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}
$changepassword=new changepassword($db);
$email=base64_decode($_GET['id']);
if (!empty($email)) {
	if (isset($_POST['setpassword'])) {
		if ($_POST['password']==$_POST['cpassword']) {
			$password=$_POST['password'];
			if (!empty($password)) {
			$result=$changepassword->checkvalid($email,$password);
			if ($result) {
				echo '<script>alert("Successfuly Chanaged Your Password.");
					window.location.href="login";
				</script>';
			}else{
				echo '<script>alert("Faild To Chanaged Your Password.");
					window.location.href="login";
				</script>';
			}
		}
		}else{
			echo '<script>alert("Confirm Password Is Not Matched.");
				</script>';
		}
		
		

		
		
		
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Re-setup Employee Password</title>
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
		<div class="container-scroller">
			<div class="container-fluid page-body-wrapper full-page-wrapper">
				<div class="content-wrapper d-flex align-items-center auth px-0">
					<div class="row w-100 mx-0">
						<div class="col-lg-4 mx-auto">
							<div class="auth-form-light text-left py-5 px-4 px-sm-5">
								<div class="brand-logo">
									<!-- <img src="images/logo.svg" alt="logo"> -->
									<h3>Create New Password</h3>
								</div>
								
								<h6 class="font-weight-light">Write your new password.</h6>
								<form class="pt-4" method="POST">
									<div class="formemail">
										<div class="form-group">
											<input type="password" class="form-control form-control-lg" id="password" name="password" pattern="[0-9]{6}" title="Please enter a 6-digit numeric password" placeholder="New Password" required>

										<input type="password" class="form-control form-control-lg" id="password" name="cpassword" pattern="[0-9]{6}" title="Please enter a 6-digit numeric password" placeholder="Confirm Password" required>	
										</div>
										<button type="submit" name="setpassword" id="onclick" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Save</button>
									</div>
									
								</div>
								
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