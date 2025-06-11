<?php
include_once 'db.php';
class guards{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	public function addguard($name,$idno,$pass){
		$status="active";
		$password=password_hash($pass, PASSWORD_DEFAULT);
		$sql="INSERT INTO `guard`(`guard_name`, `login_id`, `password`, `status`) VALUES (?,?,?,?)";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('ssss',$name,$idno,$password,$status);
		if ($stml->execute()) {
			return true;
		}else{
			return false;
		}
	} //add guard function end
	public function showguard(){
		$sql=mysqli_query($this->db,"SELECT * FROM `guard`");
		if (mysqli_num_rows($sql)>0) {
			while ($fetch_guard=mysqli_fetch_assoc($sql)) {
			echo '<tr>
									<td>'.$fetch_guard["guard_name"].'</td>
									<td>'.$fetch_guard["login_id"].'</td>
									<td>'.strtoupper($fetch_guard["status"]).'</td>
									<td>
											<a  href="edit-guard.php?id='.base64_encode($fetch_guard["gid"]).'" class="btn btn-icon btn-primary ml-5">
													<span class="tf-icons bx bx-edit"></span>
											</a>
											<a  href="delete-guard.php?id='.base64_encode($fetch_guard["gid"]).'" class="btn btn-icon btn-danger ml-5 delete-link" data-gid="'.base64_encode($fetch_guard["gid"]).'">
													<span class="tf-icons bx bx-trash"></span>
											</a>
									</td>
									
							</tr>';
			}
		}
	}


	public function singleguard($guardid){
	    $sql = "SELECT * FROM `guard` WHERE `gid`=?";
	    $stml = $this->db->prepare($sql);
	    $stml->bind_param('i', $guardid);
	    $stml->execute();   
	    $result = $stml->get_result();    
	    if ($result->num_rows > 0) {  
	        return $result->fetch_assoc();
	    } else { 
	        return false;
	    }
	}

	public function updateguard($name,$guardidno,$gids,$status,$password){
		$sql="UPDATE `guard` SET `guard_name`=?, `login_id`=?,`password`=?,`status`=? WHERE `gid`=?";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('ssssi',$name,$guardidno,$password,$status,$gids);

		if ($stml->execute()) {
			return true;
		}else{
			return false;
		}
	}




}// End Guards Class
$guard= new guards($db);
if (isset($_POST['add_guard'])) {
	
	$name=$_POST['guardname'];
	$idno=$_POST['idno'];
	$pass=$_POST['password'];
	$result=$guard->addguard($name,$idno,$pass);
	if ($result) {
echo '<script>Swal.fire({
title: "Félicitations!",
text: "Les informations sur la garde ont été ajoutées avec succès.",
icon: "success"
});</script>';
}else{
echo '<script>Swal.fire({
title: "Failded",
text: "Guard Information Failded to Added.",
icon: "success"
});</script>';
}
}






?>