<?php 
include_once 'db.php';
session_start();
if (isset($_SESSION['employee_role'])) {
 header("location:index");	
}
class UsersAuthentication {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkUserInfo($email, $password) {
        $sql = "SELECT * FROM `employees` WHERE `email`=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
            	if ($user['account_status']=="active") {
            		$_SESSION['employee_role']=$user['employee_role'];
            		$_SESSION['email']=$user['email'];
            		$_SESSION['employeidno']=$user['eid'];
                    setcookie('employee_role',$user['employee_role'],time()+(86400*30),'/');
                    setcookie('email',$user['email'],time()+(86400*30),'/');
                    setcookie('employeidno',$user['eid'],time()+(86400*30),'/');
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

$authentication = new UsersAuthentication($db);

if (isset($_POST['checkuser'])) {
    if (!empty($_POST['emailaddress'])) {
        if (!empty($_POST['password'])) {
            $email = $_POST['emailaddress'];
            $password = $_POST['password'];
            $result = $authentication->checkUserInfo($email, $password);

             if ($result) {
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Connexion réussie!",
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
