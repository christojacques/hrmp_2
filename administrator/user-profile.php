<?php 

include_once 'header.php';

?>
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                      
                      </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input class="form-control" type="text" id="firstName" name="firstName" value="" >
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" value="Doe">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="text" id="email" name="email" value="john.doe@example.com" placeholder="john.doe@example.com">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Phone</label>
                            <input class="form-control" type="text" id="phone" name="phone" value="" placeholder="+1 XXX-XXXX-XXX">
                          </div>
                           <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Date of Birth</label>
                            <input class="form-control" type="date" id="dob" name="dob" value="" placeholder="dd-mm-yyyy">
                          </div> 
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Job Title</label>
                            <input class="form-control" type="text" id="dob" name="dob" value="" placeholder="">
                          </div>
                         
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Contract Start</label>
                            <input class="form-control" type="month" id="dob" name="dob" value="" placeholder="dd-mm-yyyy">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Contract End</label>
                            <input class="form-control" type="month" id="dob" name="dob" value="" placeholder="dd-mm-yyyy">
                          </div>
                           <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Contract Number</label>
                            <input class="form-control" type="text" id="dob" name="dob" value="">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Contract Type</label>
                            <input type="text" class="form-control" id="organization" name="organization" >
                          </div> 
                          <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Department</label>
                            <input type="text" class="form-control" id="organization" name="organization" >
                          </div>
                           <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Project Assignment</label>
                            <input type="text" class="form-control" id="organization" name="organization" v>
                          </div>
                           <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Unit Assignment</label>
                            <input type="text" class="form-control" id="organization" name="organization">
                          </div>
                           <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Bank account number</label>
                            <input type="text" class="form-control" id="organization" name="organization" >
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Preference for payment</label>
                            <select name="" class="form-control" id="">
                            	<option value="">Select Perference For Payment</option>
                            	<option value="">Check</option>
                            	<option value="">Bank</option>
                            </select>
                          </div>
                           <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Password</label>
                            <input type="text" class="form-control" id="organization" name="organization">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="organization" name="organization" >
                          </div>

                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
            </div>

<?php
include_once 'footer.php';

 ?>