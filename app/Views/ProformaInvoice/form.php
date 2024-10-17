<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?>
	<style>
		.tr-readonly{
			pointer-events:none;
		}
		.tr-block{
			pointer-events: visible;
		}
		.per-lbl{
			font-size: large;
    		padding-top: 5px;
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
											<?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.((isset($token) && $token >0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
											<input type="hidden" id="id" value="<?= $token ?>" />
											<div class="settings-sub-header">
												<h4>Proforma Invoice</h4>
											</div>
											<?php if($token > 0) { ?> 
												<input type="hidden" name="vehicle_id" value="<?= isset($proforma_invoice['vehicle_id']) ? $proforma_invoice['vehicle_id'] : 0 ?>"/>
												<!-- <input type="hidden" name="booking_id" value="<?= isset($proforma_invoice['booking_id']) ? $proforma_invoice['booking_id'] : 0 ?>"/> -->
											<?php } ?>
											<div class="profile-details">
												<div class="row g-3">
													<div class="col-md-4">
														<label class="col-form-label">Vehicle Number<span class="text-danger">*</span></label>  
														<select class="form-select select2" required name="vehicle_id" id="vehicle_number" aria-label="Default select example" onchange="$.getVehicleBookingDetails();" <?= ($token > 0) ? 'disabled' : '' ?>>
															<option value="">Select Vehicle</option>
															<?php foreach ($vehicles as $o) { ?> 
																<option value="<?= $o['id'] ?>"  <?= (isset($proforma_invoice['vehicle_id']) && ($proforma_invoice['vehicle_id'] == $o['id'])) ? 'selected' : ''?> ><?= $o['rc_number'] ?></option> 
															<?php } ?>
														</select>
														<?php
														if ($validation->getError('booking_date')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_date') . '</div>';
														}
														?>
													</div>
													<div class="row  g-3" id="booking_details_div">
														
													</div>
													 
													<div class="row g-3" hidden id="bill_to_party_div">
														<div class="col-md-4">
															<label class="col-form-label">Bill to Party<span class="text-danger">*</span></label>
															<select class="form-select select2" required name="bill_to_party_id" id="bill_to_party_id" onchange="checkTaxApplicable();getCustomerBranches()">
																<option value="">Select Bill to Party</option> 
															</select>
															<input type="hidden" id="selecected_bill_to_party_id" value="<?= isset($proforma_invoice['bill_to_party_id']) && ($proforma_invoice['bill_to_party_id'] > 0) ? $proforma_invoice['bill_to_party_id'] : 0 ?>"/>
															<?php
															if ($validation->getError('bill_to_party_id')) {
																echo '<div class="alert alert-danger mt-2">' . $validation->getError('bill_to_party_id') . '</div>';
															}
															?>
														</div>	    

														<div class="col-md-4">
															<label class="col-form-label">Bill to Branch<span class="text-danger">*</span></label> 
															<select class="form-select select2" required name="customer_branch_id" id="customer_branch_id">
																<option value="">Select Branch</option> 
															</select>
															<input type="hidden" id="selecected_customer_branch_id" value="<?= isset($proforma_invoice['customer_branch_id']) && ($proforma_invoice['customer_branch_id'] > 0) ? $proforma_invoice['customer_branch_id'] : 0 ?>"/>
															<?php
															if ($validation->getError('customer_branch_id')) {
																echo '<div class="alert alert-danger mt-2">' . $validation->getError('customer_branch_id') . '</div>';
															}
															?>
														</div>
													</div>  

													<div class="col-md-12"  id="expense_div_body"></div>

													<div class="row g-3"  id="tax_applicable_div" >
														<div class="row g-3 tax_div" hidden>
															<div class="col-md-6"></div>
															<div class="col-md-1">
																<label class="col-form-label">SGST@</label>
															</div>
															<div class="col-md-2">
																<input type="number" step="0.01"  min="0" max="100" class="form-control" name="sgst_percent" id="SGST_percent"  onchange="calculate_tax_percent('SGST')" value="<?= isset($proforma_invoice['sgst_percent']) && ($proforma_invoice['sgst_percent'] > 0) ? $proforma_invoice['sgst_percent'] : 0 ?>"/>
															</div>
															<div class="col-md-1"><label class="col-form-label per-lbl">%</label></div>
															<div class="col-md-2">
																<input type="number" step="0.01" readonly class="form-control" id="SGST_total" name="sgst_total" value="<?= isset($proforma_invoice['sgst_total']) && ($proforma_invoice['sgst_total'] > 0) ? $proforma_invoice['sgst_total'] : 0 ?>"/>
															</div>
														</div>
														<div class="row g-3 tax_div" hidden>
															<div class="col-md-6"></div>
															<div class="col-md-1"> 
																<label class="col-form-label">CGST@</label>
															</div>
															<div class="col-md-2">
																<input type="number" step="0.01" min="0" max="100" class="form-control" name="cgst_percent" id="CGST_percent"  onchange="calculate_tax_percent('CGST')"  value="<?= isset($proforma_invoice['cgst_percent']) && ($proforma_invoice['cgst_percent'] > 0) ? $proforma_invoice['cgst_percent'] : 0 ?>"/> 
															</div>
															<div class="col-md-1"><label class="col-form-label per-lbl">%</label></div>
															<div class="col-md-2">
																<input type="number" step="0.01" readonly class="form-control" name="cgst_total" id="CGST_total" value="<?= isset($proforma_invoice['cgst_total']) && ($proforma_invoice['cgst_total'] > 0) ? $proforma_invoice['cgst_total'] : 0 ?>"/>
															</div>
														</div>
														<div class="row g-3 tax_div" hidden>
															<div class="col-md-6"></div>
															<div class="col-md-1"> 
																<label class="col-form-label">IGST@</label>
															</div>
															<div class="col-md-2">
																<input type="number" step="0.01" min="0"  max="100" class="form-control" name="igst_percent" id="IGST_percent"  onchange="calculate_tax_percent('IGST')" value="<?= isset($proforma_invoice['igst_percent']) && ($proforma_invoice['igst_percent'] > 0) ? $proforma_invoice['igst_percent'] : 0 ?>"/>
															</div>
															<div class="col-md-1"><label class="col-form-label per-lbl">%</label></div>
															<div class="col-md-2">
																<input type="number" step="0.01" readonly class="form-control" id="IGST_total"  name="igst_total" value="<?= isset($proforma_invoice['igst_total']) && ($proforma_invoice['igst_total'] > 0) ? $proforma_invoice['igst_total'] : 0 ?>"/>
															</div>
														</div>
														<div class="row g-3 invoice_total_amount_div" hidden>
															<div class="col-md-7"></div> 
															<div class="col-md-3"><label class="col-form-label per-lbl">Invoice Total Amount:</label></div>
															<div class="col-md-2">
																<input type="number" step="0.01" readonly class="form-control" id="invoice_total_amount"  name="invoice_total_amount" value="<?= isset($proforma_invoice['invoice_total_amount']) && ($proforma_invoice['invoice_total_amount'] > 0) ? $proforma_invoice['invoice_total_amount'] : 0 ?>"/>
															</div>
														</div>
													</div> 

												</div>
												<br>
											</div> 
											<div class="submit-button" id="form_submit" hidden>
												<input type="submit" class="btn btn-primary" value="Save">
												<a href="<?php echo base_url().$currentController; ?>"  class="btn btn-warning">Reset</a>
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
	$(document).ready(function() {
		if(($('#id').val()) > 0){
			$.getVehicleBookingDetails($('#id').val());
		}		
    });
	$.getVehicleBookingDetails = function(id) {
		var vehicle_id = $('#vehicle_number').val(); 	
		// alert('vehicle_id '+vehicle_id);	
		$.ajax({
		method: "POST",
		url: '<?php echo base_url('proformainvoices/getVehicleBookingDetails/'); ?>'+id ,
		data: {
			vehicle_id: vehicle_id
		}, 
		success: function(res) { 
				$('#booking_details_div').html(res);  
				if(($('#id').val()) > 0){ show_data(id); }  
 			}
		}); 
		
	}

	$.getBookingDetails = function(booking_ids,id = 0) {  
		if(booking_ids){
			$.ajax({
				method: "POST",
				url: '<?php echo base_url('proformainvoices/getMultipleBookingExpenses/'); ?>'+id, 
				data: {
					booking_ids: JSON.stringify(booking_ids),
				}, 
				success: function(res) { 
					$('#expense_div_body').html(res);  
					$('.invoice_total_amount_div').removeAttr('hidden'); 
					if(id == 0){
						$.calculation();	
					}  
					
				}
			});

			$.ajax({
				method: "POST",
				url: '<?php echo base_url('proformainvoices/getMultipleBookingCustomers'); ?>', 
				data: {
					booking_ids: JSON.stringify(booking_ids),
				},
				dataType:'json',
				success: function(res) { 
					var html = '<option value="">Select Bill to Party</option>';
					if(res.customers){
						var selecected_bill_to_party_id = $('#selecected_bill_to_party_id').val();
						$.each(res.customers, function(i, val) {  
							var selected = (selecected_bill_to_party_id > 0) && (selecected_bill_to_party_id == val.id) && (id > 0) ? 'selected' : '';
							html += '<option value="'+val.id+'" '+selected+'>'+val.party_name+'</option>';
						});
					}
					$('#bill_to_party_id').html(html);
					$('#bill_to_party_id').trigger('change'); 
					$('#bill_to_party_div').removeAttr('hidden');
				}
			}); 

		}else{
			$('#expense_div_body').html('');
			$('#bill_to_party_id').val(''); 
			$('.invoice_total_amount_div').attr('hidden','hidden'); 
		} 	
			
	}	

	$.billToParty = function(index) {
      if ($("#expense_flag_" + index).prop("checked")) {
        $('#expense_' + index).addClass('bill');
        $('#expense_' + index).removeClass('not_to_bill');
      } else {
        $('#expense_' + index).addClass('not_to_bill');
        $('#expense_' + index).removeClass('bill');
      }

      $.calculation(); 
    }

    $.calculation = function() {
      var rate_type = parseInt($('#rate_type').val());
      var rate = parseFloat($('#rate').val());
      var freight = 0; 

      var notbilltotal = 0;
        $('.not_to_bill').each(function() {
          notbilltotal += parseFloat($(this).val());
        });
        $('#discount').val(notbilltotal.toFixed(2)); 
      if (rate > 0) {

        var billtotal = 0;
        $('.bill').each(function() {
          billtotal += parseFloat($(this).val());
        });

        console.log(billtotal);

        freight = freight;

        // for guranteed weight
        if (rate_type == 1) {
          var guranteed_wt = parseFloat($('#guranteed_wt').val());
          freight = (rate * guranteed_wt);
        } else {
          freight = rate;
        }
		$('#other_expenses').val(billtotal);
        $('#freight').val(freight.toFixed(2));
		
        var advance = ($('#advance').val());
        var discount = ($('#discount').val());
        var balance = ((freight+billtotal) - advance - discount).toFixed(2); 
		// alert(freight + advance +discount + '= '+balance);
        $('#balance').val(balance); 
      }
	  calculate_tax_percent('all'); 
    }

	$.delete = function(index, str) {
      $('#del_' + str + '_' + index).remove();
      $.calculation();
    }

	$.addExpense = function() {
      var tot = $('#expense_table').children('tbody').children('tr').length;

      console.log(tot);
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('booking/addExpense'); ?>",
        data: {
          index: tot
        },
        success: function(data) {
          $('#expense_body').append(data);
        }
      })
    }

	function checkTaxApplicable(){  
		var bill_to_party_id = $('#bill_to_party_id').val();
		if(bill_to_party_id> 0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('proformainvoices/checkTaxApplicable/'); ?>"+bill_to_party_id, 
				success: function(tax_applicable_cnt) {
					if(tax_applicable_cnt > 0){ 
						$('.tax_div').removeAttr('hidden');
					}else{
						updateTaxDiv();
					}
				}
			})
		}else{
			updateTaxDiv();
		}    
	}
	function updateTaxDiv(){
		$('.tax_div').attr('hidden','hidden');
		$('.tax_div input').val(0);
		calculate_tax_percent('all'); 
	}
	function calculate_tax_percent(id){ 
		if(id == 'all'){
			$.each(['SGST','CGST','IGST'], function(i, idval) { 
				calculateTax(idval);
			});
		}else{
			calculateTax(id);
		}
		var freight = parseFloat($('#freight').val());
		var other_expenses = parseFloat($('#other_expenses').val());
		var SGST_total = parseFloat($('#SGST_total').val());
		var CGST_total = parseFloat($('#CGST_total').val());
		var IGST_total = parseFloat($('#IGST_total').val());
		var invoice_total_amount = (freight+other_expenses+SGST_total+CGST_total+IGST_total); 
		$('#invoice_total_amount').val(invoice_total_amount.toFixed(2)); 
	}
	function calculateTax(id){
		var tax_percent = parseFloat($('#'+id+'_percent').val());
		var other_expenses = parseFloat($('#other_expenses').val());  
		// alert(tax_percent);
		if(tax_percent > 0){
			var freight  =  parseFloat($('#freight').val());
			var tax_total = ((freight+other_expenses)*tax_percent)/100;
			// alert('#'+id+'_total'+' / freight ='+freight+' / tax_total ='+tax_total);
			$('#'+id+'_total').val(tax_total.toFixed(2));
		}else{
			$('#'+id+'_total').val(0);
		}
	}
 
	function getCustomerBranches(){
		var bill_to_party_id = $('#bill_to_party_id').val();
		var html = "<option value=''>Select Branch</option>"; 
		$('#customer_branch_id').html(html);
		if(bill_to_party_id> 0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('proformainvoices/getCustomerBranches/'); ?>"+bill_to_party_id, 
				dataType:'json',
				success: function(response) {
					if(response){  
						var selecected_customer_branch_id = $('#selecected_customer_branch_id').val();
						response.forEach(function(val) { 
							var selected = (selecected_customer_branch_id > 0) && (selecected_customer_branch_id == val.id) && ($('#id').val() > 0) ? 'selected' : '';
							html +='<option value="'+val.id+'" '+selected+'>'+val.office_name+'</option>'
						});
						$('#customer_branch_id').html(html);
					} 
				}
			})
		}
	}
	function show_data(id =0){  
		let booking_ids = []; 
		let differentCustIds = [];  
		let differentRateTypes = [];  
		$('#error_msg').html(); 
		$('#error_msg').attr('hidden','hidden');  
		$("input:checkbox[name='booking_id[]']:checked").each(function() { 
			booking_ids.push($(this).val()); 
			let customer_id = $('#customer_id_'+$(this).val()).val();
			let rate_type = $('#rate_type_'+$(this).val()).val();
			if ($.inArray(customer_id, differentCustIds) == -1) differentCustIds.push(customer_id); 
			if ($.inArray(rate_type, differentRateTypes) == -1) differentRateTypes.push(rate_type); 
		});    
		console.log(differentCustIds);console.log(differentRateTypes);
		// alert('booking_ids.length '+booking_ids.length +' //  differentCustIds '+ differentCustIds.length +' //  differentRateTypes '+ differentRateTypes.length);
		let error = false;
		if(booking_ids.length < 1){  
			$('#error_msg').html("Checkbox is not selected, Please select one!").removeAttr('hidden');error = true;
		}else if(differentCustIds.length>1){
			$('#error_msg').html("All Customer must be same! Please select similar customer bookings").removeAttr('hidden'); error = true; 
		}else if(differentRateTypes.length>1){
			$('#error_msg').html("Rate types must be same for all bookings!").removeAttr('hidden');error = true;  
		}
		
		if(!error){
			console.log(booking_ids);
			$.getBookingDetails(booking_ids,id);

			$('#form_submit').removeAttr('hidden');
		}else{
			$('#expense_div_body').html('');
			$('#bill_to_party_id').val('');
			$('#bill_to_party_id').trigger('change'); 
			$('#bill_to_party_div').attr('hidden','hidden'); 
			$('.invoice_total_amount_div').attr('hidden','hidden'); 
			$('.tax_div').attr('hidden','hidden');
			$('.tax_div input').val(0);
			$('#form_submit').attr('hidden','hidden');
		}  
	}  
	</script> 
</body>

</html>