
<?php 
include_once 'protection.php';

class weekapproved{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	
	public function submitetimesheet($timesheetid,$toweekhours,$toweekminute,$firstday,$lastday){
		if (!empty($timesheetid)) {
			foreach($timesheetid as $ids){
			$status="submited";
			$sql="UPDATE `daliy_timesheet` SET `status`=? WHERE `ts_id`=?";
			$stml=$this->db->prepare($sql);
			$stml->bind_param('si',$status,$ids);
			$stml->execute();
		}

		if ($stml->execute()) {
			$empid=$_SESSION['employeidno'];
			$checkissub2=mysqli_query($this->db,"SELECT * FROM `week_submission` WHERE `employee_id`='$empid' AND `ws_start_date`='$firstday' AND `ws_end_date`='$lastday'");
			if (mysqli_num_rows($checkissub2)>0) {
				$qry="UPDATE `week_submission` SET `ws_status`=?,`ws_hours`=?,`ws_minutes`=? WHERE `employee_id`=? AND `ws_start_date`=? AND `ws_end_date`=?";

				$slmt=$this->db->prepare($qry);
				$slmt->bind_param('sssiss',$status,$toweekhours,$toweekminute,$empid,$firstday,$lastday);

			}else{
				$qry="INSERT INTO `week_submission`(`employee_id`, `ws_hours`, `ws_minutes`,`ws_start_date`, `ws_end_date`, `ws_status`) VALUES (?,?,?,?,?,?)";
				
				$slmt=$this->db->prepare($qry);
				$slmt->bind_param('iiisss',$empid,$toweekhours,$toweekminute,$firstday,$lastday,$status);
			}	

				if ($slmt->execute()) {

					include_once 'weekly-email-template.php';
					return true;

				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
	}
}

$weekapporve=new weekapproved($db);






if (isset($_POST['weekapprove'])) {
	$toweekhours=$_POST['weekhours'];
	$toweekminute=$_POST['weekminutes'];
	$firstday=$_POST['firstday'];
	$lastday=$_POST['lastday'];
	if (isset($_POST['ts_id'])) {
		$timesheetid=$_POST['ts_id'];
		$result=$weekapporve->submitetimesheet($timesheetid,$toweekhours,$toweekminute,$firstday,$lastday);
		if ($result) {
			echo '<script>Swal.fire({
			title: "Bravo !",
			text: "Votre feuille de temps hebdomadaire a été soumise avec succès pour approbation.",
			icon: "success"
			}).then(function(){
				window.location.href="index";
			});</script>';
		}else{
			echo '<script>Swal.fire({
			title: "Veuillez réessayer !",
			text: "Votre feuille de temps hebdomadaire est soumise pour approbation.",
			icon: "error"
			}).then(function(){
				window.location.href="index";
			});;</script>';
		}
	}else{
		echo '<script>Swal.fire({
			title: "Pas de feuille de présence trouvée !",
			text: "Veuillez vérifier à nouveau",
			icon: "question"
			}).then(function(){
				window.location.href="index";
			});</script>';
	}


}


 ?>