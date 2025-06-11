<?php 

include_once 'db.php';

class timesheet{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}

	public function updatetime($title,$notes,$hours,$tsid){
		
		$sql="UPDATE `daliy_timesheet` SET `project_title`=?, `project_note`=?, `working_hours`=? WHERE `ts_id`=?";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('sssi',$title,$notes,$hours,$tsid);
		if ($stml->execute()) {
			return true;
		}else{
			return false;
		}
	}
}
$timesheet=new timesheet($db);
if (isset($_POST['update_time'])) {
	$title=$_POST['title'];
	$notes=$_POST['notes'];
	$tsid=$_POST['timesheetid'];
	$hours=$_POST['hours'];
	$result=$timesheet->updatetime($title,$notes,$hours,$tsid);

	if ($result) {
		echo '<script>Swal.fire({
		title: "Good Job",
		text: "The Task Time  Successfully Updated.",
		icon: "success"
		});</script>';
	}else{
		echo '<script>Swal.fire({
		title: "Please Try Again!",
		text: "The Task Time Failded to Update.",
		icon: "error"
		});</script>';
	}
}

 ?>