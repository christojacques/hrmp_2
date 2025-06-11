<?php
include_once 'db.php';
class users{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	public function adduser($fname,$lname,$email,$phone,$userrole,$pass){
		$status="active";
		$password=password_hash($pass, PASSWORD_DEFAULT);
		$sql="INSERT INTO `users`(`fname`, `lname`, `email`, `phone`, `password`, `user_role`, `status`) VALUES (?,?,?,?,?,?,?)";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('sssssss',$fname,$lname,$email,$phone,$password,$userrole,$status);
		if ($stml->execute()) {
			return true;
		}else{
			return false;
		}
	} //add guard function end
	public function showusers(){
		$sql=mysqli_query($this->db,"SELECT * FROM `users`");
		if (mysqli_num_rows($sql)>0) {
			while ($fetch_users=mysqli_fetch_assoc($sql)) {
			echo '<tr>
					<td>'.$fetch_users["fname"].'</td>
					<td>'.$fetch_users["lname"].'</td>
					<td>'.$fetch_users["email"].'</td>
					<td>'.$fetch_users["phone"].'</td>
					<td>'.$fetch_users["user_role"].'</td>
					<td>'.strtoupper($fetch_users["status"]).'</td>
					<td>
							<a  href="delete-guard.php?id='.base64_encode($fetch_users["uid"]).'" class="btn btn-icon btn-danger">
										<span class="tf-icons bx bx-trash"></span>
							</a>
					</td>
										
				</tr>';
			}
		}
	}
}// End Guards Class
$users= new users($db);
if (isset($_POST['add_user'])) {
	
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$userrole=$_POST['user_role'];
	$pass=$_POST['Password'];
	$result=$users->adduser($fname,$lname,$email,$phone,$userrole,$pass);
	if ($result) {
echo '<script>Swal.fire({
title: "Congratulation",
text: "Successfully Created User Profile.",
icon: "success"
});</script>';
}else{
echo '<script>Swal.fire({
title: "Please Try Again",
text: "Faild To Created User Profile.",
icon: "error"
});</script>';
}
}
?>