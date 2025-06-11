<?php
include_once 'private/protection.php';

if (isset($_POST['phid'])) {
	$id=$_POST['phid'];
	$query=mysqli_query($db,"SELECT * FROM `public_holidays` WHERE `ph_id`='$id'");
	if (mysqli_num_rows($query)>0) {
		$fetch_edittype=mysqli_fetch_assoc($query);
		
		echo '<div class="modal-header">
	<h1 class="modal-title fs-5" id="exampleModalLabel">Modifier le jour férié</h1>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form method="post" >
		 <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Jour férié</label>
                <input type="text" name="holidayname" required class="form-control" id="holidayname" value="'.$fetch_edittype["holiday_name"].'">

        		<input type="hidden" name="ph_id" value="'.$fetch_edittype["ph_id"].'" required hidden>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Date</label>
                <input type="text" name="holidaydate" required class="form-control" id="holidaydate" placeholder="dd-mm-yyyy"  pattern="\d{2}-\d{2}-\d{4}" title="Please enter date in dd-mm-yyyy format"  value="'.$fetch_edittype["holiday_date"].'">
              </div>

		<input type="submit" name="updatepholiday" class="btn btn-primary" value="Enregistrer">
	</form>
</div>
';
	}
	
}
?>
 <script src="js/jquery-3.7.0.js"></script>
    <script src="js/jquery-ui.min.js"></script>

<script>
	$.noConflict();
    jQuery(document).ready(function($) {
    $("#holidaydate").datepicker({
    dateFormat: "dd-mm-yy"
    });
    });
</script>