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
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<!-- Settings Info -->
								<div class="card">
									<div class="card-body">
										<div class="settings-form"> 
                                            <div class="settings-sub-header">
                                                <h4>Preview Booking Cancellation Reasons</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Reason Name: </b></label>
                                                        <label class="col-form-label"><?= $booking_cancellation_reasons['name'] ?></label>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Status: </b></label>
                                                        <label class="col-form-label">
                                                            <?php 
                                                            if($booking_cancellation_reasons['status'] == 1){
                                                                echo 'Active';	
                                                            }else {
                                                                echo 'Inactive';	
                                                            }												
                                                            ?>
                                                        </label>  
                                                    </div> 

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Added At: </b></label> 
                                                        <label class="col-form-label">
                                                            <?= (strtotime($booking_cancellation_reasons['created_at']) > 0) ? date('d/m/Y h:i A',strtotime($booking_cancellation_reasons['created_at'])) : '-' ?>
                                                        </label>    
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Updated At: </b></label>
                                                        <label class="col-form-label">
                                                            <?= (strtotime($booking_cancellation_reasons['updated_at']) > 0) ? date('d/m/Y h:i A',strtotime($booking_cancellation_reasons['updated_at'])) : '-' ?>
                                                        </label> 
                                                    </div> 

                                                </div>
                                                <br>
                                            </div> 
                                            <div class="submit-button"> 
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