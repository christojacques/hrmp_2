<?php
// Database connection
include 'private/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected employee IDs
    $employee_ids = $_POST['employee_ids'] ?? [];

    if (!empty($employee_ids)) {
        // Convert array to comma-separated string for SQL
        $ids = implode(',', array_map('intval', $employee_ids));

        // Update the annual leave balance
        $sql = "UPDATE `employees` SET `spend_holiday`=0 WHERE `eid` IN ($ids)";
        if (mysqli_query($db, $sql)) {
            echo true;
        } else {
            echo false;
        }
    } else {
        echo false;
    }
}
?>
