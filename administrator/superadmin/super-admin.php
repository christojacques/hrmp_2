<?php
include_once 'header.php';
include_once 'db.php';


$user_id = $_SESSION['superadmin_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['superadmin_id'])) {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Session Expired!",
                    text: "Please log in again.",
                    showConfirmButton: true
                }).then(() => {
                    window.location.href = "login.php";
                });
              </script>';
        exit;
    }

    $fname      = htmlspecialchars(trim($_POST['fname']));
    $lname      = htmlspecialchars(trim($_POST['lname']));
    $email      = htmlspecialchars(trim($_POST['email']));
    $phone      = htmlspecialchars(trim($_POST['phone']));
    $password   = $_POST['password'];
    $cpassword  = $_POST['cpassword'];
    $mypassword = $_POST['pass'];

    

    if ($password !== $cpassword) {
        echo '<script>
                Swal.fire({
                    icon: "warning",
                    title: "Passwords do not match!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "super-admin.php";
                });
              </script>';
        exit;
    }

    $stmt = $db->prepare("SELECT `password` FROM `users` WHERE `uid`=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $row= $stmt->get_result();
    $result= $row->fetch_assoc();

    if (!password_verify($mypassword, $result['password'])) {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Incorrect current password!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "super-admin.php";
                });
              </script>';
        exit;
    }

    $updatePasswordSQL = '';
    $params = [$fname, $lname, $email, $phone];
    $types = "ssss";

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updatePasswordSQL = ", password = ?";
        $params[] = $hashedPassword;
        $types .= "s";
    }

    $params[] = $user_id;
    $types .= "i";

    $sql = "UPDATE `users` SET `fname` = ?, `lname` = ?, `email` = ?, `phone` = ?" . $updatePasswordSQL . " WHERE uid = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Super Admin Info Updated!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "super-admin.php";
                });
              </script>';
    } else {
        echo "Failed to update: " . $stmt->error;
    }

}



$stml = $db->prepare("SELECT `fname`,`lname`,`email` ,`phone`,`password` FROM `users` WHERE `uid`=?");
$stml->bind_param("i", $user_id);
$stml->execute();
$row= $stml->get_result();
$result= $row->fetch_assoc();


?>
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <!-- Notifications -->
          <div class="card-body">
            <h4 class="card-title text-primary mt-3">Update Super Admin Profile Informations</h4>
            <!-- Your Form -->
            <form id="profileForm" method="post">
              <input type="hidden" name="pass" id="pass" hidden>
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="firstName" class="form-label">First Name</label>
                  <input class="form-control" type="text" id="firstName" name="fname" value="<?=$result['fname'];?>" required>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="lastName" class="form-label">Last Name</label>
                  <input class="form-control" type="text" id="lastName" name="lname" value="<?=$result['lname'];?>" required>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="email" class="form-label">Email Address</label>
                  <input class="form-control" type="email" id="email" name="email" value="<?=$result['email'];?>" required>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="phone" class="form-label">Phone</label>
                  <input class="form-control" type="number" id="phone" name="phone" value="<?=$result['phone'];?>" required>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="password" class="form-label">New Password</label>
                  <input class="form-control" type="password" id="password" name="password">
                </div>
                <div class="mb-3 col-md-6">
                  <label for="cpassword" class="form-label">Confirm Password</label>
                  <input class="form-control" type="password" id="cpassword" name="cpassword">
                </div>
              </div>
              <div class="row">
                <button type="button" class="btn btn-primary col-2 text-center" data-bs-toggle="modal" data-bs-target="#passwordModel">Register</button>
              </div>
            </form>
            <!-- Modal -->
            <div class="modal fade" id="passwordModel" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="passwordModalLabel">Confirm your password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <label for="confirmPasswordModal" class="form-label">Enter your password</label>
                    <input class="form-control" type="password" name="mypassword" id="confirmPasswordModal" placeholder="Enter your password to update details." required>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="update_profile">Confirm</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <!-- / Content -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JavaScript -->
<script>
document.getElementById('update_profile').addEventListener('click', function () {
const enteredPassword = document.getElementById('confirmPasswordModal').value;
if (enteredPassword.trim() === '') {
alert('Please enter your password to confirm.');
return;
}
$("#pass").val(enteredPassword);

// You could optionally match this with actual user password via backend via AJAX before submitting.
// Submit the form
document.getElementById('profileForm').submit();
});
</script>
<?php include_once 'footer.php'; ?>