<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php 
include_once 'header.php';
$taskid=base64_decode($_GET['id']);
$desql="DELETE FROM `daliy_timesheet` WHERE `ts_id`=?";
$stml=$db->prepare($desql);
$stml->bind_param('i',$taskid);
 ?>
 <script>
		<?php
	if ($stml->execute()) {
	echo 'Swal.fire({
		title: "Congratulation",
		text: "Successfully Deleted Task Time.",
		icon: "success"
		}).then( function(){
			window.location.href="index";
		});';
}else{
	echo 'Swal.fire({
		title: "Please Try Again!",
		text: Faild To Deleted Task Time.",
		icon: "error"
		}).then( function(){
			window.location.href="index";
		});';
}
		?>
</script>

</body>
</html>