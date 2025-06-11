<?php
include_once 'db.php';
class alaglance{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	public function getempinfos($empglanceid,$start,$end){
		
		$current_date = strtotime($start);
		$end_timestamp = strtotime($end);
		$tweekend=0;
		$tweekend2=0;
		$tworkingday=0;
		$tholidays=0;
		$workingdates=array();
		$holidays=array();
		$getleavdays = array();
		$totaljustabsday=0;
		$totaldayofexu=0;
		while ($current_date <= $end_timestamp) {
			$dayOfWeek = date('N', $current_date);
			if ($dayOfWeek <= 7) {
				$formatted_date = date('d-m-Y', $current_date);
				//echo date('D', $current_date);
				$gettotalleaveday=mysqli_query($this->db,"SELECT * FROM `leave_request` WHERE `emp_id`='$empglanceid' AND `start_date`='$formatted_date' AND `lr_status`='Approved'");
				if (mysqli_num_rows($gettotalleaveday)>0) {
					while($fetch_getotalleav=mysqli_fetch_assoc($gettotalleaveday)){
						$totaljustabsday+=$fetch_getotalleav['approval_day'];
					}
				}
				
				$getholiday=mysqli_query($this->db,"SELECT * FROM `public_holidays` WHERE `holiday_date`='$formatted_date'");
				if (mysqli_num_rows($getholiday)>0) {
					$fetchholi=mysqli_fetch_assoc($getholiday);
					$tholidays+=1;
					$holidays[]=$fetchholi["holiday_date"];
					$tworkingday+=1;
					$workingdates[]=$formatted_date;
				}else{
					
					$tworkingday+=1;
					$workingdates[]=$formatted_date;
				}
			}else{
				$tweekend+=1;
			}
			if ($dayOfWeek < 6) {
				
			}else{
				$tweekend2+=1;
			}
		
			$getleave = mysqli_query($this->db, "SELECT * FROM `leave_request` WHERE `emp_id`='$empglanceid' AND `start_date`='$formatted_date'");
			if (mysqli_num_rows($getleave) > 0) {
			while ($fetchleavinfo = mysqli_fetch_assoc($getleave)) {
				$leavS = $fetchleavinfo['start_date'];
				$leavE = $fetchleavinfo['end_date'];
				$LeavS_date = strtotime($leavS);
				$LeavE_date = strtotime($leavE);
			while ($LeavS_date <= $LeavE_date) {
				$dayOfWeek = date('N', $LeavS_date);
			if ($dayOfWeek < 6) { // Exclude weekends
				$pre_date = date('d-m-Y', $LeavS_date);
				$getholiday = mysqli_query($this->db, "SELECT * FROM `public_holidays` WHERE `holiday_date`='$pre_date'");
			if (mysqli_num_rows($getholiday) == 0) {
				$getleavdays[] = $pre_date;
				//echo $pre_date . '<br>'; // Debugging: Output the non-holiday date
			}
			}
				$LeavS_date = strtotime('+1 day', $LeavS_date); // Move to next day
			}
			}
			}
			//day of exucation
			$getdayofexit = mysqli_query($this->db, "SELECT * FROM `week_submission` WHERE `ws_start_date`='$formatted_date'");
			if (mysqli_num_rows($getdayofexit) > 0) {
			while ($fetch_getdayofexit = mysqli_fetch_assoc($getdayofexit)) {
			// Accumulate dayofex values to calculate total
				$totaldayofexu+=$fetch_getdayofexit['dayofex'];
			}
			}
		$current_date = strtotime('+1 day', $current_date);
		}
		$Tworkrecoard=0;
		$Tworkhours=0;
		$Tworkminut=0;
		foreach($workingdates  as $gdates){
			$newarray = array_merge($holidays, $getleavdays);
			if (in_array($gdates,$newarray)) {
			//echo "Current date is found in the array.";
			}else{

			//echo $gdates.'<br>';
			$dtimesheet = mysqli_query($this->db,"SELECT * FROM `daliy_timesheet` WHERE `employee_id`='$empglanceid' AND `wroking_date`='$gdates' AND `DRH_status`='valid'");
			// $dtimesheet = mysqli_query($this->db,"SELECT * FROM `daliy_timesheet` WHERE `employee_id`='$empglanceid' AND `wroking_date`='$gdates' AND `DRH_status`='valid' ");
				if (mysqli_num_rows($dtimesheet)>0) {
				$dhours=0;
				$dminutes=0;
				$Tworkrecoard+=1;
				while ($fetchtimesheet=mysqli_fetch_assoc($dtimesheet)) {
					//echo $fetchtimesheet["wroking_date"].'='.$fetchtimesheet["working_hours"].'<br>';
				list($hours, $minutes) = explode(':', $fetchtimesheet["working_hours"]);
				$dhours+=$totalHours = $hours;
				$dminutes+=$totalMinutes = $minutes;
				if ($dminutes>=60) {
					$dhours+=1;
					$dminutes-=60;
				}
				
				}
				$Tworkhours+=$dhours;
				$Tworkminut+=$dminutes;
			$dattend=mysqli_query($this->db,"SELECT * FROM `attendance` WHERE `dates`='$gdates'");
			$start1=null;
			$end2=null;
			if (mysqli_num_rows($dattend)>0) {
				$thours=0;
				$tminues=0;
				
				while ($fetchdatten=mysqli_fetch_assoc($dattend)) {
					$start1=$fetchdatten['entry_dt'];
					$end2=$fetchdatten['exit_dt'];
					$entry = new DateTime($fetchdatten['entry_dt']);
					$exit = new DateTime($fetchdatten['exit_dt']);
					// Calculate the difference between the two DateTime objects
					$interval = $entry->diff($exit);
					// Extract total minutes and total hours from the difference
					$total_minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
					$total_hours = floor($total_minutes / 60); // Get the whole number of hours
					$remaining_minutes = $total_minutes % 60; // Get the remaining minutes
					$thours+=$total_hours;
					$tminues+=$remaining_minutes;
					// echo "Total Time: $total_hours Hours $remaining_minutes Minutes\n";
				}
				if ($tminues>=60) {
					$thours+=1;
					$tminues-=60;
				}
					$stayoffice =$thours.' Hours '.$tminues.' Minutes';
				}else{
				$stayoffice ='0 Hours 0 Minutes';
			}
			if ($dminutes!=0) {
				$hdi=7-$dhours;
				$mdi=60-$dminutes;
			}else{
				$hdi=8-$dhours;
				$mdi=0-$dminutes;
			}
			
			$Weeknd = date('D', strtotime($gdates));
			if ($Weeknd == 'Sat' || $Weeknd == 'Sun') {
				$background_color = '#ddd';
			} elseif (in_array($gdates, $holidays)) { // Check if it's a holiday
				$background_color = '#272658';
				$text_color = 'white';
			} else { // Regular weekday
				$background_color = ''; // Default background color
				$text_color = '';
			}
			if (in_array($gdates, $getleavdays)) {
			
			
			} elseif (in_array($gdates, $holidays)) { // Check if it's a holiday
			
			}else{
			
			}
			
			
				
			}else{
				$Weeknd = date('D', strtotime($gdates));
				if ($Weeknd == 'Sat' || $Weeknd == 'Sun') {
				$background_color = '#ddd';
				} elseif (in_array($gdates, $holidays)) { // Check if it's a holiday
				$background_color = '#272658';
				$text_color = 'white';
				} else { // Regular weekday
				$background_color = '';
				$text_color = '';
				// Default background color
				}
				if (in_array($gdates,$getleavdays)) {
				
				} elseif (in_array($gdates, $holidays)) { // Check if it's a holiday
			
			}else{
				
			}
				
			
				
			}
		 }
		}
		$countleave=count($getleavdays);
		$withoutweekend=$tworkingday-$tweekend2;
		$withoutpublic=$withoutweekend-$tholidays;
		$dayofnotwork=$withoutpublic-$Tworkrecoard;
		$dayofnotworkwithpubweek=$withoutpublic-$countleave-$Tworkrecoard;
		
