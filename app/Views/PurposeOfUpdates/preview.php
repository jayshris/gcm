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
                                                <h4>Purpose Of Update</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Purpose Name: </b></label>
                                                        <label class="col-form-label"><?= ucfirst($data['name']) ?></label>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Status: </b></label>
                                                        <label class="col-form-label">
                                                            <?php 
                                                            if($data['status'] == 1){
                                                                echo 'Active';	
                                                            }else {
                                                                echo 'Inactive';	
                                                            }												
                                                            ?>
                                                        </label>  
                                                    </div> 

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Is Money Mandatory?: </b></label>
                                                        <label class="col-form-label">
                                                            <?php 
                                                            if($data['is_money_mandatory'] == 1){
                                                                echo 'Yes';	
                                                            }else {
                                                                echo 'No';	
                                                            }												
                                                            ?>
                                                        </label>  
                                                    </div> 

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Is Fuel Mandatory?: </b></label>
                                                        <label class="col-form-label">
                                                            <?php 
                                                            if($data['is_fuel_mandatory'] == 1){
                                                                echo 'Yes';	
                                                            }else {
                                                                echo 'No';	
                                                            }												
                                                            ?>
                                                        </label>  
                                                    </div> 

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Added At: </b></label> 
                                                        <label class="col-form-label">
                                                            <?= (strtotime($data['created_at']) > 0) ? date('d/m/Y h:i A',strtotime($data['created_at'])) : '-' ?>
                                                        </label>    
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Updated At: </b></label>
                                                        <label class="col-form-label">
                                                            <?= (strtotime($data['updated_at']) > 0) ? date('d/m/Y h:i A',strtotime($data['updated_at'])) : '-' ?>
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