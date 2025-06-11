<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Download Doc File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-fluid">
<?php 
include_once 'private/employee_function.php';

$getempid = base64_decode($_GET['id']);
$start = $_GET['start'];
$end = $_GET['end'];

// Store the output in a variable
$content =$employee->timesheetreport($start,$end,$getempid);

$filename = $start . '-' . $end . '-timesheet-' . date('d-M-Y') . '.doc';
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=\"$filename\"");

// Echo the content after sending headers
echo $content;
?>
</div>
</body>
</html>
