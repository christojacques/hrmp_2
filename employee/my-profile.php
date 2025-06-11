<?php
include_once 'header.php';
include_once 'private/employee_function.php';
?>
<div class="main-panel">
  <div class="content-wrapper">
    
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h2 class="text-left mb-3">Informations sur mon profil</h2>
            <div class="d-flex align-items-start align-items-sm-center gap-4 mb-5">
              
              <img src="<?=$img;?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
            </div>
            <form class="form-sample" method="post" enctype="multipart/form-data">
              <h4 class="text-left">Informations personnelles</h4>
              <div class="row mt-5">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Prénom</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['fname'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nom de famille</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['lname'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Courriel</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['email'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Date de naissance</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['dob'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Titre du poste</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['job_title'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Numéro de contrat</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['contract_no'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Début du contrat</label>
                    <div class="col-sm-8">
                      <input type="month" required class="form-control" value="<?=$fetch_employee['contract_start'];?>" disabled="disabled">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Fin du contrat</label>
                    <div class="col-sm-8">
                      <input type="month" required class="form-control" value="<?=$fetch_employee['contract_end'];?>" disabled="disabled">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Type de contrat</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['contract_type'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Département</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['department'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Attribution du projet</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['project_assign'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Affectation de l'unité</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['unit_assign'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Numéro de compte bancaire</label>
                    <div class="col-sm-8">
                      <input type="text"   value="<?=$fetch_employee['bank_account'];?>"class="form-control" disabled="disabled" >
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Préférence pour le paiement</label>
                    <div class="col-sm-8">
                      <select name="paymentmethod" required class="form-select-lg col-12">
                        <option value="<?=$fetch_employee['payment_method'];?>"><?=$fetch_employee['payment_method'];?></option>
                        <option value="Check">Check</option>
                        <option value="Bank">Bank</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Mise à jour de la photo de profil</label>
                    <div class="col-sm-8">
                      <input type="file" name="employee_img" accept="image/png,image/jpg,image/jpeg"  class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Téléphone</label>
                    <div class="col-sm-8">
                      <input type="text" name="phone" value="<?=$fetch_employee['phone'];?>" required class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                
                <div class="col-md-12">
                  <div class="form-group row" style="align-items: center;">
                    <label class="col-sm-4 col-form-label">Modifier le mot de passe</label>
                    <div class="col-sm-8">
                      <input type="password" name="password" maxlength="6" minlength="6" pattern="[0-9]{6}" title="Please enter a 6-digit numeric password" class="form-control mb-3" placeholder="New password">
                      <input type="password" name="cpassword" maxlength="6" minlength="6" pattern="[0-9]{6}" title="Please enter a 6-digit numeric password" class="form-control" placeholder="Confirm password">
                    </div>
                  </div>
                </div>
                <!--  <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-9">
                      <input type="password" name="cpassword"  class="form-control">
                    </div>
                  </div>
                </div> -->
              </div>
              
              <div class="row">
                <div class="col">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                  Confirmer
                  </button>
                  <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel1">Confirmez votre mot de passe</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col mb-3">
                              <label for="nameBasic" class="form-label">Tapez votre mot de passe</label>
                              <input type="password" name="currentpassword"  class="form-control" required>
                            </div>
                          </div>
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                          Fermer
                          </button>
                          <input type="submit" name="update_employee" class="btn btn-primary btn-sm" value="Confirmer">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <input type="submit" name="update_employee" class="btn btn-primary btn-sm" value="Save Chanages"> -->
                </div>
              </div>
              
            </form>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
  <?php include_once 'footer.php'; ?>