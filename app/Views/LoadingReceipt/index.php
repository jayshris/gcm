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
								<h4 class="page-title">Loading Receipt</h4>
								</div>
								<div class="col-4 text-end">
								<div class="head-icons">
									<a href="<?= base_url('loadingreceipt') ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
									<a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
								</div>
								</div>
							</div>
						</div>
						<!-- /Page Header -->

						
						<div class="col-md-3 text-end mt-3">
							<?php echo makeListActions($currentController, $Action, 0, 1); ?>
						</div>


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
									</div>

								</div>
								<!-- /Search -->

								<!-- Product Type List -->
								<div class="table-responsive custom-table">
								 
								</div>
								<div class="row align-items-center">
								<div class="col-md-6">
									<div class="datatable-length"></div>
								</div>
								<div class="col-md-6">
									<div class="datatable-paginate"></div>
								</div>
								</div>
								<!-- /Product Type List -->

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

</body>

</html>