<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?>
</head>
<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<?= $this->include('partials/menu') ?>
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				<div class="row">
					<div class="col-md-12"> 
						 <!-- Page Header -->
						<div class="page-header">
							<div class="row align-items-center">
								<div class="col-8">
								<h4 class="page-title">Expense Heads</h4>
								</div>
								<div class="col-4 text-end">
								<div class="head-icons">
									<a href="<?= base_url('expensehead') ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
									<a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
								</div>
								</div>
							</div>
						</div>
						<!-- /Page Header -->
						
						<form method="post" enctype="multipart/form-data" action="<?php echo base_url('expensehead'); ?>">
							<div class="card main-card">
								<div class="card-body"> 
									<div class="row">  
										<div class="col-md-3">
											<?php echo makeListActions($currentController, $Action, 0, 1); ?>
										</div>
									</div>
								</div>
							</div>
						</form>

						<div class="card main-card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<?php
										$session = \Config\Services::session();
										if ($session->getFlashdata('success')) {
										echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
										}
										if ($session->getFlashdata('danger')) {
										echo '<div class="alert alert-danger">' . $session->getFlashdata("danger") . '</div>';
										}
										?>
										<br>
									</div>
								</div>
								<!-- /Search -->
 
								<div class="table-responsive custom-table">
									<table class="table" id="expensehead-table">
										<thead class="thead-light">
										<tr>
											<th>#</th>
											<th>Action</th>
											<th>Head Name</th> 
											<th>Balance Sheet / <br>Profit and Loss</th>
											<th>Operating Expense / <br>Non-Operating Expense</th>
											<th>Fixed / <br>Variable</th>
											<th>Status</th> 
										</tr>
										</thead>
										<tbody>
											<?php
											$i = 1;
											foreach ($expense_heads as $b) {
											?>
											<tr>
												<td><?= $i++; ?>.</td> 
												<td><?= makeListActions($currentController, $Action, $b['id'], 2) ?></td>
												<td><?= $b['head_name'] ?></td> 
												<td>
													<?php if($b['type_1'] == 'balance_sheet'){
														echo 'Balance Sheet';	
													}else if($b['type_1'] == 'profit_and_loss'){
														echo 'Profit and Loss';	
													}else{
														echo '-';
													}												
													?>
												</td> 
												<td>
													<?php if($b['type_2'] == 'operating_expense'){
														echo 'Operating Expense';	
													}else if($b['type_2'] == 'non_operating_expense'){
														echo 'Non-Operating Expense';	
													}else{
														echo '-';
													}
													?>
												</td>
												<td>
													<?php if($b['type_3'] == 'fixed'){
														echo 'Fixed';	
													}else if($b['type_3'] == 'variable'){
														echo 'Variable';	
													}else{
														echo '-';
													}												
													?>
												</td>    
												<td>
													<?php if($b['status']){
														echo '<span class="badge badge-pill bg-success">Active</span>';	
													}else{
														echo '<span class="badge badge-pill bg-danger">Inactive</span>';
													}												
													?>
												</td>
											</td>
											</tr>
										<?php } ?>
										</tbody>
									</table>
								</div>
								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="datatable-length"></div>
									</div>
									<div class="col-md-6">
										<div class="datatable-paginate"></div>
									</div>
								</div> 

							</div>
							</div>

					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

	<?= $this->include('partials/vendor-scripts') ?>
	<script>
    function delete_data(id) {
      if (confirm("Are you sure you want to remove this product category ?")) {
        window.location.href = "<?php echo base_url('product-categories-delete/'); ?>" + id;
      }
      return false;
    }


    // datatable init
    if ($(' #expensehead-table').length > 0) {
      $('#expensehead-table').DataTable({
        "bFilter": false,
        "bInfo": false,
        "autoWidth": true,
        "language": {
          search: ' ',
          sLengthMenu: '_MENU_',
          searchPlaceholder: "Search",
          info: "_START_ - _END_ of _TOTAL_ items",
          "lengthMenu": "Show _MENU_ entries",
          paginate: {
            next: 'Next <i class=" fa fa-angle-right"></i> ',
            previous: '<i class="fa fa-angle-left"></i> Prev '
          },
        },
        initComplete: (settings, json) => {
          $('.dataTables_paginate').appendTo('.datatable-paginate');
          $('.dataTables_length').appendTo('.datatable-length');
        } ,
		"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [1] } 
		]
      });
    }

	function delete_data(id) {
      if (confirm("Are you sure you want to remove it?")) {
        window.location.href = "<?php echo base_url(); ?>/expensehead/delete/" + id;
      }
      return false;
    }

  </script>											
</body>

</html>