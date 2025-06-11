<?php
include_once 'header.php';
include_once 'private/employee_function.php';
$getid=base64_decode($_GET['id']);
$getemino=$employee->singleemployee($getid);


if (!empty($getemino['profile_picture'])) {
  $getstufimg=$getemino['profile_picture'];
}else{
  $getstufimg="employee_images/demo-avther.png";
}
?>
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
      <h5 class="card-header">Détails du profil de l'employé</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="../employee/<?=$getstufimg;?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
          
        </div>
      </div>
      <hr class="my-0">
      <div class="card-body">
        <form id="formAccountSettings" method="POST">
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="firstName" class="form-label">Prénom</label>
            <input class="form-control" type="text" id="firstName"  value="<?=$getemino['fname'];?>" readonly>
            
          </div>
          <div class="mb-3 col-md-6">
            <label for="lastName" class="form-label">Nom de famille</label>
            <input class="form-control" type="text"  id="lastName" value="<?=$getemino['lname'];?>" readonly>
          </div>
          <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Courrier électronique</label>
            <input class="form-control" type="text" name="emailadd"  value="<?=$getemino['email'];?>" readonly>
          </div>
          <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Téléphone</label>
            <input class="form-control" type="text" id="phone" value="<?=$getemino['phone'];?>"  readonly>
          </div>
          <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Date de naissance</label>
            <input class="form-control" type="date" id="dob" value="<?=$getemino['dob'];?>" readonly>
          </div>
          <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Fonction</label>
            <input class="form-control" type="text" id="jobtitle" name="jobtitle" value="<?=$getemino['job_title'];?>">
          </div>
         
          <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Date de début de contrat</label>
            <input class="form-control" type="month" id="dob" name="con_start" value="<?=$getemino['contract_start'];?>"  >
          </div>
          <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Date de fin de contract</label>
            <input class="form-control" type="month" id="dob" name="con_end" value="<?=$getemino['contract_end'];?>" >
          </div>
           <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Numéro ou référence du contrat</label>
            <input class="form-control" type="text" id="dob" name="con_no" value="<?=$getemino['contract_no'];?>">
          </div>
          <div class="mb-3 col-md-6">
            <label for="organization" class="form-label">Type de contrat</label>
            <input type="text" class="form-control" id="organization" name="con_type" value="<?=$getemino['contract_type'];?>">
          </div>
          <div class="mb-3 col-md-6">
            <label for="organization" class="form-label">Département</label>
            <input type="text" class="form-control" id="organization" name="department" value="<?=$getemino['department'];?>" >
          </div>
          <div class="mb-3 col-md-6">
            <label for="organization" class="form-label">Attribution du projet</label>
            <input type="text" class="form-control" id="organization" name="pro_assign" value="<?=$getemino['project_assign'];?>" >
          </div>
          <div class="mb-3 col-md-6">
            <label for="organization" class="form-label">Affectation de l'unité</label>
            <input type="text" class="form-control" id="organization" name="unit_assign" value="<?=$getemino['unit_assign'];?>">
          </div>
          <div class="mb-3 col-md-6">
            <label for="organization" class="form-label">Numéro de compte bancaire</label>
            <input type="text" class="form-control" id="organization" name="bank_ac" value="<?=$getemino['bank_account'];?>">
          </div>
          <div class="mb-3 col-md-6">
            <label for="organization" class="form-label">Nom de la banque</label>
             <input type="text" class="form-control"  value="<?=$getemino['bank_name'];?>" disabled="disabled">
          </div>
           <div class="mb-3 col-md-6">
            <label for="organization" class="form-label">Préférence pour le paiement</label>
          <?php
            $payby = ''; // default value
            if ($getemino['payment_method'] == "Check") {
            $payby = "Chèque";
            } elseif ($getemino['payment_method'] == "Bank") {
            $payby = "Banque";
            }
          ?>
             <input type="text" class="form-control"  value="<?=$payby;?>" disabled="disabled">
          </div>
          
        </div>
        <hr class="my-0">
       
        <div class="row">
          <h5 class="card-header">Espace administrateur</h5>
           <input type="hidden" name="employeeid" value="<?=$getid;?>" required>
<?php 
if ($mp_module!=0) { ?>
            <div class="mb-3 col-md-4">
              <label for="organization" class="form-label">Salaire mensuel brut</label>
              <input type="text" class="form-control" value="<?=$getemino['monthly_salary'];?>"  required  name="annual" placeholder="Monthly Salary">
             
            </div>
<?php }else{
echo '<input type="hidden" name="annual" value="0" required hidden>';
 }
if ($lm_module!=0) {?>          
            <div class="mb-3 col-md-4">
              <label for="organization" class="form-label">Attribuer des vacances</label>
              <input type="text" class="form-control" value="<?=$getemino['total_holiday'];?>"  required  name="holiday" placeholder="Assign total holiday">
            </div>
<?php }else{
  echo '<input type="hidden" name="holiday" value="0" required hidden>';
} ?>
            <div class="mb-3 col-md-6">
              <label for="organization" class="form-label">Statut du compte</label>
              <select name="status" class="form-control" required>
                 <?php 
            if (!empty($getemino['account_status'])) {
            // Translate "active" to "Actif" and "inactive" to "Inactif"
            $translatedStatus = ($getemino['account_status'] == "active") ? "Actif" : "Inactif";
            echo '<option value="' . $getemino['account_status'] . '" selected>' . $translatedStatus . '</option>';
            } else {
            echo '<option value="" selected>Sélectionner le statut</option>';
            }
            ?>
            <option value="active">Actif</option>
            <option value="inactive">Inactif</option>
              </select>
            </div>
            <div class="mb-3 col-md-6">
              <label for="organization" class="form-label">Rôle de l'employé</label>
              <select name="employe_role" class="form-control" required>
                 <?php if (!empty($getemino['employee_role'])) {
                 echo '<option value="'.$getemino['employee_role'].'">'. 
             (($getemino['employee_role'] == "employee") ? "Collaborateur" : strtoupper($getemino['employee_role'])) .
             '</option>';
                }else{
                  echo '<option value="">Sélectionnez le rôle</option>';
                } ?>
                <option value="employee">Collaborateur</option>
                <option value="DRH">DRH</option>
                <?php 
if ($mp_module!=0 && $ts_module!=0) { ?>
                <option value="Treasurer">Treasurer</option>
                <option value="CEO">CEO</option>
                <option value="FINANCIAL DIRECTOR">FINANCIAL DIRECTOR</option>
 <?php }?>                
              </select>
            </div>
           <!--  <div class="mb-3 col-md-6">
              <label for="organization" class="form-label">Your Password</label>
             
              <input type="password" class="form-control"   required  name="mypassword" placeholder="Type your password to update Employee Details.">
             
            </div> -->
          </div>
          <div class="mt-2">
            <!-- <button type="submit" name="update_employee" class="btn btn-primary me-2">Save changes</button> -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Enregistrer les modifications
                </button>
          </div>
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmez votre mot de passe</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div>
                        <label for="password" class="form-label">TTapez votre mot de passe</label>
                        <input class="form-control" type="password" name="mypassword" placeholder="Saisissez votre mot de passe pour mettre à jour les détails de l'employé."  required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      
                      <button type="submit" class="btn btn-primary" name="update_employee">Confirmé</button>
                    </div>
                  </div>
                </div>
              </div>
        </form>
      </div>
      <!-- /Account -->
    </div>
  </div>
  <?php include_once 'footer.php' ?>