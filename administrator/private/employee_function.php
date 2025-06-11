<?php 

include_once 'protection.php';

class employees{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	public function showemployeerequest(){
		$query=mysqli_query($this->db,"SELECT * FROM `employees`");
		if (mysqli_num_rows($query)>0) {
			while ($fetch_empolyee=mysqli_fetch_assoc($query)) {
				if ($fetch_empolyee["account_status"]=='active') {
				$showstatus='<span class="badge rounded-pill bg-success">VALIDÉ</span';
				}elseif($fetch_empolyee["account_status"]=='inactive'){
					$showstatus='<span class="badge rounded-pill bg-danger">Rejected</span';
				}else{
					$showstatus='<span class="badge rounded-pill bg-warning">En attente</span';
				}
			    echo '

			    <tr>
					<td><input type="checkbox" class="form-check-input singlempcheck" id="singlempcheck" value="'.$fetch_empolyee["eid"].'"></td>
					<td>'.$fetch_empolyee["fname"].' '.$fetch_empolyee["lname"].'</td>
					<td>'.$fetch_empolyee["email"].'</td>
					<td>'.$fetch_empolyee["phone"].'</td>
					<td>'.$fetch_empolyee["job_title"].'</td>
					<td>'.$fetch_empolyee["contract_no"].'</td>
					<td>'.$fetch_empolyee["dob"].'</td>
					<td>'.$showstatus.'</td>
					<td>
						<a  href="view-employee.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="btn btn-icon btn-primary"><span class="tf-icons bx bx-show"></span>
						</a>
						<a  href="delete-employee.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="btn btn-icon btn-danger delete-link" data-eid="'.base64_encode($fetch_empolyee["eid"]).'"><span class="tf-icons bx bx-trash"></span>
						</a>
					</td>
								
				</tr>

			    ';
			}
		}

	}// Show Employee Request Method End Here

	public function employeereport($ts_module,$ma_module,$lm_module){
		$query=mysqli_query($this->db,"SELECT * FROM `employees`");
		if (mysqli_num_rows($query)>0) {
			while ($fetch_empolyee=mysqli_fetch_assoc($query)) {
				if ($ts_module!=0 && $ma_module!=0 && $lm_module!=0) {
					// <a  href="monthly-ataglance.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="dropdown-item">Rapport Complet de Présence</a>
					$button='<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu" style="">
          <a  href="print-timesheet.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="dropdown-item">Feuille de Temps par Projet</a>
         <a  href="monthly-ataglance.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="dropdown-item">Rapport Complet de Présence</a>
          <a  href="print-attendencesheet.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="dropdown-item">Journal d&#39Heures Bureau</a>
                            </div>
                          </div>';
				}elseif ($ts_module!=0 && $ma_module!=0 ) {
					// <a  href="monthly-ataglance.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="dropdown-item">Rapport Complet de Présence</a>
					$button='<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu" style="">
          <a  href="print-timesheet.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="dropdown-item">Feuille de Temps par Projet</a>
          <a  href="print-attendencesheet.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="dropdown-item">Journal d&#39Heures Bureau</a>
                            </div>
                          </div>';
				}elseif($ts_module!=0){
					$button='<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu" style="">
          <a  href="print-timesheet.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="dropdown-item">Feuille de Temps par Projet</a>
           </div>
          </div>';
				}elseif($ma_module!=0){
					$button='<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu" style="">
          <a  href="print-attendencesheet.php?id='.base64_encode($fetch_empolyee["eid"]).'" class="dropdown-item">Journal d&#39Heures Bureau</a>
                            </div>
                          </div>';
				}
				
			    echo '

			    <tr>
					<td>'.$fetch_empolyee["fname"].' '.$fetch_empolyee["lname"].'</td>
					<td>'.$fetch_empolyee["email"].'</td>
					<td>'.$fetch_empolyee["phone"].'</td>
					<td>'.$fetch_empolyee["job_title"].'</td>
					<td>'.$fetch_empolyee["contract_no"].'</td>
					<td>'.$fetch_empolyee["dob"].'</td>
					<td>'.$button.'</td>
								
				</tr>

			    ';
			}
		}

	}// Show Employee Request Method End Here



