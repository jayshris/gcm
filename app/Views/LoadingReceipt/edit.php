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
											<form action="<?php echo base_url('loadingreceipt/edit/'.$loading_receipts['id']); ?>" method="post" enctype="multipart/form-data">
                                                <div class="settings-sub-header">
                                                    <h4>Edit Loading Receipt</h4>
                                                </div>
												<?= $this->include('LoadingReceipt/form.php') ?>                                                
											</form>
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

	<script>
		$.getBookingDetails = function() {
			var booking_id = $('#booking_id').val();

			$.ajax({
				method: "POST",
				url: '<?php echo base_url('loadingreceipt/getBookingDetails') ?>',
				data: {
					booking_id: booking_id
				},
				dataType: "json",
				success: function(res) { 
					$("#office_id").val(res.office_id).attr("selected","selected").trigger('change').attr('disabled','disabled');
					$("#booking_date").val(res.booking_date).attr('disabled','disabled');
					$("#vehicle_number").val(res.vehicle_id).trigger('change').attr('disabled','disabled');
					$("#consignment_date").attr('min',res.booking_date);
				}
			});
		}

	</script>
</body>

</html>