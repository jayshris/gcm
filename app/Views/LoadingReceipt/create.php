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
											<?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
											<div class="settings-sub-header">
												<h4>Add Loading Receipt</h4>
											</div>
											<?= $this->include('LoadingReceipt/form.php') ?>    
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
					$("#office_id").val(res.office_id).attr("selected","selected").trigger('change').attr('disabled','disabled');
					$("#booking_date").val(res.booking_date).attr('disabled','disabled');
					$("#vehicle_number").val(res.vehicle_id).trigger('change').attr('disabled','disabled');
					$("#consignment_date").attr('min',res.booking_date);
					$("#loading_station").val(res.bp_city);
					$("#delivery_station").val(res.bp_city);
					$("#charge_weight").val(res.guranteed_wt);
				}
			});
		}

		$(document).ready(function() {
			$("#consignor_name").select2({
				tags: true
			}); 
			 $("#consignee_name").select2({
				tags: true
			}); 
 
		}); 
		function changeIdIpt(thisv,party_id,id,key = 'consignor'){   
			$('#'+id).val( (party_id) > 0 ? party_id : 0) ;

			if(party_id>0){
				$.ajax({
				method: "POST",
				url: '<?php echo base_url('loadingreceipt/getPartyDetails') ?>',
				data: {
					party_id: party_id
				},
				dataType: "json",
				success: function(res) { 
					// alert(res.state_id); 
						var pre = 'place_of_delivery';
						if(key == 'consignor'){
							pre = 'place_of_dispatch';
						}
						$("#"+key+"_state").val(res.state_id).attr("selected","selected").trigger('change');  
						$("#"+pre+"_state").val(res.state_id).attr("selected","selected").trigger('change');  
						$("#"+key+"_address").val(res.business_address);
						$("#"+pre+"_address").val(res.business_address);

						$("#"+key+"_city").val(res.city);
						$("#"+pre+"_city").val(res.city);

						$("#"+key+"_pincode").val(res.postcode);
						$("#"+pre+"_pincode").val(res.postcode);
					}
				});
			}
		}
		
	</script>
</body>

</html>