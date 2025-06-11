<?php 

include_once 'db.php';

class leaves{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}

	public function showleavetypes(){
		$sql=mysqli_query($this->db,"SELECT * FROM `leave_type`");
		if (mysqli_num_rows($sql)>0) {
			while ($fetch_leaves=mysqli_fetch_assoc($sql)) {
			    echo '
			    <option value="'.$fetch_leaves["lt_id"].'">'.$fetch_leaves["leave_name"].'</option>

			    ';
			}
		}
	} //End Show Leaves Type

	public function leaverequest($type,$start,$Whenstart,$end,$whenend,$reason,$days,$new_file){
		$sql="INSERT INTO `leave_request`(`emp_id`, `leave_type`, `start_date`, `end_date`, `start_part`, `end_part`, `totaldays`, `leave_reason`, `attached_doc`, `lr_status`,`create_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
		$datetime = date('Y-m-d H:i:s');
		$id=$_SESSION['employeidno'];
		$status="Under Review";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('issssssssss',$id,$type,$start,$end,$Whenstart,$whenend,$days,$reason,$new_file,$status,$datetime);
		if ($stml->execute()) {
			include_once 'email_function.php';
			include_once 'new-leave-request.php';
			return true;
		}else{
			return false;
		}

	} // End LeaveRequest Method

	public function showleaverequest(){
		$id=$_SESSION['employeidno'];
		$sql=mysqli_query($this->db,"SELECT * FROM `leave_request` JOIN  `leave_type` ON `leave_type`.`lt_id`=`leave_request`.`leave_type` WHERE `emp_id`='$id' ORDER BY `leave_request`.`create_date` DESC");
		if (mysqli_num_rows($sql)>0) {
			while($fetch_req=mysqli_fetch_assoc($sql)){
				if ($fetch_req["lr_status"]=="Approved") {
					$action='';
					$status='<span class="alert-success">Approuvé</span>';
					
				}elseif($fetch_req["lr_status"]=="Rejected"){
					$status='<span class="alert-danger">Rejected</span>';
					$action='';
				}else{
					$status='<span class="alert-warning">En cours de révision</span>';
					$action='<a href="edit-leave-req.php?id='.base64_encode($fetch_req["lr_id"]).'" class="btn btn-sm btn-primary">Editer</a>
			<a href="delete-leave-req.php?id='.base64_encode($fetch_req["lr_id"]).'" class="btn btn-sm btn-danger delete-link" data-ltid="'.base64_encode($fetch_req["lr_id"]).'">Supprimer</a>';
				}
				echo '<tr>
		<td>'.$fetch_req["leave_name"].'</td>
		<td>'.$fetch_req["start_date"].'</td>
		<td>'.$fetch_req["end_date"].'</td>
		<td>'.$fetch_req["totaldays"].'</td>
		<td>'.$fetch_req["leave_reason"].'</td>
		<td>'.$fetch_req["commment"].'</td>
		<td>'.$status.'</td>
		<td>'.$action.'</td>
	</tr>

				';
			}
		}
	}// End Showleave Request


	public function getsingleleave($levreq){
		$sql="SELECT * FROM `leave_request` WHERE `lr_id`='$levreq'";
		$query=mysqli_query($this->db,$sql);
		if (mysqli_num_rows($query)>0) {
			return $fetchsingleav=mysqli_fetch_assoc($query);
		}
	} // End signleleave request method

	public function updateleavereq($type, $lrid, $start, $startwhen, $end, $endwhen, $reason, $days) {
    $sql = "UPDATE `leave_request` SET `leave_type`=?, `start_date`=?, `end_date`=?, `start_part`=?, `end_part`=?, `totaldays`=?, `leave_reason`=? WHERE `lr_id`=?";
    $stml = $this->db->prepare($sql);
    $stml->bind_param('sssssssi', $type, $start, $end, $startwhen, $endwhen, $days, $reason, $lrid);
    if ($stml->execute()) {
        return true;
    } else {
        return false;
    }
}


} //End Class


$leaves=new leaves($db);




