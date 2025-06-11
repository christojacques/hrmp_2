<?php
include_once 'header.php';
include_once 'private/payslip-proform-function.php';
?>
<div class="content-wrapper">
	<!-- Content -->
	<div class="container-xxl flex-grow-1 container-p-y">
		<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage Payroll /</span> Pay Slip Perform</h4>
		<div class="card">
			<h4 class="card-header">Genarated Payroll Slips</h4>
			<div class="card-body">
				<form method="post" class="mb-5">
					<div class="row mt-3">
						<div class="col-md-3 text-center">
							<label for="" class="form-label">Months</label>
							<input type="month" name="month" class="form-control-sm">
						</div>
						<div class="col-md-3">
							<input type="submit" name="search" id="search" class="btn btn-primary btn-sm" value="Genarate">
						</div>
					</div>
				</form>
				<table class="table  table-bordered" id="example">
					<thead>
						<tr>
							<th>Employee Name</th>
							<th>Bank</th>
							<th>Month</th>
							<th>Account Number</th>
							<th>Pay. Method</th>
							<th>CEO Status</th>
							<th>Transection Status</th>
							<th>Net Salary</th>
						</tr>
					</thead>
					<tbody>

						<?php 

						if (isset($_POST['search'])) {
							$month=$_POST['month'];
							$payslip->showpayslip($month);
						}else{
							$month=date('Y-m');
							$payslip->showpayslip($month);
						 
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script src="js/jquery-3.7.0.js"></script>
	<script>
 $(document).ready(function() {
  $('#example').DataTable( {
  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
  });
  });
		$(document).on('change', '#tstatus', function() {
    // Get the value of the selected option
    var status = $(this).val();
    // Get the parent <tr> element's exs_id attribute
    var amsId = $(this).closest('tr').data('ams-id');
    //alert(amsId)
    $.ajax({
            url: 'private/payslip-proform-function.php',
            type: 'post',
            data: {status: status, id: amsId},
            success: function (data) {
                console.log(data)
            }
        });
});
	</script>
	<?php include_once 'footer.php'; ?>