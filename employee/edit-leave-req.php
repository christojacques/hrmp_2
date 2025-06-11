<?php 
include_once 'header.php';
include_once 'private/leave_function.php';
$levreq=base64_decode($_GET['id']);
$signleresult=$leaves->getsingleleave($levreq);

 ?>

      <div class="main-panel">
        <div class="content-wrapper">
          
         <div class="row">
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Type</label>
                        <select name="type" class="form-control col" id="type" required>
                            <option value="<?=$signleresult['leave_type']?>"><?=$signleresult['leave_type']?></option>
                            <?=$leaves->showleavetypes(); ?>
                        </select>
                        <input type="hidden" value="<?=$levreq?>" hidden name="lrid"> 
                      
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="form-label">Date de début</label>
                            <input type="text" id="start" name="starts" class="form-control col" value="<?=$signleresult['start_date']?>" placeholder="dd-mm-yyyy" required>
                            <select name="startwhen" class="form-control col" id="startwhen" required>

                                <?php 
                                    if ($signleresult['start_part']=="Morning") {
                                        echo '<option value="Morning">Matin</option>';
                                        echo '<option value="Afternoon">Après-midi</option>';
                                    }elseif ($signleresult['start_part']=="Afternoon") {
                                        echo '<option value="Afternoon">Après-midi</option>';
                                        echo '<option value="Morning">Matin</option>';
                                    }
                                 ?>
                                
                                
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Date de fin</label>
                            <input type="text" id="end" name="ends" class="form-control col" value="<?=$signleresult['end_date']?>" placeholder="dd-mm-yyyy">
                            <select name="endwhen" class="form-control col" id="endwhen" required>
                               
                                <?php 
                                    if ($signleresult['end_part']=="Lunchtime") {
                                        echo '<option value="Lunchtime">Heure du déjeuner</option>';
                                        echo '<option value="End Of Day">Fin de journée</option>';

                                    }elseif ($signleresult['end_part']=="End Of Day") {
                                        echo '<option value="End Of Day">Fin de journée</option>';
                                        echo '<option value="Lunchtime">Heure du déjeuner</option>';

                                    }
                                 ?>
                            </select>
                        </div>
                        
                        
                        
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="" class="form-label mt-3">Raison</label>
                            <textarea name="reason" class="form-control" id="reason" cols="30" rows="5" required><?=$signleresult['leave_reason']?></textarea>
                        </div>
                        
                    </div>
                    <textarea type="hidden" id="totalday" name="totalday" hidden><?=$signleresult['totaldays']?></textarea>
                    <strong id="days" class="mt-3 mb-3">Déduction de <?=$signleresult['totaldays']?> jours de l'allocation de congé annuel.</strong>
                    <input type="submit" name="updatereq" class="btn btn-primary btn-sm col-md-2" value="Enregistrer les modifications">
                </div>
            </form>
                </div>
            </div>
         </div>
        </div>

<script src="date/jquery-3.7.0.js"></script>
<script src="date/jquery-ui.min.js"></script>

<script >
    $.noConflict();
    jQuery(document).ready(function($) {
    $("#start").datepicker({
    dateFormat: "dd-mm-yy"
    });
    $("#end").datepicker({
    dateFormat: "dd-mm-yy"
    });
    // $("#start").on('change', function() {
    //     var start = $(this).val();
    //     //console.log(start);
    // });
    $("#end").on('change', function() {
        var starts = $("#start").val();
        var whens = $("#startwhen").val();
        var whene = $("#endwhen").val();
        var ends = $(this).val();
    $.ajax({
        url: 'private/leave_function.php',
        type: 'POST',
        data: {start: starts, end: ends, ws: whens, we: whene},
        success:function (data) {
            //console.log(data);
            
                var da="Déduction de "+data+" jours de l'allocation de congé annuel.";
                //console.log(da);
                $("#days").html(da);
                $("#totalday").html(data);
            
            
        }
    });
    
    
    });
    function whenchnage(){
        var starts = $("#start").val();
        var whens = $("#startwhen").val();
        var whene = $("#endwhen").val();
        var ends = $("#end").val();
    $.ajax({
        url: 'private/leave_function.php',
        type: 'POST',
        data: {start: starts, end: ends, ws: whens, we: whene},
        success:function (data) {
            //console.log(data);
            
                var da="Déduction de "+data+" jours de l'allocation de congé annuel.";
                //console.log(da);
                $("#days").html(da);
                $("#totalday").html(data);
            
            
        }
    });
    }
    // $("#start").on('change', function() {
        //  whenchnage();
    // });
    $("#startwhen").on('change', function() {
        whenchnage();
    });
    $("#endwhen").on('change', function() {
        whenchnage();
    });
    });
    </script>











    <script>
    // Add event listener to the delete links
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior (i.e., navigating to the URL)

            const gid = this.getAttribute('data-ltid'); // Retrieve the 'gid' attribute value

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
        <!-- content-wrapper ends -->
<?php include_once 'footer.php'; ?>      