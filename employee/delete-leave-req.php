<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php 

include_once 'private/protection.php';

$ids=base64_decode($_GET['id']);

$sql="DELETE FROM `leave_request` WHERE `lr_id`=?";

$stmls=$db->prepare($sql);
$stmls->bind_param('i',$ids);
 ?>
 <script>
	
		<?php
		if ($stmls->execute()) {
			echo 'Swal.fire({
				title: "Successfully Deleted",
				text: "Successfuly Deleted Your Leave Request.",
				icon: "success"
			}).then(function(){
				window.location.href = "apply-for-leave";
			});';
		} else {
			echo 'Swal.fire({
				title: "Please Try Again!",
				text: "Failded To Delete Your Leave Request.",
				icon: "error"
			}).then(function(){
				window.location.href = "apply-for-leave";
			});';
		}
		?>
</script>

</body>
</html>