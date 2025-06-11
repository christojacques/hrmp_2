<?php include_once 'header.php'; ?>
<style>
	th {
padding: 0px !important;
}
</style>
<div class="main-panel">
	<!-- Content -->
	<div class="content-wrapper">
		<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Vacances /</span> Calendrier</h4>
		<?php
$daysInFrench = [
    'Mon' => 'Lun',
    'Tue' => 'Mar',
    'Wed' => 'Mer',
    'Thu' => 'Jeu',
    'Fri' => 'Ven',
    'Sat' => 'Sam',
    'Sun' => 'Dim'
];

		date_default_timezone_set('Africa/Kinshasa');
		// Initialize $monthCount and $currentYear if they're not set in the session
		$monthCount = isset($_SESSION['monthCount']) ? $_SESSION['monthCount'] : date("m");
		$currentYear = isset($_SESSION['year']) ? $_SESSION['year'] : date("Y");
		// Handle increment and decrement actions
		if (isset($_POST['increment'])) {
		$monthCount++;
		if ($monthCount > 12) {
		$monthCount = 1;
		$currentYear++;
		}
		} elseif (isset($_POST['decrement'])) {
		$monthCount--;
		if ($monthCount == 0) {
		$monthCount = 12;
		$currentYear--;
		}
		}
		// Update session variables
		$_SESSION['monthCount'] = $monthCount;
		$_SESSION['year'] = $currentYear;
		
		$currentDate = date('Y-m-D');
		//$year=date("Y");
		$year=isset($_SESSION['year']) ? $_SESSION['year'] : date("Y");
		//$totalday=date("t");
		//$month=date("m");
		$today=date("d");
		$todayname=date("D");
		$month=isset($_SESSION['monthCount']) ? $_SESSION['monthCount'] : date("m");
		$totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		
		
		?>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="card  col-md-4 ">
				<table class="table table-bordered text-center">
					<thead>
						<tr>
							<th>Icône</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="background:#525dff;border-radius:5%;color:white;"><h4 style="    margin: 5px;">Mon</h4></td>
							<td>Date du jour</td>
						</tr>
						<tr>
							<td style="background: #ddd;color: black;"><h4 style="    margin: 5px;">10</h4></td>
							<td >Week-end</td>
						</tr>
						<tr>
							<td style="background: #272658;color: white;"><h4 style="    margin: 5px;">1</h4></td>
							<td>Congé approuvé</td>
						</tr>
						<tr>
							<td><i class="mdi mdi-calendar-remove"style="font-size: 40px;color:#401d95;"></i></td>
							<td>Jours fériés</td>
						</tr>
						
						
						
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<form method="post" class="mb-3">
				<div class="btn-group" role="group" aria-label="Basic example"style="
					margin-right: 5px;">
					<button type="submit" name="decrement" class="btn btn-outline-secondary"><i class='mdi mdi-arrow-left'></i></button>
					<button type="submit" name="increment" class="btn btn-outline-secondary"><i class='mdi mdi-arrow-right' ></i></button>
					
				</div>
				<strong class="card-title text-primary"  style="font-size: 18px;font-weight: 400;"><?php echo date('M Y', mktime(0, 0, 0, $month, 1, $year)); ?></strong>
			</form>
			
			<div class="col-md-12">
				<div class="card table-responsive">
					<div class="">
						<table class="table table-bordered text-center">
							<thead>
								<tr>
									<th>Collaborateur</th>
									<?php  for ($i =1; $i <= $totalDays ; ++$i) {
									 $currentDate = date("D", strtotime("$year-$month-$i")); // Get English day name
								    $currD = date("d-m-Y", strtotime("$year-$month-$i")); 
								    $dayInFrench = $daysInFrench[$currentDate] ?? $currentDate; 
									$cdate=date('d-m-Y');
									if ($cdate==$currD) {
										echo '<th style="background:#525dff;border-radius:5%;color:white;">'.$dayInFrench.'</th>';
									}else{
										echo '<th>'.$dayInFrench.'</th>';
									}
									
									}
									?>
								</tr>
							</thead>
							<tbody>
								<?php
								
								$getemployeedel=mysqli_query($db,"SELECT * FROM `employees` WHERE `account_status`='active'");
								if (mysqli_num_rows($getemployeedel)>0) {
									while ($fetch_emplo=mysqli_fetch_assoc($getemployeedel)) {
										$firstidentity = substr($fetch_emplo['fname'], 0, 1) . substr($fetch_emplo['lname'], 0, 1);
										$caneid=$fetch_emplo['eid'];
										$holidayt=$fetch_emplo['total_holiday'];
										$speholiday=$fetch_emplo['spend_holiday'];
								$getleavinfo = mysqli_query($db, "SELECT * FROM `leave_request` WHERE `emp_id`='$caneid' AND `lr_status`='Approved'");
								if (mysqli_num_rows($getleavinfo) > 0) {
									$holidays=array();
									while($fetchempleav=mysqli_fetch_assoc($getleavinfo)){
									$lrstart = $fetchempleav['start_date'];
									$lrend = $fetchempleav['end_date'];
									//									$intday=$fetchempleav['totaldays'];
									$current_date = strtotime($lrstart);
									$end_timestamp = strtotime($lrend);
									while ($current_date <= $end_timestamp) {
									$dayOfWeek = date('N', $current_date);
									if ($dayOfWeek < 6) { // Check if it's not Saturday or Sunday
									$formatted_date = date('d-m-Y', $current_date);
											$getphday1=mysqli_query($db,"SELECT * FROM `public_holidays` WHERE `holiday_date`='$formatted_date'");
											if (mysqli_num_rows($getphday1)>0) {
												
											}else{
												$holidays[]=$formatted_date;
											}
									
									}
									$current_date = strtotime('+1 day', $current_date);
									}
									}
								}else{
									$holidays=array();
								}
								?>
								
								
								
								<tr>
									<td style="margin-right: 50px; padding: 5px 5px 5px 5px !important;" title="<?=$fetch_emplo['fname'].' '.$fetch_emplo['lname'];?>">
										<button type="button" class="btn btn-icon btn-outline-primary position-relative" style="border-radius:50px;"><?=$firstidentity;?><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-label-primary" style="color:blue; width: 35px; height: 24px; background: #ddd;"><?=$holidayt-$speholiday;?>+</span></button></td>
										<?php
										for ($i =1; $i <= $totalDays ; ++$i) {
										$currentDate = date("D", strtotime("$year-$month-$i"));
										$currD= date("d-m-Y", strtotime("$year-$month-$i"));
										
										$getphday=mysqli_query($db,"SELECT * FROM `public_holidays` WHERE `holiday_date`='$currD'");
										if (mysqli_num_rows($getphday)>0) {
											$fetchph=mysqli_fetch_assoc($getphday);
											$phday=$fetchph['holiday_date'];
										}else{
											$phday=0;
										}
										
									

									$getleavedates1=mysqli_query($db,"SELECT * FROM `leave_request` WHERE `emp_id`='$caneid' AND `start_date`='$currD' AND `lr_status`='Approved'");
									$lastD=0;
									if (mysqli_num_rows($getleavedates1)>0) {
										$fetch_empleav=mysqli_fetch_assoc($getleavedates1);
										$startDa=$fetch_empleav['start_date'];
										$startwh=$fetch_empleav['start_part'];
										$endwh=$fetch_empleav['end_part'];
										if ($startwh=="Afternoon" && $endwh=="End Of Day") {
											$last=0.5;
											$lastD=$startDa;
										}
										
									}else{
										
										$last=0;
										$lastD=0;

									}


									$getleavedates2=mysqli_query($db,"SELECT * FROM `leave_request` WHERE `emp_id`='$caneid' AND `end_date`='$currD' AND `lr_status`='Approved'");

									if (mysqli_num_rows($getleavedates2)>0) {
										$fetch_empleav2=mysqli_fetch_assoc($getleavedates2);
										$endDa=$fetch_empleav2['end_date'];
										$startwh2=$fetch_empleav2['start_part'];
										$endwh2=$fetch_empleav2['end_part'];
										$firstD=0;
										if ($startwh2=="Morning" && $endwh2=="Lunchtime") {
											$first=0.5;
											$firstD=$endDa;
										}
										
									}else{
										$first=0;
										$firstD=0;
										$endDa=0;

									}

										if ($currD==$lastD) {
											if ($last==0.5) {
												echo '<td style="background: linear-gradient(to right, transparent 30% , #272658 30%);color: white;">'.$i.'</td>';
											}else{
												//echo '<td style="background: #272658;color: white;">'.$i.'</td>';
											}
											
										}elseif ($currentDate=="Sat") {
										echo '<td style="background: #ddd;color: black;">'.$i.'</td>';
										}elseif ($currentDate=="Sun") {
										echo '<td style="background: #ddd;color: black;">'.$i.'</td>';
										}elseif ($currD==$firstD) {
											if ($first==0.5) {
												echo '<td style="background: linear-gradient(to right, #272658 67%, transparent 75%);color: white;">'.$i.'</td>';
											}else{
												//echo '<td style="background: #272658;color: white;">'.$i.'</td>';
											}
											
										}elseif (in_array($currD, $holidays)) {
										echo '<td style="background: #272658;color: white;">'.$i.'</td>';
										}elseif ($currD==$phday) {
										echo '<td style="color:#401d95;"><i class="mdi mdi-calendar-remove"style="font-size: 40px;"></i></td>';
										}elseif ($currD==date('d-m-Y')) {
										echo '<td style="color: black;">'.$i.'</td>';
										}else{
										echo '<td style="color: black;">'.$i.'</td>';
										}
										}
										?>
									</tr>
									<?php  }
									}?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<style>
		/* table{
		font-size: 15px;
		text-align: center;
		}
		table tr th{
		padding: 0px !important;
		}*/
		table tr td{
		padding: 0px !important;
		}
		</style>
		<?php include_once 'footer.php'; ?>