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
      
    </div>
    
    <div class="card">
      <h5 class="card-header">Gérer la présence des Collaborateurs</h5>
      <div class="table-responsive text-nowrap">
        
        <div class="card-body">
          <form method="post" class="mb-5">
            <div class="form-group">

              <label>Date de début:</label>
              <input type="text" id="sdatepic"  name="sdate" placeholder="dd-mm-yyyy">
              <label >Date de fin:</label>
              <input type="text" id="edatepic"  name="edate" placeholder="dd-mm-yyyy">
              <input type="submit" class="btn btn-sm btn-primary" name="search" value="Rechercher">
            </div>
             
            
          </form>
          <table class="table" id="example">
           
            <thead>
              <tr>
                <th><input type="checkbox" id="selectAll" class="form-check" name="allattend"></th>
                <th>Collaborateurs</th>
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
                $sdate = date('Y-m-d', strtotime($_POST['sdate']));
                $edate = (!empty($_POST['edate'])) ? date('Y-m-d', strtotime($_POST['edate'])) : null;
                echo $attendence->showattendemployee($sdate, $edate);
                } else {
                $sdate = date('Y-m-d'); // default today in correct format
                $edate = null;
                echo $attendence->showattendemployee($sdate, $edate);
                }
              ?>
            </tbody>
          </table>

          <button class="btn btn-danger m-2"  data-bs-toggle="modal" data-bs-target="#freestorage">Libérer la mémoire</button>
        </div>
      </div>
    </div>
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




<!-- Modal Free Storage -->
<div class="modal fade" id="freestorage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Libérer de l’espace en supprimant des photos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <h4 class="card-title">Voulez-vous supprimer les photos associées aux entrées et sorties sélectionnées dans le système ?<br>
✅ Seules les photos seront supprimées. Les informations de localisation, l’heure d’entrée et l’heure de sortie resteront enregistrées et ne seront pas affectées.<br>
ℹ️ Pourquoi cette action ? La suppression des photos permet de libérer de l’espace de stockage lorsque le système commence à en accumuler trop. <br>
Cette opération n’a aucun impact sur les autres données de présence, qui restent toujours accessibles.</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" id="deleteSelected" class="btn btn-primary">Confirmer</button>
      </div>
    </div>
  </div>
</div>











  
  <script src="js/jquery-3.7.0.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
  <script src="js/jquery-ui.min.js"></script>
  <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->
  <script src="js/suppress-console.js"></script>


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
<script type="text/javascript">

jQuery(document).ready(function($) {
    $("#sdatepic").datepicker({ dateFormat: "dd-mm-yy" });
    $("#edatepic").datepicker({ dateFormat: "dd-mm-yy" });
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
// $.noConflict();
// jQuery(document).ready(function ($) {
//     $("#datepic").datepicker({
//         dateFormat: "dd-mm-yy"
//     });
// });


  </script>

  <script type="text/javascript">
    $(document).ready(function () {
    // Select All functionality
    $('#selectAll').on('change', function () {
        $('.indattend').prop('checked', this.checked);
    });

    // Update "Select All" checkbox state based on individual checkbox changes
    $('.indattend').on('change', function () {
        if ($('.indattend:checked').length === $('.indattend').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });

    // Delete selected records
    $('#deleteSelected').on('click', function () {
        // Collect selected IDs
        let selectedIds = [];
        $('.indattend:checked').each(function () {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            alert('Please select at least one record to delete.');
            return;
        }
        $("#freestorage").modal('hide');
        $.ajax({
            url: 'free-storage.php',
            type: 'POST',
            data: { attendance_ids: selectedIds },
            success: function (response) {
             //console.log(response);
             
               Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Selected records deleted successfully!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // Refresh the page or update the table dynamically
                });
            },
            error: function () {
                alert('An error occurred while processing your request.');
            }
        });

        
    });
});

  </script>
  <!-- / Content -->
  <?php include_once 'footer.php'; ?>