		$exp_ho=$withoutweekend*8;
		if ($Tworkminut >= 60) {
    // Calculate overflow hours
    $overflow_hours = intval($Tworkminut / 60);
    
    // Add overflow hours to total hours
    $Tworkhours += $overflow_hours;
    
    // Update remaining minutes
    $Tworkminut %= 60;
}
		$apprvac=count($getleavdays)*8;
		
		
		$totalhrecod=$Tworkhours;//.'.'.$Tworkminut;
		$totalhrecod1=$Tworkhours.' Hours '.$Tworkminut.' Minutes';
		
		$act_hourswithpubweekwork=$totalhrecod+($tholidays*8)+$apprvac;
		$act_hourswithpubweekwork1=$totalhrecod+($tholidays*8)+$apprvac.' Hours '.$Tworkminut.' Minutes';


		$att_rate=(($act_hourswithpubweekwork*60+$Tworkminut)/($exp_ho*60))*100;
		$hnotwork=$exp_ho-$totalhrecod;
		$exhnotwork=$exp_ho-$act_hourswithpubweekwork;

		if ($Tworkminut > 0) {
			$hnotwork1=$hnotwork-1;
			$exhnotwork1=$exhnotwork-1;
			
			$Tworkminut1=60-$Tworkminut;
			
			$hoursnotwork=$hnotwork1.' Hours '.$Tworkminut1.' Minutes.';
			$exhoursnotwork=$exhnotwork1.' Hours '.$Tworkminut1.' Minutes.';
		}else{
			$hoursnotwork=$hnotwork.' Hours '.$Tworkminut.' Minutes.';
			$exhoursnotwork=$exhnotwork.' Hours '.$Tworkminut.' Minutes.';
		}
	$getinfoemp=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$empglanceid'");
	if (mysqli_num_rows($getinfoemp)) {
		$fetchemp=mysqli_fetch_assoc($getinfoemp);
	}
 $filename=$fetchemp["fname"].'-'.$fetchemp["lname"].'-'.date('d-M-Y').'.doc';
 header("Content-Type: application/vnd.ms-word");
 header("Content-Disposition: attachment; filename=\"$filename\"");
		$output='
	
<div class="row text-dark mb-4">
	<div class="mb-4 text-center">
		<h4 >FICHE DE PRESENCE DU '.$start.' AU '.$end.'</h4>
		<strong >Nombre de jours ouvrables de la periode: '.$tworkingday-$tweekend2.' Days</strong>
	</div>
	<div class="col text-left">
		<h5>1. Identites</h5>
		<table >
			<tbody>
				<tr>
					<td>Noms:</td>
					<td>'.$fetchemp["fname"].' '.$fetchemp["lname"].'</td>
				</tr>
				<tr>
					<td>Fonction:</td>
					<td> '.$fetchemp["job_title"].'</td>
				</tr>
				<tr>
					<td>Projet:</td>
					<td> '.$fetchemp["project_assign"].'</td>
				</tr>
				<tr>
					<td>Departement:</td>
					<td> '.$fetchemp["department"].'</td>
				</tr>
				<tr>
					<td>N*: Contrat</td>
					<td> '.$fetchemp["contract_no"].'</td>
				</tr>
				<tr>
					<td>Type de Contrat:</td>
					<td> '.$fetchemp["contract_type"].'</td>
				</tr>
				
