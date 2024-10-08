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
                                                <h4>Payment Mode</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Name: </b></label>
                                                        <label class="col-form-label"><?= $data['name'] ?></label>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Added At: </b></label> 
                                                        <label class="col-form-label">
                                                            <?= (strtotime($data['created_at']) > 0) ? date('d M Y h:i A',strtotime($data['created_at'])) : '-' ?>
                                                        </label>    
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Updated At: </b></label>
                                                        <label class="col-form-label">
                                                            <?= (strtotime($data['updated_at']) > 0) ? date('d M Y h:i A',strtotime($data['updated_at'])) : '-' ?>
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