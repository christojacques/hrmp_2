<?php
include_once 'email_function.php';
date_default_timezone_set('Africa/Kinshasa');
$currentDate = new DateTime();
// Get the first day of the next month
$firstDayOfNextMonth = new DateTime(date('Y-m-01', strtotime('next month', $currentDate->getTimestamp())));
// Calculate the last day of the current month
$lastDayOfCurrentMonth = $firstDayOfNextMonth->sub(new DateInterval('P1D'));
// Subtract 5 days from the last day of the current month
$notificationDate = $lastDayOfCurrentMonth->sub(new DateInterval('P5D'));
// Display the notification date
$GetDate=$notificationDate->format('Y-m-d');
//$GetDate="2024-03-15";
$datecurntmnt=date('Y-m');

$checksendornot=mysqli_query($db,"SELECT * FROM `alert_mail` WHERE `month`='$datecurntmnt'");
if (mysqli_num_rows($checksendornot)>0) {
	
}else{

if ($GetDate==date('Y-m-d')) {

$getdrhid=mysqli_query($db,"SELECT * FROM `employees` WHERE `employee_role`='DRH' OR `employee_role`='FINANCIAL DIRECTOR'");
if (mysqli_num_rows($getdrhid)>0) {
	while($fetch_drh=mysqli_fetch_assoc($getdrhid)){
	$to=$fetch_drh['email'];
	$subject="All Payroll Entries Ready for DHR Review";
	$msg='
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payroll Notification</title>
</head>
<body>
  <p>Dear '.$fetch_drh["fname"].' '.$fetch_drh["lname"].'</p>
  <p>This is an automated notification to inform you that all payroll entries for the current month of this '.date('M, Y').' have been completed and are ready for your review. The Financial Director has finalized inputs for salary advances, deductions, and bonuses for all employees.</p>
  <p><strong>Action Required:</strong></p>
  <p>Please navigate to your admin panel and select "Manage Payroll". From there, click on "Generate Payroll&" to view and approve the indicated payroll entries. Upon approval, these entries will be ready for submission to the CEO for final review.</p>
  <p>For any queries or additional information, please contact the Financial Director.</p>
  <p>Thank you for your attention to this matter.</p>
  <p>Best regards,</p>
  <p>Team Infinity Group Solutions</p>
</body>
</html>





';

smtp_mailer($to,$subject, $msg);

$alertstore=mysqli_query($db,"INSERT INTO `alert_mail`(`month`, `status`) VALUES ('$datecurntmnt','DONE')");



}
}
}
}
?>