<?php
include_once 'db.php';
class weeklyworks{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	public function showsubmitedwork($week){
		$year = substr($week, 0, 4);
		$week_number = substr($week, 6);
		$start = date("d-m-Y", strtotime($year . 'W' . $week_number));
		$end = date("d-m-Y", strtotime($year . 'W' . $week_number . ' +6 days'));
		$sql = mysqli_query($this->db, "SELECT * FROM `week_submission` JOIN `employees` ON `week_submission`.`employee_id`= `employees`.`eid` WHERE `ws_start_date`='$start' AND `ws_end_date`='$end'");
		// $sql = mysqli_query($this->db, "SELECT * FROM `week_submission` JOIN `employees` ON `week_submission`.`employee_id`= `employees`.`eid` WHERE `ws_status`='submited'");
		$output='';
		if (mysqli_num_rows($sql)>0) {
			while($fetch_submitwork=mysqli_fetch_assoc($sql)){
				if ($fetch_submitwork["ws_status"]=='submited') {
					$status='<div class="alert-primary" role="alert">Submited</div>';
				}elseif ($fetch_submitwork["ws_status"]=='Approved') {
					$status='<div class="alert-success" role="alert">Approved</div>';
				}else{
					$status='<div class="alert-warning" role="alert">'.$fetch_submitwork["ws_status"].'</div>';
				}
				$output.=' <tr">
					<td>'.$fetch_submitwork["fname"].'</td>
					<td>'.$fetch_submitwork["job_title"].'</td>
					<td>'.$fetch_submitwork["department"].'</td>
					<td>'.$fetch_submitwork["contract_no"].'</td>
					<td>'.$fetch_submitwork["ws_start_date"].' <b>To</b> '.$fetch_submitwork["ws_end_date"].'</td>
					<td>'.$fetch_submitwork["ws_hours"].' Hours '.$fetch_submitwork["ws_minutes"].' Minutes</td>
					<td>
					<input type="number" class="from-control dayofex" value="'.$fetch_submitwork["dayofex"].'">
      <input type="hidden" class="wsid" value="'.$fetch_submitwork["ws_id"].'">
					</td>
					<td>'.$status.'</td>
					<td>
						<a href="view-weekly-submission.php?id='.base64_encode($fetch_submitwork["ws_id"]).'" class="btn btn-sm 				btn-outline-primary"><i class="bx bx-spreadsheet"></i></a>
					</td>
					</tr>';
			}
		}
		return $output;
	}
	public function submitiondetails($subid){
			$getwssql=mysqli_query($this->db,"SELECT * FROM `week_submission` WHERE `ws_id`='$subid'");
			if (mysqli_num_rows($getwssql)>0) {
				$fetchws=mysqli_fetch_assoc($getwssql);
				$eid=$fetchws['employee_id'];
				$start=$fetchws['ws_start_date'];
				$end=$fetchws['ws_end_date'];
				$current_date = strtotime($start);
				$end_timestamp = strtotime($end);
				$output='';
				$workingids='';
				while ($current_date <= $end_timestamp) {
				 $dayOfWeek = date('N', $current_date);
				 
				 if ($dayOfWeek<6) {
				 	 $formatted_date = date('d-m-Y', $current_date);
				 	$getdailysheet=mysqli_query($this->db, "SELECT * FROM `daliy_timesheet` WHERE `employee_id`='$eid' AND `wroking_date`='$formatted_date' AND `status`!=''");
				if (mysqli_num_rows($getdailysheet)>0) {
					// $output.='';
					// $workingids.='';
						while($fetch_dailytime=mysqli_fetch_assoc($getdailysheet)){
							$output.='<tr>
								<td>'.$fetch_dailytime["project_title"].'</td>
								<td>'.$fetch_dailytime["project_note"].'</td>
								<td>'.$fetch_dailytime["working_hours"].'</td>
								<td>'.$fetch_dailytime["wroking_date"].'</td>
								<td><a type="button" data-edit="'.$fetch_dailytime["ts_id"].'" data-bs-toggle="modal" data-bs-target="#updatetimesheet" class="btn btn-primary text-white" id="edit-time"><i class="bx bxs-edit"></i></a>
								</td>
						</tr>';
						$workingids.=$fetch_dailytime["ts_id"].',';
						}
						
				 
					 
						
				}

				
				 }
				
				 $current_date = strtotime('+1 day', $current_date);

				}
				echo '<input type="text" name="tsids" value="'.$workingids.'" hidden>';
				 echo '<input type="text" name="emids" value="'.$eid.'" hidden>';
				return $output;
				
				

				


			}
	}
	public function daliyreports($subid,$ma_module,$ts_module) {
		$getwssql = mysqli_query($this->db, "SELECT * FROM `week_submission` WHERE `ws_id`='$subid'");
		if (mysqli_num_rows($getwssql) > 0) {
		$fetchws = mysqli_fetch_assoc($getwssql);
		$eid = $fetchws['employee_id'];
		$start = $fetchws['ws_start_date'];
		$end = $fetchws['ws_end_date'];
		$current_date = strtotime($start);
		$end_timestamp = strtotime($end);
		if ($ma_module==1 && $ts_module==1) {
			$output2='<strong>Semaine du: '.$start.' Au: '.$end.'</strong>
			<table class="table table-bordered">
					<thead>
						<tr>
							<th>Date</th>
							<th>Entrée</th>
							<th>Sortie</th>
							<th>HEURES DE TRAVAIL  (FEUILLE DE TEMPS)</th>
							<th>Heures au bureau (Gardien)</th>
							<th>Écart (Heures bureau / travail)</th>
						</tr>
					</thead>
					<tbody>
		';
		}elseif($ma_module!=1 && $ts_module==1){
		$output2='<strong>Start Week: '.$start.' End Week: '.$end.'</strong>
		<table class="table table-bordered">
					<thead>
						<tr>
							<th>Date</th>
							<th>Heures de travail</th>
						</tr>
					</thead>
					<tbody>
		';
		}
		
		
			$diffInSeconds = 0;
			$totalhours = 0;
			$totalminutes = 0;
			$diffhours=0;
			$diffminutes=0;
			$tdwh=0;
			$tdwm=0;
			$totime=0;
			

			while ($current_date <= $end_timestamp) {
				$dayOfWeek = date('N', $current_date);

			 if ($dayOfWeek <6) {
				$dayOfWeek = date('N', $current_date);
			$output2.= '<tr>';	
			 
			$formatted_date = date('d-m-Y', $current_date);
			$getdailysheet = mysqli_query($this->db, "SELECT * FROM `daliy_timesheet` WHERE `employee_id`='$eid' AND `wroking_date`='$formatted_date' AND `status`!=''");
			$getatten = mysqli_query($this->db, "SELECT * FROM `attendance` WHERE `dates`='$formatted_date' AND `employee_id`='$eid'");
			$timecount1= $formatted_date;
			$diff=0;
			$diffh=0;
			$diffm=0;
			if (mysqli_num_rows($getatten) > 0) {
			$timecount = 0;

			while ($fetchatten = mysqli_fetch_assoc($getatten)) {
			$timecount = $fetchatten["dates"];
			$entry = $fetchatten["entry_dt"];
			$exit = $fetchatten["exit_dt"];
			$datetime1 = new DateTime($entry);
			$datetime2 = new DateTime($exit);
			$interval = $datetime1->diff($datetime2);
			$diff=$interval->format('%H Hours %i Minutes');
			$diffh+=$interval->format('%H');
			$diffm+=$interval->format('%i');
			$diffhours+=$interval->format('%H');
			$diffminutes+=$interval->format('%i');
			if ($diffminutes >=60) {
				$diffhours+=1;
				$diffminutes-=60;
			}
			
			//$diffInSeconds += $interval->s + $interval->i * 60 + $interval->h * 3600;
			}
			$output2 .= '<td>' . $timecount . '</td>';
			if ($ma_module==1) {
				$output2 .= '<td>' . date("H:i:s",strtotime($entry)) . '</td>';
				$output2 .= '<td>' . date("H:i:s",strtotime($exit)) . '</td>';
			}
			
			
			}else{
			$output2.= '<td>' . $timecount1 . '</td>';
			if ($ma_module==1) {
				$output2 .= '<td></td>';
				$output2 .= '<td></td>';
			}
			
			$diffh=0;
			$diffm=0;
			}
			$dhours = 0;
			$dminutes = 0;
			while ($fetch_dailytime = mysqli_fetch_assoc($getdailysheet)) {
			list($hours, $minutes) = explode(':', $fetch_dailytime["working_hours"]);
			$dhours += $hours;
			$dminutes += $minutes;
			}
			//echo $dhours.'-'.$dminutes.'<br>';
			$dhours += floor($dminutes / 60);
			$dminutes = $dminutes % 60;
			
			$totalhours += $dhours;
			$totalminutes += $dminutes;
			// calculation
			$officeStayTotalMinutes = ($diffh * 60) + $diffm;
			$workRecordTotalMinutes = ($dhours * 60) + $dminutes;
			$differenceTotalMinutes = $officeStayTotalMinutes - $workRecordTotalMinutes;
			if ($differenceTotalMinutes >= 0) {
    			$dwh = floor($differenceTotalMinutes / 60);
    			$dwm = $differenceTotalMinutes % 60;
			} else {
    			$dwh = ceil($differenceTotalMinutes / 60); // Overtime hours will be negative
    			$dwm = abs($differenceTotalMinutes) % 60;
			}
			
			// calculation
			
			if ($ma_module==1) {
				$output2 .= '<td>' . $dhours . ' Heures ' . $dminutes . ' Minutes</td>
				<td>' . $diffh .' Heures '. $diffm.' Minutes</td>
				<td>' . $dwh . ' Heures '.$dwm.' Minutes</td></tr>';	
			}else{
				$output2 .= '<td>' . $dhours . ' Heures ' . $dminutes . ' Minutes</td>';	
			}

		$tdwh+=$dwh;
		$tdwm+=$dwm;
		$totime+=$differenceTotalMinutes;
		}
		
		$current_date = strtotime('+1 day', $current_date);

		
		}
		if ($totime >= 0) {
    			$tdwh = floor($totime / 60);
    			$tdwm = $totime % 60;
		} else {
    			$tdwh = ceil($totime / 60); // Overtime hours will be negative
    			$tdwm = abs($totime) % 60;
		}
		 $totalhours += floor($totalminutes / 60);
		 $totalminutes = $totalminutes % 60;
		$formattedDuration = gmdate("H:i:s", $diffInSeconds);
		if ($ma_module==1) {
			$output2 .= '<tr>
			<td colspan="3" class="text-center"><strong>Total</strong></td>
			<td>' . $totalhours . ' Heures ' . $totalminutes . ' Minutes</td>
			<td>' .$diffhours.  ' Heures '.$diffminutes.' Minutes</td>
			<td>' .$tdwh.  ' Heures '.$tdwm.' Minutes</td>
		</tr>
		</tbody>
		</table>
		</div>';	
		}else{
			$output2 .= '<tr>
			<td  class="text-center"><strong>Total</strong></td>
			<td>' . $totalhours . ' Heures ' . $totalminutes . ' Minutes</td>
		</tr>
		</tbody>
		</table>
		</div>';
		}
		

		return $output2;
		}
	}

