<?php include_once 'header.php';

$phid=base64_decode($_GET['id']);

$deleteholiday="DELETE FROM `public_holidays` WHERE `ph_id`=?";
$delh=$db->prepare($deleteholiday);
$delh->bind_param('i',$phid);
if ($delh->execute()) {
  echo '<script>Swal.fire({
title: "Successfully",
text: "Deleted Public Holiday.",
icon: "success"
}).then(function(){
  window.location.href="public_holiday.php";
});</script>';
}else{
    echo '<script>Swal.fire({
title: "Please Try Again!",
text: "Faild To Delete Public Holiday.",
icon: "error"
}).then(function(){
  window.location.href="public_holiday.php";
});</script>';

}
 ?>
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
           
            </div>
             

            <!-- / Content -->
}
<?php include_once 'footer.php'; ?>
