<?php 


include_once 'header.php';
include_once 'private/attendence_function.php';


 ?>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEFi0ukdX5djFwWXQYODn9DFwu6tZyNbo&callback=initMap" async defer></script>
 <link rel="stylesheet" href="js/jquery-ui.min.css">
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Bienvenue  <?=$fetch_employee['fname'].' '.$fetch_employee['lname']?>! 🎉 </h5>
                <p class="mb-4">
                  Bienvenue <?=$fetch_employee['fname'].' '.$fetch_employee['lname']?> sur votre espace d'administration des ressources humaines 🌟
Ici, vous disposez d'une gamme complète d'outils conçus pour faciliter la gestion quotidienne de vos employés 🕒 et optimiser les processus de ressources humaines au sein de votre organisation 💼
                </p>
               
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                src="assets/img/illustrations/man-with-laptop-light.png"
                height="140"
                alt="View Badge User"
                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                data-app-light-img="illustrations/man-with-laptop-light.png"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Order Statistics -->
        
        
      </div>
    </div>
     <?php if ($ma_module!=0) { ?>
    <div class="card">
      <h5 class="card-header">Présence des collaborateurs</h5>
      <div class="table-responsive text-nowrap">
        
        <div class="card-body">
          <form method="post" class="mb-5">
          <div class="form-group">
            <input type="text" id="datepic" name="date" placeholder="dd-mm-yyyy">
            <input type="submit" class="btn btn-sm btn-primary" name="search" value="Rechercher">
          </div>
        
        </form>
          <table class="table" id="example">
          <thead>
              <tr>
              <th>Collaborateur </th>
              <th>Date de naissance</th>
              <th>Fonction</th>
              <th>Date et heure d'entrée</th>
              <th>Date et heure de sortie</th>
              <th>Statut</th>
              <th>Voir</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php 
              if (isset($_POST['search'])) {
                $date=$_POST['date'];
                echo $attendence->showattendence($date);
              }else{
                $date=date('d-m-Y');
                echo $attendence->showattendence($date);
              }
            
             ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  <?php } ?>
    </div>




<!-- Modal -->
<div class="modal fade" id="attendenceinfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Détails de la participation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="card-title">Entrée</h4>
        <strong>Capturer la photo</strong>
        
        
        <div class="row">
          <div class="col">
            <img src="" id="entryimg" alt="" style="width: 100%;height: 200px;">
          </div>
          <div class="col">
            <div id="mapentry" style="height: 200px; width: 100%;"></div> <!-- Entry map -->
          </div>
        </div>
        <hr>
        <h4 class="card-title">Sortie</h4>
        <strong>Capturer la photo</strong>
        <div class="row">
          <div class="col">
            <img src="" id="exitimg" alt="" style="width: 100%;height: 200px;">
          </div>
          <div class="col">
            <div id="mapexit" style="height: 200px; width: 100%;"></div> <!-- Exit map -->
          </div>
        </div>
        
        
      </div>
    </div>
  </div>
</div>

    <script src="js/jquery-3.7.0.js"></script>
    <script src="js/jquery-ui.min.js"></script>
 <script>
    $(document).ready(function() {
        $('#example').DataTable({
            order: [[ 3, 'desc' ], [ 0, 'asc' ]],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'  // URL for French translations
            }
        });
    });
</script>
<script>
$(document).on("click", ".attendenceinfo", function () {
    var attid = $(this).data("attid");

    // 🔴 **CLEAR PREVIOUS DATA BEFORE LOADING NEW DATA**
    $("#entryimg").attr("src", ""); 
    $("#exitimg").attr("src", ""); 
    $("#mapentry").html("").css("background", "#f0f0f0"); // Reset map container
    $("#mapexit").html("").css("background", "#f0f0f0"); // Reset map container

    $.ajax({
        url: "attendencemapview.php",
        type: "POST",
        data: { attdenceid: attid },
        success: function (response) {
            try {
                var datas = JSON.parse(response);
                console.log(datas); // Debugging

                if (Array.isArray(datas) && datas.length > 0) {
                    let entryFound = false, exitFound = false;

                    datas.forEach(function (data) {
                        if (data.attend_type === "Entry" && !entryFound) {
                            $("#entryimg").attr("src", '../guard/attendance_photo/' + data.phtoto);
                            let [lat, lng] = data.takeinfo.split(",").map(Number);
                            setTimeout(() => initMap('mapentry', lat, lng), 500); // 🔵 Delay to ensure reset
                            entryFound = true;
                        } 
                        if (data.attend_type === "Exit" && !exitFound) {
                            $("#exitimg").attr("src", '../guard/attendance_photo/' + data.phtoto);
                            let [lat, lng] = data.takeinfo.split(",").map(Number);
                            setTimeout(() => initMap('mapexit', lat, lng), 500); // 🔵 Delay to ensure reset
                            exitFound = true;
                        }
                    });

                    if (!entryFound) $("#entryimg").attr("src", '../guard/attendance_photo/no_entry.png');
                    if (!exitFound) $("#exitimg").attr("src", '../guard/attendance_photo/no_exit.png');
                } else {
                    console.log("No attendance records found.");
                }
            } catch (error) {
                console.error("Error parsing response: ", error);
            }
        },
        error: function (xhr, status, error) {
            console.log("AJAX Error: " + error);
        }
    });
});

// 🔴 **RESET MODAL WHEN CLOSED**
$('#attendenceinfo').on('hidden.bs.modal', function () {
    $("#entryimg").attr("src", ""); 
    $("#exitimg").attr("src", ""); 
    $("#mapentry").html("").css("background", "#f0f0f0");
    $("#mapexit").html("").css("background", "#f0f0f0");
});

// **Google Map Initialization (Ensures New Data is Loaded)**
function initMap(mapId, lat, lng) {
    $("#" + mapId).html(""); // Clear map div before adding a new one

    setTimeout(() => {
        const location = { lat: lat, lng: lng };

        const map = new google.maps.Map(document.getElementById(mapId), {
            zoom: 16,
            center: location,
        });

        new google.maps.Marker({
            position: location,
            map: map,
        });
    }, 500); // Small delay ensures the map is properly reset
}

// **Datepicker Initialization**
$.noConflict();
jQuery(document).ready(function ($) {
    $("#datepic").datepicker({
        dateFormat: "dd-mm-yy"
    });
});


  </script>




    <!-- / Content -->
    <?php include_once 'footer.php'; ?>