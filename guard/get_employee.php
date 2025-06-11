<?php 

 include_once 'private/protection.php';

if (isset($_POST['idemp'])) {
	$empid=$_POST['idemp'];
	$sqlemp=mysqli_query($db,"SELECT * FROM `employees` WHERE `eid`='$empid'");

	if (mysqli_num_rows($sqlemp)) {
		$fetch_employede=mysqli_fetch_assoc($sqlemp);
		echo '
	<div class="modal-body">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4"><img src="guard_images/entry.jpg" alt="entry.jpg" style="width:200px;height:200px;border-radius: 50%;margin-bottom: 25px;"></div>
			<div class="col-md-4"></div>
		</div>
		
		<h3 class="text-center">Do you Confirm the entry of Mr./Ms. '.$fetch_employede["fname"].' '.$fetch_employede["lname"].'</h3>

	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	<button type="button" data-edit="' .$fetch_employede["eid"]. '" data-bs-toggle="modal" data-bs-target="#entryempcon" class="btn btn-primary" id="entry-con">Yes</button>
	</div>



          
            

		';
	}

}
if (isset($_POST['entryconid'])) {
	$empid=$_POST['entryconid'];
	$sqlemp=mysqli_query($db,"SELECT * FROM `employees` WHERE `eid`='$empid'");

	if (mysqli_num_rows($sqlemp)) {
		$fetch_employede=mysqli_fetch_assoc($sqlemp);
		echo '
	
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4"><img src="guard_images/entry.jpg" alt="entry.jpg" style="width:200px;height:200px;border-radius: 50%;margin-bottom: 25px;"></div>
			<div class="col-md-4"></div>
		</div>
		
		<h3 class="text-center">Mr./Ms. '.$fetch_employede["fname"].' '.$fetch_employede["lname"].'<br>Do you Confirm your entry of the Office. If yes please enter your password.</h3>

		<div class="mt-3">
			 <label class="text-capitalize">Password</label>
			 <div class="input-group">
			  <input type="password" name="password" id="password" class="form-control">
        <span class="input-group-text cursor-pointer" id="togglePassword" onclick="togglePasswordVisibility()"><i class="mdi mdi-eye-off"></i></span>
			 </div>
             <input type="hidden" name="empid" class="form-control" value="'.$fetch_employede["eid"].'">
             <input type="hidden" name="gid" class="form-control" value="'.$_SESSION['guardid'].'">
		</div>
	
	       

		';
	}

}


if (isset($_POST['exit'])) {
	$empid=$_POST['exit'];
	$sqlemp=mysqli_query($db,"SELECT * FROM `employees` WHERE `eid`='$empid'");

	if (mysqli_num_rows($sqlemp)) {
		$fetch_employede=mysqli_fetch_assoc($sqlemp);
		echo '
		
          
      <div class="modal-body">
      	<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4"><img src="guard_images/exit-office.png" alt="exit-office.png" style="width:200px;height:200px;border-radius: 50%;margin-bottom: 25px;"></div>
			<div class="col-md-4"></div>
		</div>
		
		<h3 class="text-center">Do you Confirm the Exit of Mr./Ms. '.$fetch_employede["fname"].' '.$fetch_employede["lname"].'</h3>		
      </div>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" data-edit="'.$fetch_employede["eid"].'" data-bs-toggle="modal" data-bs-target="#exitempassword" class="btn btn-primary" id="emppassword">Yes</button> 
</div>
		';
	}
}



if (isset($_POST['passexit'])) {
	$empid=$_POST['passexit'];
	$sqlemp=mysqli_query($db,"SELECT * FROM `employees` WHERE `eid`='$empid'");

	if (mysqli_num_rows($sqlemp)) {
		$fetch_employede=mysqli_fetch_assoc($sqlemp);
		echo '
      
      	<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4"><img src="guard_images/exit-office.png" alt="exit-office.png" style="width:200px;height:200px;border-radius: 50%;margin-bottom: 25px;"></div>
			<div class="col-md-4"></div>
		</div>
		
		<h3 class="text-center">Mr./Ms. '.$fetch_employede["fname"].' '.$fetch_employede["lname"].'<br> Do you confirm your exit from Office. If yes please enter your password.</h3>

		<div class="mt-3">
			 <label class="text-capitalize">Password</label>
             <div class="input-group">
			  <input type="password" name="password" id="password" class="form-control">
        <span class="input-group-text cursor-pointer" id="togglePassword" onclick="togglePasswordVisibility()"><i class="mdi mdi-eye-off"></i></span>
			 </div>
             <input type="hidden" name="empid" class="form-control" value="'.$fetch_employede["eid"].'" required>
             <input type="hidden" name="gid" class="form-control" value="'.$_SESSION['guardid'].'" required>
		</div>
      
		';
	}
}


 ?>