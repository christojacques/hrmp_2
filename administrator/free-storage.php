<?php
include_once 'private/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['attendance_ids'])) {
        $attendanceIds = $_POST['attendance_ids'];

        foreach ($attendanceIds as $value) {
            // Prepare and execute the query to get the photo for the given `att_id`
            $stmt = $db->prepare("SELECT `phtoto`, `attc_id` FROM `attendance_captures` WHERE `att_id` = ?");
            $stmt->bind_param("i", $value);
            $stmt->execute();
            $result = $stmt->get_result(); // Fix: Missing semicolon

            while ($row = $result->fetch_assoc()) {
                $photo = $row['phtoto']; // Fix: Corrected column name
                $id = $row['attc_id'];

                if (!empty($photo)) {
                    $photoPath = "../guard/attendance_photo/" . $photo; // Path to the photo file

                    // Check if the file exists and delete it
                    if (file_exists($photoPath)) {
                        if (unlink($photoPath)) {
                            // Prepare to update the database after deleting the photo
                            $updateStmt = $db->prepare("UPDATE `attendance_captures` SET `phtoto` = '' WHERE `attc_id` = ?");
                            $updateStmt->bind_param("i", $id);
                            if ($updateStmt->execute()) {
                                echo 'true';
                            } else {
                                echo json_encode(["success" => false, "message" => "Failed to update the database."]);
                            }
                            $updateStmt->close(); // Close the statement
                        } else {
                            echo json_encode(["success" => false, "message" => "Failed to delete: " . $photoPath]);
                        }
                    } else {
                        echo json_encode(["success" => false, "message" => "File does not exist: " . $photoPath]);
                    }
                }
            }
            $stmt->close(); // Close the statement
        }
    } else {
        echo json_encode(["success" => false, "message" => "No attendance IDs provided."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