			</tbody>
		</table>
	</div>
	<div class="col text-left">
		<h5>2. Presences</h5>
		<table >
			<tbody>
				<tr>
					<td>Total Number of Workable Days:</td>
					<td> '.$withoutweekend.' Holidays</td>
				</tr>
				<tr>
					<td>Total Scheduled Workdays:</td>
					<td> '.$withoutpublic.' Days</td>
				</tr>
				<tr>
					<td>Days Worked:</td>
					<td> '.$Tworkrecoard.' Days</td>
				</tr>
				<tr>
					<td>Expected Hours:</td>
					<td> '.$exp_ho.' Hours</td>
				</tr>
				<tr>
					<td>Actual Hours ( With Pu. & Va. Days ):</td>
					<td> '.$act_hourswithpubweekwork1.'</td>
				</tr>
				<tr>
					<td>Actual Hours (Recorded):</td>
					<td> '.$totalhrecod1.'</td>
				</tr>
				<tr>
					<td>Days Not Worked:</td>
					<td> '.$dayofnotwork.' Days</td>
				</tr>
				<tr>
					<td>Days Not Worked (Ex. Pub. & Off Days ):</td>
					<td> '.$dayofnotworkwithpubweek.' Days</td>
				</tr>
				
			</tbody>
		</table>
	</div>
	<div class="col text-left">
		<table >
			<tbody>
				<tr>
					<td>Hours Not Worked (In. Pub. & Day Off):</td>
					<td> '.$hnotwork.' Hours</td>
				</tr>
				<tr>
					<td>Hours Not Worked (Ex. Pub. & Day Off):</td>
					<td> '.$exhnotwork.' Hours</td>
				</tr>
				<tr>
					<td>Attendance Rate:</td>
					<td> '.number_format($att_rate, 2).'%</td>
				</tr>
				<tr>
					<td>Justified Absence Days:</td>
					<td> '.$totaljustabsday.' Days</td>
				</tr>
				<tr>
					<td>Leave Days Used:</td>
					<td> '.$totaljustabsday.' Days</td>
				</tr>
				<tr>
					<td>Observed Public Holidays:</td>
					<td>'.$tholidays.' Days</td>
				</tr>
				<tr>
					<td>Remaining Annual Leave Days:</td>
					<td>'.$fetchemp["total_holiday"]-$fetchemp["spend_holiday"].' Days</td>
				</tr>
				<tr>
					<td>Weekend Days:</td>
					<td>'.$tweekend2.' Days</td>
				</tr>
				<tr>
					<td>Days of Exclusion:</td>
					<td>'.$totaldayofexu.' Days</td>
				</tr>
				
				
			</tbody>
		</table>
	</div>
</div>
		';
return $output;










	}//employee info.......

