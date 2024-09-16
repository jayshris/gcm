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
											<div class="profile-details">
												<div class="row g-3">
													<div class="col-md-4">
														<label class="col-form-label">Vehicle Number</label> 
														<select class="form-select select2" name="vehicle_id" id="vehicle_number" aria-label="Default select example" onchange="$.getVehicleBookings();">
															<option value="">Select Vehicle</option>
															<?php foreach ($vehicles as $o) { ?> 
																<option value="<?= $o['id'] ?>"><?= $o['rc_number'] ?></option> 
															<?php } ?>
														</select>
														<?php
														if ($validation->getError('booking_date')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_date') . '</div>';
														}
														?>
													</div>

													<div class="col-md-4">
														<label class="col-form-label">Booking Order No<span class="text-danger">*</span></label> 
														<select class="form-select select2" required name="booking_id" id="booking_id" aria-label="Default select example"  onchange="$.getBookingDetails();">
															<option value="">Select Booking No.</option>
															<?php foreach ($bookings as $o) { ?>
															<option value="<?= $o['id'] ?>" <?= (isset($proforma_invoice['booking_id']) && ($proforma_invoice['booking_id'] == $o['id'])) ? 'selected' : ''?> ><?= $o['booking_number'] ?></option> 
															<?php } ?>
														</select>
														<?php
														if ($validation->getError('booking_id')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_id') . '</div>';
														}
														?>
													</div>

													<div class="col-md-4">
														<label class="col-form-label">Bill to Party<span class="text-danger">*</span></label>
														<select class="form-select select2" required name="bill_to_party_id" id="bill_to_party_id" onchange="checkTaxApplicable()">
															<option value="">Select Bill to Party</option> 
														</select>
														<input type="hidden" id="selecected_bill_to_party_id" value="<?= isset($proforma_invoice['bill_to_party_id']) && ($proforma_invoice['bill_to_party_id'] > 0) ? $proforma_invoice['bill_to_party_id'] : 0 ?>"/>
														<?php
														if ($validation->getError('bill_to_party_id')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('bill_to_party_id') . '</div>';
														}
														?>
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
											<div class="submit-button">
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
		if($('#id').val()){
			$.getBookingDetails($('#id').val());
		}		
    });
	$.getVehicleBookings = function() {
		var vehicle_id = $('#vehicle_number').val(); 		
		$.ajax({
		method: "POST",
		url: '<?php echo base_url('proformainvoices/getVehicleBookings'); ?>' ,
		data: {
			vehicle_id: vehicle_id
		},
		dataType: "json",
		success: function(res) { 
				console.log(res);
				var html  ='<option value="">Select Booking No.</option>';
				if(res){
					$.each(res, function(i, item) {  
						var selected = (i=0) ? 'selected' : '';
						html += '<option value="'+item.id+'" selected="'+selected+'">'+item.booking_number+'</option>'; 
					}); 
					$('#booking_id').html(html); 
					$('#booking_id').val($('#booking_id').val()).attr("selected","selected").trigger('change');  
				}
			}
		}); 
		
	}

	$.getBookingDetails = function(id = 0) {
		var booking_id = $('#booking_id').val();  
		if(booking_id){
			$.ajax({
				method: "POST",
				url: '<?php echo base_url('proformainvoices/getBookingExpense/'); ?>'+booking_id+'/'+id, 
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
				url: '<?php echo base_url('proformainvoices/getBookingCustomers/'); ?>'+booking_id, 
				dataType:'json',
				success: function(res) { 
					var html = '<option value="">Select Bill to Party</option>';
					if(res){
						var selecected_bill_to_party_id = $('#selecected_bill_to_party_id').val();
						$.each(res, function(i, val) {  
							var selected = (selecected_bill_to_party_id > 0) && (selecected_bill_to_party_id == val.id) && (id > 0) ? 'selected' : '';
							html += '<option value="'+val.id+'" '+selected+'>'+val.party_name+'</option>';
						});
					}
					$('#bill_to_party_id').html(html);
					$('#bill_to_party_id').trigger('change');
				}
			});

			// $.ajax({
			// 	method: "POST",
			// 	url: '<?php echo base_url('proformainvoices/getBookingDetails/'); ?>'+booking_id, 
			// 	dataType:'json',
			// 	success: function(res) {  
			// 		if(id <1){
			// 			$('#invoice_total_amount').val(res);
			// 		}
			// 		alert(' invoice_total_amount '+res); 
					
			// 	}
			// });
			
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
          freight = (rate * guranteed_wt) + billtotal;
        } else {
          freight = rate + billtotal;
        }

        $('#freight').val(freight.toFixed(2));
		
        var advance = ($('#advance').val());
        var discount = ($('#discount').val());
        var balance = (freight - advance - discount).toFixed(2); 
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
		var SGST_total = parseFloat($('#SGST_total').val());
		var CGST_total = parseFloat($('#CGST_total').val());
		var IGST_total = parseFloat($('#IGST_total').val());
		var invoice_total_amount = (freight+SGST_total+CGST_total+IGST_total); 
		$('#invoice_total_amount').val(invoice_total_amount.toFixed(2)); 
	}
	function calculateTax(id){
		var tax_percent = parseFloat($('#'+id+'_percent').val());  
		// alert(tax_percent);
		if(tax_percent > 0){
			var freight  =  parseFloat($('#freight').val());
			var tax_total = (freight*tax_percent)/100;
			// alert('#'+id+'_total'+' / freight ='+freight+' / tax_total ='+tax_total);
			$('#'+id+'_total').val(tax_total.toFixed(2));
		}else{
			$('#'+id+'_total').val(0);
		}
	}
 
	</script>
</body>

</html>