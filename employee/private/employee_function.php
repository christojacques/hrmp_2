<?php
include_once 'protection.php';
class employees{
private $db;
public function __construct($db){
$this->db = $db;
}
public function update_employee($phone, $paymetod, $employeenewimg, $passsword){

$sql = "UPDATE `employees` SET `phone`=? ,`payment_method`=? ,`password`=? ,`profile_picture`=? WHERE `eid`=?";
$stml = $this->db->prepare($sql);
$stml->bind_param('ssssi', $phone, $paymetod, $passsword, $employeenewimg, $_SESSION['employeidno']);
if ($stml->execute()) {
return true;
} else {
return false;
}
}
}
$employees = new employees($db);
if (isset($_POST['update_employee'])) {
$phone = $_POST['phone'];
$paymetod = $_POST['paymentmethod'];
if (!empty($_FILES['employee_img']['name'])) {
    $IMAGE =$_FILES['employee_img']['name'];
$originalExtension = pathinfo($IMAGE, PATHINFO_EXTENSION);
$employeenewimg= 'employee_images/' . uniqid() . '.' . $originalExtension;
move_uploaded_file($_FILES['employee_img']['tmp_name'], $employeenewimg);
} else {
$employeenewimg = $fetch_employee['profile_picture'];
}
if (!empty($_POST['password']) && !empty($_POST['cpassword'])) {
if ($_POST['password'] == $_POST['cpassword']) {
$passsword = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
echo '<script>Swal.fire({
title: "Pas de correspondance !",
text: "Votre nouveau mot de passe et la confirmation du mot de passe ne correspondent pas !",
icon: "question"
});</script>';

}
} elseif (empty($_POST['password']) && empty($_POST['cpassword'])) {
$passsword = $fetch_employee['password'];
} else {

echo '<script>Swal.fire({
title: "Obligatoire !",
text: "Nouveau mot de passe et confirmation du mot de passe requis !",
icon: "question"
});</script>';    

}
if (password_verify($_POST['currentpassword'], $fetch_employee['password'])) {
if (isset($passsword)) {
$result = $employees->update_employee($phone, $paymetod, $employeenewimg, $passsword);
if ($result) {
echo '<script>Swal.fire({
title: "Félicitations",
text: "Mise à jour réussie de vos informations.",
icon: "success"
});</script>';
} else {
echo '<script>Swal.fire({
title: "Veuillez réessayer!",
text: "Vous n avez pas mis à jour vos informations",
icon: "error"
});</script>';
}
}


}else{
echo '<script>Swal.fire({
title: "Veuillez réessayer!",
text: "Vos mots de passe ne correspondent pas !",
icon: "question"
});</script>';    

}
}
?>