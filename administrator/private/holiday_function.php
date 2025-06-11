<?php 

include_once 'db.php';

class holidays{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	public function addholiday($hdate,$hname){
		$sql="INSERT INTO `public_holidays`(`holiday_name`, `holiday_date`, `created_by`) VALUES (?,?,?)";
		$id=$_SESSION['employeidno'];
		$stml=$this->db->prepare($sql);
		$stml->bind_param('ssi',$hname,$hdate,$id);
		if ($stml->execute()) {
			return true;
		}else{
			return false;
		}

	}//End Add Holiday Method;

	public function showholidays(){
		$sql=mysqli_query($this->db,"SELECT * FROM `public_holidays`");
		if (mysqli_num_rows($sql)>0) {
			while($fetch_holiday=mysqli_fetch_assoc($sql)){
				echo '
				<tr>
                <td>'.$fetch_holiday["holiday_name"].'</td>
                <td>'.$fetch_holiday["holiday_date"].'</td>
                <td>
                 
                  <a type="button" data-edit="'.$fetch_holiday["ph_id"].'" data-bs-toggle="modal" data-bs-target="#edittype"  class="btn btn-sm btn-primary text-white" id="edit-type">Modifier</a>
                  <a href="delete-public_holiday.php?id='.base64_encode($fetch_holiday["ph_id"]).'" class="btn btn-sm btn-danger delete-link" data-hid="'.base64_encode($fetch_holiday["ph_id"]).'">Supprimer</a>
                </td>
              </tr>

				';
			}
		}
	}

	public function updateholiday($hn,$phid,$hd){
		$sql="UPDATE `public_holidays` SET `holiday_name`=?,`holiday_date`=? WHERE `ph_id`=?";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('ssi',$hn,$hd,$phid);
		if ($stml->execute()) {
			return true;
		}else{
			return false;
		}
	}
}// end class


$holidays=new holidays($db);

if (isset($_POST['addholiday'])) {
	$hdate=$_POST['holidaydate'];
	$hname=$_POST['holidayname'];
	$result=$holidays->addholiday($hdate,$hname);

	if ($result) {
		echo '<script>Swal.fire({
		title: "Félicitations",
		text: "Ajout réussi d un nouveau jour férié.",
		icon: "success"
		}).then(function(){
		window.location.href="public_holiday"
		});</script>';
	}else{
		echo '<script>Swal.fire({
		title: "Veuillez réessayer",
		text: "Échec de l ajout d un nouveau jour férié.",
		icon: "error"
		}).then(function(){
		window.location.href="public_holiday"
		});</script>';
	}
}


if (isset($_POST['updatepholiday'])) {
	$hn=$_POST['holidayname'];
	$phid=$_POST['ph_id'];
	$hd=$_POST['holidaydate'];
	$result=$holidays->updateholiday($hn,$phid,$hd);

	if ($result) {
			echo '<script>Swal.fire({
		title: "Félicitations",
		text: "Mise à jour réussie du jour férié.",
		icon: "success"
		}).then(function(){
		window.location.href="public_holiday"
		});</script>';
	}else{
		echo '<script>Swal.fire({
		title: "Veuillez réessayer",
		text: "Faild pour la mise à jour des jours fériés.",
		icon: "error"
		}).then(function(){
		window.location.href="public_holiday"
		});</script>';
	}

}




 ?>