<?php
include_once 'db.php'; // Include your database connection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $module_id = $_POST['module_id'];
    $status = $_POST['status'];
    $createdid = $_SESSION['superadmin_id'];
    $cat = date('Y-m-d H:i:s'); // Updated date format

    // Corrected query with commas separating the columns
    $query = "UPDATE `modules` SET `module_status` = ?, `created_by` = ?, `created_at` = ? WHERE `mf_id` = ?";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("iisi", $status, $createdid, $cat, $module_id);

    if ($stmt->execute()) {
        echo "Module status updated successfully.";
    } else {
        echo "Failed to update module status.";
    }
    
    $stmt->close();
    $db->close();
}
?>
