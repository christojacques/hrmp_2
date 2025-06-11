<?php 
include_once 'header.php';
include_once 'private/leave_type_function.php';

 ?>
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
             <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les vacances /</span> Demande de congé</h4>
              <div class="row">
                <div class="card table-responsive">
                  <div class="card-body">
                    <h4>Liste des demandes de congé des employés</h4>
                    <table class="table table-bordered" id="example">
                      <thead>
                        <tr>
                          <th style="display: none;">Create Date</th>
                          <th>Collaborateur</th>
                          <th>Type de congé</th>
                          <th>Date de début</th>
                          <th>Date de fin</th>
                          <th>Nombre des jours</th>
                          <th>Raison</th>
                          <th>Documents</th>
                          <th>Statut</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?=$leavetype->showleaverequest();?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
 <script src="js/jquery-3.7.0.js"></script>             
<script>
   $(document).ready(function() {
        $('#example').DataTable({
            columnDefs: [
                {
                    targets: [0], // Index of the hidden column
                    visible: false,
                    searchable: false
                }
            ],
            order: [[0, 'desc']], // Change '3' to the correct index of create_date column
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
            }
        });
    });
</script>
            <!-- / Content -->
<?php include_once 'footer.php'; ?>
