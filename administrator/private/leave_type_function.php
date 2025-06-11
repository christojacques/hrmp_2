<?php
include_once 'db.php';
class leavetypes{
	private $db;
	public function __construct($db){
		$this->db=$db;
	}
	public function addtypes($type,$cnt){
		$sql="INSERT INTO `leave_type`(`leave_name`,`leave-type`) VALUES (?,?)";
	$stml=$this->db->prepare($sql);
	$stml->bind_param('ss',$type,$cnt);
	if ($stml->execute()) {
		return true;
	}else{
		return false;
	}
	}//End Addtype Method
	public function updatetypes($type,$id,$cnt){
		$sql="UPDATE `leave_type` SET `leave_name`=?, `leave-type`=? WHERE `lt_id`=?";
	$stml=$this->db->prepare($sql);
	$stml->bind_param('ssi',$type,$cnt,$id);
	if ($stml->execute()) {
		return true;
	}else{
		return false;
	}
	}//End Addtype Method
	public function showtypes(){
		$sql=mysqli_query($this->db,"SELECT * FROM `leave_type`");
		if (mysqli_num_rows($sql)>0) {
			$output="";
			while ($fetch_type=mysqli_fetch_assoc($sql)) {
				if (strtoupper($fetch_type["leave-type"])=="COUNTABLE") {
					$type="Jours déductibles";
				}elseif (strtoupper($fetch_type["leave-type"])=="NON_COUNTABLE") {
					$type="Jours non déductibles";
				}else{
					$type="";
				}
			$output.=' <tr>
	<td>'.$fetch_type["leave_name"].'</td>
	<td>'.$type.'</td>
	<td>
		<a type="button" data-edit="'.$fetch_type["lt_id"].'" data-bs-toggle="modal" data-bs-target="#edittype"  class="btn btn-sm btn-primary text-white" id="edit-type">Modifier</a>
		<a href="delete-leave-type.php?id='.base64_encode($fetch_type["lt_id"]).'" class="btn btn-danger btn-sm delete-link" data-ltid="'.base64_encode($fetch_type["lt_id"]).'">Supprimer</a>
	</td>
	
</tr>';
			}
			return $output;
		}
	}

