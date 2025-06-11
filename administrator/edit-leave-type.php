<?php
include_once 'private/protection.php';
if (isset($_POST['typesid'])) {
	$id=$_POST['typesid'];
	$query=mysqli_query($db,"SELECT * FROM `leave_type` WHERE `lt_id`='$id'");
	if (mysqli_num_rows($query)>0) {
		$fetch_edittype=mysqli_fetch_assoc($query);
		if ($fetch_edittype['leave-type']=="countable") {
			$checkedC="checked";
			$checkedN="";
		}elseif ($fetch_edittype['leave-type']=="non_countable") {
			$checkedN="checked";
			$checkedC="";
		}else{
			$checkedC="";
			$checkedN="";
		}
		echo '<div class="modal-header">
	<h1 class="modal-title fs-5" id="exampleModalLabel">Modifier le type de congé</h1>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form method="post" >
		<div class="mb-3">
			<label for="typename" class="col-form-label">Type de congé</label>
			<input type="text" name="typename" required class="form-control" id="typename" value="'.$fetch_edittype["leave_name"].'"required/>
			<input type="hidden" name="lt_id" value="'.$fetch_edittype["lt_id"].'" required hidden>
		</div>
<input type="radio" id="countable" name="type" required   value="countable" '.$checkedC.'>
<label for="countable">Jour déductible</label><br>
<input type="radio" id="non_countable" name="type"  required value="non_countable" '.$checkedN.'>
<label for="non_countable">Jour non déductible</label><br>
		<input type="submit" name="updatetype" class="btn btn-primary" value="Enregistrer">
	</form>
</div>
';
	}
	
}
?>