<?php 

include_once 'db.php';

class payroll{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}

	public function payrollemployee(){
		$query=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `account_status`='active'");
		if (mysqli_num_rows($query)>0) {
			while ($fetch_empolyee=mysqli_fetch_assoc($query)) {
				$emids=$fetch_empolyee["eid"];
				$cumon=date('Y-m');
				$getextra=mysqli_query($this->db,"SELECT * FROM `extra_salary` WHERE `employee_id`='$emids' AND `assgin_month`='$cumon'");
				if (mysqli_num_rows($getextra)>0) {
					$fetch_extrasal=mysqli_fetch_assoc($getextra);
					$status1=$fetch_extrasal["finance-status"];
					if ($fetch_extrasal["finance-status"]=="Yes") {
						$status1="Oui";
					}
					if ($fetch_extrasal["exs_status"]=="Padding") {
						$status2="En attente";
					}else{
						$status2="Oui";
					}

					
				}else{
					$status1="Pas d’action";
					$status2="Pas d’action";
				}

				if ($_SESSION['employee_role']=='FINANCIAL DIRECTOR'|| $_SESSION['employee_role']=='DRH'|| $_SESSION['employee_role']=='CEO') {
					$button='
					<a  href="advance-salary.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="btn btn-icon btn-warning mb-2"><span class="tf-icons bx bx-dollar-circle"></span>
						</a>
						<a  href="print_payroll-slip.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="btn btn-icon btn-primary mb-2"><span class="tf-icons bx bxs-file"></span>
						</a>

					';
				}else{
					$button='<a  href="print_payroll-slip.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="btn btn-icon btn-primary mb-2"><span class="tf-icons bx bxs-file"></span>
						</a>';
				}
			    echo '

			    <tr>
					<td>'.$fetch_empolyee["fname"].' '.$fetch_empolyee["lname"].'</td>
					<td>'.$fetch_empolyee["email"].'</td>
					<td>'.$fetch_empolyee["phone"].'</td>
					<td>'.$fetch_empolyee["job_title"].'</td>
					<td>'.$fetch_empolyee["contract_no"].'</td>
					<td>'.$fetch_empolyee["dob"].'</td>
					<td>'.$status1.'</td>
					<td>'.$status2.'</td>
					
					<td>
						'.$button.'
					</td>
								
				</tr>

			    ';
			}
		}
	} // end payroll employee


	public function payrollemployeeinfo($getpayempid){
		$sql="SELECT * FROM `employees` WHERE `eid`=?";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('i',$getpayempid);
		$stml->execute(); // Execute the prepared statement
    $result = $stml->get_result(); // Get the result set

    // Fetch the data
    if ($result->num_rows > 0) {
        return $row = $result->fetch_assoc();
		}else {
      return null; // Return null if no rows found
    }
	}

	public function payrollslipA($Sdate,$Edate,$getpayempid){
			$getemployeeinfo=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$getpayempid'");
			if (mysqli_num_rows($getemployeeinfo)>0) {
				return $fetch_employee=mysqli_fetch_assoc($getemployeeinfo);
			}

	}// End Payroll Slip A

	public function payrollslipB($Sdate,$Edate,$getpayempid){
			$current_date = strtotime($Sdate);
		$end_timestamp = strtotime($Edate);
		$tweekend=0;
		$tweekend2=0;
		$tworkingday=0;
		$tholidays=0;
		$workingdates=array();
		$holidays=array();
		$getleavdays = array();
		$totaljustabsday=0;
		$totaljustabsday2=0;
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
		
			$getleave = mysqli_query($this->db, "SELECT * FROM `leave_request` WHERE `emp_id`='$getpayempid' AND `start_date`='$formatted_date' AND `lr_status`='Approved'");
			if (mysqli_num_rows($getleave) > 0) {
			while ($fetchleavinfo = mysqli_fetch_assoc($getleave)) {
				$decimalPart = fmod($fetchleavinfo['approval_day'], 1);
				if ($decimalPart==0.5) {
					$halft=0.5;
				}else{
					$halft=0;
				}
				$totaljustabsday2+=$fetchleavinfo['approval_day']+$halft;
				$totaljustabsday+=$fetchleavinfo['approval_day'];
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
		$Tworkrecoard=0;
		$Tworkhours=0;
		$Tworkminut=0;
		foreach($workingdates  as $gdates){
			$newarray = array_merge($holidays, $getleavdays);
			if (in_array($gdates,$newarray)) {
			//echo "Current date is found in the array.";
			}else{
			//echo $gdates.'<br>';
			$dtimesheet = mysqli_query($this->db,"SELECT * FROM `daliy_timesheet` WHERE `employee_id`='$getpayempid' AND `wroking_date`='$gdates' AND `DRH_status`='valid'");
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
					$stayoffice =$thours.' Heures '.$tminues.' Minutes';
				}else{
				$stayoffice ='0 Heures 0 Minutes';
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
		$countleave=$totaljustabsday;
		$withoutweekend=$tworkingday-$tweekend2;
		$withoutpublic=$withoutweekend-$tholidays;
		$dayofnotwork=$withoutpublic-$Tworkrecoard;
		$dayofnotworkwithpubweek=$withoutpublic-$countleave-$Tworkrecoard;
		$dayofnotworkwithpubweek2=$withoutpublic-$Tworkrecoard;
		
		$exp_ho=$withoutweekend*8;
		if ($Tworkminut >= 60) {
    // Calculate overflow hours
    $overflow_hours = intval($Tworkminut / 60);
    
    // Add overflow hours to total hours
    $Tworkhours += $overflow_hours;
    
    // Update remaining minutes
    $Tworkminut %= 60;
}
		$apprvac=$totaljustabsday2*8;
		
		
		$totalhrecod=$Tworkhours;//.'.'.$Tworkminut;
		$totalhrecod1=$Tworkhours.' Heures '.$Tworkminut.' Minutes';
		
		$act_hourswithpubweekwork=$totalhrecod+($tholidays*8)+$apprvac;
		$act_hourswithpubweekwork1=$totalhrecod+($tholidays*8)+$apprvac.' Heures '.$Tworkminut.' Minutes';


		$att_rate=(($act_hourswithpubweekwork*60+$Tworkminut)/($exp_ho*60))*100;
		$hnotwork=$exp_ho-$totalhrecod;
		$exhnotwork=$exp_ho-$act_hourswithpubweekwork;

		if ($Tworkminut > 0) {
			$hnotwork1=$hnotwork-1;
			$exhnotwork1=$exhnotwork-1;
			
			$Tworkminut1=60-$Tworkminut;
			
			$hoursnotwork=$hnotwork1.' Heures '.$Tworkminut1.' Minutes.';
			$exhoursnotwork=$exhnotwork1.' Heures '.$Tworkminut1.' Minutes.';
		}else{
			$hoursnotwork=$hnotwork.' Heures '.$Tworkminut.' Minutes.';
			$exhoursnotwork=$exhnotwork.' Heures '.$Tworkminut.' Minutes.';
		}




	$getinfoemp=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$getpayempid'");
	if (mysqli_num_rows($getinfoemp)) {
		$fetchemp=mysqli_fetch_assoc($getinfoemp);
	}

// Extra Salary Get Query
$conver_moth=date('Y-m',strtotime($Sdate));
$getextrasalary=mysqli_query($this->db,"SELECT * FROM `extra_salary` WHERE `employee_id`='$getpayempid' AND `assgin_month`='$conver_moth' AND `exs_status`='Valid'");
if (mysqli_num_rows($getextrasalary)>0) {
	$fetch_advanceget=mysqli_fetch_assoc($getextrasalary);
	$advancesalary=$fetch_advanceget['advance_salary'];
	$deduction=$fetch_advanceget['deduction_salary'];
	$bonus=$fetch_advanceget['bonus_salary'];
}else{
	$advancesalary=0;
	$deduction=0;
	$bonus=0;
}

// Extra Salary Get Query

$conver_moth2=date('m-Y',strtotime($Sdate));
// Payroll Validation check Query
$checkvalidatoion=mysqli_query($this->db,"SELECT * FROM `approved_monthly_salary` WHERE `employee_id`='$getpayempid' AND `salary_month`='$conver_moth2'");
if (mysqli_num_rows($checkvalidatoion)>0) {
	$fetch_adminvalidation=mysqli_fetch_assoc($checkvalidatoion);
	$drhvalid=$fetch_adminvalidation['drh_id'];
	$ceovalid=$fetch_adminvalidation['ceo_id'];
	$finvalid=$fetch_adminvalidation['finance_id'];
	$trevalid=$fetch_adminvalidation['treasure_id'];

//DHR ====
	$getsignaturesdrh=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$drhvalid'");
	if (mysqli_num_rows($getsignaturesdrh)) {
		$fetch_drhsign=mysqli_fetch_assoc($getsignaturesdrh);
	$getsignnamedrh=$fetch_drhsign['emp_signature'];
	$getnamedrh=$fetch_drhsign['fname'].' '.$fetch_drhsign['lname'];
	}else{
		$getsignnamedrh=null;
		$getnamedrh=null;
	}
	
//DHR ====

//FINACNCE ====
	$getsignaturesfinance=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$finvalid'");
	if (mysqli_num_rows($getsignaturesfinance)) {
		$fetch_financesign=mysqli_fetch_assoc($getsignaturesfinance);
	$getsignnamefinance=$fetch_financesign['emp_signature'];
	$getnamefinance=$fetch_financesign['fname'].' '.$fetch_financesign['lname'];
	}else{
		$getsignnamefinance=null;
		$getnamefinance=null;
	}
	
//FINACNCE ====


//CEO ====
	$getsignaturesceo=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$ceovalid'");
	if (mysqli_num_rows($getsignaturesceo)) {
		$fetch_ceosign=mysqli_fetch_assoc($getsignaturesceo);
	$getsignnameceo=$fetch_ceosign['emp_signature'];
	$getnameceo=$fetch_ceosign['fname'].' '.$fetch_ceosign['lname'];
	}else{
		$getsignnameceo=null;
		$getnameceo=null;
	}
	
//CEO ====

//Treasure ====
	$getsignaturestreasure=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$trevalid'");
	if (mysqli_num_rows($getsignaturestreasure)) {
	$fetch_treasuresign=mysqli_fetch_assoc($getsignaturestreasure);
	$getsignnametreasure=$fetch_treasuresign['emp_signature'];
	$getnametreasure=$fetch_treasuresign['fname'].' '.$fetch_treasuresign['lname'];
	}else{
		$getsignnametreasure=null;
		$getnametreasure=null;
	}
	
//Treasure ====








	$drhvalstat=$fetch_adminvalidation['drh_status'];
	$ceovalstat=$fetch_adminvalidation['ceo_status'];
	$finvalstat=$fetch_adminvalidation['finance_status'];
	$trevalstat=$fetch_adminvalidation['treasure_status'];



}else{
$drhvalstat="Select Status";
$ceovalstat="";
$finvalstat="";
$trevalstat="";
$getsignnamedrh='';
$getnamedrh='';
$getsignnamefinance='';
$getnamefinance='';
$getsignnameceo='';
$getnameceo='';
$getsignnametreasure='';
$getnametreasure='';

}
// Payroll Validation check Query

if ($_SESSION['employee_role']=='DRH') {
       if ($drhvalstat=="Approved") {
       	$madestatus='<option value="Approved">Approuver</option>
            <option value="Rejected">Rejeter</option>';
       }elseif($drhvalstat=="Rejected"){
       	$madestatus='<option value="Rejected">Rejeter</option>
       	<option value="Approved">Approuver</option>';
       }else{
       	$madestatus='<option selected>Select Status</option>
            <option value="Approved">Approuver</option>
            <option value="Rejected">Rejeter</option>';
       }

       $getvalstus='<select name="status" class="form-select-sm col-md-4" id="">
           '.$madestatus.'
          </select>
          <input type="submit" name="has-validation" class="btn btn-primary btn-sm">';


}elseif($_SESSION['employee_role']=='CEO'){
			if ($ceovalstat=="Approved") {
       	$madestatus='<option value="Approved">Approuver</option>
            <option value="Rejected">Rejeter</option>';
       }elseif($ceovalstat=="Rejected"){
       	$madestatus='<option value="Rejected">Rejeter</option>
       	<option value="Approved">Approved</option>';
       }else{
       	$madestatus='<option selected>Select Status</option>
            <option value="Approved">Approuver</option>
            <option value="Rejected">Rejeter</option>';
       }

     $getvalstus='<select name="status" class="form-select-sm col-md-4" id="">
           '.$madestatus.'
          </select>
          <input type="submit" name="has-validation" class="btn btn-primary btn-sm">';  
}elseif($_SESSION['employee_role']=='FINANCIAL DIRECTOR'){
			if ($finvalstat=="Approved") {
       	$madestatus='<option value="Approved">Approuver</option>
            <option value="Rejected">Rejeter</option>';
       }elseif($finvalstat=="Rejected"){
       	$madestatus='<option value="Rejected">Rejeter</option>
       	<option value="Approved">Approuver</option>';
       }else{
       	$madestatus='<option selected>Select Status</option>
            <option value="Approved">Approuver</option>
            <option value="Rejected">Rejeter</option>';
       }

      $getvalstus='<select name="status" class="form-select-sm col-md-4" id="">
           '.$madestatus.'
          </select>
          <input type="submit" name="has-validation" class="btn btn-primary btn-sm">'; 
}elseif($_SESSION['employee_role']=='Treasurer'){

	$getvalstus='';
}











//Salary Based counting=====================
if (!empty($fetchemp["monthly_salary"])) {

$join_date = new DateTime($fetchemp["contract_start"]);
$exit_date = new DateTime($fetchemp["contract_end"]);

// Initialize start and end dates for iteration
$thecurrent_date = clone $join_date;
$theend_date = clone $exit_date;
$thisyearmnth=0;
// Loop through each month and print
while ($thecurrent_date <= $theend_date) {
  if ($thecurrent_date->format('Y')==date('Y')) {
    $thisyearmnth+=1;
  }
    
    $thecurrent_date->modify('+1 month'); // Move to the next month
}


	$monthsalary=$fetchemp["monthly_salary"];
	$yearsalary=$monthsalary*$thisyearmnth;
	$expyearsalary=$monthsalary*12;
}else{
	$monthsalary=0;
	$yearsalary=0;
}
$recive_salary=$fetchemp["receive_balance"];
$unpaidsalary=$yearsalary-$recive_salary;
$pitax=$monthsalary*0.03;

$Basttendsalary=($act_hourswithpubweekwork/$exp_ho)*$monthsalary;
$notworksalary=$monthsalary-$Basttendsalary;


$netsalary=$Basttendsalary-$advancesalary-$deduction+$bonus-$pitax;
//Salary Based counting=====================

//URL TREAM FOR IMG
$url=($_SERVER['SERVER_PORT']==80? 'http://':'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/';
$pos = strpos($url, 'print_payroll-slip.php');
$pos2 = strpos($url, 'doc-payroll.php');

if ($pos !== false) {
    // Remove everything after "print_payroll-slip2.php" including it
    $baseUrl = substr($url, 0, $pos);

    // Ensure the base URL ends with a slash
    $baseUrl = rtrim($baseUrl, '/') . '/';

   // echo $baseUrl; // Outputs: http://localhost/2024/cms/administrator/
} elseif($pos2!== false) {
	$baseUrl = substr($url, 0, $pos);
  $baseUrl = rtrim($baseUrl, '/') . '/';
}else{
	$baseUrl="";
}
//URL TREAM FOR IMG




if($drhvalstat=="Rejected") {
$signdhr='Rejected By';	
}elseif($drhvalstat=="Approved"){
$signdhr='<img src="'.$baseUrl.$getsignnamedrh.'" width="100"  alt="">';
}else{
$signdhr='';	
}

if($ceovalstat=="Rejected") {
$signceo='Rejected By';	
}elseif($ceovalstat=="Approved"){
$signceo='<img src="'.$baseUrl.$getsignnameceo.'" width="100"  alt="">';
}else{
$signceo='';	
}

if($finvalstat=="Rejected") {
$signfin='Rejected By';	
}elseif($finvalstat=="Approved"){
$signfin='<img src="'.$baseUrl.$getsignnamefinance.'" width="100"  alt="">';
}else{
$signfin='';	
}


if($trevalstat=="Rejected") {
$signtre='Rejected By';	
}elseif($trevalstat=="Approved"){
$signtre='<img src="'.$baseUrl.$getsignnametreasure.'" width="100"  alt="">';
}else{
$signtre='';	
}








 $output=' <div class="row">
          <div class="col-md-6">
            <h4 class="card-title" style="text-align: left;">B. Informations sur la masse salariale</h4>
            <table class="table">
              <tbody>
                <tr>
                  <td>Salaire annuel :</td>
                  <td>'.$expyearsalary.'$</td>
                  
                </tr>
                 <tr>
                  <td>Salaire annuel prévu :</td>
                  <td>'.$yearsalary.'$</td>
                  
                </tr>
                <tr>
                  <td>Part du salaire annuel perçu :</td>
                  <td>'.$recive_salary.' $</td>
                  
                </tr>
                <tr>
                  <td>Part du salaire annuel non payé :</td>
                  <td>'.$unpaidsalary.' $</td>
                  
                </tr>
                <tr>
                  <td>Salaire mensuel :</td>
                  <td>'.$monthsalary.'$</td>
                  
                </tr>
                
              </tbody>
            </table>
            <h4 class="card-title" style="text-align: left;">D. Calcul de la rémunération</h4>
            <strong>Rémunération à payer :</strong>
            <table class="table">
              <tbody>
                <tr>
                  <td>Salaire mensuel brut :</td>
                  <td>'.$monthsalary.' $</td>
                  
                </tr>
                <tr>
                  <td>Salaire mensuel brut basé sur la présence :</td>
                  <td>'.number_format($Basttendsalary,2).' $</td>
                  
                </tr>
                <tr>
                  <td>Déduction pour les absences :</td>
                  <td>'.number_format($notworksalary,2).' $</td>
                  
                </tr>
                <tr>
                  <td>Avance salariale :</td>
                  <td>'.$advancesalary.' $</td>
                  
                </tr>
                <tr>
                  <td>Déduction salariale :</td>
                  <td>'.$deduction.' $</td>
                  
                </tr>
                <tr>
                  <td>Bonus ou tout autre avantage :</td>
                  <td>'.$bonus.' $</td>
                  
                </tr>
                <tr>
                  <td>Impôt sur le revenu :</td>
                  <td>'.$pitax.' $</td>
                  
                </tr>
                <tr>
                  <td>Salaire mensuel net :</td>
                  <td>'.number_format($netsalary,2).' $</td>
                  
                </tr>
                
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <h4 class="card-title " style="text-align: left;">C. Présence du mois</h4>
            
            <table class="table">
              <tbody>
                <tr>
                  <td>Jours ouvrables (fériés inclus) :</td>
                  <td>'.$withoutweekend.' Jours</td>
                </tr>
                
                <tr>
                  <td>Jours ouvrables (fériés exclus) :</td>
                  <td>'.$withoutpublic.' Jours</td>
                </tr>
                <tr>
                  <td>Jours travaillés :</td>
                  <td>'.$Tworkrecoard.' Jours</td>
                </tr>
                <tr>
                  <td>Heures de travail prévu, y compris les jours fériés :</td>
                  <td>'.$exp_ho.' Heures</td>
                </tr>
                <tr>
                  <td>Heures effectives, y compris les jours fériés et les jours de congé :</td> 
                  <td> '.$act_hourswithpubweekwork1.'</td>
                </tr>
                <tr>
                  <td>Heures effectives (fériés et congés exclus) :</td>
                  <td>'.$totalhrecod1.'</td>
                </tr>
                 
                <tr>
                  <td>Jours non travaillés (y compris les jours congé) :</td>
                   <td>'.$dayofnotworkwithpubweek2.' Jours</td>
                </tr>
                <tr>
                  <td>Jours non travaillés (fériés et congés exclus) :</td>
                   <td>'.$dayofnotworkwithpubweek.' Jours</td>
                </tr>
                <tr>
                  <td>Heures non travaillées (fériés exclus) :</td> 
                  <td>'.$hoursnotwork.'</td>
                </tr>
                <tr>
                  <td>Heures non travaillées (fériés inclus) :</td> 
                  <td>'.$exhoursnotwork.'</td>
                </tr>
                 
                <tr>
                  <td>Taux de présence :</td>
                  <td>'.number_format($att_rate, 2).'%</td>
                </tr>
                <tr>
                  <td>Jours de congé utilisés :</td>
                  <td>'.$totaljustabsday.' Jours</td>
                </tr>
                <tr>
                  <td>Jours fériés observés :</td>
                  <td>'.$tholidays.' Jours</td>
                </tr>
                <tr>
                  <td>Jours de congé annuel restants :</td>
                  <td>'.$fetchemp["total_holiday"]-$fetchemp["spend_holiday"].' Jours</td>
                </tr>
                
                
              </tbody>
            </table>
          </div>
           </div>
        <div class="row mt-3">
          <div class="col-md-6">
            <h4 class="card-title" style="text-align: left;">Moyen de paiement</h4>
            <table class="table">
              <tbody>
                <tr>
                  <td>Chèque :</td>
                  <td>'.number_format($netsalary,2).' $</td>
                  
                </tr>
                <tr>
                  <td>Virement bancaire :</td>
                  <td>0,00$</td>
                  
                </tr>
                <tr>
                  <td>Banque :</td>
                  <td>EQUITY</td>
                  
                </tr>
                <tr>
                  <td>Numéro de compte :</td>
                  <td>23485493E49</td>
                  
                </tr>
                
              </tbody>
            </table>
            <h4>Montant net à payer : '.number_format($netsalary,2).' $</h4>
          </div>
          
        </div>
        <div class="row mt-3">
          <div class="col">
            <table class="table text-center border-0">
              
              <tbody>
                 <tr>
                  <td>Éditée par</td>
                  <td>Ajusté par</td>
                  <td>Approuvé par</td>
                  <td>Autorisé par</td>
                </tr>
                <tr>
                  <td>'.$signdhr.'</td>
                  <td>'.$signfin.'</td>
                  <td>'.$signceo.'</td>
                  <td>'.$signtre.'</td>
                 
                  
                </tr>
                 <tr>
                  <td>'.$getnamedrh.'</td>
                  <td>'.$getnamefinance.'</td>
                  <td>'.$getnameceo.'</td>
                  <td>'.$getnametreasure.'</td>
                 
                </tr>
                <tr>
                  <td>DRH</td>
                  <td>DIRECTOR OF FINANCE</td>
                  <td>CEO</td>
                  <td>TREASURER</td>
                  
                </tr>
                
              </tbody>
            </table>
          </div>
          
        </div>




        <div class="card text-center noprint">
      <div class="card-body">
        <form method="post">
        <input type="hidden" name="getemployeeid" value="'.$getpayempid.'" hidden>
        <input type="hidden" name="month" value="'.date("m-Y",strtotime($Sdate)).'" hidden>
        <input type="hidden" name="msalary" value="'.$monthsalary.'" hidden>
        <input type="hidden" name="attsalary" value="'.number_format($Basttendsalary,2).'" hidden>
        <input type="hidden" name="notworksalary" value="'.number_format($notworksalary,2).'" hidden>
        <input type="hidden" name="adsalary" value="'.$advancesalary.'" hidden>
        <input type="hidden" name="desalary" value="'.$deduction.'" hidden>
        <input type="hidden" name="bosalary" value="'.$bonus.'" hidden>
        <input type="hidden" name="tax" value="'.$pitax.'" hidden>
        <input type="hidden" name="netsalary" value="'.number_format($netsalary,2).'" hidden>
           '.$getvalstus.'
        </form>
      </div>
      
    </div>


		';
return $output;

	}// End Payroll Slip B



	public function valided_salary($getemployeeid,$month,$msalary,$attsalary,$notworksalary,$adsalary,$desalary,$bosalary,$tax,$netsalary,$status){

		$sql=mysqli_query($this->db,"SELECT * FROM `approved_monthly_salary` WHERE `employee_id`='$getemployeeid' AND `salary_month`='$month'");
		if (mysqli_num_rows($sql)>0) {
				if ($_SESSION['employee_role']=='DRH') {
					$drhido=$_SESSION['employeidno'];
				      $query=mysqli_query($this->db,"UPDATE `approved_monthly_salary` SET `attendance_sal`='$attsalary',`notwork_sal`='$notworksalary',`ad_salary`='$adsalary',`de_salary`='$desalary',`bon_salary`='$bosalary',`net_salary`='$netsalary',`drh_id`='$drhido', `drh_status`='$status',`ams_status`='Pandding' WHERE `employee_id`='$getemployeeid' AND `salary_month`='$month'");
				}elseif($_SESSION['employee_role']=='CEO'){
					$CEO=$_SESSION['employeidno'];
					$query=mysqli_query($this->db,"UPDATE `approved_monthly_salary` SET `ceo_id`='$CEO',`ceo_status`='$status' WHERE `employee_id`='$getemployeeid' AND `salary_month`='$month'");
				}elseif($_SESSION['employee_role']=='Treasurer'){
					$Treasurer=$_SESSION['employeidno'];
					
					$query=mysqli_query($this->db,"UPDATE `approved_monthly_salary` SET `treasure_id`='$Treasurer',`treasure_status`='$status' WHERE `employee_id`='$getemployeeid' AND `salary_month`='$month'");
							
				}elseif($_SESSION['employee_role']=='FINANCIAL DIRECTOR'){
					$finance=$_SESSION['employeidno'];
					$query=mysqli_query($this->db,"UPDATE `approved_monthly_salary` SET `finance_id`='$finance',`finance_status`='$status' WHERE `employee_id`='$getemployeeid' AND `salary_month`='$month'");
				}

				if ($query) {
					return true;
				}else{
					return false;
				}
				

		}else{
			
				if ($_SESSION['employee_role']=='DRH') {
		             $idnm='`drh_id`';
		             $statusnm='`drh_status`';
		    }elseif($_SESSION['employee_role']=='CEO'){
		    				$idnm='`ceo_id`';
		             $statusnm='`ceo_status`';
				}elseif($_SESSION['employee_role']=='Treasurer'){
								$idnm='`treasure_id`';
		             $statusnm='`treasure_status`';
				}elseif($_SESSION['employee_role']=='FINANCIAL DIRECTOR'){
								$idnm='`finance_id`';
		             $statusnm='`finance_status`';
				}

			$query="INSERT INTO `approved_monthly_salary`(`employee_id`, `salary_month`, `attendance_sal`, `notwork_sal`, `ad_salary`, `de_salary`, `bon_salary`, `tax`, `net_salary`, $idnm, $statusnm,`create_datetime`,`ams_status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$stml=$this->db->prepare($query);
			$DRH=$_SESSION['employeidno'];
			$today=date('d-m-Y h:i:s');
			$sttkd='Pandding';
			$stml->bind_param('issssssssisss',$getemployeeid,$month,$attsalary,$notworksalary,$adsalary,$desalary,$bosalary,$tax,$netsalary,$DRH,$status,$today,$sttkd);
			
			if ($stml->execute()) {
				return true;
			}else{
				return false;
			}
		}

	}





}


$payrolls=new payroll($db);



if (isset($_POST['has-validation'])) {
	$getemployeeid=$_POST['getemployeeid'];
	$month=$_POST['month'];
	$msalary=$_POST['msalary'];
	$attsalary=$_POST['attsalary'];
	$notworksalary=$_POST['notworksalary'];
	$adsalary=$_POST['adsalary'];
	$desalary=$_POST['desalary'];
	$bosalary=$_POST['bosalary'];
	$tax=$_POST['tax'];
	$netsalary=$_POST['netsalary'];
	$status=$_POST['status'];




	$result=$payrolls->valided_salary($getemployeeid,$month,$msalary,$attsalary,$notworksalary,$adsalary,$desalary,$bosalary,$tax,$netsalary,$status);

	if ($result) {
		echo '<script>Swal.fire({
		title: "Félicitations",
		text: "Mise à jour réussie du statut de la fiche de paie.",
		icon: "success"
		}).then(function(){
		window.location.href="generate_payroll"
		});</script>';
	}else{
		echo '<script>Swal.fire({
		title: "Veuillez réessayer",
		text: "Faild To Update Status Payroll Slip.",
		icon: "error"
		}).then(function(){
		window.location.href="generate_payroll"
		});</script>';
	}
}



 ?>