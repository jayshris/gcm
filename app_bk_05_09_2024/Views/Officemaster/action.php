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

								<div class="card">
									<div class="card-body">
										<div class="settings-form">
											<?php echo form_open_multipart(base_url() . $currentController . '/' . $currentMethod . (($token > 0) ? '/' . $token : ''), ['name' => 'actionForm', 'id' => 'actionForm']); ?>
											<div class="settings-sub-header">
												<h4>Add Office</h4>
											</div>
											<div class="profile-details">
												<div class="row g-3">
													<div class="col-md-6">
														<label class="col-form-label">Office Name <span class="text-danger">*</span> </label>
														<input type="text" name="name" id="name" class="form-control" required value="<?= (isset($office_detail['name'])) ?  $office_detail['name'] : '' ?>">
														<span class="text-danger" id="msg"></span>
													</div>
													<?php if (isset($office_detail)) { ?>
														<div class="col-md-2">
															<label class="col-form-label">Status<span class="text-danger">*</span></label>
															<select class="form-select" required name="status" aria-label="Default select example">
																<option value="1" <?= isset($office_detail) && $office_detail['status'] == '1' ? 'selected' : '' ?>>Active</option>
																<option value="0" <?= isset($office_detail) && $office_detail['status'] == '0' ? 'selected' : '' ?>>InActive</option>
															</select>
														</div>
													<?php } ?>
												</div>
												<br>
											</div>
											<div class="submit-button">
												<input type="submit" id="submit" class="btn btn-primary" value="Save">
												<a href="./<?= isset($office_detail) ? $office_detail['id'] : 'create' ?>" class="btn btn-warning">Reset</a>
												<a href="<?php echo base_url() . $currentController; ?>" class="btn btn-light">Cancel</a>
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
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

	<?= $this->include('partials/vendor-scripts') ?>
</body>

<script>
	$(document).ready(function() {

		$('#name').on('input', function() {
			var name = $(this).val();
			console.log(name);

			$.ajax({
				type: 'POST',
				url: '<?= base_url('officemaster/validate_office') ?>',
				data: {
					name: name
				},
				success(response) {
					console.log(response);
					if (response == "1") {
						$('#msg').html('&nbsp;&nbsp; Office With Same Name Already Exists !!');
						$('#submit').attr('disabled', 'disabled');
					} else {
						$('#msg').html('');
						$('#submit').removeAttr('disabled');
					}
				}
			})
		})

	})
</script>

</html>