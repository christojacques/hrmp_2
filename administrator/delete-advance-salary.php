<?php 
include_once 'header.php';

$idgetads = base64_decode($_GET['id']);

$deleteadvs = "DELETE FROM `extra_salary` WHERE `exs_id`=?";
$sqldeadv = $db->prepare($deleteadvs);
$sqldeadv->bind_param('i', $idgetads);

?>
<script>
		<?php
		if ($sqldeadv->execute()) {
			echo 'Swal.fire({
				title: "Successfully Deleted",
				text: "The Extra Salary Deleted Successfully.",
				icon: "success"
			}).then(function(){
				window.location.href = "advance-salary.php?id='.$_GET['emi'].'";
			});';
		} else {
			echo 'Swal.fire({
				title: "Please Try Again!",
				text: "The Extra Salary Delete Failed.",
				icon: "error"
			}).then(function(){
				window.location.href = "advance-salary.php?id='.$_GET['emi'].'";
			});';
		}
		?>
</script>

<?php
include_once 'footer.php';
?>
