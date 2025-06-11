<?php
include_once 'header.php';
include_once 'private/attendence_function.php';
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEFi0ukdX5djFwWXQYODn9DFwu6tZyNbo" async defer></script>
<style>
@media (max-width: 767px) {
.content-wrapper {
padding: 0;
}
.card-body {
padding: 10px !important;
}
}
.card-title{
color: white !important;
}
.card-text{
font-size: 18px;
}
input[type="search"] {width: 98%;height: 35px;}
#map {
height: 100px;
width: 100%;
}
video {
width: 100%;
height: auto;
border: 1px solid #ddd;
border-radius: 8px;
margin-bottom: 10px;
}
</style>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="row">
          <h3 class="font-weight-bold">Bienvenue  <?=$gardfetch['guard_name'];?></h3>
        </div>
      </div>
    </div>
    <div class="row">
      <?php $attendence->getempldetails(); ?>
    </div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="" style="color:black;">Liste des collaborateurs</h4>
            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table id="employeelist" class="table">
                    <!-- id="example" -->
                    <thead>
                      <tr>
                        <th>Nom du collaborateur</th>
                        <th>Date de naissance</th>
                        <th>Fonction</th>
                        <th>Action</th>
                        <th>Date et heure d’entrée</th>
                        <th>Date et heure de sortie</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <?=$attendence->showemployees();?>
                      <!-- Add more rows as needed -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Model entry -->
  <div class="modal fade" id="entryModal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="entryModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="text-center" id="title"></h5>
       <label for="inputPassword5" class="form-label">Mot de passe</label>
         <div class="input-group">
          
        <input type="password" id="inputPassword5" class="form-control" placeholder="Entrez votre mot de passe">
        <span class="input-group-text cursor-pointer" id="togglePassword" onclick="togglePasswordVisibility()"><i class="mdi mdi-eye-off"></i></span>
       </div>
       <input type="hidden" id="security">
      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button id="confirmpass" name="confirmpass" class="btn btn-primary">Confirmer</button>
      </div>
    </div>
  </div>
</div>
<!-- Model entry -->



  <!-- Model entry -->
  <div class="modal fade" id="entryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="entryModalLabel1"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="text-center" id="title1"></h5>
          <div class="row">
            <div class="col-md-6">
              <div id="cameraContainer">
              <video id="videoElement" autoplay style="width: 100%; border: 1px solid #ccc;"></video>
            </div>
          </div>
          <div class="col-md-6">
            <div id="map" style="height: 270px; width: 100%;"></div>
          </div>
        </div>
        <div class="d-flex justify-content-between mt-3">
          <button id="switchCamera" class="btn btn-secondary">Passer à la caméra avant/arrière</button>
          <button id="capturePhoto" class="btn btn-success">Confirmer</button>
        </div>
        <input type="hidden" id="empid">
        <input type="hidden" id="latitude">
        <input type="hidden" id="longitude">
        <input type="hidden" id="security">
        <input type="hidden" id="status">
      </div>
    </div>
  </div>
</div>
<!-- Model entry -->
<!-- Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content text-center p-4" style="align-items: center;">
      <div class="spinner-border text-primary mb-3" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p>Veuillez patienter...</p>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<script type="text/javascript">
  $(document).ready(function() {
      $('#employeelist').DataTable({
          order: [[ 3, 'desc' ], [ 0, 'asc' ]],
          language: {
              url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'  // URL for French translations
          }
      });
  });
</script>

<script>
$(document).on("click", ".entry-btn",function() {
var empid=$(this).data("id");
var empnm=$(this).data("name");
var empsec=$(this).data("security");
var model=$(this).data("model");

$("#security").val(empsec);
$("#empid").val(empid);
$("#status").val(model);
 if (model=="Entry") {
   var model='l’entrée';
 }else{
    var model='la sortie';
 }
var entryModalLabel='Enregistrement de '+model;
var title='Confirmez l’enregistrement de '+model+' de '+empnm+' en saisissant votre mot de passe';
var title1='Enregistrement de votre photo et de votre localisation';

$("#title").text(title);
$("#title1").text(title1);
$("#entryModalLabel").text(entryModalLabel);
$("#entryModalLabel1").text(entryModalLabel);

});

</script>
<script>
function togglePasswordVisibility() {
const passwordInput = document.getElementById("inputPassword5");
const togglePasswordButton = document.getElementById("togglePassword");
if (passwordInput.type === "password") {
passwordInput.type = "text";
togglePasswordButton.innerHTML = "<i class='mdi mdi-eye'>";
} else {
passwordInput.type = "password";
togglePasswordButton.innerHTML = "<i class='mdi mdi-eye-off'></i>";
}
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const confirmButton = document.getElementById('capturePhoto'); // The button
    const formModalEl = document.getElementById('entryModal');     // The form modal
    const progressModalEl = document.getElementById('progressModal');

    confirmButton.addEventListener('click', function () {
        // Show the progress modal
        const progressModal = new bootstrap.Modal(progressModalEl);
        progressModal.show();

        // Hide the form modal (if it's still open)
        const formModal = bootstrap.Modal.getInstance(formModalEl);
        if (formModal) formModal.hide();

    });
});
</script>


<script src="nhpiash.js"></script>
<!-- content-wrapper ends -->
<?php include_once 'footer.php'; ?>