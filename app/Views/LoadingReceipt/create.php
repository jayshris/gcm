<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?>
</head>
<body>
	<div class="main-wrapper">
		<?= $this->include('partials/menu') ?>
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
								<div class="card">
									<div class="card-body">
										<div class="settings-form">
											<div class="settings-sub-header">
												<h3>Add Loading Receipt</h3>
											</div>

											<?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'searchForm', 'id'=>'searchForm','method'=>'get']);?>
											<div class="col-lg-12 col-md-12 d-flex">
									            <div class="security-grid flex-fill" style="background: #FCE9E6;color: #E41F07;">
								                    <div class="security-heading">
								                        <h4 style="color: #E41F07;">Search E-WayBill from GST Portal</h4>
								                    </div>
								                    <hr>

								                    <div class="row">
								                        <div class="col-md-3">
								                            <?php 
								                            $label = 'Bill Number';
								                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
								                            echo form_input(['name'=>'bill_no','id'=>'bill_no','value'=>set_value('bill_no', (isset($loading_receipts['bill_no']) ? $loading_receipts['bill_no'] : '')),'class'=>'form-control '.(($validation->getError('bill_no')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'required'=>'required']);
								                            echo ($validation->getError('bill_no')) ? '<div class="invalid-feedback">'.$validation->getError('bill_no').'</div>' : '';
								                            ?>
								                        </div>

								                        <div class="col-md-2">
								                            <?php 
								                            $label = 'Bill Date';
								                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
								                            echo form_input(['type'=>'date', 'name'=>'bill_date','id'=>'bill_date','value'=>set_value('bill_date', (isset($loading_receipts['bill_date']) ? $loading_receipts['bill_date'] : '')),'class'=>'form-control '.(($validation->getError('bill_date')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'required'=>'required']);
								                            echo ($validation->getError('bill_date')) ? '<div class="invalid-feedback">'.$validation->getError('bill_date').'</div>' : '';
								                            ?>
								                        </div>

								                        <div class="col-md-2">
								                            <?php 
								                            $label = 'Bill Generator';
								                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
								                            echo form_input(['name'=>'bill_generator','id'=>'bill_generator','value'=>set_value('bill_generator', (isset($loading_receipts['bill_generator']) ? $loading_receipts['bill_generator'] : '')),'class'=>'form-control '.(($validation->getError('bill_generator')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'required'=>'required']);
								                            echo ($validation->getError('bill_generator')) ? '<div class="invalid-feedback">'.$validation->getError('bill_generator').'</div>' : '';
								                            ?>
								                        </div>

								                        <div class="col-md-3">
								                            <?php 
								                            $label = 'Document Number';
								                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
								                            echo form_input(['name'=>'doc_no','id'=>'doc_no','value'=>set_value('doc_no', (isset($loading_receipts['doc_no']) ? $loading_receipts['doc_no'] : '')),'class'=>'form-control '.(($validation->getError('doc_no')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'required'=>'required']);
								                            echo ($validation->getError('doc_no')) ? '<div class="invalid-feedback">'.$validation->getError('doc_no').'</div>' : '';
								                            ?>
								                        </div>

								                        <div class="col-md-2" style="margin-top: 25px;">
								                        	<?php
								                        	echo form_button(array('type'=>'submit','name'=>'search','id'=>'search','value'=>'true','content'=>'<i class="fa fa-search"></i> Search','class'=> 'btn btn-danger'));
								                        	echo form_button(array('type'=>'button','onClick'=>"window.location.href='".base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : '')."'",'value'=>'true','content'=>'<i class="fa fa-refresh"></i> Reset','class'=> 'btn btn-warning'));
								                        	?>
								                        </div>
								                    </div>
									            </div>
									        </div>
									        <?php echo form_close(); ?>

											<?php
											echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);
											echo $this->include('LoadingReceipt/form.php');
											echo form_close();
											?>    
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<?= $this->include('partials/vendor-scripts') ?> 

	<input type="hidden" id="base_url" value="<?php echo base_url() ?>" />
	<script src="<?php echo base_url(); ?>public/assets/js/loading_receipt.js"></script>
 
</body>
</html>