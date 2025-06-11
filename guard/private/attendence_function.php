<?php
include_once 'db.php';
class attendence{
    private $db;
    public function __construct($db){
        $this->db=$db;
    }
public function entry($image, $latitude, $longitude, $eid, $status) {
    date_default_timezone_set('Africa/Kinshasa');

    // SQL queries
    $attsql = "INSERT INTO `attendance`(`employee_id`, `guard_id`, `attend_type`, `entry_dt`, `dates`) VALUES (?,?,?,?,?);";
    $attcap = "INSERT INTO `attendance_captures`(`att_id`, `emp_id`, `phtoto`, `takeinfo`,`whentake`) VALUES (?,?,?,?,?);";

    $type = "Entry";
    $imageData = base64_decode($image);

    // Check if image decoding is successful
    if ($imageData === false) {
        error_log('Base64 decode failed');
        return false;
    }

    $fileName = uniqid('entry_') . '.png';
    $filePath = '../attendance_photo/' . $fileName;
    $takeinfo = $latitude . ',' . $longitude;
    $date = date('Y-m-d H:i:s');
    $dates = date('Y-m-d');

    // Start session to get guard ID
    session_start();
    if (!isset($_SESSION['guardid'])) {
        error_log('Guard ID not found in session');
        return false;
    }
    $gid = $_SESSION['guardid'];

    // Prepare and execute the attendance query
    $stml = $this->db->prepare($attsql);
    if (!$stml) {
        error_log('Prepare statement for attendance failed: ' . $this->db->error);
        return false;
    }
    $stml->bind_param('iisss', $eid, $gid, $type, $date, $dates);

    if (!$stml->execute()) {
        error_log('Failed to execute attendance query: ' . $this->db->error);
        return false;
    }

    $lastId = $this->db->insert_id;

    // Prepare and execute the attendance captures query
    $stmt = $this->db->prepare($attcap);
    if (!$stmt) {
        error_log('Prepare statement for attendance captures failed: ' . $this->db->error);
        return false;
    }
    $stmt->bind_param('iisss', $lastId, $eid, $fileName, $takeinfo,$type);

    if (!$stmt->execute()) {
        error_log('Failed to execute attendance captures query: ' . $this->db->error);
        return false;
    }

    // Update the employee's entry ID
    $emup = mysqli_query($this->db, "UPDATE `employees` SET `entry_id`='$lastId' WHERE `eid`='$eid'");
    if (!$emup) {
        error_log('Failed to update employee entry ID');
        return false;
    }

    // Save the image to the server
    if (file_put_contents($filePath, $imageData) === false) {
        error_log('Failed to save image to ' . $filePath);
        return false;
    }

    return true;
}

public function exit($image, $latitude, $longitude, $eid, $status){
     $sql=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `eid`='$eid'");
     if (mysqli_num_rows($sql)>0) {
             $fetchpass=mysqli_fetch_assoc($sql);
                     date_default_timezone_set('Africa/Kinshasa');
                     $entryid=$fetchpass['entry_id'];
                     $attsql="UPDATE `attendance` SET `attend_type`=?,`exit_dt`=? WHERE `atten_id`=? AND `employee_id`=?";
                     $attcap = "INSERT INTO `attendance_captures`(`att_id`, `emp_id`, `phtoto`, `takeinfo`,`whentake`) VALUES (?,?,?,?,?)";
                    $imageData = base64_decode($image);
                    if ($imageData === false) {
                    error_log('Base64 decode failed');
                    return false;
                    }
                    $fileName = uniqid('exit_') . '.png';
                    $filePath = '../attendance_photo/' . $fileName;
                    $takeinfo = $latitude . ',' . $longitude;
                    $type="Exit";
                     $date=date('Y-m-d H:i:s');
                     $dates=date('Y-m-d');
                     $stml=$this->db->prepare($attsql);
                     $stmt=$this->db->prepare($attcap);
                     $stml->bind_param('ssii',$type,$date,$entryid,$eid);
                     if ($stml->execute()) {
                         $stmt->bind_param('iisss', $entryid, $eid, $fileName, $takeinfo,$type);
                         if ($stmt->execute()) {
                            if (file_put_contents($filePath, $imageData) === false) {
                                error_log('Failed to save image to ' . $filePath);
                                return false;
                            }
                            return true;
                         }else{
                             return false;
                         }
                            return true;
                
                     }else{
                             return false;
                     }
             
     }else{
             return false;
     }
}
    
public function showEmployees() {
    $sql = mysqli_query($this->db, "SELECT * FROM `employees`");
    $output = '';
    $currentDate = date('Y-m-d');

    while ($fetchEmployee = mysqli_fetch_assoc($sql)) {
        $employeeId = $fetchEmployee["eid"];
        $currentatten = $fetchEmployee["entry_id"];
        $checkAttendance = mysqli_query($this->db, "SELECT * FROM `attendance` WHERE `employee_id`='$employeeId' AND `dates`='$currentDate' AND `atten_id`='$currentatten'");
        $entry = '';
        $exit = '';
        $attbtn = '';

        // Check if attendance exists for the employee
        if (mysqli_num_rows($checkAttendance) > 0) {
            $fetchAttendance = mysqli_fetch_assoc($checkAttendance);

            if ($fetchAttendance["attend_type"] === 'Entry') {
                $attbtn = '<button class="btn btn-danger entry-btn" 
                            data-id="' . $employeeId . '" 
                            data-name="' . $fetchEmployee["fname"] . ' ' . $fetchEmployee["lname"] . '" 
                            data-security="' . $fetchEmployee["password"] . '" 
                            data-model="Exit" 
                            data-bs-toggle="modal" 
                            data-bs-target="#entryModal1">
                            <i class="mdi mdi-exit-to-app"></i>
                          </button>';
            } else {
                $attbtn = '<button class="btn btn-primary entry-btn" 
                            data-id="' . $employeeId . '" 
                            data-name="' . $fetchEmployee["fname"] . ' ' . $fetchEmployee["lname"] . '" 
                            data-security="' . $fetchEmployee["password"] . '" 
                            data-model="Entry" 
                            data-bs-toggle="modal" 
                            data-bs-target="#entryModal1">
                            <i class="mdi mdi-account-check"></i>
                            
                          </button>';
            }


            $entry = $fetchAttendance["entry_dt"];
            $exit = $fetchAttendance["exit_dt"];
        } else {
            // Default button for new attendance
            $attbtn = '<button class="btn btn-primary entry-btn" 
                        data-id="' . $employeeId . '" 
                        data-name="' . $fetchEmployee["fname"] . ' ' . $fetchEmployee["lname"] . '" 
                        data-security="' . $fetchEmployee["password"] . '" 
                        data-model="Entry" 
                        data-bs-toggle="modal" 
                        data-bs-target="#entryModal1">
                        <i class="mdi mdi-account-check"></i>
                      </button>';
        }

        $output .= '<tr>
            <td>' . $fetchEmployee["fname"] . ' ' . $fetchEmployee["lname"] . '</td>
            <td>' . $fetchEmployee["dob"] . '</td>
            <td>' . $fetchEmployee["job_title"] . '</td>
            <td>' . $attbtn . '</td>
            <td>' . $entry . '</td>
            <td>' . $exit . '</td>
        </tr>';
    }

    return $output;
}


public function getempldetails(){
        $currdate=date('Y-m-d');
        $gettotalemplo=mysqli_query($this->db,"SELECT * FROM `employees` WHERE `account_status`='active'");

        $gettotalemployeeno=mysqli_num_rows($gettotalemplo);
        $gettotalprest=0;
        while ($fetch_empinfo=mysqli_fetch_assoc($gettotalemplo)) {
        $emipid=$fetch_empinfo['eid'];
        $gettotalemplopresent=mysqli_query($this->db,"SELECT * FROM  `attendance` WHERE `employee_id`='$emipid' AND `dates`='$currdate' AND `attend_type` = 'Entry'");

        if (mysqli_num_rows($gettotalemplopresent)) {
        $gettotalprest+=1;
        }
        }

        /*
        Total number of employee
        Number of employee in
        Number of employee out
        */
        echo '
        <div class="col mb-2 stretch-card transparent">
        <div class="card card-tale">
        <div class="card-body">
        <h4 class="card-title mb-2">Collaborateurs enregistrés</h4>
        <p class="card-text mb-2">'.$gettotalemployeeno.'</p>
        </div>
        </div>
        </div>
        <div class="col mb-2 stretch-card transparent">
        <div class="card bg-success text-light">
        <div class="card-body">
        <h4 class="card-title mb-2">Employés présents</h4>
        <p class="card-text mb-2">'.$gettotalprest.'</p>
        </div>
        </div>
        </div>
        <div class="col mb-2 stretch-card transparent">
        <div class="card bg-danger text-light">
        <div class="card-body">
        <h4 class="card-title mb-2">Employés absents</h4>
        <p class="card-text mb-2">'.$gettotalemployeeno-$gettotalprest.'</p>
        </div>
        </div>
        </div>
        ';
            
        
    }
}
$attendence=new attendence($db);

$payload = json_decode(file_get_contents('php://input'), true);
$image = $payload['image'] ?? null; // Base64 encoded string
$latitude = $payload['latitude'] ?? null;
$longitude = $payload['longitude'] ?? null;
$eid = $payload['eid'] ?? null;
$status = $payload['status'] ?? null;
if ($image && $latitude && $longitude && $eid && $status) {
if ($status==='Entry') {
    $result=$attendence->entry($image,$latitude,$longitude,$eid,$status);
        if ($result) {
 echo json_encode([
        'status' => true,
        'message' => 'L\'entrée du collaborateur a été enregistrée avec succès'
    ]);
    }else{
        echo json_encode([
        'status' => false,
        'message' => 'La participation à l entrée du salarié a échoué !'
    ]);
    }
}elseif($status==='Exit'){
    $result=$attendence->exit($image,$latitude,$longitude,$eid,$status);
 if ($result) {
 echo json_encode([
        'status' => true,
        'message' => 'La sortie du collaborateur a été enregistré avec succès'
    ]);


}else{
 echo json_encode([
        'status' => false,
        'message' => 'La fréquentation des employés à la sortie du travail est en baisse !'
    ]);
}
}

}
?>