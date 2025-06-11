<?php 

include_once 'db.php';



class employees{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}

	public function EmployeeRequest($fname,$lname,$email,$phone,$dob,$password,$jobtitle,$contractno,$contractstart,$contractend,$contracttype,$department,$assignproject,$assigunit,$bankname,$bankaccount,$paymentmethod){
		$pass=password_hash($password, PASSWORD_DEFAULT);
		$sql="INSERT INTO `employees`(`fname`, `lname`, `email`, `phone`, `job_title`, `contract_no`, `contract_start`, `contract_end`, `contract_type`, `project_assign`, `unit_assign`, `dob`, `department`, `bank_name`,`bank_account`, `payment_method`, `password`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

		$stml=$this->db->prepare($sql);
		$stml->bind_param('sssssssssssssssss',$fname,$lname,$email,$phone,$jobtitle,$contractno,$contractstart,$contractend,$contracttype,$assignproject,$assigunit,$dob,$department,$bankname,$bankaccount,$paymentmethod,$pass);
		$sqlquery=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `email`='$email'");
		// if (mysqli_num_rows($sqlquery)>0) {
		// 	return "Exit";
		// }else{
		// if ($stml->execute()) {
		// 	return true;
		// }else{
		// 	return false;
		// }
		// }
			if (mysqli_num_rows($sqlquery) > 0) {
				return "Exit";
			} else {
			if ($stml->execute()) {
				include_once 'registration-email-template.php';
				return "Done";
			} else {
				return false;
			}
			}
		
	}
}

$employee=new employees($db);

if (isset($_POST['add_employee'])) {
	
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$dob=$_POST['dob'];
	$pass=$_POST['password'];
	$conpass=$_POST['cpassword'];
	$jobtitle=$_POST['jobtitle'];
	$contractno=$_POST['contractno'];
	$contractstart=$_POST['contractstart'];
	$contractend=$_POST['contractend'];
	$contracttype=$_POST['contracttype'];
	$department=$_POST['department'];
	$assignproject=$_POST['assignproject'];
	$assigunit=$_POST['assigunit'];
	$bankname=$_POST['bankname'];
	$bankaccount=$_POST['bankaccount'];
	$paymentmethod=$_POST['paymentmethod'];

	if (!empty($pass) && !empty($conpass)) {
		if ($pass==$conpass) {
			$password=$pass;
			$result=$employee->EmployeeRequest($fname,$lname,$email,$phone,$dob,$password,$jobtitle,$contractno,$contractstart,$contractend,$contracttype,$department,$assignproject,$assigunit,$bankname,$bankaccount,$paymentmethod);
		if ($result == "Done") {
    echo '<script>Swal.fire({
        title: "Félicitations !",
        text: "Votre formulaire d’inscription a bien été envoyé. Il sera transmis à votre responsable, qui examinera votre demande et validera votre inscription si tout est en ordre. Une fois votre inscription acceptée, vous recevrez un e-mail de confirmation. Vous pourrez alors vous connecter à la plateforme avec le mot de passe que vous avez créé.",
        icon: "success"
        }).then(function(){
            window.location.href="../";
        });</script>';
}elseif ($result == "Exit") {
    echo '<script>Swal.fire({
        title: "Please Try Again",
        text: "Un compte existe déjà avec cette adresse e-mail. Veuillez utiliser une adresse différente ou vous connecter à votre compte existant.",
        icon: "question"
        });</script>';
}else{
    echo '<script>Swal.fire({
        title: "Please Try Again",
        text: "Failed To Submit Your Employee Registration Form.",
        icon: "error"
        }).then(function(){
            window.location.href="employee-registration-form";
        });</script>';
}

		}else{
			echo '<script>Swal.fire({
		title: "Please Try Again !",
		text: "Password & Confirm Password Not Same.",
		icon: "error"
		});</script>';
		}
	}else{
		echo '<script>Swal.fire({
		title: "Please Try Again !",
		text: "Please Input your Login Password.",
		icon: "error"
		});</script>';
	}
	


	


}


 ?>