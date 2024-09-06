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
											<?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.((isset($token) && ($token > 0)) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
											<div class="settings-sub-header">
												<h4><?= (isset($token) && ($token > 0) ? 'Edit' : 'Add')?> Trip Paused Reason</h4>
											</div> 
											<?php 
												$validation = \Config\Services::validation();
											?>
											<div class="profile-details">
												<div class="row g-3">
													<div class="col-md-6">
														<label class="col-form-label">Reason Name<span class="text-danger">*</span></label>
														<input type="text" name="name" id="name" class="form-control" required value="<?= (isset($data['name'])) ?  $data['name'] : ''?>">
														<?php
														if ($validation->getError('name')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('name') . '</div>';
														}
														?>
													</div> 
												</div>
												<br>
											</div> 
											<div class="submit-button">
												<input type="submit" class="btn btn-primary" value="Save">
												<input type="reset" name="reset" class="btn btn-warning" value="Reset">
												<a href="<?php echo base_url().$currentController; ?>" class="btn btn-light">Cancel</a>
											</div>
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

	<?= $this->include('partials/vendor-scripts') ?>
 
</body>

</html>