<?php 
include_once 'db.php';
if (isset($_SESSION['superadmin_id'])) {
 header("location:index");	
}

class Auth{
	public function __construct($db){
		$this->db=$db;
	}

	public function checkUserInfo($email, $password) {
        $sql = "SELECT * FROM `users` WHERE `email`=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
            	if ($user['status']=="active") {
            		$_SESSION['superadmin_role']=$user['user_role'];
            		$_SESSION['superadmin_email']=$user['email'];
            		$_SESSION['superadmin_id']=$user['uid'];
            		return true;
            	}
            }else{
            	return false;
            }
        } else {
            // User not found
            return false;
        }
    }
}

$Auth=new Auth($db);


if (isset($_POST['checkuser'])) {
    if (!empty($_POST['emailaddress'])) {
        if (!empty($_POST['password'])) {
            $email = $_POST['emailaddress'];
            $password = $_POST['password'];
            $result = $Auth->checkUserInfo($email, $password);

            if ($result) {
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Authentication successful!",
                        showConfirmButton: false,
                        timer: 1000 // 1.5 seconds
                    }).then(() => {
                        window.location.href = "index";
                    });
                  </script>';
            } else {

     echo '<script>Swal.fire({
        title: "Please Try Again!",
        text: "Authentication failed. Please check your email and password.",
        icon: "error"
        });</script>';

            }

        } else {
             echo '<script>Swal.fire({
        title: "Please Try Again!",
        text: "Password is required. Please enter your password.",
        icon: "question"
        });</script>';
        }
    } else {
         echo '<script>Swal.fire({
        title: "Please Try Again!",
        text: "Email address is required. Please enter your correct email address.",
        icon: "question"
        });</script>';
    }
}

 ?>