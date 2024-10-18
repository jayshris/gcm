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
											<?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.((isset($token) && $token >0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
											<input type="hidden" id="id" value="<?= $token ?>" />
											<div class="settings-sub-header">
												<h4>Tax Invoice</h4>
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
														<?php if($bookings){ foreach ($bookings as $o) { ?>
															<option value="<?= $o['id'] ?>" <?= (isset($invoice['booking_id']) && ($invoice['booking_id'] == $o['id'])) ? 'selected' : ''?> ><?= $o['booking_number'] ?></option> 
															<?php }}else{ ?>
															<option value="">Select Booking No.</option>
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
														<select class="form-select select2" required name="bill_to_party_id" id="bill_to_party_id" aria-label="Default select example">
															<option value="">Select Bill to Party</option> 
														</select>
														<input type="hidden" id="selecected_bill_to_party_id" value="<?= isset($invoice['bill_to_party_id']) && ($invoice['bill_to_party_id'] > 0) ? $invoice['bill_to_party_id'] : 0 ?>"/>
														<?php
														if ($validation->getError('bill_to_party_id')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('bill_to_party_id') . '</div>';
														}
														?>
													</div>	  

													<div class="col-md-12"  id="expense_div_body"></div>
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
			$.getBookingDetails();
		}		
    });
	$.getVehicleBookings = function() {
		var vehicle_id = $('#vehicle_number').val();
		
		$.ajax({
			method: "POST",
			url: '<?php echo base_url('taxinvoices/getVehicleBookings'); ?>' ,
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

	$.getBookingDetails = function() { 
		var booking_id = $('#booking_id').val(); 
		if(booking_id){
			$.ajax({
				method: "POST",
				url: '<?php echo base_url('taxinvoices/getBookingExpense/'); ?>'+booking_id, 
				success: function(res) { 
					$('#expense_div_body').html(res);
				}
			});

			$.ajax({
				method: "POST",
				url: '<?php echo base_url('taxinvoices/getBookingCustomers/'); ?>'+booking_id, 
				dataType:'json',
				success: function(res) { 
					var html = '<option value="">Select Customer</option>';
					if(res){
						var selecected_bill_to_party_id = $('#selecected_bill_to_party_id').val();
						$.each(res, function(i, val) {
							var selected = (selecected_bill_to_party_id > 0) && (selecected_bill_to_party_id == val.id) ? 'selected' : '';
							html += '<option value="'+val.id+'" '+selected+'>'+val.party_name+'</option>';
						});
					}
					$('#bill_to_party_id').html(html);
				}
			});

			$.ajax({
				method: "POST",
				url: '<?php echo base_url('taxinvoices/getBookingDetails/'); ?>'+booking_id, 
				dataType:'json',
				success: function(res) {  
					if(res){
						$('#total_freight').val(res.freight);
					} 
				}
			});
		}else{
			$('#expense_div_body').html('');
			$('#bill_to_party_id').html('');
			$('#total_freight').val('');
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
		$('#other_expenses').val(billtotal.toFixed(2));
        $('#freight').val(freight.toFixed(2));

        var advance = ($('#advance').val());
        var discount = ($('#discount').val());
        var balance = ((freight+billtotal) - advance - discount).toFixed(2); 
		// alert(freight + advance +discount + '= '+balance);
        $('#balance').val(balance); 
      }
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

	</script>
</body>

</html>