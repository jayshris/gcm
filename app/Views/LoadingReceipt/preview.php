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
                                                <h4>Preview Loading Receipt</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Booking Order No: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['booking_number'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Branch Name: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['branch_name'] ?></label>  
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Booking Date: </label>
                                                        <label class="col-form-label"><?= date('d M Y',strtotime($loading_receipts['booking_date'])) ?></label> 
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Vehicle Number: </label> 
                                                        <label class="col-form-label"><?= $loading_receipts['rc_number'] ?></label>    
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Loading Station: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['loading_station'] ?></label> 
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Delivery Station: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['delivery_station'] ?></label> 
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Consignment Date: </label>
                                                        <label class="col-form-label"><?= date('d M Y',strtotime($loading_receipts['consignment_date'])) ?></label> 
                                                    </div>   														

                                                    <hr>

                                                    <h6>Consignor Details:</h6>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Consignor Name: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_name'] ?></label> 
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label">Address: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_address'] ?></label> 
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">City: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_city'] ?></label> 
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">State: </label> 
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_state'] ?></label> 
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Pincode: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_pincode'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">GSTIN: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_GSTIN'] ?></label>
                                                    </div>
                                                    
                                                    <hr>
                                                    
                                                    <h6>Consignee Details:</h6>
                                                    
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Consignee Name: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_name'] ?></label>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label">Address: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_address'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">City: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_city'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">State: </label> 
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_state'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Pincode: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_pincode'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">GSTIN: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_GSTIN'] ?></label>
                                                    </div>

                                                    <hr>
                                                    
                                                    <h6>Place of Delivery:</h6>
                                                    <div class="col-md-12">
                                                        <label class="col-form-label">Address: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_delivery_address'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">City: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_delivery_city'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">State: </label> 
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_delivery_state'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Pincode: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_delivery_pincode'] ?></label>
                                                    </div> 
                                                    
                                                    <hr>

                                                    <h6>Place of Dispatch:</h6>
                                                    <div class="col-md-12">
                                                        <label class="col-form-label">Address: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_dispatch_address'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">City: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_dispatch_city'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">State: </label> 
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_dispatch_state'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Pincode: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_dispatch_pincode'] ?></label>
                                                    </div> 

                                                    <hr>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Particulars: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['particulars'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">HSN Code: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['hsn_code'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">No. of Packages: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['no_of_packages'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Actual Weight: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['actual_weight'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Charge Weight: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['charge_weight'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Payment Terms: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['payment_terms'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">E-WAY Bill Number: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['e_way_bill_number'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">E-WAY Bill Expiry Date: </label> 
                                                        <label class="col-form-label"><?= date('d M Y',strtotime($loading_receipts['e_way_expiry_date'])) ?></label> 
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Freight Charges Amount: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['freight_charges_amount'] ?></label>
                                                    </div>

                                                    <hr>
                                                    
                                                    <h6>Party Document Details</h6>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Invoice/BOE No.: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['invoice_boe_no'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Invoice/BOE Date: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['invoice_boe_date'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Invoice Value: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['invoice_value'] ?></label>
                                                    </div>

                                                    <hr>
                                                    <h6>Transit Insurance</h6>
                                                    <h6>Dispatch Details:</h6>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Reporting Date/Time: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['reporting_datetime'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Releasing Date/Time: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['releasing_datetime'] ?></label>
                                                    </div>
                                                    <h6>Insurance Co.:</h6>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Policy Date: </label> 
                                                        <label class="col-form-label"><?= date('d M Y',strtotime($loading_receipts['policy_date'])) ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Policy Number: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['policy_no'] ?></label>
                                                    </div>
                                                </div>
                                                <br>
                                            </div> 
                                            <div class="submit-button"> 
                                                <a href="<?php echo base_url(); ?>loadingreceipt" class="btn btn-light">Cancel</a>
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