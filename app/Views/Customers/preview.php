<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/print_report.css"> 
    <style>
        @media print {
            .printableArea { 
                display: block;
            } 
        }
		.b-bt-none{
			border-bottom: none !important;
		}
		.b-lt1{
			border-left: 1pt solid #221E1F;
		}
		.b-tp1{
			border-top: 1pt solid #221E1F
		}
		.b-tp-none{
			border-top: none !important;
		}
		.b-rt1{
			border-right: 1pt solid #221E1F;
		}
    </style>
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
                                                <h4>Preview Customer</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>Party Types: </b></label>
                                                        <label class="col-form-label"><?= isset($party_types['pt']) && ($party_types['pt']) ? $party_types['pt'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>Party: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['party_name']) ? $customer_detail['party_name'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>Address: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['address']) ? $customer_detail['address'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>City: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['city']) ? $customer_detail['city'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>State: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['state_name']) ? $customer_detail['state_name'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>Postcode: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['postcode']) ? $customer_detail['postcode'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>Phone: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['phone']) ? $customer_detail['phone'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>Status: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['status']) && ($customer_detail['status']==1) ? 'Active': 'Inactive' ?></label>
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
	</div>
	<!-- /Main Wrapper -->

	<?= $this->include('partials/vendor-scripts') ?>  
</body>

</html>