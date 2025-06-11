<?php 

include_once 'header.php';
include_once 'module_function.php';

$modulelist=$module->showmodule();



 ?>
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <!-- Notifications -->
          <h5 class="card-header">The System Module Flexibility</h5>
          <div class="card-body">
            <span>We need permission from your browser to show notifications.
              <span class="notificationRequest"><strong>Request Permission</strong></span></span>
              <div class="error"></div>
            </div>

            <div class="table-responsive">
              <h4 class="card-title text-primary mt-3">GUARD PANEL</h4>
              <table class="table table-striped table-borderless border-bottom">
                <thead>
                  <tr>
                    <th class="text-nowrap">Module  Type</th>
                    <th class="text-nowrap text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  foreach ($modulelist as $listvalue) {
                      if ($listvalue['mf_id']==1) { 
                          $checked = ($listvalue['module_status'] == 1) ? "checked" : ""; // Check if active
                          echo '
                          <tr>
                              <td class="text-nowrap">'.htmlspecialchars($listvalue['module_name']).'</td>
                              <td>
                                  <div class="form-check d-flex justify-content-center">
                                      <input class="form-check-input module-status" type="checkbox" '.$checked.' value="'.$listvalue['mf_id'].'">
                                  </div>
                              </td>
                          </tr>
                          ';
                      }
                  }
                ?> 

                </tbody>
              </table>
              <h4 class="card-title text-primary mt-3">ADMINISTRATOR PANEL</h4>
              <table class="table table-striped table-borderless border-bottom">
                <thead>
                  <tr>
                    <th class="text-nowrap">Module  Type</th>
                    <th class="text-nowrap text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
              <?php 
                  foreach ($modulelist as $listvalue) {
                      if ($listvalue['mf_id'] >= 3 && $listvalue['mf_id'] <= 5) { 
                          $checked = ($listvalue['module_status'] == 1) ? "checked" : ""; // Check if active
                          echo '
                          <tr>
                              <td class="text-nowrap">'.htmlspecialchars($listvalue['module_name']).'</td>
                              <td>
                                  <div class="form-check d-flex justify-content-center">
                                      <input class="form-check-input module-status" type="checkbox" '.$checked.' value="'.$listvalue['mf_id'].'">
                                  </div>
                              </td>
                          </tr>
                          ';
                      }
                  }
                ?> 
                </tbody>
              </table>

              <h4 class="card-title text-primary mt-3">EMPLOYEE PANEL</h4>
              <table class="table table-striped table-borderless border-bottom">
                <thead>
                  <tr>
                    <th class="text-nowrap">Module  Type</th>
                    <th class="text-nowrap text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  foreach ($modulelist as $listvalue) {
                      if ($listvalue['mf_id'] >= 6 && $listvalue['mf_id'] <= 8) { 
                          $checked = ($listvalue['module_status'] == 1) ? "checked" : ""; // Check if active
                          echo '
                          <tr>
                              <td class="text-nowrap">'.htmlspecialchars($listvalue['module_name']).'</td>
                              <td>
                                  <div class="form-check d-flex justify-content-center">
                                      <input class="form-check-input module-status" type="checkbox" '.$checked.' value="'.$listvalue['mf_id'].'">
                                  </div>
                              </td>
                          </tr>
                          ';
                      }
                  }
                ?> 
                  
                </tbody>
              </table>

              

            </div>
           <!--  <div class="card-body">
              <h6>When should we send you notifications?</h6>
              <form action="javascript:void(0);">
                <div class="row">
                  <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                    <button type="reset" class="btn btn-outline-secondary">Discard</button>
                  </div>
                </div>
              </form>
            </div> -->
            <!-- /Notifications -->
          </div>
        </div>
      </div>
    </div>
    <!-- / Content -->
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(".module-status").change(function () {
        var module_id = $(this).val();
        var status = $(this).prop("checked") ? 1 : 0;
        console.log(module_id);
        console.log(status);
        $.ajax({
            url: "update_module_status.php",
            type: "POST",
            data: { module_id: module_id, status: status },
            success: function (response) {
                alert(response);
            },
            error: function () {
                alert("Something went wrong! Please try again.");
            }
        });
    });
});
</script>




  <?php include_once 'footer.php'; ?>