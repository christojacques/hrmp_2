<?php include_once 'db.php';




class payslip{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}

	public function showpayslip($month){
		$rplmn=date('m-Y',strtotime($month));
		$sql=mysqli_query($this->db,"SELECT * FROM `approved_monthly_salary` JOIN `employees` ON `approved_monthly_salary`.`employee_id`=`employees`.`eid` WHERE `salary_month`='$rplmn'");

		if (mysqli_num_rows($sql)>0) {
			while ($fetch_payslip=mysqli_fetch_assoc($sql)) {
				if ($fetch_payslip["ams_status"]=="Performed") {
					$tsta='
						<option value="'.$fetch_payslip["ams_status"].'">'.$fetch_payslip["ams_status"].'</option>
						<option value="Not Performed">Not Performed</option>';

				}elseif($fetch_payslip["ams_status"]=="Not Performed"){
					$tsta='
						<option value="'.$fetch_payslip["ams_status"].'">'.$fetch_payslip["ams_status"].'</option>
						<option value="Performed">Performed</option>
					';
				}else{
					$tsta='
						<option value="Not Performed">Not Performed</option>
						<option value="Performed">Performed</option>
						';
				}
				if ($_SESSION['employee_role']=="Treasurer") {
					$iftrea='<select name="tstatus" id="tstatus" class="form-control">'.$tsta.'</select>';
				}else{
					$iftrea='<select disabled class="form-control">'.$tsta.'</select>';
				}
			    echo '
					<tr  data-ams-id="'.$fetch_payslip["ams_id"].'">
					<td>'.$fetch_payslip["fname"].' '.$fetch_payslip["lname"].'</td>
					<td>'.$fetch_payslip["bank_name"].'</td>
					<td>'.date("M", strtotime("01-" . $fetch_payslip["salary_month"])).'</td>
					<td>'.$fetch_payslip["bank_account"].'</td>
					<td>'.$fetch_payslip["payment_method"].'</td>
					<td>'.$fetch_payslip["ceo_status"].'</td>
					<td class="text-center">'.$iftrea.'</td>
					<td>'.$fetch_payslip["net_salary"].' $ USD</td>
					</tr>

			    ';
			}
		}
	}

	public function updatepayroll($status,$payid){
		session_start();
		$Treasurerid=$_SESSION['employeidno'];

		$sql="UPDATE `approved_monthly_salary` SET `ams_status`=?, `treasure_status`=?,`treasure_id`=? WHERE `ams_id`=?";
		$stml=$this->db->prepare($sql);
		if ($status=="Performed") {
			$sta="Approved";
		}elseif($status=="Not Performed"){
			$sta="Rejected";
			$status="Not Performed";
		}else{
			$sta="Rejected";
		}
		$stml->bind_param('ssii',$status,$sta,$Treasurerid,$payid);
		
			$sql=mysqli_query($this->db,"SELECT * FROM `approved_monthly_salary` WHERE `ams_id`='$payid'");
			$fetch_payslip=mysqli_fetch_assoc($sql);
			$eid=$fetch_payslip['employee_id'];
			$statu3s=$fetch_payslip['ams_status'];
			
			if($fetch_payslip['ams_status']=="Not Performed" && $status=="Performed"){
				$getempl=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$eid'");
				if (mysqli_num_rows($getempl)>0) {
					$fetch_emp=mysqli_fetch_assoc($getempl);
					$monthlysa=$fetch_emp['monthly_salary']+$fetch_emp['receive_balance'];
					$update=mysqli_query($this->db,"UPDATE `employees` SET `receive_balance`='$monthlysa' WHERE `eid`='$eid'");
				}
			}elseif ("Pandding"==$statu3s && $status=="Performed") {
				$getempl=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$eid'");
				if (mysqli_num_rows($getempl)>0) {
					$fetch_emp=mysqli_fetch_assoc($getempl);
					$monthlysa=$fetch_emp['monthly_salary']+$fetch_emp['receive_balance'];
					$update=mysqli_query($this->db,"UPDATE `employees` SET `receive_balance`='$monthlysa' WHERE `eid`='$eid'");
				}
				//echo 'Yes';
			}elseif ("Performed"==$statu3s && $status=="Not Performed") {
				$getempl=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$eid'");
				if (mysqli_num_rows($getempl)>0) {
					$fetch_emp=mysqli_fetch_assoc($getempl);
					$monthlysa=$fetch_emp['monthly_salary']-$fetch_emp['receive_balance'];
					$update=mysqli_query($this->db,"UPDATE `employees` SET `receive_balance`='$monthlysa' WHERE `eid`='$eid'");
				}
				//echo 'Yes';
			}else{
				$update=false;
			}
			
			if ($update) {
				if ($stml->execute()) {
					return true;
				}else{
					return false;
				}
			}

			
			
	}
}

$payslip= new payslip($db);




if (isset($_POST['status']) && isset($_POST['id'])) {
	$status=$_POST['status'];
	$payid=$_POST['id'];

	$payslip->updatepayroll($status,$payid);
}


 ?>