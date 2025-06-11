<?php 
include_once 'private/db.php';
if (isset($_POST['attdenceid'])) {
	$attid=$_POST['attdenceid'];

$sql = "SELECT * FROM `attendance` 
        JOIN `attendance_captures` 
        ON `attendance_captures`.`att_id` = `attendance`.`atten_id` 
        WHERE `atten_id` = ?";

$stml = $db->prepare($sql); // Prepare the query
$stml->bind_param('i', $attid); // Bind the `atten_id` value as an integer
$stml->execute(); // Execute the query

$result = $stml->get_result(); // Get the result set

$data = []; // Initialize an array to store the rows
while ($row = $result->fetch_assoc()) {
    // Push each row into the data array
    //$data[] =$row;
     $data[] = [
    	'attend_type'=>$row['whentake'],
    	'entry_dt'=>$row['entry_dt'],
    	'phtoto'=>$row['phtoto'],
    	'takeinfo'=>$row['takeinfo'],
    ];
}
if (!empty($data)) {
    // Return the result as a JSON object with multiple entries
    echo json_encode($data); // Output the rows as JSON
} else {
    echo json_encode(["message" => "No record found."]); // Output a message if no record is found
}
$stml->close();


}


 ?>