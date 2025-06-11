<?php include_once 'header.php';




if (isset($_POST['signed'])) {
    $folderPath = "signature-img/";
    $image_parts = explode(";base64,", $_POST['signed']); 
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = $folderPath . uniqid() . '.'.$image_type;
    //echo '<img src="'.$image_base64.'" alt="" width="200" height="200">';
    $upload=file_put_contents($file, $image_base64);
    if ($upload) {
      $signupquery=mysqli_query($db,"UPDATE `employees` SET `emp_signature`='$file' WHERE `eid`='$employeeid'");
      if ($signupquery) {
        echo '<script>
            Swal.fire({
    title: "Parfait",
    text: "La modification de votre signature a bien été prise en compte.",
    icon: "success"
    }).then(function(){
      window.location.href="my-signature";
    });</script>';
      }else{
        echo "<script>alert('Signature Information Not Saved.');window.location.href='my-signature';</script>";
      }
    }else{
       echo "<script>alert('Signature File Not Uploaded.');window.location.href='my-signature';</script>";
    }

    
}











 ?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript" src="e-signature/asset/jquery.signature.min.js"></script>
<link rel="stylesheet" type="text/css" href="e-signature/asset/jquery.signature.css">

<style>
.kbw-signature { width:400px; height: 250px;}
#sig canvas{
width: 100% !important;
height: auto;
}
</style>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestion de la rémunération /</span> Ma signature</h4>
    <div class="card text-center">
      <div class="card-body">
        <form method="POST">
          <div class="row">
            <div class="col-md-6">
            <label class="" for="">Nouvelle signature:</label>
            <br/>
            <div id="sig" ></div>
            <br/>
           
            <textarea id="signature64" name="signed" style="display: none"></textarea>
          </div>
           <div class="col-md-6 border-opacity-10">
            <label class="" for="">Signature actuelle:</label>
            <a href="<?=$fetch_employee['emp_signature'];?>" download>
           <img src="<?=$fetch_employee['emp_signature'];?>" width="400" height="250" style="border: 1px solid #ddd;">
           </a>
          </div>
          </div>
          
          
          <br/>
          <button class="btn btn-primary">Confirmer</button>
           <button id="clear" class="btn btn-warning">Effacer</button>
        </form>
      </div>
    </div>
  </div>
  
  <script type="text/javascript">
  var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
  $('#clear').click(function(e) {
  e.preventDefault();
  sig.signature('clear');
  $("#signature64").val('');
  });
  </script>      <!-- / Content -->
  <?php include_once 'footer.php'; ?>