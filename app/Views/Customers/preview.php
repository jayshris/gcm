<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/print_report.css"> 
    <style>
        @media print {
           .card label{
                font-size: 12px !important;
           }
        } 
        .lblh{
            font-weight: bold;
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
                                                <h4>Customer Details</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>Party Types: </b></label>
                                                        <label class="col-form-label"><?= isset($party_types['pt']) && ($party_types['pt']) ? $party_types['pt'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>Party: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['party_name']) ? ucwords(strtolower($customer_detail['party_name'])) : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="col-form-label"><b>Address: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['business_address']) ? $customer_detail['business_address'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>City: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['pcity']) ? ucwords(strtolower($customer_detail['pcity'])) : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>State: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['ps_state']) ? ucwords(strtolower($customer_detail['ps_state'])) : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>Postcode: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['ppost']) ? $customer_detail['ppost'] : '-' ?></label>
                                                    </div> 

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>Adhar No.: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['adhar_no']) ? $customer_detail['adhar_no'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>IT Pan No.: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['pan_no']) ? $customer_detail['pan_no'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>GST No.: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['gst_no']) ? $customer_detail['gst_no'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>MSME No.: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['msme_no']) ? $customer_detail['msme_no'] : '-' ?></label>
                                                    </div>
        
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>Tan No.: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['tan_no']) ? ucwords(strtolower($customer_detail['tan_no'])) : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>CIN No.: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['cin_no']) ? ucwords(strtolower($customer_detail['cin_no'])) : '-' ?></label>
                                                    </div>
  
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="col-form-label"><b>Alternate Address: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['address']) ? ucwords(strtolower($customer_detail['address'])) : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6">
                                                        <label class="col-form-label"><b>City: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['city']) ? ucwords(strtolower($customer_detail['city'])) : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>State: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['state_name']) ? ucwords(strtolower($customer_detail['state_name'])) : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>Postcode: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['postcode']) ? $customer_detail['postcode'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>Phone: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['phone']) ? $customer_detail['phone'] : '-' ?></label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <label class="col-form-label"><b>Status: </b></label>
                                                        <label class="col-form-label"><?= ($customer_detail['status']) && ($customer_detail['status']==1) ? 'Active': 'Inactive' ?></label>
                                                    </div> 
                                                    
                                                    <hr>
                                                      <!-- Customer Branches -->
                                                    <?php if(isset($customer_branches) && !empty($customer_branches)){?>
                                                        <div class="settings-sub-header">
                                                            <h4>Customer Branches:</h4>
                                                        </div>  
                                                        <?php foreach($customer_branches as $customer_branche){ ?>
                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                            <label class="col-form-label"><b>Branch Name: </b></label>
                                                            <label class="col-form-label"><?= ($customer_branche['office_name']) ? $customer_branche['office_name'] : '-' ?></label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                            <label class="col-form-label"><b>Phone: </b></label>
                                                            <label class="col-form-label"><?= ($customer_branche['phone']) ? $customer_branche['phone'] : '-' ?></label>
                                                        </div> 

                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                            <label class="col-form-label"><b>GST Number: </b></label>
                                                            <label class="col-form-label"><?= ($customer_branche['gst']) ? $customer_branche['gst'] : '-' ?></label>
                                                        </div>
                                                            <div class="col-sm-12 col-md-12"></div>
                                                            <h6>Branch Contact Persons:</h6>
                                                        <?php if (isset($customer_branche['branch_persons'])) { 
                                                            foreach ($customer_branche['branch_persons'] as $bp) {
                                                            ?>
                                                                <div class="col-sm-6 col-md-6">
                                                                    <label class="col-form-label lblh">Contact Person Name</label> 
                                                                    <label class="col-form-label"><?= ($bp['name']) ? $bp['name'] : '-' ?></label>
                                                                </div>
                                                                <div class="col-sm-6 col-md-6">
                                                                    <label class="col-form-label lblh">Designation</label>
                                                                    <label class="col-form-label"><?= ($bp['designation']) ? $bp['designation'] : '-' ?></label>
                                                                </div>
                                                                <div class="col-sm-6 col-md-6">
                                                                    <label class="col-form-label lblh">Phone No.</label>
                                                                    <label class="col-form-label"><?= ($bp['phone']) ? $bp['phone'] : '-' ?></label> 
                                                                </div>
                                                                <div class="col-sm-6 col-md-6">
                                                                    <label class="col-form-label lblh">Email</label>
                                                                    <label class="col-form-label"><?= ($bp['email']) ? $bp['email'] : '-' ?></label> 
                                                                </div>                                                               
                                                            <?php } ?> 
                                                        <?php } ?> 
                                                        <div class="col-sm-12 col-md-12 col-lg-12"></div>
                                                        <h6>Register Address:</h6>
                                                        <?php if (isset($customer_branche['reg_address'])) { 
                                                            foreach ($customer_branche['reg_address'] as $bp) {
                                                            ?>
                                                                <div class="col-sm-12 col-md-12">
                                                                    <label class="col-form-label lblh">Address</label> 
                                                                    <label class="col-form-label"><?= ($bp['address']) ? $bp['address'] : '-' ?></label>
                                                                </div>
                                                                <div class="col-sm-6 col-md-6">
                                                                    <label class="col-form-label lblh">City</label>
                                                                    <label class="col-form-label"><?= ($bp['city']) ? $bp['city'] : '-' ?></label>
                                                                </div>
                                                                <div class="col-sm-6 col-md-6">
                                                                    <label class="col-form-label lblh">State</label>
                                                                    <label class="col-form-label"><?= ($bp['state_name']) ? $bp['state_name'] : '-' ?></label> 
                                                                </div>
                                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                                    <label class="col-form-label lblh">Country</label>
                                                                    <label class="col-form-label"><?= ($bp['country']) ? $bp['country'] : '-' ?></label> 
                                                                </div>        
                                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                                    <label class="col-form-label lblh">Zip</label>
                                                                    <label class="col-form-label"><?= ($bp['zip']) ? $bp['zip'] : '-' ?></label> 
                                                                </div>        
                                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                                    <label class="col-form-label lblh">Effective From</label>
                                                                    <label class="col-form-label"><?= ($bp['effective_from']) && ($bp['effective_from'] != '0000-00-00') ? date('d-M-Y',strtotime($bp['effective_from'])) : '-' ?></label> 
                                                                </div>                                                   
                                                            <?php } ?> 
                                                        <?php } ?> 

                                                        <hr>
                                                    <?php } }?> 
                                                    
                                                </div> 
                                            </div>  

                                          

                                            <?php //echo $this->include('partials/print-footer') ?>
                                            <div class="submit-button noprint">  
                                                <button type="button" class="btn btn-danger" onclick="window.print();"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
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