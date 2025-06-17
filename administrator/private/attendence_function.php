<?php 

include_once 'db.php';

class attendence{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}

	public function showattendence($date){
        $date=date('Y-m-d',strtotime($date));
		$sql=mysqli_query($this->db,"SELECT fname,lname,job_title,dob,dates,attend_type,entry_dt,exit_dt,atten_id FROM `attendance` JOIN `employees` ON  `employees`.`eid`= `attendance`.`employee_id` WHERE `dates`='$date'");
		if (mysqli_num_rows($sql)>0) {
			while ($fetch_atten=mysqli_fetch_assoc($sql)) {

				if ($fetch_atten["attend_type"]=="Entry") {
					$status='<span class="alert-success">Présent</span>';
				}elseif($fetch_atten["attend_type"]=="Exit"){
					$status='<span class="alert-danger">Absent</span>';
				}
				if (empty($fetch_atten["exit_dt"])) {
					$exitime="";
				}else{
					$exitime=date('d-m-Y H:i:s',strtotime($fetch_atten["exit_dt"]));
				}
			    echo '

			    <tr>
			    	<td>'.$fetch_atten["fname"].' '.$fetch_atten["lname"].'</td>
			    	<td>'.date('d-m-Y',strtotime($fetch_atten["dob"])).'</td>
			    	<td>'.$fetch_atten["job_title"].'</td>
			    	<td>'.date('d-m-Y H:i:s',strtotime($fetch_atten["entry_dt"])).'</td>
			    	<td>'.$exitime.'</td>
			    	<td>'.$status.'</td>
			    	<td> <button data-bs-toggle="modal" data-bs-target="#attendenceinfo" class="btn btn-icon btn-primary attendenceinfo" data-attid="'.$fetch_atten["atten_id"].'"><span class="tf-icons bx bx-show"></span></button></td>
			    </tr>

			    ';
			}
		}
	}


	public function showattendemployee($sdate, $edate = null) {
    $query = "SELECT fname, lname, job_title, dob, dates, attend_type, entry_dt, exit_dt, atten_id 
              FROM `attendance` 
              JOIN `employees` ON `employees`.`eid` = `attendance`.`employee_id` 
              WHERE `employees`.`account_status` = 'active'";

    if ($edate != null) {
        $query .= " AND `dates` BETWEEN ? AND ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $sdate, $edate);
    } else {
        $query .= " AND `dates` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $sdate);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($fetch_atten = $result->fetch_assoc()) {
            $status = ($fetch_atten["attend_type"] == "Entry") 
                        ? '<span class="alert-success">Présent</span>' 
                        : '<span class="alert-danger">Absent</span>';

            $exitime = (!empty($fetch_atten["exit_dt"])) 
                        ? date('d-m-Y H:i:s', strtotime($fetch_atten["exit_dt"])) 
                        : "";

            echo '
            <tr>
                <td><input type="checkbox" class="form-check indattend" name="indattend" value="'.$fetch_atten["atten_id"].'">
                </td>
                <td>' . htmlspecialchars($fetch_atten["fname"] . ' ' . $fetch_atten["lname"]) . '</td>
                <td>' . date('d-m-Y', strtotime($fetch_atten["dob"])) . '</td>
                <td>' . htmlspecialchars($fetch_atten["job_title"]) . '</td>
                <td>' . date('d-m-Y H:i:s', strtotime($fetch_atten["entry_dt"])) . '</td>
                <td>' . $exitime . '</td>
                <td>' . $status . '</td>
                <td>
                    <button data-bs-toggle="modal" data-bs-target="#attendenceinfo" 
                            class="btn btn-icon btn-primary attendenceinfo" 
                            data-attid="' . $fetch_atten["atten_id"] . '">
                        <span class="tf-icons bx bx-show"></span>
                    </button>
                </td>
            </tr>';
        }
    } else {
        echo '<tr><td colspan="8" class="text-center">No attendance records found.</td></tr>';
    }
   
}

}

$attendence=new attendence($db);

 ?>