	public function empinfo($subid){
				$getwssql = mysqli_query($this->db, "SELECT * FROM `week_submission` JOIN `employees` ON `week_submission`.`employee_id`= `employees`.`eid` WHERE `ws_id`='$subid'");

				if (mysqli_num_rows($getwssql)>0) {
					return $fethemp=mysqli_fetch_assoc($getwssql);
					 //'<h4 class="text-center">'.$fethemp['fname'].' '.$fethemp['lname'].'</h4>';

				}
	}


	public function validtimesheetids($tsids,$empids,$weeklyid){
		$ids = explode(",", $tsids);
		foreach($ids as $value){
 			$sql=mysqli_query($this->db,"UPDATE `daliy_timesheet` SET `DRH_status`='valid',`status`='Approved' WHERE `ts_id`='$value' AND `employee_id`='$empids'");
  		}
  		$sql2=mysqli_query($this->db,"UPDATE `week_submission` SET `ws_status`='Approved' WHERE `ws_id`='$weeklyid' AND `employee_id`='$empids'");
  		if ($sql && $sql2) {
  			return true;
  		}else{
  			return false;
  		}
  	}
}


$weeklywork=new weeklyworks($db);


if (isset($_POST['approved'])) {
	//echo ;
  $tsids=$_POST['tsids'];
  
	$empids=$_POST['emids'];
	$weeklyid=$_POST['weeklysubid'];


	$result=$weeklywork->validtimesheetids($tsids,$empids,$weeklyid);
if ($result) {
echo '<script>Swal.fire({
title : " Félicitations",
text : " Feuille de temps de l employé approuvée avec succès ",
icon : "success",
}).then(function(){
	window.location.href="manage-weekly-work";
});</script>' ;
}else{
echo '<script>Swal.fire({
title : " Veuillez réessayer ",
text : " Échec à la feuille de temps approuvée de l employé ",
icon : "error",
}).then(function(){
	window.location.href="manage-weekly-work";
});</script>' ;
}

}




?>