<?php 
include_once 'header.php'; 
include_once 'private/weekly_work_function.php';


 ?>
 <link rel="stylesheet" href="js/jquery-ui.min.css">
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Collaborateurs /</span> Rapport hebdomadaire </h4>


            <div class="card">
              <div class="card-body">
                <h5>Liste des feuilles de temps hebdomadaires</h5>
               <div class="row mb-4">
                  <form method="post">
                  <input type="week" name="week" class="form-control-sm col-md-2" required>
                  <input type="submit" name="search" class="btn btn-sm btn-primary" value="Recherche">
                </form>
               </div>
                <table id="example" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Nom de l'employé</th>
                      <th>Fonction</th>
                      <th>Département</th>
                      <th>Numéro ou référence du contrat</th>
                      <th>Semaine</th>
                      <th>Temps total</th>
                      <th>Nombre de jours de suspension</th>
                      <th>Statut</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
                    if (isset($_POST['search'])) {
                         $week = $_POST['week'];
                        echo $weeklywork->showsubmitedwork($week);
                    }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
            </div>

             
<script src="js/jquery-3.7.0.js"></script>
<script src="js/jquery-ui.min.js"></script>
  <script>
  $(document).ready(function() {
  $('#example').DataTable( {
  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
  } );

  
    // $("#datepic").datepicker({
    // dateFormat: "dd-mm-yy"
    // });

  } );
  </script>


 <script>
// $(document).ready(function() {
//     $("#dayofex").on('change', function() { // Change event instead of keyup
//         var value = $(this).val(); // Use $(this) to refer to the current input field
//         console.log('Enter Value:', value);
//         var ws_id = $("#wsid").val();
//         console.log('Row ID:', ws_id);
//         $.ajax({
//           url: 'update_dayofex.php',
//           type: 'POST',
//           data: {ws_id: ws_id, value: value},
//           success: function(data){
//             console.log(data);
//           }
//         });
//     });
// });

$(document).ready(function() {
    $(".dayofex").on('change', function() { // Change event instead of keyup
        var value = $(this).val(); // Use $(this) to refer to the current input field
        console.log('Enter Value:', value);
        var ws_id = $(this).closest('tr').find(".wsid").val(); // Adjust to find the closest wsid in the same row
        console.log('Row ID:', ws_id);
        $.ajax({
          url: 'update_dayofex.php',
          type: 'POST',
          data: {ws_id: ws_id, value: value},
          success: function(data){
            console.log(data);
          }
        });
    });
}); 
</script> 


            <!-- / Content -->
<?php include_once 'footer.php'; ?>
