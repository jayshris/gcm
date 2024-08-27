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
                                                <h4>Preview Expense Head</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Head Name: </b></label>
                                                        <label class="col-form-label"><?= $expense_heads['head_name'] ?></label>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Balance Sheet / Profit and Loss: </b></label>
                                                        <label class="col-form-label">
                                                            <?php 
                                                            if($expense_heads['type_1'] == 'balance_sheet'){
                                                                echo 'Balance Sheet';	
                                                            }else if($expense_heads['type_1'] == 'profit_and_loss'){
                                                                echo 'Profit and Loss';	
                                                            }else{
                                                                echo '-';
                                                            }												
                                                            ?>
                                                        </label>  
                                                    </div> 

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Operating Expense / Non-Operating Expense: </b></label> 
                                                        <label class="col-form-label">
                                                            <?php
                                                            if($expense_heads['type_2'] == 'operating_expense'){
                                                                echo 'Operating Expense';	
                                                            }else if($expense_heads['type_2'] == 'non_operating_expense'){
                                                                echo 'Non-Operating Expense';	
                                                            }else{
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </label>    
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label"><b>Fixed / Variable: </b></label>
                                                        <label class="col-form-label">
                                                            <?php if($expense_heads['type_3'] == 'fixed'){
                                                                echo 'Fixed';	
                                                            }else if($expense_heads['type_3'] == 'variable'){
                                                                echo 'Variable';	
                                                            }else{
                                                                echo '-';
                                                            }												
                                                            ?>
                                                        </label> 
                                                    </div> 

                                                </div>
                                                <br>
                                            </div> 
                                            <div class="submit-button"> 
                                                <a href="<?php echo base_url(); ?>expensehead" class="btn btn-light">Cancel</a>
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