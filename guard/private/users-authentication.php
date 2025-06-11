<?php 
include_once 'db.php';
session_start([
    'cookie_lifetime' => 0, // 0 means session lasts until browser is closed
    'read_and_close' => false // Allows modification of session
]);
if (isset($_SESSION['login_id'])) {
 header("location:index");	
}
class UsersAuthentication {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkUserInfo($email, $password) {
        $sql = "SELECT * FROM `guard` WHERE `login_id`=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
            	if ($user['status']=="active") {
            		$_SESSION['login_id']=$user['login_id'];
            		$_SESSION['guardid']=$user['gid'];
                    setcookie("login_id", $user['login_id'], time() + (86400 * 30), "/"); // 30-day cookie
                    setcookie("guardid", $user['gid'], time() + (86400 * 30), "/"); // 30-day cookie
            		return true;
            	}else{
                    return false;
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

if (isset($_POST['checkguard'])) {
    if (!empty($_POST['guardid'])) {
        if (!empty($_POST['password'])) {
            $email = $_POST['guardid'];
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
            } elseif ($result==2) {
                echo '<script>
                    Swal.fire({
                        icon: "question",
                        title: "Your Account Inactive. Please Contact With Admin!",
                        showConfirmButton: false,
                        timer: 1000 // 1.5 seconds
                    });
                  </script>';
            }else {
               
                 echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Authentication failed. Please check your Guard ID and password.",
                        showConfirmButton: false,
                        timer: 1000 // 1.5 seconds
                    });
                  </script>';
            }

        } else {
           
             echo '<script>
                    Swal.fire({
                        icon: "question",
                        title: "Password is required. Please enter your password.",
                        showConfirmButton: false,
                        timer: 1000 // 1.5 seconds
                    });
                  </script>';
        }
    } else {
         echo '<script>
                    Swal.fire({
                        icon: "question",
                        title: "Guard ID is required. Please enter your correct Guard ID.",
                        showConfirmButton: false,
                        timer: 1000 // 1.5 seconds
                    });
                  </script>';
    }
}
?>
