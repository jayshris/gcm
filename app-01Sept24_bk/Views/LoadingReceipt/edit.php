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
						<?php $validation = \Config\Services::validation(); ?>
						<?php
						$session = \Config\Services::session();
						if ($session->getFlashdata('success')) {
							echo '
								<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
								';
						}
						?>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<!-- Settings Info -->
								<div class="card">
									<div class="card-body">
										<div class="settings-form"> 
											<?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($loading_receipts['id']>0) ? '/'.$loading_receipts['id'] : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
											<div class="settings-sub-header">
												<h4>Edit Loading Receipt</h4>
											</div>
											<?= $this->include('LoadingReceipt/form.php') ?>     
										</div>
									</div>
								</div>
								<!-- /Settings Info -->

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->
	<input type="hidden" id="selected_consignor_name" value="<?php echo $selected_consignor_name; ?>"/> 
	<input type="hidden" id="selected_consignee_name" value="<?php echo $selected_consignee_name; ?>"/> 

	<?= $this->include('partials/vendor-scripts') ?>

	<input type="hidden" id="base_url" value="<?php echo base_url() ?>" />
	<script src="<?php echo base_url(); ?>public/assets/js/loading_receipt.js"></script> 
	
</body>

</html>