	public function getworkingtimes($empglanceid,$start,$end){
		$current_date = strtotime($start);
		$end_timestamp = strtotime($end);
		$tweekend=0;
		$tweekend2=0;
		$tworkingday=0;
		$tholidays=0;
		$workingdates=array();
		$holidays=array();
		$getleavdays = array();
		while ($current_date <= $end_timestamp) {
			$dayOfWeek = date('N', $current_date);
			if ($dayOfWeek <= 7) {
				$formatted_date = date('d-m-Y', $current_date);
				//echo date('D', $current_date);
				
				
				$getholiday=mysqli_query($this->db,"SELECT * FROM `public_holidays` WHERE `holiday_date`='$formatted_date'");
				if (mysqli_num_rows($getholiday)>0) {
					$fetchholi=mysqli_fetch_assoc($getholiday);
					$tholidays+=1;
					$holidays[]=$fetchholi["holiday_date"];
					$tworkingday+=1;
					$workingdates[]=$formatted_date;
				}else{
					
					$tworkingday+=1;
					$workingdates[]=$formatted_date;
				}
			}else{
				$tweekend+=1;
			}
			if ($dayOfWeek < 6) {
				
			}else{
				$tweekend2+=1;
			}
		
			$getleave = mysqli_query($this->db, "SELECT * FROM `leave_request` WHERE `emp_id`='$empglanceid' AND `start_date`='$formatted_date'");
			if (mysqli_num_rows($getleave) > 0) {
			while ($fetchleavinfo = mysqli_fetch_assoc($getleave)) {
				$leavS = $fetchleavinfo['start_date'];
				$leavE = $fetchleavinfo['end_date'];
				$LeavS_date = strtotime($leavS);
				$LeavE_date = strtotime($leavE);
			while ($LeavS_date <= $LeavE_date) {
				$dayOfWeek = date('N', $LeavS_date);
			if ($dayOfWeek < 6) { // Exclude weekends
				$pre_date = date('d-m-Y', $LeavS_date);
				$getholiday = mysqli_query($this->db, "SELECT * FROM `public_holidays` WHERE `holiday_date`='$pre_date'");
			if (mysqli_num_rows($getholiday) == 0) {
				$getleavdays[] = $pre_date;
				//echo $pre_date . '<br>'; // Debugging: Output the non-holiday date
			}
			}
				$LeavS_date = strtotime('+1 day', $LeavS_date); // Move to next day
			}
			}
			}
			
		$current_date = strtotime('+1 day', $current_date);
		}
		$output='';
		foreach($workingdates  as $gdates){
			
			//echo $gdates.'<br>';
			$dtimesheet = mysqli_query($this->db,"SELECT * FROM `daliy_timesheet` WHERE `employee_id`='$empglanceid' AND `wroking_date`='$gdates' AND `DRH_status`='valid'");
				if (mysqli_num_rows($dtimesheet)>0) {
				$dhours=0;
				$dminutes=0;
				while ($fetchtimesheet=mysqli_fetch_assoc($dtimesheet)) {
					//echo $fetchtimesheet["wroking_date"].'='.$fetchtimesheet["working_hours"].'<br>';
				list($hours, $minutes) = explode(':', $fetchtimesheet["working_hours"]);
				$dhours+=$totalHours = $hours;
				$dminutes+=$totalMinutes = $minutes;
				if ($dminutes>=60) {
					$dhours+=1;
					$dminutes-=60;
				}
				}
			$dattend=mysqli_query($this->db,"SELECT * FROM `attendance` WHERE `dates`='$gdates'");
			$start1=null;
			$end2=null;
			if (mysqli_num_rows($dattend)>0) {
				$thours=0;
				$tminues=0;
				
				while ($fetchdatten=mysqli_fetch_assoc($dattend)) {
					$start1=$fetchdatten['entry_dt'];
					$end2=$fetchdatten['exit_dt'];
					$entry = new DateTime($fetchdatten['entry_dt']);
					$exit = new DateTime($fetchdatten['exit_dt']);
					// Calculate the difference between the two DateTime objects
					$interval = $entry->diff($exit);
					// Extract total minutes and total hours from the difference
					$total_minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
					$total_hours = floor($total_minutes / 60); // Get the whole number of hours
					$remaining_minutes = $total_minutes % 60; // Get the remaining minutes
					$thours+=$total_hours;
					$tminues+=$remaining_minutes;
					// echo "Total Time: $total_hours Hours $remaining_minutes Minutes\n";
				}
				if ($tminues>=60) {
					$thours+=1;
					$tminues-=60;
				}
					$stayoffice =$thours.' Hours '.$tminues.' Minutes';
				}else{
				$stayoffice ='0 Hours 0 Minutes';
			}
			if ($dminutes!=0) {
				$hdi=7-$dhours;
				$mdi=60-$dminutes;
			}else{
				$hdi=8-$dhours;
				$mdi=0-$dminutes;
			}
			
			$Weeknd = date('D', strtotime($gdates));
			if ($Weeknd == 'Sat' || $Weeknd == 'Sun') {
				$background_color = '#ddd';
			} elseif (in_array($gdates, $holidays)) { // Check if it's a holiday
				$background_color = '#401d95';
				$text_color = 'white';
			} else { // Regular weekday
				$background_color = ''; // Default background color
				$text_color = '';
			}
			if (in_array($gdates, $getleavdays)) {
			$output.='<tr style="background: ' . $background_color . '; color: ' . $text_color . ';">
							<td>'.$gdates.'</td>
							<td colspan="7" class="text-center"><strong>Vacation Approved By DRH</strong></td>
			</tr>';
			
			} elseif (in_array($gdates, $holidays)) { // Check if it's a holiday
				$output.= '<tr style="background: ' . $background_color . '; color: ' . $text_color . ';">
							<td>'.$gdates.'</td>
							<td colspan="7" class="text-center"></td>
				</tr>';
			}else{
				$output.= '<tr style="background: ' . $background_color . '; color: ' . $text_color . ';">
							<td>'.$gdates.'</td>
							<td>'.$start1.'</td>
							<td>'.$end2.'</td>
							<td>'.$stayoffice.'</td>
							<td>'.$dhours.' Hours '.$dminutes.' Minutes</td>
							<td>8 Hours 0 Minutes</td>
							<td>'.$hdi.' Hours '.$mdi.' Minutes</td>
							<td></td>
				</tr>';
			}
			
			
				
			}else{
				$Weeknd = date('D', strtotime($gdates));
				if ($Weeknd == 'Sat' || $Weeknd == 'Sun') {
				$background_color = '#ddd';
				} elseif (in_array($gdates, $holidays)) { // Check if it's a holiday
				$background_color = '#401d95';
				$text_color = 'white';
				} else { // Regular weekday
				$background_color = '';
				$text_color = '';
				// Default background color
				}
				if (in_array($gdates,$getleavdays)) {
					$output.= '<tr style="background: ' . $background_color . '; color: ' . $text_color . ';">
							<td>'.$gdates.'</td>
							<td colspan="7" class="text-center"><strong>Vacation Approved By DRH</strong> </td>
					</tr>';
				
				} elseif (in_array($gdates, $holidays)) { // Check if it's a holiday
				$output.= '<tr style="background: ' . $background_color . '; color: ' . $text_color . ';">
							<td>'.$gdates.'</td>
							<td colspan="7" class="text-center"></td>
				</tr>';
			}else{
					$output.= '<tr style="background: ' . $background_color . '; color: ' . $text_color . ';">
							<td>'.$gdates.'</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
					</tr>';
			}
				//$getleav=mysqli_query($this->db,"");
			
				
			}
		}
		return $output;
		// echo 'Total Weekend Day: '.$tweekend2.'<br>';
		// echo 'Total Working Days: '.$tworkingday-$tweekend2.'<br>';
		// echo 'Public holidays: '.$tholidays.'<br>';
		// echo 'Total Vacation: '.count($getleavdays).'<br>';
	}
		


	}

$ataglance=new alaglance($db);
?>