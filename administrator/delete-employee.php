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
$employid=base64_decode($_GET['id']);
$sql="DELETE FROM `employees` WHERE `eid`=?";
$stml=$db->prepare($sql);
$stml->bind_param('i',$employid);
	?>
	

<?php

 if ($stml->execute()) {

	echo '<script>Swal.fire({
		title: "Compte collaborateur supprimé avec succès!",
		text: "Les informations du collaborateur ont été supprimées avec succès du système.",
		icon: "success"
		}).then(function(){
			window.location.href="manage-employee";
		});</script>';

}else{
	echo '<script>Swal.fire({
		title: "Please Try Again!",
		text: "Faild To Deleted Employee Informations.",
		icon: "error"
		}).then(function(){
			window.location.href="manage-employee";
		});</script>';

}

?>
 



 </body>
</html>