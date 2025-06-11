<?php 
include_once 'header.php';
include_once 'private/holiday_function.php';

 ?>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les vacances /</span> jours fériés</h4>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Ajouter un nouveau</button>
    <div class="row">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Liste des jours fériés</h4>
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>Jour férié</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $holidays->showholidays(); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un nouveau jour férié</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Jour férié</label>
                <input type="text" name="holidayname" required class="form-control" id="holidayname">
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Date</label>
                <input type="text" name="holidaydate" required class="form-control" id="holidaydate" placeholder="dd-mm-yyyy"  pattern="\d{2}-\d{2}-\d{4}" title="Please enter date in dd-mm-yyyy format">
              </div>
              
            
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="addholiday" class="btn btn-primary">Save</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="edittype" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" id="editltype">
          
        </div>
      </div>
    </div>

     <script src="js/jquery-3.7.0.js"></script>
    <script src="js/jquery-ui.min.js"></script>


<script>
  $(document).on("click", "#edit-type",function() {
  $("#edittype").show();
  var pholidayid=$(this).data("edit");
  //console.log(timesid);
  $.ajax({
  url: 'edit-public-holiday.php',
  type: 'post',
  data: {phid: pholidayid},
  success: function (data) {
  //console.log(data)
  $("#editltype").html(data);
  }
  });
  });
  </script>






  <script>
  $(document).ready(function() {
  $('#example').DataTable( {
  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
  });
  });

   $.noConflict();
    jQuery(document).ready(function($) {
    $("#holidaydate").datepicker({
    dateFormat: "dd-mm-yy"
    });
    });
    
  </script>


  <script>
    // Add event listener to the delete links
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior (i.e., navigating to the URL)

            const gid = this.getAttribute('data-hid'); // Retrieve the 'gid' attribute value

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: "Confirmation de suppression Êtes-vous sûr de vouloir supprimer votre demande ? Cette action est irréversible.",
                showCancelButton: true,
                confirmButtonText: "Confirmer",
                cancelButtonText: "Annuler",
                icon: "warning",
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms deletion, proceed with navigating to the deletion URL
                    window.location.href = this.href + "&gid=" + gid;
                } else {
                    // If user cancels deletion, do nothing
                    // Alternatively, you can display a message or perform other actions
                }
            });
        });
    });
</script>
    <!-- / Content -->
    <?php include_once 'footer.php'; ?>