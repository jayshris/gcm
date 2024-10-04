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
						$errors = $validation->getErrors();
						if($errors){
							foreach($errors as $error){
								echo '<div class="alert alert-danger mt-2">' . $error . '</div>';
							}
						}
						?>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<!-- Settings Info -->
								<div class="card">
									<div class="card-body">
										<div class="settings-form">
											<?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
											<div class="settings-sub-header">
												<h4>Make Payment</h4>
											</div>
											<div class="profile-details">
												<div class="row g-3"> 
													<div class="col-md-12">
														<!-- <label class="col-form-label"> <span id="confirmMsg"></span> <span class="text-danger">*</span> </label><br> -->
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="payment_for" checked id="inlineRadio1" value="driver">
															<label class="form-check-label" for="inlineRadio1">Driver</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="payment_for" id="inlineRadio2" value="vendor">
															<label class="form-check-label" for="inlineRadio2">Vendor</label>
														</div>
													</div> 
													<div class="col-md-6 driver_div"> 
														<label class="col-form-label">
														Driver<span class="text-danger">*</span>
														</label>
														<select class="form-control select2" id="driver_id" name="driver_id" required onchange="getDriverVehicles();getDriverBookings();">
														<option value="">Select</option>
														<?php foreach($drivers as $val){?>
															<option value="<?= $val['id'] ?>"><?= $val['driver_name'].' - '.$val['rc_number'] ?></option>
														<?php }?>
														</select> 
														<?php
														if ($validation->getError('driver_id')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('driver_id') . '</div>';
														}
														?>
													</div>
													<div class="col-md-6">
														<div class="form-wrap">
															<label class="col-form-label">
															Payment Types<span class="text-danger">*</span>
															</label>
															<input type="hidden" name="money_payment_type_id" id="money_payment_type_id" value="<?= $money_payment_type_id; ?>" />
															<select class="select" id="payment_type_id" name="payment_type_id"  onchange="displayDivs()" required>
															<option  value="">Select</option>
															<?php foreach($payment_types as $val){?>
																<option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
															<?php }?>
															</select>
															<?php
															if ($validation->getError('payment_type_id')) {
																echo '<div class="alert alert-danger mt-2">' . $validation->getError('payment_type_id') . '</div>';
															}
															?>
														</div>
													</div>
													<div class="col-md-6 driver_div"> 
														<label class="col-form-label">Reason</label>
														<select class="form-control select2" id="reason_id" name="reason_id">
														<option value="">Select Booking</option> 
														</select> 
													</div>
													<div class="col-md-6 payment_types_fuel_urea_html driver_div" hidden>
														<div class="form-wrap">
															<label class="col-form-label">
															Vehicle<span class="text-danger payment_types_fuel_urea_html" hidden>*</span>
															</label>
															<select class="form-class select2 payment_types_fuel_urea_inpt" id="vehicle_id" name="vehicle_id" onchange="duplicateVehicle('vehicle_id','transfer_from_vehicle_id');getSameTypesVehicles();" >
															<option value="">Select Vehicle</option> 
															</select>
															<span class="text-danger duplicate_vehicle_spn" id="vehicle_id_spn" hidden>Vehicle No. is duplicate, please select another vehicle</span>
															<?php
															if ($validation->getError('vehicle_id')) {
																echo '<div class="alert alert-danger mt-2">' . $validation->getError('vehicle_id') . '</div>';
															}
															?>
														</div>
													</div> 
													
													<div class="col-md-6 fuel_fill_type_html" hidden>
														<div class="form-wrap">
															<label class="col-form-label">
															Fuel Fill Type<span class="text-danger fuel_fill_type_html" hidden>*</span>
															</label>
															<select class="form-class select2 fuel_fill_type_inpt" id="fuel_fill_type" name="fuel_fill_type" onchange="displayFuelType()">
															<option value="">Select</option>
															<option value="1">Fuel Transfer From Another</option>
															<option value="2">Fuel From Pump</option>
															</select>
															<?php
															if ($validation->getError('fuel_fill_type')) {
																echo '<div class="alert alert-danger mt-2">' . $validation->getError('fuel_fill_type') . '</div>';
															}
															?>
														</div>
													</div> 

													<div class="col-md-6 fuel_fill_type_transfer" hidden>
														<div class="form-wrap">
															<label class="col-form-label">
															Transfer From Vehicle<span class="text-danger fuel_fill_type_transfer" hidden>*</span>
															</label>
															<select class="form-class select2" id="transfer_from_vehicle_id" name="transfer_from_vehicle_id" onchange="duplicateVehicle('transfer_from_vehicle_id','vehicle_id')">
															<option value="">Select</option> 
															</select>
															<span class="text-danger duplicate_vehicle_spn" id="transfer_from_vehicle_id_spn" hidden>Vehicle No. is duplicate, please select another vehicle</span>
															<?php
															if ($validation->getError('transfer_from_vehicle_id')) {
																echo '<div class="alert alert-danger mt-2">' . $validation->getError('transfer_from_vehicle_id') . '</div>';
															}
															?>
														</div>
													</div> 

													<div class="col-md-6 fuel_fill_type_pump" hidden>
														<div class="form-wrap">
															<label class="col-form-label">
															Fuel Pump Brand<span class="text-danger fuel_fill_type_pump" hidden>*</span>
															</label>
															<select class="form-class select2" id="fuel_pump_brand_id" name="fuel_pump_brand_id">
															<option value="">Select</option>
															<?php foreach($fuel_pump_brands as $val){?>
																<option value="<?= $val['id'] ?>"><?= $val['brand_name'] ?></option>
															<?php }?>
															</select>
															<?php
															if ($validation->getError('fuel_pump_brand_id')) {
																echo '<div class="alert alert-danger mt-2">' . $validation->getError('fuel_pump_brand_id') . '</div>';
															}
															?>
														</div>
													</div>

													<div class="col-md-6 urea_html" hidden>
														<div class="form-wrap">
															<label class="col-form-label">
															Vendor<span class="text-danger urea_html" hidden>*</span>
															</label>
															<select class="form-class select2 urea_inpt" id="vendor_id" name="vendor_id">
															<option value="">Select</option>
															<?php foreach($vendors as $val){?>
																<option value="<?= $val['id'] ?>"><?= $val['party_name'] ?></option>
															<?php }?>
															</select>
														</div>
														<?php
														if ($validation->getError('vendor_id')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('vendor_id') . '</div>';
														}
														?>
													</div>   

													<div class="col-md-6 payment_types_fuel_urea_html" hidden>
														<label class="col-form-label">Quantity<span class="text-danger payment_types_fuel_urea_html" hidden>*</span></label>
														<input type="number" step="0.01" name="quantity" id="quantity" class="form-control payment_types_fuel_urea_inpt" >
														<?php
														if ($validation->getError('quantity')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('quantity') . '</div>';
														}
														?>
													</div>  

													<div class="col-md-6 payment_types_fuel_urea_html" hidden>
														<label class="col-form-label">KM Reading<span class="text-danger payment_types_fuel_urea_html" hidden>*</span></label>
														<input type="number" step="0.01" name="km_reading" id="km_reading" class="form-control payment_types_fuel_urea_inpt">
														<?php
														if ($validation->getError('km_reading')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('km_reading') . '</div>';
														}
														?>
													</div>   
		
													<div class="col-md-6">
														<label class="col-form-label">Amount<span class="text-danger">*</span></label>
														<input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
														<?php
														if ($validation->getError('amount')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('amount') . '</div>';
														}
														?>
													</div>  

													<div class="col-md-6 money_html" hidden>
														<label class="col-form-label">Adavanced Payment</label>
														<input type="number" step="0.01" name="adavanced_payment" id="adavanced_payment" class="form-control money_inpt" > 
													</div>  

													<div class="col-md-6">
														<div class="form-wrap">
															<label class="col-form-label">
															Payment Mode<span class="text-danger">*</span>
															</label>
															<select class="form-class select2" id="payment_mode" name="payment_mode" onchange="displayPaymentMode()">
															<option value="">Select</option>
															<option value="1" validinpt="card">Card</option>
															<option value="2" validinpt="upi">UPI</option>
															<option value="3" validinpt="account">Account</option>
															</select>
															<?php
															if ($validation->getError('payment_mode')) {
																echo '<div class="alert alert-danger mt-2">' . $validation->getError('payment_mode') . '</div>';
															}
															?>
														</div>
													</div>

													<div class="col-md-6 form-wrap card_html payment_mode" hidden>
														<label class="col-form-label">Card Number<span class="text-danger card_html" hidden>*</span></label>
														<input type="number" maxlength="20" name="card_no" autocomplete="off" id="card_no" class="form-control card_inpt">
														<?php
														if ($validation->getError('card_no')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('card_no') . '</div>';
														}
														?>
													</div>  

													<div class="col-md-6 form-wrap upi_html payment_mode" hidden>
														<label class="col-form-label">UPI Number<span class="text-danger upi_html" hidden>*</span></label>
														<input type="text" maxlength="30" name="upi_no" autocomplete="off" id="upi_no" class="form-control upi_inpt" onchange="isValid_UPI_ID()" placeholder="test@PNB">
														<span class="text-danger upi_err" hidden>Please enter valid upi</span>
														<?php
														if ($validation->getError('upi_no')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('upi_no') . '</div>';
														}
														?>
													</div>  

													<div class="col-md-6 form-wrap account_html payment_mode" hidden>
														<label class="col-form-label">Account Number<span class="text-danger upi_html" hidden>*</span></label>
														<input type="number" maxlength="30" name="account_no" autocomplete="off" id="account_no" class="form-control account_inpt">
														<?php
														if ($validation->getError('account_no')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('account_no') . '</div>';
														}
														?>
													</div> 
													<input type="hidden" name="transaction_no" id="transaction_no" value=""/>
												</div>
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

	<script>
		function displayDivs(){
			var payment_type_id = $('#payment_type_id').val();  

			//Fuel
			if(payment_type_id == 1){
				$('.fuel_fill_type_html').removeAttr('hidden');
				$('.fuel_fill_type_inpt').attr('required','required');
			}else{
				$('.fuel_fill_type_html').attr('hidden','hidden');
				$('.fuel_fill_type_inpt').removeAttr('required');
				$('#fuel_fill_type').val('').trigger('change');
			}

			//Urea
			if(payment_type_id == 2){
				$('.urea_html').removeAttr('hidden');
				$('.urea_inpt').attr('required','required');
			}else{
				$('.urea_html').attr('hidden','hidden');
				$('.urea_inpt').removeAttr('required');
				$('#vendor_id').val('').trigger('change');
			}

			//Money
			if(payment_type_id == 3){
				$('.money_html').removeAttr('hidden'); 
			}else{
				$('.money_html').attr('hidden','hidden'); 
				$('#adavanced_payment').val('');
			}

			//Fuel or Urea
			if(payment_type_id == 1 || payment_type_id == 2){
				$('.payment_types_fuel_urea_html').removeAttr('hidden');
				$('.payment_types_fuel_urea_inpt').attr('required','required');
			}else{
				$('.payment_types_fuel_urea_html').attr('hidden','hidden');
				$('.payment_types_fuel_urea_inpt').removeAttr('required');
				$('.payment_types_fuel_urea_inpt').val('');
				$('#vehicle_id').val('').select2();
			}
		}

		function displayFuelType(){
			var fuel_fill_type = $('#fuel_fill_type').val();

			//transfer from other vehicle
			if(fuel_fill_type == 1){
				$('.fuel_fill_type_transfer').removeAttr('hidden');
				$('#transfer_from_vehicle_id').attr('required','required');
			}else{
				$('.fuel_fill_type_transfer').attr('hidden','hidden');
				$('#transfer_from_vehicle_id').removeAttr('required');
				$('#transfer_from_vehicle_id').val('').select2();
			}

			//from pump
			if(fuel_fill_type == 2){
				$('.fuel_fill_type_pump').removeAttr('hidden');
				$('#fuel_pump_brand_id').attr('required','required');
			}else{
				$('.fuel_fill_type_pump').attr('hidden','hidden');
				$('#fuel_pump_brand_id').removeAttr('required');
				$('#fuel_pump_brand_id').val('').select2();
			}
		}

		function displayPaymentMode(){
			var payment_mode = $('#payment_mode').find(':selected').val();
			// alert('payment_mode '+payment_mode);
			$('.payment_mode').attr('hidden','hidden');
			$('.payment_mode input').removeAttr('required'); 
			if(payment_mode > 0){
				var html_id = $('#payment_mode').find(':selected').attr('validinpt'); 
				$('.'+html_id+'_html').removeAttr('hidden');
				$('.'+html_id+'_inpt').attr('required','required');
			} 

		}
 

		// Function to validate the
		// upi_Id Code  
		//9136812895@ybl?
		//rahul.12chauhan1998-1@okicici?
		function isValid_UPI_ID() {
			var upi_Id = $('#upi_no').val();
			// Regex to check valid
			// upi_Id
			// let regex = new RegExp(/^[a-zA-Z0-9.-]{2, 256}@[a-zA-Z][a-zA-Z]{2, 64}$/);
			let regex = new RegExp(/^[\w.-]+@[\w.-]+$/);
			// upi_Id
			// is empty return false
			var returnval  = false;
			if (upi_Id == null) {
				returnval =  "false";
			} 
			// Return true if the upi_Id
			// matched the ReGex
			if (regex.test(upi_Id) == true) {
				returnval =  "true";
			}else{
				returnval =  "false";
			}
			// alert('returnval '+returnval); 
			if(returnval == "false"){
				$('#upi_no').val('');
				$('.upi_err').removeAttr('hidden');
			}else{
				$('.upi_err').attr('hidden','hidden');
			}
		}
 
		function duplicateVehicle(id,other_id){
			var selected_inpt = $('#'+id).val();
			var selected_other_inpt = $('#'+other_id).val();
			$('.duplicate_vehicle_spn').attr('hidden','hidden');
			// alert('selected_inpt '+selected_inpt+' / selected_other_inpt = '+selected_other_inpt);
			if(selected_inpt == selected_other_inpt){  
				$('#'+id).val("");
				$('#'+id).select2();
				$('#'+id+'_spn').removeAttr('hidden');
			}
		}

		function getDriverVehicles(){
			var driver_id = $('#driver_id').val();
			var html ='<option value="0">Select Vehicle</option>';
			$('#vehicle_id').html(html);
			if(driver_id > 0){
				$.ajax({
					method: "POST",
					url: '<?php echo base_url('payments/getDriverVehicles') ?>',
					data: {
						driver_id: driver_id
					},
					dataType:'json',
					success: function(response) { 
						if(response){
							response.forEach(function(val) {
								html += '<option value="'+val.id+'">'+val.rc_number+'</option>'
							});
							$('#vehicle_id').html(html);
						} 
					}
				});
			} 
			
		}

		function getSameTypesVehicles(){
			var vehicle_id = $('#vehicle_id').val();
			var html ='<option value="0">Select Vehicle</option>';
			$('#transfer_from_vehicle_id').html(html); 
			if(vehicle_id > 0){
				$.ajax({
					method: "POST",
					url: '<?php echo base_url('payments/getSameTypesVehicles') ?>',
					data: {
						vehicle_id: vehicle_id
					},
					dataType:'json',
					success: function(response) { 
						if(response){
							response.forEach(function(val) {
								html += '<option value="'+val.id+'">'+val.rc_number+'</option>'
							});
							$('#transfer_from_vehicle_id').html(html);
						} 
					}
				});
			} 
		}

		function getDriverBookings(){
			var driver_id = $('#driver_id').val();
			var html ='<option value="0">Select Vehicle</option>';
			$('#reason_id').html(html); 
			if(driver_id > 0){
				$.ajax({
					method: "POST",
					url: '<?php echo base_url('payments/getDriverBookings') ?>',
					data: {
						driver_id: driver_id
					},
					dataType:'json',
					success: function(response) { 
						if(response){
							response.forEach(function(val) {
								html += '<option value="'+val.id+'">'+val.booking_number+'</option>'
							});
							$('#reason_id').html(html);
						} 
					}
				});
			} 
		}

		$("input[name='payment_for']").click(function(){      
			var payment_for = $('input[name="payment_for"]:checked').val();
			$('.driver_div').attr('hidden','hidden');   
			$('#driver_id').removeAttr('required');   
			if(payment_for=='driver'){ 
				$('.driver_div').removeAttr('hidden');   
				$('#driver_id').attr('required','required');   
				$("#payment_type_id").val('').trigger('change').select2();
				$("#payment_type_id").select2({disabled:false}); 
			} 
			if(payment_for == 'vendor'){
				$("#payment_type_id").val($('#money_payment_type_id').val()).trigger('change').select2();
				$("#payment_type_id").select2({disabled:'readonly'});
			}
		});
	</script>
</body>

</html>