<?php
include_once 'header.php';
include_once 'private/attendence_function.php';
?>
<link rel="stylesheet" href="js/jquery-ui.min.css">
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Attendence  / Manage Attendence /</span> View Attendence</h4>
    </div>
    
    <div class="card">
      <h5 class="card-header">Manage Employee Attendence</h5>
      <div class="table-responsive text-nowrap">
        <div class="card-body">
          
        </div>
      </div>
    </div>
  </div>
  <script src="js/jquery-3.7.0.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script>
  $(document).ready(function() {
  $('#example').DataTable( {
  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
  });
  });
  $.noConflict();
  jQuery(document).ready(function($) {
  $("#datepic").datepicker({
  dateFormat: "dd-mm-yy"
  });
  });
  </script>
  <!-- / Content -->
  <?php include_once 'footer.php'; ?>