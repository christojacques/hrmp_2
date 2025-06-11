<?php 

include_once 'db.php';


class advance{
	private $db;
	public function __construct($db){
		$this->db=$db;

	}


	public function showemployees(){
		$sql=mysqli_query($this->db,"SELECT * FROM `employees`");
		if (mysqli_num_rows($sql)>0) {
			while($fetch_emp=mysqli_fetch_assoc($sql)){
				echo '<option value="'.$fetch_emp["eid"].'">'.$fetch_emp["fname"].' '.$fetch_emp["lname"].'</option>';
			}
		}
	}

	public function addadvance($month,$asamount,$dsamount,$bsamount,$drhid,$empid){
		$sql="INSERT INTO `extra_salary`(`employee_id`, `assgin_month`, `advance_salary`, `deduction_salary`, `bonus_salary`,`finance-status`, `exs_status`, `created_by`) VALUES (?,?,?,?,?,?,?,?)";
		$status1="Yes";
		$status2="Padding";
		$today=date('d-m-Y h:i:s');
		$stml=$this->db->prepare($sql);
		$stml->bind_param('issssssi',$empid,$month,$asamount,$dsamount,$bsamount,$status1,$status2,$drhid);

		if ($stml->execute()) {
			return true;
		}else{
			return false;
		}
	}


	public function showadvance($empassid){
	   $sql = mysqli_query($this->db, "SELECT * FROM `extra_salary` JOIN `employees` ON `extra_salary`.`employee_id` = `employees`.`eid` WHERE `employee_id` = '$empassid'");

	    if (mysqli_num_rows($sql)>0) {
	    	while ($fetch_advance=mysqli_fetch_assoc($sql)) {
	    		
	    		if ($_SESSION['employee_role']=='DRH') {
	    			if ($fetch_advance['exs_status']=="Padding") {
	    				$exstatusf="En attente";
	    				$exstatusb="Padding";
	    			}elseif($fetch_advance['exs_status']=="Valid"){
	    				$exstatusf="Oui";
	    				$exstatusb="Valid";
	    			}
	    			$dhr='<select name="drhstatus" id="drhstatus" class="form-control-sm">
                            	<option value="'.$exstatusb.'">'.$exstatusf.'</option>
	    						<option value="Valid">Oui</option>
	    						<option value="Padding">En attente</option>
                            	
                            	
                            </select>';
	    		}else{
	    			$dhr="En attente";//$fetch_advance['exs_status'];
	    		}

	    		if ($fetch_advance['finance-status']=="Yes") {
	    			$fsta="Oui";
	    		}

	    		
	    	    echo ' <tr data-exs-id="'.$fetch_advance["exs_id"].'">
                            <td>'.$fetch_advance['fname'].' '.$fetch_advance['lname'].'</td>
                            <td>'.date("M-Y", strtotime($fetch_advance["assgin_month"])).'</td>
                            <td>'.$fetch_advance['advance_salary'].'</td>
                            <td>'.$fetch_advance['deduction_salary'].'</td>
                            <td>'.$fetch_advance['bonus_salary'].'</td>
                            <td>'.$fsta.'</td>

                            <td class="text-center">'.$dhr.'</td>

                            <td>
                                <a href="delete-advance-salary.php?id='.base64_encode($fetch_advance['exs_id']).'&emi='.base64_encode($fetch_advance['eid']).'" class="btn btn-danger btn-sm delete-link" data-asid="'.base64_encode($fetch_advance['exs_id']).'&emi='.base64_encode($fetch_advance['eid']).'">Supprimer</a>
                            </td>
                        </tr>';
	    	}
	    }

	}


	public function updatestatus($id,$status){
		$sql="UPDATE `extra_salary` SET `exs_status`=? WHERE `exs_id`=?";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('si',$status,$id);
		$stml->execute();
	}
}


$advance=new advance($db);


if (isset($_POST['addadvance'])) {
	$month=$_POST['month'];
	$asamount=$_POST['asamount'];
	$dsamount=$_POST['dsamount'];
	$bsamount=$_POST['bsamount'];
	$drhid=$_POST['adminid'];
	$empid=$_POST['empid'];
	$result=$advance->addadvance($month,$asamount,$dsamount,$bsamount,$drhid,$empid);

	if ($result) {
		echo '<script>Swal.fire({
		title: "Félicitations",
		text: "Les ajustements salariaux ont bien été pris en compte.",
		icon: "success"
		});</script>';
	}else{
		echo '<script>Swal.fire({
		title: "Veuillez réessayer",
		text: "salaire anticipé assigné",
		icon: "error"
		});</script>';
	}
}


if (isset($_POST['status']) && isset($_POST['id'])) {
	$id=$_POST['id'];
	$status=$_POST['status'];
	$advance->updatestatus($id,$status);
}