	public function showleaverequest(){
	
		$sql = mysqli_query($this->db, "
    SELECT * 
    FROM `leave_request` 
    JOIN `employees` ON `leave_request`.`emp_id` = `employees`.`eid` 
    JOIN `leave_type` ON `leave_request`.`leave_type` = `leave_type`.`lt_id`
    ORDER BY `leave_request`.`create_date` DESC");
		if (mysqli_num_rows($sql)>0) {
			while ($fetch_leavereq=mysqli_fetch_assoc($sql)) {
			    if ($fetch_leavereq['lr_status']=="Under Review") {
			    	$status='<span class="alert-warning">En cours de révision</span>';
			    }elseif($fetch_leavereq['lr_status']=="Approved"){
			    	$status='<span class="alert-success">Approuvé</span>';
			    }elseif($fetch_leavereq['lr_status']=="Rejected"){
			    	$status='<span class="alert-danger">Rejected</span>';
			    }else{
			    	$status="";
			    }
			    if (!empty($fetch_leavereq['attached_doc'])) {
			    	$doc='<a href="../employee/'.$fetch_leavereq["attached_doc"].'"target="__blank">Click</a>';
			    }else{
			    	$doc="";
			    }

			    echo '<tr>			<td style="display: none;">'.$fetch_leavereq['create_date'].'></td>
                          <td>'.$fetch_leavereq['fname'].' '.$fetch_leavereq['lname'].'</td>
                          <td>'.$fetch_leavereq['leave_name'].'</td>
                          <td>'.$fetch_leavereq['start_date'].'</td>
                          <td>'.$fetch_leavereq['end_date'].'</td>
                          <td>'.$fetch_leavereq['totaldays'].'</td>
                          <td>'.$fetch_leavereq['leave_reason'].'</td>
                          <td>'.$doc.'</td>
                          <td>'.$status.'</td>
                          <td>
                            <a href="view-leave-request.php?id='.base64_encode($fetch_leavereq['lr_id']).'" class="btn btn-primary btn-sm">Voir</a>
                           
                          </td>
                        </tr>';
// <a href="delete-leave-request.php?id='.base64_encode($fetch_leavereq['lr_id']).'" class="btn btn-danger btn-sm">Delete</a>

			}
		}
	} //showleaverequest Method End

	public function getrequestdetails($lrid){
		$sql=mysqli_query($this->db,"SELECT * FROM `leave_request` JOIN  `employees` ON `leave_request`.`emp_id`=`employees`.`eid` JOIN `leave_type` ON `leave_request`.`leave_type`=`leave_type`.`lt_id` WHERE `lr_id`='$lrid'");
		if (mysqli_num_rows($sql)>0) {
			$fetch_leavereq=mysqli_fetch_assoc($sql);
			    if ($fetch_leavereq['lr_status']=="Under Review") {
			    	$status='<option selected>Sélectionnez le statut de congé</option>
                       <option value="Approved">Approuver</option>
                       <option value="Rejected">Rejeter</option>';
			    }elseif($fetch_leavereq['lr_status']=="Approved"){
			    	$status='<option value="Approved">Approuver</option>
                       <option value="Rejected">Rejeter</option>';
			    }elseif($fetch_leavereq['lr_status']=="Rejected"){
			    	$status='<option value="Rejected">Rejeter</option>
			    	<option value="Approved">Approuver</option>';
			    }else{
			    	$status='<option selected>Sélectionnez le statut de congé</option>
                       <option value="Approved">Approuver</option>
                       <option value="Rejected">Rejeter</option>';
			    }
			    if (!empty($fetch_leavereq['attached_doc'])) {
			    	$doc='../employee/'.$fetch_leavereq['attached_doc'];
			    }else{
			    	$doc="#";
			    }

			    if($fetch_leavereq['leave-type']=="countable"){
			    	$leavetyp="Jours déductibles";;
			    }else{
			    	$leavetyp="Jours non déductibles";
			    }

			    if ($fetch_leavereq["start_part"]=="Morning") {
			    	$spart="Matin";
			    }else{
			    	$spart="Après-midi";
			    }

			    if($fetch_leavereq["end_part"]=="Lunchtime"){
			    	$epart="Heure du déjeuner";
			    }else{
			    	$epart="Fin de journée";
			    }



			   

                     echo '  <div class="row">
                     <div class="col-md-6">
                       <label>Noms du collaborateur</label>
                       <input type="text" value="'.$fetch_leavereq['fname'].' '.$fetch_leavereq['lname'].'" class="form-control" disabled>

                     </div>
                      <div class="col-md-6">
                       <label>Fonction</label>
                       <input type="text" value="'.$fetch_leavereq['job_title'].'" class="form-control" disabled>
                     </div>
                   </div>
                    <div class="row">
                     <div class="col-md-6">
                       <label>Type de congé</label>
                       <input type="text" value="'.$fetch_leavereq['leave_name'].' / '.$leavetyp.'" class="form-control" disabled>
                     </div>
                      <div class="col-md-6">
                       <label>Date de la demande</label>
                       <input type="text" value="'.date('d-m-Y',strtotime($fetch_leavereq['create_date'])).'" class="form-control" disabled>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-md-6">
                       <label>Date de début du congé</label>
                       <input type="text" value="'.$fetch_leavereq['start_date'].' / '.$spart.'" class="form-control" disabled>
                     </div>
                      <div class="col-md-6">
                       <label>Date de fin du congé</label>
                       <input type="text" value="'.$fetch_leavereq['end_date'].' / '.$epart.'" class="form-control" disabled>
                     </div>
                   </div>
                  
                  
                   <div class="row">
                     <div class="col">
                       <label>Motif du congé</label>
                      <textarea name="" class="form-control" id=""  disabled>'.$fetch_leavereq['leave_reason'].'</textarea>
                     </div>
                     
                   </div>
                   <div class="row">
                     <div class="col-md-6">
                       <label>Nombre total de jours: '.$fetch_leavereq['totaldays'].'</label>
                     </div>
                      <div class="col-md-6">
                       <label>Document joint:<a href="'.$doc.'" target="__blank">Click</a></label>
                      
                     </div>
                   </div>
                   <form method="post" class="mt-2">
                  <input type="hidden" name="lrid" hidden value="'.$lrid.'">
                  <input type="hidden" name="empid" hidden value="'.$fetch_leavereq['emp_id'].'">
                <input type="hidden" hidden name="ptleavd" value="'.$fetch_leavereq['spend_holiday'].'">
                  <input type="hidden" name="appday" hidden value="'.$fetch_leavereq['totaldays'].'">
                  <input type="hidden" name="leavetype" hidden value="'.$fetch_leavereq['leave-type'].'">

                   <div class="row mb-3">
                     <label for="form-select" class="form-label">Statut du congé</label>
                     <select name="status1" class="form-control" id="status" required>'.$status.' </select>
                   </div>
                   <div class="row mb-4">
                     <label for="form-select" class="form-label">Commentaires</label>
                     <textarea name="comment"  class="form-control" id="comment" cols="30" rows="5">'.$fetch_leavereq['commment'].'</textarea>
                   </div>
                   <input type="submit" class="btn btn-primary btn-sm" name="lvreq" value="Soumettre">
                 </form>
                   ';


			
		}
	} //showleaverequest Method End

	public function leavedrhupdate($status1,$comment,$lrid,$appday,$empid,$ptleavd,$typeleave){
	$drhid=$_SESSION['employeidno'];
	$parts = explode(" ", $appday);
	$whole = (int)$parts[0];
	if (count($parts)==2) {
	  if ($parts[1]=="½") {
	  $fraction = 0.5;
	}else{
	  $fraction = 0;

	}
	}else{
	   $fraction = 0;
	}

	$decimal = $whole + $fraction;

	if ($status1=='Approved') {
		$tdaysd=$ptleavd+$decimal;
		$checklrsta=mysqli_query($this->db,"SELECT * FROM `leave_request` WHERE `lr_id`='$lrid' AND `lr_status`='Approved'");
		if (mysqli_num_rows($checklrsta)>0) {
			$tdaysd=$ptleavd;
		}else{
			$tdaysd=$ptleavd+$decimal;
		}
		if ($typeleave=="countable") {
			$sql1=mysqli_query($this->db,"UPDATE `employees` SET `spend_holiday`='$tdaysd' WHERE `eid`='$empid'");
		}

		$sql="UPDATE `leave_request` SET `lr_status`=?,`drh_info`=?,`commment`=?, `approval_day`=? WHERE `lr_id`=?";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('sissi',$status1,$drhid,$comment,$decimal,$lrid);
		
		
	}elseif($status1=='Rejected'){
		$checklrsta=mysqli_query($this->db,"SELECT * FROM `leave_request` WHERE `lr_id`='$lrid' AND `lr_status`='Approved'");
		if (mysqli_num_rows($checklrsta)>0) {
			$tdaysd=$ptleavd-$decimal;
		if ($typeleave=="countable") {
			$sql1=mysqli_query($this->db,"UPDATE `employees` SET `spend_holiday`='$tdaysd' WHERE `eid`='$empid'");
		}
		}
		$appday=0;
		$sql="UPDATE `leave_request` SET `lr_status`=?,`drh_info`=?,`commment`=?, `approval_day`=? WHERE `lr_id`=?";
		$stml=$this->db->prepare($sql);
		$stml->bind_param('sissi',$status1,$drhid,$comment,$appday,$lrid);
	}

		if ($stml->execute()) {
			include_once'email_function.php';
			include_once'leave_email_template.php';
			
			return true;
		}else{
			return false;
		}

	}




} // End Class



$leavetype=new leavetypes($db);


if (isset($_POST['addtype'])) {
	$type=$_POST['typename'];
	$cnt=$_POST['type'];
	$result=$leavetype->addtypes($type,$cnt);
	if ($result) {
echo '<script>Swal.fire({
title: "Félicitations",
text: "Ajout réussi d un nouveau type de congé.",
icon: "success"
}).then(function(){
	window.location.href="manage-leave-type.php"
});</script>';
}else{
echo '<script>Swal.fire({
title: "Veuillez réessayer",
text: "Échec à l ajout d un nouveau type de congé.",
icon: "error"
}).then(function(){
	window.location.href="manage-leave-type.php"
});</script>';
}
}
// Add Leave type Form Submit End
if (isset($_POST['updatetype'])) {
$type=$_POST['typename'];
$id=$_POST['lt_id'];
$cnt=$_POST['type'];

$result=$leavetype->updatetypes($type,$id,$cnt);
if ($result) {
echo '<script>Swal.fire({
title: "Félicitations",
text: "Mise à jour réussie Type de congé.",
icon: "success"
}).then(function(){
	window.location.href="manage-leave-type.php"
});</script>';
}else{
echo '<script>Swal.fire({
title: "Veuillez réessayer",
text: "Échec de la mise à jour du type de congé.",
icon: "error"
}).then(function(){
	window.location.href="manage-leave-type.php"
});</script>';
}
}




if (isset($_POST['lvreq'])) {
	$status1=$_POST['status1'];
	$comment=$_POST['comment'];
	$lrid=$_POST['lrid'];
	$appday=$_POST['appday'];
	$empid=$_POST['empid'];
	$ptleavd=$_POST['ptleavd'];
	$typeleave=$_POST['leavetype'];
	$result=$leavetype->leavedrhupdate($status1,$comment,$lrid,$appday,$empid,$ptleavd,$typeleave);
	if ($result) {
echo '<script>Swal.fire({
title: "Félicitations",
text: "Mise à jour réussie de la demande de congé de l employé.",
icon: "success"
}).then(function(){
	window.location.href="leave-request"
});</script>';
}else{
echo '<script>Swal.fire({
title: "Veuillez réessayer",
text: "Échec de la mise à jour de la demande de congé de l employé.",
icon: "error"
}).then(function(){
	window.location.href="leave-request"
});</script>';
}

}
?>