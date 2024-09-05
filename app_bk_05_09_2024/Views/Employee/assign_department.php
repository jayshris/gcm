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
												<h4>Assign Department</h4>
											</div>
											<div class="profile-details">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                                            <select class="select" id="department_id" name="department_id" required>
                                                                <option value="">Select Department</option>
                                                                <?php
																$selected = isset($last_emp_dept_data["department_id"]) ? $last_emp_dept_data["department_id"] : '';
                                                                foreach ($departments as $row) { ?>
                                                                <option value="<?= $row["id"] ?>"  <?= ($selected == $row["id"]  ? 'selected' : set_select('department_id', $row['id']) ) ?>><?= $row["dept_name"] ?></option>
                                                                <?php  }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Start Date<span class="text-danger">*</span></label>
														<?php $start_date = isset($last_emp_dept_data["start_date"])  && (strtotime($last_emp_dept_data["start_date"]) > 0) ? date('Y-m-d',strtotime($last_emp_dept_data["start_date"])) : date('Y-m-d'); ?>
                                                        <input type="date" required name="start_date" value="<?= $start_date ?>" min="<?= $start_date ?>" class="form-control">
                                                        <?php
                                                        if ($validation->getError('start_date')) {
                                                            echo '<div class="alert alert-danger mt-2">' . $validation->getError('start_date') . '</div>';
                                                        }   
                                                        ?>
                                                    </div>  
                                                </div>
                                            </div>

											
											<div class="submit-button mt-3">
												<button type="submit" class="btn btn-primary">Save Changes</button>
												<button type="reset" class="btn btn-secondary">Reset</button>
												<a href="<?php echo base_url($currentController); ?>" class="btn btn-light">Back</a>
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