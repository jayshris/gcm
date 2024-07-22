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
											<form action="<?php echo base_url('profile'); ?>" method="post" enctype="multipart/form-data">
                                                <div class="settings-sub-header">
                                                    <h4>Loading Receipt</h4>
                                                </div>
                                                <div class="profile-details">
													<div class="row g-3">
														<div class="col-md-4">
															<label class="col-form-label">Booking Order No<span class="text-danger">*</span></label>
															<select class="form-select select2" required name="booking_id" id="booking_id" aria-label="Default select example"  onchange="$.getBookingDetails();">
																<option value="">Select Booking</option>
																<?php foreach ($bookings as $o) {
																echo '<option value="' . $o['id'] . '">' . $o['booking_number'] . '</option>';
																} ?>
															</select>
														</div>

														<div class="col-md-4">
															<label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
															<select class="form-select select2" required name="office_id" id="office_id" aria-label="Default select example">
																<option value="">Select Office</option>
																<?php foreach ($offices as $o) {
																echo '<option value="' . $o['id'] . '">' . $o['name'] . '</option>';
																} ?>
															</select>
														</div>

														<div class="col-md-4">
															<label class="col-form-label">Booking Date<span class="text-danger">*</span></label>
															<input type="date" name="booking_date" id="booking_date" class="form-control" required>
														</div>

														<div class="col-md-4">
                                                            <label class="col-form-label">Vehicle Number<span class="text-danger">*</span></label> 
															<select class="form-select select2" required name="vehicle_number" id="vehicle_number" aria-label="Default select example">
																<option value="">Select</option>
																<?php foreach ($vehicles as $o) {
																echo '<option value="' . $o['id'] . '">' . $o['rc_number'] . '</option>';
																} ?>
															</select>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">Loading Station<span class="text-danger">*</span></label>
                                                            <input type="text" name="loading_station" id="loading_station" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">Delivery Station<span class="text-danger">*</span></label>
                                                            <input type="text" name="delivery_station" id="delivery_station" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Consignment Date<span class="text-danger">*</span></label>
                                                            <input type="date" required name="consignment_date" id="consignment_date" min="<?= date('Y-m-d') ?>"  class="form-control">
                                                        </div>  

														<div class="col-md-4">
                                                            <label class="col-form-label">Consignor Name<span class="text-danger">*</span></label>
                                                            <input type="text" name="consignor_name" id="consignor_name" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">Consignee Name<span class="text-danger">*</span></label>
                                                            <input type="text" name="consignee_name" id="consignee_name" class="form-control" required>
                                                        </div>

														<hr>

														<h6>Consignor Address:</h6>
														<div class="col-md-12">
                                                            <label class="col-form-label">Address<span class="text-danger">*</span></label>
                                                            <input type="text" name="consignor_address" id="consignor_address" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">City<span class="text-danger">*</span></label>
                                                            <input type="text" name="consignor_city" id="consignor_city" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">State<span class="text-danger">*</span></label> 
															<select class="form-select select2" required name="consignor_state" id="consignor_state" aria-label="Default select example">
																<option value="">Select</option>
																<?php foreach ($states as $o) {
																echo '<option value="' . $o['state_id'] . '">' . $o['state_name'] . '</option>';
																} ?>
															</select>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                                            <input type="number" name="consignor_pincode" id="consignor_pincode" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">GSTIN<span class="text-danger">*</span></label>
                                                            <input type="number" name="consignor_GSTIN" id="consignor_GSTIN" class="form-control" required>
                                                        </div>
														
														<hr>
														
														<h6>Consignee Address:</h6>
														<div class="col-md-12">
                                                            <label class="col-form-label">Address<span class="text-danger">*</span></label>
                                                            <input type="text" name="consignee_address" id="consignee_address" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">City<span class="text-danger">*</span></label>
                                                            <input type="text" name="consignee_city" id="consignee_city" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">State<span class="text-danger">*</span></label> 
															<select class="form-select select2" required name="consignee_state" id="consignee_state" aria-label="Default select example">
																<option value="">Select</option>
																<?php foreach ($states as $o) {
																echo '<option value="' . $o['state_id'] . '">' . $o['state_name'] . '</option>';
																} ?>
															</select>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                                            <input type="number" name="consignee_pincode" id="consignee_pincode" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">GSTIN<span class="text-danger">*</span></label>
                                                            <input type="number" name="consignee_GSTIN" id="consignee_GSTIN" class="form-control" required>
                                                        </div>

														<hr>
														
														<h6>Place of Delivery:</h6>
														<div class="col-md-12">
                                                            <label class="col-form-label">Address<span class="text-danger">*</span></label>
                                                            <input type="text" name="place_of_delivery_address" id="place_of_delivery_address" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">City<span class="text-danger">*</span></label>
                                                            <input type="text" name="place_of_delivery_city" id="place_of_delivery_city" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">State<span class="text-danger">*</span></label> 
															<select class="form-select select2" required name="place_of_delivery_state" id="place_of_delivery_state" aria-label="Default select example">
																<option value="">Select</option>
																<?php foreach ($states as $o) {
																echo '<option value="' . $o['state_id'] . '">' . $o['state_name'] . '</option>';
																} ?>
															</select>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                                            <input type="number" name="place_of_delivery_pincode" id="place_of_delivery_pincode" class="form-control" required>
                                                        </div> 
														
														<hr>

														<h6>Place of Dispatch:</h6>
														<div class="col-md-12">
                                                            <label class="col-form-label">Address<span class="text-danger">*</span></label>
                                                            <input type="text" name="place_of_delivery_address" id="place_of_delivery_address" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">City<span class="text-danger">*</span></label>
                                                            <input type="text" name="place_of_delivery_city" id="place_of_delivery_city" class="form-control" required>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">State<span class="text-danger">*</span></label> 
															<select class="form-select select2" required name="place_of_delivery_state" id="place_of_delivery_state" aria-label="Default select example">
																<option value="">Select</option>
																<?php foreach ($states as $o) {
																echo '<option value="' . $o['state_id'] . '">' . $o['state_name'] . '</option>';
																} ?>
															</select>
                                                        </div>

														<div class="col-md-4">
                                                            <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                                            <input type="number" name="place_of_delivery_pincode" id="place_of_delivery_pincode" class="form-control" required>
                                                        </div> 

														<hr>

														<div class="col-md-4">
                                                            <label class="col-form-label">Particulars<span class="text-danger">*</span></label>
                                                            <input type="text" name="particulars" id="particulars" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">HSN Code<span class="text-danger">*</span></label>
                                                            <input type="number" name="hsn_code" id="hsn_code" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">No. of Packages<span class="text-danger">*</span></label>
                                                            <input type="number" name="no_of_packages" id="no_of_packages" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">Actual Weight<span class="text-danger">*</span></label>
                                                            <input type="text" name="actual_weight" id="actual_weight" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">Charge Weight<span class="text-danger">*</span></label>
                                                            <input type="text" name="charge_weight" id="charge_weight" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">Payment Terms<span class="text-danger">*</span></label>
                                                            <input type="text" name="payment_terms" id="payment_terms" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">E-WAY Bill Number<span class="text-danger">*</span></label>
                                                            <input type="number" name="e_way_bill_number" id="e_way_bill_number" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">E-WAY Bill Expiry Date<span class="text-danger">*</span></label>
                                                            <input type="date" name="e_way_expiry_date" id="e_way_expiry_date" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">Freight Charges Amount<span class="text-danger">*</span></label>
                                                            <input type="number" name="freight_charges_amount" id="freight_charges_amount" class="form-control" required>
                                                        </div>

														<hr>
														
														<h6>Party Document Details</h6>
														<div class="col-md-4">
                                                            <label class="col-form-label">Invoice/BOE No.<span class="text-danger">*</span></label>
                                                            <input type="number" name="invoice_boe_no" id="invoice_boe_no" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">Invoice/BOE Date<span class="text-danger">*</span></label>
                                                            <input type="date" name="invoice_boe_date" id="invoice_boe_date" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">Invoice Value<span class="text-danger">*</span></label>
                                                            <input type="number" name="invoice_value" id="invoice_value" class="form-control" required>
                                                        </div>

														<hr>
														<h6>Transit Insurance</h6>
														<h6>Dispatch Details:</h6>
														<div class="col-md-4">
                                                            <label class="col-form-label">Reporting Date/Time<span class="text-danger">*</span></label>
                                                            <input type="datetime-local" name="reporting_datetime" id="reporting_datetime" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">Releasing Date/Time<span class="text-danger">*</span></label>
                                                            <input type="datetime-local" name="releasing_datetime" id="releasing_datetime" class="form-control" required>
                                                        </div>
														<h6>Insurance Co.:</h6>
														<div class="col-md-4">
                                                            <label class="col-form-label">Policy Date<span class="text-danger">*</span></label>
                                                            <input type="date" name="policy_date" id="policy_date" class="form-control" required>
                                                        </div>
														<div class="col-md-4">
                                                            <label class="col-form-label">Policy Number<span class="text-danger">*</span></label>
                                                            <input type="number" name="policy_no" id="policy_no" class="form-control" required>
                                                        </div>
													</div>
													<br>
												</div> 
												<div class="submit-button">
													<input type="submit" name="add_profile" class="btn btn-primary" value="Save">
													<a href="<?php echo base_url(); ?>profile" class="btn btn-light">Cancel</a>
												</div>
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
					$("#office_id").val(res.office_id).attr("selected","selected").trigger('change');
					$("#booking_date").val(res.booking_date);
					$("#vehicle_number").val(res.vehicle_id).trigger('change');
					$("#consignment_date").attr('min',res.booking_date);
				}
			});
		}

	</script>
</body>

</html>