<?php
include_once 'private/protection.php';
include_once 'header.php';
$id=base64_decode($_GET['id']);
if ($id) {
	
	$result=mysqli_query($db,"DELETE FROM `leave_type` WHERE `lt_id`='$id'");
	if ($result) {
echo '<script>Swal.fire({
title: "Congratulation",
text: "Successfully Deleted Leave Type.",
icon: "success"
}).then(function(){
	window.location.href="manage-leave-type.php"
});</script>';
}else{
echo '<script>Swal.fire({
title: "Please Try Again",
text: "Faild To Delete Leave Type.",
icon: "error"
}).then(function(){
	window.location.href="manage-leave-type.php"
});</script>';
}
}
?>