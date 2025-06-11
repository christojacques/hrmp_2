<?php
include_once 'protection.php';
class timesheet{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	public function addtime($title,$notes,$date,$hours,$employeeid){
		$createdate = date('Y-m-d h:i:s');
		$drh="invalid";
		$sql="INSERT INTO `daliy_timesheet`(`employee_id`, `project_title`, `project_note`, `working_hours`, `wroking_date`, `create_date`, `DRH_status`) VALUES (?,?,?,?,?,?,?)";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('issssss',$employeeid,$title,$notes,$hours,$date,$createdate,$drh);
		if ($stml->execute()) {
			return true;
		}else{
			return false;
		}
	}// add timesheet
	public function updatetime($title,$notes,$hours,$tsid,$employeeid){
		
		$sql="UPDATE `daliy_timesheet` SET `project_title`=?,`project_note`=?,`working_hours`=? WHERE `ts_id`=? AND `employee_id`=?";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('sssii',$title,$notes,$hours,$tsid,$employeeid);
		if ($stml->execute()) {
			return true;
		}else{
			return false;
		}
	}// Update timesheet





	public function showtimesheet($tabsdate) {
	$empid = $_SESSION['employeidno'];
	$sql = "SELECT * FROM `daliy_timesheet` WHERE `wroking_date`=? AND `employee_id`=?";
	$stmt = $this->db->prepare($sql);
	$stmt->bind_param('si', $tabsdate, $empid);
	$stmt->execute();
	$result = $stmt->get_result();
	$output = '';  // Variable to store HTML output
	if ($result->num_rows > 0) {

	$dhours=0;
	$dminutes=0;

	while ($fetch_dailytime = $result->fetch_assoc()) {
		if (empty($fetch_dailytime["status"])) {
			$action='<a  type="button" data-edit="'.$fetch_dailytime["ts_id"].'" data-bs-toggle="modal" data-bs-target="#updatetimesheet"  class="btn btn-sm btn-outline-primary" id="edit-time"><i class="mdi mdi-table-edit"></i></a>
			<a href="delete-task-time.php?id='.base64_encode($fetch_dailytime["ts_id"]).'" class="btn btn-sm btn-outline-danger delete-link" data-tsid="'.base64_encode($fetch_dailytime["ts_id"]).'"><i class="mdi mdi-delete"></i></a>';
		}else{
			$action='<div class="alert alert-primary text-center" role="alert">'.$fetch_dailytime["status"].'</div>';
		}
	$output .= '
	<tr>
		<td>'.$fetch_dailytime["project_title"].'</td>
		<td>'.$fetch_dailytime["project_note"].'</td>
		<td>'.$fetch_dailytime["working_hours"].'</td>
		<td>'.$action.'</td>
	</tr>
	<input type="hidden" name="ts_id[]" value="'.$fetch_dailytime["ts_id"].'" hidden>
	';

	list($hours, $minutes) = explode(':', $fetch_dailytime["working_hours"]);
	$dhours+=$totalHours = $hours;
	$dminutes+=$totalMinutes = $minutes;
	if ($dminutes>=60) {
		$dhours+=1;
		$dminutes-=60;
	}

	}
	echo "<h4 class='text-primary' style='text-align: center;padding: 10px;'>Today: $dhours Hours $dminutes Minutes</h4>";  // Echo the total time
	
	}
	$stmt->close();
	return $output;
	
	} //End Showtimesheet method


	public function weektimecounter($currentDate3){
		$formattedDate = $currentDate3->format('d-m-Y');
		 //return $formattedDate.'<br>';
		$empid=$_SESSION['employeidno'];
		 	$sql="SELECT * FROM `daliy_timesheet` WHERE `wroking_date`=? AND `employee_id`=?";
		 	$stml=$this->db->prepare($sql);
		 	$stml->bind_param('si',$formattedDate,$empid);
		 	$stml->execute();
			$result = $stml->get_result();
			$dhours=0;
			$dminutes=0;
			if ($result->num_rows > 0) {
				while ($fetch_dailytime = $result->fetch_assoc()) {
					list($hours, $minutes) = explode(':', $fetch_dailytime["working_hours"]);
					$dhours+=$hours;
					$dminutes+=$minutes;
					if ($dminutes>=60) {
						$dhours+=1;
						$dminutes-=60;
					}
				}

				//return "$dhours Hours $dminutes Minutes <br>";
			}
			 return array('hours' => $dhours, 'minutes' => $dminutes);
	}
}


$timesheet=new timesheet($db);





if (isset($_POST['add_time'])) {
	$title=$_POST['title'];
	$notes=$_POST['notes'];
	$date=$_POST['date'];
	$hours=$_POST['hours'];
	$result=$timesheet->addtime($title,$notes,$date,$hours,$employeeid);
	if ($result) {
echo '<script>Swal.fire({
title: "Parfait",
text: "Votre tâche a été enregistrée avec succès par notre système. N\'oubliez pas de soumettre votre feuille de temps à la fin de la semaine en cliquant sur le bouton bleu « Soumettre la semaine à l’approbation » en bas à gauche.  Cela permettra d\'envoyer toutes vos tâches à votre responsable pour validation.",
icon: "success"
}).then(function(){
	window.location.href="index";
});</script>';
}else{
echo '<script>Swal.fire({
title: "Veuillez réessayer !",
text: "La durée de votre projet n a pas été stockée.",
icon: "error"
}).then(function(){
	window.location.href="index";
});</script>';
}

}


if (isset($_POST['update_time'])) {
	$title=$_POST['title'];
	$notes=$_POST['notes'];
	$hours=$_POST['hours'];
	$tsid=$_POST['timesheetid'];
	$result=$timesheet->updatetime($title,$notes,$hours,$tsid,$employeeid);
	if ($result) {
echo '<script>Swal.fire({
title: "Bon travail",
text: "Le temps de votre projet mis à jour avec succès.",
icon: "success"
});</script>';
}else{
echo '<script>Swal.fire({
title: "Veuillez réessayer !",
text: "Le temps de votre projet est lié à la mise à jour.",
icon: "error"
});</script>';
}

}




?>
