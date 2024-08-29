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
    </style>
</head>
<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<?= $this->include('partials/menu') ?> 
        <hr>
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
                                                <h4>Preview Consignment Note</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Consignment No: </label>
                                                        <label class="col-form-label"><?= $lr['consignment_no'] ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Booking Number: </label>
                                                        <label class="col-form-label"><?= $lr['booking_number'] ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Customer Name: </label>
                                                        <label class="col-form-label"><?= $lr['customer'] ?></label>  
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Booking Date: </label>
                                                        <label class="col-form-label"><?= date('d M Y',strtotime($lr['booking_date'])) ?></label> 
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Pick Location: </label> 
                                                        <label class="col-form-label"><?= $lr['bp_city'] ?></label>    
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Drop Location: </label>
                                                        <label class="col-form-label"><?= $lr['bd_city'] ?></label> 
                                                    </div>
 
                                                </div>
                                                <br>
                                            </div> 
                                            <div class="submit-button noprint"> 
                                                <button type="button" class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                                <a href="<?php echo base_url().$currentController; ?>" class="btn btn-light">Cancel</a>
                                            </div>  
										</div>
									</div>
								</div>
								<!-- /Settings Info -->
                                
                                <div class="card" id="printableArea" style="display: none;">
                                    <div class="card-body">  
                                        <?= $this->include('ConsignmentNote/consignee_note.php') ?> 
                                        <?= $this->include('ConsignmentNote/terms_and_conditions.php') ?>
                                        <?= $this->include('ConsignmentNote/consignor_note.php') ?>
                                        <?= $this->include('ConsignmentNote/terms_and_conditions.php') ?>
                                        <?= $this->include('ConsignmentNote/truck_forwarding_note.php') ?>
                                        <?= $this->include('ConsignmentNote/terms_and_conditions.php') ?>
                                    </div>
                                </div>


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
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>

</html>