	public function singleemployee($getid){
		$sql=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$getid'");

		if (mysqli_num_rows($sql)>0) {
			$fetch_empolyeeinfo=mysqli_fetch_assoc($sql);
			return $fetch_empolyeeinfo;
		}else{
			return false;
		}
	}// single Employee Fetch

	public function updateemployee($job,$constart,$conend,$conno,$contype,$dep,$assipro,$unitassi,$backac,$salary,$status,$role,$emid,$validholyday){

		$sql = "UPDATE `employees` SET `job_title`=?, `contract_no`=?, `monthly_salary`=?, `contract_start`=?, `contract_end`=?, `contract_type`=?, `project_assign`=?, `unit_assign`=?, `department`=?, `bank_account`=?, `account_status`=?, `employee_role`=?,`total_holiday`=?, `created_by`=? WHERE `eid`=?";

			include_once 'registration-email-template.php';

			$stml=$this->db->prepare($sql);
			$stml->bind_param('sssssssssssssii',$job,$conno,$salary,$constart,$conend,$contype,$assipro,$unitassi,$dep,$backac,$status,$role,$validholyday,$_SESSION['employeidno'],$emid);
			if ($stml->execute()) {
				return true;
			}else{
				return false;
			}
	}





	public function timesheetreport($start,$end,$getempid){
		$sql="SELECT * FROM `daliy_timesheet` WHERE `employee_id`='$getempid' AND STR_TO_DATE(`wroking_date`, '%d-%m-%Y') BETWEEN STR_TO_DATE('$start', '%d-%m-%Y') AND STR_TO_DATE('$end', '%d-%m-%Y');";
		$query=mysqli_query($this->db,$sql);
		$query2=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$getempid'");
		$fetchemp=mysqli_fetch_assoc($query2);
		$output='<h3 class="text-center"> Date: Du '.$start.' Au '.$end.'</h3>
		<table class="table-bordered table">
			<thead>
				<tr>
					<th> Collaborateurs : '.$fetchemp['fname'].' '.$fetchemp['lname'].'</th>
					<th>Téléphone : '.$fetchemp['phone'].'</th>
					<th>Fonction : '.$fetchemp['job_title'].'</th>
					<th>Numéro ou référence de contrat : '.$fetchemp['contract_no'].'</th>
				</tr>
			</thead>
		</table>
		
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Titre du projet / tâche</th>
              <th>Note du projet / tâche</th>
              <th>Heures travaillées</th>
              <th>Date d’enregistrement des heures travaillées</th>
            </tr>
          </thead>
          <tbody>';
		if (mysqli_num_rows($query)>0) {
			$dhours=0;
			$dminutes=0;
			while ($fetch_worksheet=mysqli_fetch_assoc($query)) {
			    $output.='<tr>
			    <td>'.$fetch_worksheet["project_title"].'</td>
			    <td>'.$fetch_worksheet["project_note"].'</td>
			    <td>'.$fetch_worksheet["working_hours"].'</td>
			    <td>'.$fetch_worksheet["wroking_date"].'</td>

			    </tr>';

				list($hours, $minutes) = explode(':', $fetch_worksheet["working_hours"]);
				$dhours+=$totalHours = $hours;
				$dminutes+=$totalMinutes = $minutes;
				if ($dminutes>=60) {
					$dhours+=1;
					$dminutes-=60;
				}

			}

			$time=$dhours.' Hours '.$dminutes. ' Minutes.';
			$output.='
		<tr>
		<td colspan="2" class="text-center">Total</td>
		<td colspan="">'.$time.'</td>
		<td colspan=""></td>
		</tr>';
		}

		$output.='</tbody>
        </table>';

        return $output;
	}// End Timesheet Report method

