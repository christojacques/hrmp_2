<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php 
include_once 'private/protection.php';
$gid=base64_decode($_GET['id']);

$sql="DELETE FROM `guard` WHERE `gid`=?";
$stml=$db->prepare($sql);
$stml->bind_param('i',$gid);
    ?>
    
<script>
<?php
 if ($stml->execute()) {
    echo 'Swal.fire({
                title: "Successfully Deleted",
                text: "Successfuly Deleted Guard Informations.",
                icon: "success"
            }).then(function(){
                window.location.href = "manage-guard";
            });';

}else{
    echo 'Swal.fire({
                title: "Please Try Again!",
                text: "Faild To Deleted Guard Informations.",
                icon: "error"
            }).then(function(){
                window.location.href = "manage-guard";
            });';
}

?>
</script>
</body>
</html>