if (isset($_POST['start']) && isset($_POST['end']) && isset($_POST['ws']) && isset($_POST['we'])) {
    $start = $_POST['start'];
    $end = $_POST['end'];
    $ws = $_POST['ws'];
    $we = $_POST['we'];

    // Define half day based on start and end times
    if ($ws == "Morning") {
        if ($we == "Lunchtime") {
            $halfs = 0.5;
        } elseif ($we == "End Of Day") {
            $halfs = 1;
        }
    } elseif ($ws == "Afternoon") {
        if ($we == "End Of Day") {
            $halfs = 0.5;
        }elseif($we == "Lunchtime") {
            $halfs = -0.5;
        }else{
        	$halfs = 0;
        }
    }

    $start_date = DateTime::createFromFormat('d-m-Y', $start);
    $end_date = DateTime::createFromFormat('d-m-Y', $end);

    // Initialize total days
    $total_days = 0;

    // Iterate through each day in the range
    $current_date = clone $start_date;
    while ($current_date <= $end_date) {
        $current_day = $current_date->format('N'); // 1 for Monday, 7 for Sunday
        
        // Exclude Saturdays, Sundays, and public holidays
        if ($current_day < 6) { // Weekdays
            $holidate = $current_date->format('d-m-Y');
            $getphinfo = mysqli_query($db, "SELECT * FROM `public_holidays` WHERE `holiday_date`='$holidate'");
            if (mysqli_num_rows($getphinfo) == 0) {
                $total_days++;
            }
        }
        // Move to the next day
        $current_date->modify('+1 day');
    }

    // Adjust total days based on half days
    if ($halfs == 0.5 && $total_days==1) {
       echo 0 .' ½'; // Add half day
    }elseif($halfs == 0.5 && $total_days > 1){
    	echo $total_days-1 .' ½';
    }elseif($halfs == 1 && $total_days==1){
    	echo $total_days;
    }elseif($halfs == 0.5 && $total_days>1){
    	echo $total_days-1;
    }elseif($halfs == 1 && $total_days>1){
    	echo $total_days;
    }elseif($halfs == -0.5 && $total_days>1){
    	echo $total_days-1;
    }else{
    	echo $total_days;
    }

    // Output the result
    //echo $total_days$halfs;
}




if (isset($_POST['sendrequest'])) {
	$type=$_POST['type'];
	$start=$_POST['starts'];
	$Whenstart=$_POST['startwhen'];
	$end=$_POST['ends'];
	$whenend=$_POST['endwhen'];
	$reason=$_POST['reason'];
	$days=$_POST['days'];

	if(isset($_FILES['documents']) && !empty($_FILES['documents']['name'])) {
    	$original_name = $_FILES['documents']['name'];
    	$file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
    	$new_file = 'leave_doc/'.uniqid() . '.' . $file_extension;
    	move_uploaded_file($_FILES['documents']['tmp_name'], $new_file);
    // Process the file here
	} else {
   		$new_file="";
	}

	$result=$leaves->leaverequest($type,$start,$Whenstart,$end,$whenend,$reason,$days,$new_file);

if ($result) {
echo '<script>Swal.fire({
title: "Félicitations!",
text: "Votre demande de congé a été envoyée avec succès.",
icon: "success"
}).then(function(){
	window.location.href="apply-for-leave";
});</script>'; 	

}else{
echo '<script>Swal.fire({
title: "Veuillez réessayer !",
text: "Cliquez sur le lien pour envoyer votre demande de congé.",
icon: "error"
}).then(function(){
	window.location.href="apply-for-leave";
});</script>'; 	
}

	
}


if (isset($_POST['updatereq'])) {
	$type=$_POST['type'];
	$lrid=$_POST['lrid'];
	$start=$_POST['starts'];
	$startwhen=$_POST['startwhen'];
	$end=$_POST['ends'];
	$endwhen=$_POST['endwhen'];
	$reason=$_POST['reason'];
	$days=$_POST['totalday'];


	$result=$leaves->updateleavereq($type,$lrid,$start,$startwhen,$end,$endwhen,$reason,$days);
	if ($result) {
		echo '<script>Swal.fire({
title: "Félicitations",
text: "Votre demande de congé a été mise à jour avec succès.",
icon: "success"
}).then(function(){
	window.location.href="apply-for-leave";
});</script>'; 
	}else{
		echo '<script>Swal.fire({
title: "Veuillez réessayer !",
text: "Faild pour mettre à jour votre demande de congé.",
icon: "error"
}).then(function(){
	window.location.href="apply-for-leave";
});</script>'; 	
	}
	
}



 ?>