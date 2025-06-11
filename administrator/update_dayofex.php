<?php 
include_once 'private/db.php';

if (isset($_POST['ws_id']) && isset($_POST['value'])) {
	$id=$_POST['ws_id'];
	$value=$_POST['value'];
	$sql="UPDATE `week_submission` SET `dayofex`=? WHERE `ws_id`=?";
	$stml=$db->prepare($sql);
	$stml->bind_param('si',$value,$id);
	if ($stml->execute()) {
		return true;
	}else{
		return false;
	}
}

 ?>