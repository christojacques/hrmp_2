<?php 
include_once 'header.php';
include_once 'private/advance_function.php';
$empassid=base64_decode($_GET['id']);

?>
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les salaires /</span> Ajustement de la rémunération</h4>
        <?php if ($_SESSION['employee_role']=='FINANCIAL DIRECTOR') {
            echo '<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Attribuer un salaire supplémentaire</button>';
        } ?>
      
        <div class="card table-responsive" >
            <div class="card-body">
                <table class="table table-bordered" id="example">
                    <thead>
                        <tr>
                            <th>Collaborateurs</th>
                            <th>MOIS</th>
                            <th>AVANCE ACCORDÉE</th>
                            <th>DÉDUCTION</th>
                            <th>BONUS / AUTRES</th>
                            <th>Effectué par le comptable</th>
                            <th>Révisé par la DRH</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $advance->showadvance($empassid); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajustement de la rémunération</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Mois:</label>
                                <input type="month" class="form-control" id="month" name="month" required>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Avance accordée:</label>
                                <input type="text" class="form-control" id="amount" name="asamount" required>
                            </div>
                             <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Déduction:</label>
                                <input type="text" class="form-control" id="amount" name="dsamount" required>
                            </div> 
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Bonus ou autres avantages:</label>
                                <input type="text" class="form-control" id="amount" name="bsamount" required>
                            </div>
                            <input type="hidden" name="adminid" hidden value="<?=$employeeid;?>" required> 
                            <input type="hidden" name="empid" hidden value="<?=$empassid;?>" required>
                           
                        
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" name="addadvance" class="btn btn-primary">Confirmer</button>
                        </div>
                        </form>
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
    //   $("#datepic").datepicker({
    // dateFormat: "dd-mm-yy"
    // });


$(document).on('change', '#drhstatus', function() {
    // Get the value of the selected option
    var status = $(this).val();
    
    // Get the parent <tr> element's exs_id attribute
    var exsId = $(this).closest('tr').data('exs-id');
    
    // Now you have the status and the exs_id, you can perform further actions as needed
   // console.log('Status changed to ' + status + ' for row with exs_id ' + exsId);

    $.ajax({
            url: 'private/advance_function.php',
            type: 'post',
            data: {status: status, id: exsId},
            success: function (data) {
                
            }
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
        <?php include_once 'footer.php';?>