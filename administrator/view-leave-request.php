<?php 

include_once 'header.php';
include_once 'private/leave_type_function.php';

$lrid=base64_decode($_GET['id']);

 ?>
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
             <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gérer les employés /</span> Rapport de travail hebdomadaire</h4>
             <div class="row">
               <div class="card">
                 <div class="card-body">
                   <h4>Demande de congé d'un collaborateur</h4>
                  
                 <?php $leavetype->getrequestdetails($lrid); ?>
                 
                 </div>
               </div>
             </div>
            </div>
             

            <!-- / Content -->
<?php include_once 'footer.php'; ?>
