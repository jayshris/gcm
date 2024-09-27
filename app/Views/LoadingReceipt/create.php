<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?>
</head>
<body>
	<div class="main-wrapper">
		<?= $this->include('partials/menu') ?>
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
								<div class="card">
									<div class="card-body">
										<div class="settings-form">
											<?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
											<div class="settings-sub-header">
												<h3>Add Loading Receipt</h3>
											</div>
											<?= $this->include('LoadingReceipt/form.php') ?>    
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<?= $this->include('partials/vendor-scripts') ?> 

	<input type="hidden" id="base_url" value="<?php echo base_url() ?>" />
	<script src="<?php echo base_url(); ?>public/assets/js/loading_receipt.js?<?= time()?>"></script>
 
</body>

</html>