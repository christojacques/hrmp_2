<?php
include_once 'header.php';
include_once 'private/leave_type_function.php';
?>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les vacances /</span> Gérer les types de congés</h4>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Ajouter un nouveau</button>
    <div class="row">
      <div class="card">
        <div class="card-body">
          <h4>Liste des types de congé</h4>
          <table class="table table-bordered table-responsive">
            <thead>
              <tr>
                <th>Type de congé</th>
                <th>Catégorie du congé</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?=$leavetype->showtypes();?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un nouveau type de congé</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Type de congé</label>
                <input type="text" name="typename" required class="form-control" id="typename">
              </div>
              <input type="radio" id="countable" name="type" required   value="countable">
<label for="countable">Jour déductible</label><br>
<input type="radio" id="non_countable" name="type"  required value="non_countable">
<label for="non_countable">Jour non déductible</label><br>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
              <button type="submit" name="addtype" class="btn btn-primary">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="edittype" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" id="editltype">
          
        </div>
      </div>
    </div>
    
  </div>
  <script src="js/jquery-3.7.0.js"></script>
  <script>
  $(document).on("click", "#edit-type",function() {
  $("#edittype").show();
  var typeid=$(this).data("edit");
  //console.log(timesid);
  $.ajax({
  url: 'edit-leave-type.php',
  type: 'post',
  data: {typesid: typeid},
  success: function (data) {
  //console.log(data)
  $("#editltype").html(data);
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
  <!-- / Content -->
  <?php include_once 'footer.php'; ?>