	public function attendencesheetreport($start,$end,$getempid){
		$sql="SELECT * FROM `attendance` JOIN `guard` ON `attendance`.`guard_id`= `guard`.`gid` WHERE `employee_id`='$getempid' AND STR_TO_DATE(`dates`, '%d-%m-%Y') BETWEEN STR_TO_DATE('$start', '%d-%m-%Y') AND STR_TO_DATE('$end', '%d-%m-%Y');";
		$query=mysqli_query($this->db,$sql);
		$query2=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$getempid'");
		$fetchemp=mysqli_fetch_assoc($query2);
		$output='<h3 class="text-center">Date: Du '.$start.' Au '.$end.'</h3>
		<table class="table-bordered table">
			<thead>
				<tr>
					<th>Collaborateur : '.$fetchemp['fname'].' '.$fetchemp['lname'].'</th>
					<th>Téléphone : '.$fetchemp['phone'].'</th>
					<th>Fonction: '.$fetchemp['job_title'].'</th>
					<th>Numéro ou référence de contrat : '.$fetchemp['contract_no'].'</th>
				</tr>
			</thead>
		</table>
		
        <table class="table table-bordered">
          <thead>
             <tr>
              <th>Nom du gardien</th>
              <th>Date</th>
              <th>Heure d’entrée</th>
              <th>Heure de sortie</th>
              <th>Heures au bureau (Gardien)</th>
              <th>Statut</th>
              
            </tr>
          </thead>
          <tbody>';
		if (mysqli_num_rows($query)>0) {
			$diffhours=0;
			$diffminutes=0;
			while ($fetch_worksheet=mysqli_fetch_assoc($query)) {

			$datetime1 = new DateTime($fetch_worksheet["entry_dt"]);
			$datetime2 = new DateTime($fetch_worksheet["exit_dt"]);
			$interval = $datetime1->diff($datetime2);
			$diff=$interval->format('%H Hours %i Minutes');
			$diffh=$interval->format('%H');
			$diffm=$interval->format('%i');
			if ($fetch_worksheet["attend_type"]=="Entry") {
				$aatype="Entrée";
			}elseif($fetch_worksheet["attend_type"]=="Exit"){
				$aatype="Sortie";
			}else{
				$aatype="";
			}
			    $output.='<tr>
			    <td>'.$fetch_worksheet["guard_name"].'</td>
			    <td>'.date('d-m-Y',strtotime($fetch_worksheet["dates"])).'</td>
			    <td>'.$fetch_worksheet["entry_dt"].'</td>
			    <td>'.$fetch_worksheet["exit_dt"].'</td>
			    <td>'.$diffh.' Heures '.$diffm.' Minutes.</td>
			    <td>'.$aatype.'</td>

			    </tr>';

				

			}

		}

		$output.='</tbody>
        </table>';

        return $output;
	}// End Attende.-sheet Report method


} // End Employee Class


$employee=new employees($db);


if (isset($_POST['update_employee'])) {
	
	$emid=$_POST['employeeid'];
	$job=$_POST['jobtitle'];
	$constart=$_POST['con_start'];
	$conend=$_POST['con_end'];
	$conno=$_POST['con_no'];
	$contype=$_POST['con_type'];
	$dep=$_POST['department'];
	$assipro=$_POST['pro_assign'];
	$unitassi=$_POST['unit_assign'];
	$backac=$_POST['bank_ac'];
	$salary=$_POST['annual'];
	$status=$_POST['status'];
	$role=$_POST['employe_role'];
	$mypassword=$_POST['mypassword'];
	$validholyday=$_POST['holiday'];
	

	if (password_verify($_POST['mypassword'],$fetch_employee['password'])) {

		$result=$employee->updateemployee($job,$constart,$conend,$conno,$contype,$dep,$assipro,$unitassi,$backac,$salary,$status,$role,$emid,$validholyday);

	if ($result) {
		echo '<script>Swal.fire({
		title: "Félicitations !",
		text: "Mise à jour réussie de ce profil d employé.",
		icon: "success"
		});</script>';
	}else{
		echo '<script>Swal.fire({
		title: "Veuillez réessayer !",
		text: "Faild To Updated This Employee Profile (en anglais).",
		icon: "error"
		});</script>';
	}
	}else{
		echo '<script>Swal.fire({
		title: "Pas de correspondance !",
		text: "Veuillez saisir votre mot de passe correct.",
		icon: "question"
		});</script>';
	}


	
}







 ?>

