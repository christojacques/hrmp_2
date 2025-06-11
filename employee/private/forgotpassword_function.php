<?php
include_once 'db.php';
class forgotpassword{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	public  function resetpassword($email){
	$sql = "SELECT * FROM `employees` WHERE `email`=?";
	$stmt = $this->db->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		$user = $result->fetch_assoc();
		if ($user['email']==$email) {
			include_once 'email_function.php';
			$to=$user['email'];
			$subject="Réinitialisation de votre mot de passe.";
			$currentURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
			$msg="<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Password Reset</title>
</head>
<body>
    <p>Bonjour ".$user['fname'].",</p>

    <p>Nous avons reçu une demande de réinitialisation de votre mot de passe. Si vous n'avez pas initié cette demande, veuillez ignorer cet e-mail. Aucune modification ne sera apportée à votre compte sans action supplémentaire de votre part.</p>

    <p>Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant : <a href='".$currentURL."/employee/confirme-password.php?id=".base64_encode($user['email'])."'>Réinitialiser mon mot de passe</a></p>

    <p>Si vous avez des questions ou besoin d'assistance supplémentaire, n'hésitez pas à contacter notre support à <a href='mailto:client@infinity-rdc.com'>client@infinity-rdc.com</a></p>

    <p>Cordialement,<br>Team Infinity Group Solutions</p>
</body>
</html>";

			echo smtp_mailer($to,$subject,$msg);
			return true;
			
		}else{
			return false;
		}
	}
	}
}
$forgotpassword=new forgotpassword($db);
if (isset($_POST['checkemail'])) {
	$email=$_POST['emailaddress'];
	$result=$forgotpassword->resetpassword($email);
	if ($result) {

		echo '<script>Swal.fire({
			title: "Password Reset Request Successfuly.",
			text: "Please Check Your Email Address. Usign Email Address providen Link Create New Password",
			icon: "success"
			}).then(function(){
				window.location.href="login";
			});</script>';
}else{

echo '<script>Swal.fire({
			title: "Password Reset Request Failded.",
			text: "Please Try To Reset Password With Valid Email Address",
			icon: "error"
			}).then(function(){
				window.location.href="login";
			});</script>';
}
}
?>