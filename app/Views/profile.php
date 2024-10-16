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

						<?= $this->include('partials/page-title') ?>
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
													<h6>Company Information</h6>
												</div>
												<div class="form-wrap">
													<div class="profile-upload">
														<div class="profile-upload-img">
															<span><i class="ti ti-photo"></i></span>
															<?php if (isset($profile_data['company_logo']) && $profile_data['company_logo'] != '') { ?>
																<img id="ImgPreview" src="<?= $profile_data['company_logo'] ?>" alt="img" name="company_logo">
															<?php } else { ?>
																<span><i class="ti ti-photo"></i></span>
																<img id="ImgPreview" src="<?= base_url(); ?>assets/img/profiles/avatar-02.jpg" alt="img" name="company_logo" class="preview1">
															<?php } ?>
															<button type="button" id="removeImage1" class="profile-remove">
																<i class="feather-x"></i>
															</button>
														</div>
														<div class="profile-upload-content">
															<strong style="font-weight: 500;">Company Logo</strong> <br>
															<label class="profile-upload-btn">
																<i class="ti ti-file-broken"></i> Upload file
																<input type="file" id="imag" name="company_logo" class="input-img">
															</label>
															<?php
															if ($validation->getError('company_logo')) {
																echo '<div class="alert alert-danger mt-2">' . $validation->getError('company_logo') . '</div>';
															}
															?>
															<p>JPG, GIF or PNG. Max size of 800K</p>
														</div>
													</div>
												</div>
												<div class="profile-details">
													<div class="row">
														<div class="col-md-4">
															<div class="form-wrap">
																<label class="col-form-label">
																	Company Name <span class="text-danger">*</span>
																</label>
																<input type="text" name="company_name" value="<?php
																												if (isset($profile_data)) {
																													echo $profile_data['company_name'];
																												} else {
																													echo set_value('company_name');
																												} ?>" class="form-control">
																<?php
																if ($validation->getError('company_name')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('company_name') . '</div>';
																}
																?>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-wrap">
																<label class="col-form-label">
																	Abbreviation <span class="text-danger">*</span>
																</label>
																<input type="text" name="abbreviation" value="<?php
																												if (isset($profile_data)) {
																													echo $profile_data['abbreviation'];
																												} else {
																													echo set_value('abbreviation');
																												}
																												?>" class="form-control">
																<?php
																if ($validation->getError('abbreviation')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('abbreviation') . '</div>';
																}
																?>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-wrap">
																<label class="col-form-label">
																	Email id<span class="text-danger">*</span>
																</label>
																<input type="text" class="form-control" name="email" value="<?php
																															if (isset($profile_data)) {
																																echo $profile_data['email'];
																															} else {
																																echo set_value('email');
																															}
																															?>">
																<?php
																if ($validation->getError('email')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('email') . '</div>';
																}
																?>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-wrap">
																<label class="col-form-label">
																	Landline No.
																</label>
																<input type="text" class="form-control" name="landline_number" value="<?php
																																		if (isset($profile_data)) {
																																			echo $profile_data['landline_number'];
																																		} else {
																																			set_value('landline_number');
																																		}
																																		?>">
																<?php
																if ($validation->getError('landline_number')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('landline_number') . '</div>';
																}

																?>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-wrap">
																<label class="col-form-label">
																	Mobile No. <span class="text-danger">*</span>
																</label>
																<input type="text" class="form-control" name="phone_number" value="<?php
																																	if (isset($profile_data)) {
																																		echo $profile_data['phone_number'];
																																	} else {
																																		set_value('phone_number');
																																	}
																																	?>">
																<?php
																if ($validation->getError('phone_number')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('phone_number') . '</div>';
																}

																?>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-wrap">
																<label class="col-form-label">
																	Alternate Phone No.
																</label>
																<input type="text" class="form-control" name="alternate_phone_number" value="<?php
																																				if (isset($profile_data)) {
																																					echo $profile_data['alternate_phone_number'];
																																				} else {
																																					set_value('alternate_phone_number');
																																				}
																																				?>">
																<?php
																if ($validation->getError('alternate_phone_number')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('alternate_phone_number') . '</div>';
																}

																?>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-wrap">
																<label class="col-form-label">
																	GST Number <span class="text-danger">*</span>
																</label>
																<input type="text" class="form-control" name="gst" value="<?php
																															if (isset($profile_data)) {
																																echo $profile_data['gst'];
																															} else {
																																echo set_value('gst');
																															}
																															?>">
																<?php
																if ($validation->getError('gst')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('gst') . '</div>';
																}
																?>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-wrap">
																<label class="col-form-label">
																	IT PAN No. <span class="text-danger">*</span>
																</label>
																<input type="text" class="form-control" name="pan_no" value="<?php
																																if (isset($profile_data)) {
																																	echo $profile_data['pan_no'];
																																} else {
																																	echo set_value('pan_no');
																																}
																																?>">
																<?php
																if ($validation->getError('pan_no')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('pan_no') . '</div>';
																}
																?>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-wrap">
																<label class="col-form-label">
																	Other ID <span class="text-danger">*</span>
																</label>
																<input type="text" class="form-control" name="otherid" value="<?php
																																if (isset($profile_data)) {
																																	echo $profile_data['otherid'];
																																} else {
																																	echo set_value('otherid');
																																}
																																?>">
																<?php
																if ($validation->getError('otherid')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('otherid') . '</div>';
																}
																?>
															</div>
														</div>
													</div>
												</div>
												<div class="profile-address">

													<div class="row">
														<div class="col-md-12">
															<div class="form-wrap">
																<label class="col-form-label">
																	Address <span class="text-danger">*</span>
																</label>
																<input type="text" class="form-control" name="company_business_address" value="<?php
																																				if (isset($profile_data)) {
																																					echo $profile_data['company_business_address'];
																																				} else {
																																					echo set_value('company_business_address');
																																				}  ?>">
																<?php
																if ($validation->getError('company_business_address')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('company_business_address') . '</div>';
																}
																?>
															</div>
														</div>
														<div class="col-lg-3 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																	Country <span class="text-danger">*</span>
																</label>
																<input type="text" value="India" readonly class="form-control" name="country" value="<?php
																																						if (isset($profile_data)) {
																																							echo $profile_data['country'];
																																						} else {
																																							echo set_value('country');
																																						}   ?>">
																<?php
																if ($validation->getError('country')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('country') . '</div>';
																}
																?>
															</div>
														</div>
														<div class="col-lg-4 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																	State / Province <span class="text-danger">*</span>
																</label><br>
																<select class="dropdown" name="state">
																	<option>Select</option>
																	<?php
																	if (isset($state)) {
																		foreach ($state as $row) { ?>
																			<option value="<?php echo $row["state_id"] ?>" <?php
																															if (isset($profile_data)) {
																																if ($profile_data['state'] == $row["state_id"]) echo 'selected';
																															} ?>><?php echo $row["state_name"] ?></option>
																	<?php
																		}
																	}
																	?>
																</select>
																<?php
																if ($validation->getError('state')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('state') . '</div>';
																}
																?>
															</div>
														</div>
														<div class="col-lg-2 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																	City <span class="text-danger">*</span>
																</label>
																<input type="text" class="form-control" name="city" value="<?php
																															if (isset($profile_data)) {
																																echo $profile_data['city'];
																															} else {
																																echo set_value('city');
																															}  ?>">
																<?php
																if ($validation->getError('city')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('city') . '</div>';
																}
																?>
															</div>
														</div>
														<div class="col-lg-3 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																	Postal Code <span class="text-danger">*</span>
																</label>
																<input type="text" class="form-control" name="pincode" value="<?php
																																if (isset($profile_data)) {
																																	echo $profile_data['pincode'];
																																} else {
																																	echo set_value('pincode');
																																}  ?>">
																<?php
																if ($validation->getError('pincode')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('pincode') . '</div>';
																}
																?>
															</div>
														</div>

														<div class="col-lg-3 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																	Purchase Order Prefix
																</label>
																<input type="text" class="form-control" name="purchase_order_prefix" value="<?php
																																			if (isset($profile_data)) {
																																				echo $profile_data['purchase_order_prefix'];
																																			} else {
																																				echo set_value('purchase_order_prefix');
																																			}  ?>">
																<?php
																if ($validation->getError('purchase_order_prefix')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('purchase_order_prefix') . '</div>';
																}
																?>
															</div>
														</div>
														<div class="col-lg-3 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																	Invoice Prefix
																</label>
																<input type="text" class="form-control" name="invoice_prefix" value="<?php
																																		if (isset($profile_data)) {
																																			echo $profile_data['invoice_prefix'];
																																		} else {
																																			echo set_value('invoice_prefix');
																																		} ?>">
																<?php
																if ($validation->getError('invoice_prefix')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('invoice_prefix') . '</div>';
																}
																?>
															</div>
														</div>

														<div class="col-lg-3 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																	Booking Prefix
																</label>
																<input type="text" class="form-control" name="booking_prefix" value="<?php
																																		if (isset($profile_data)) {
																																			echo $profile_data['booking_prefix'];
																																		} else {
																																			echo set_value('booking_prefix');
																																		} ?>">
																<?php
																if ($validation->getError('booking_prefix')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_prefix') . '</div>';
																}
																?>
															</div>
														</div>

														<div class="col-lg-3 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																	Loading Receipt Prefix
																</label>
																<input type="text" class="form-control" name="loading_receipt_prefix" value="<?php
																																		if (isset($profile_data)) {
																																			echo $profile_data['loading_receipt_prefix'];
																																		} else {
																																			echo set_value('loading_receipt_prefix');
																																		} ?>">
																<?php
																if ($validation->getError('loading_receipt_prefix')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('loading_receipt_prefix') . '</div>';
																}
																?>
															</div>
														</div>

														<div class="col-lg-3 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																Proforma Invoice Prefix
																</label>
																<input type="text" class="form-control" name="proforma_invoice_prefix" value="<?php
																																		if (isset($profile_data)) {
																																			echo $profile_data['proforma_invoice_prefix'];
																																		} else {
																																			echo set_value('proforma_invoice_prefix');
																																		} ?>">
																<?php
																if ($validation->getError('proforma_invoice_prefix')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('proforma_invoice_prefix') . '</div>';
																}
																?>
															</div>
														</div>

														<div class="col-lg-3 col-md-6">
															<div class="form-wrap">
																<label class="col-form-label">
																Tax Invoice Prefix
																</label>
																<input type="text" class="form-control" name="tax_invoice_prefix" value="<?php
																																		if (isset($profile_data)) {
																																			echo $profile_data['tax_invoice_prefix'];
																																		} else {
																																			echo set_value('tax_invoice_prefix');
																																		} ?>">
																<?php
																if ($validation->getError('tax_invoice_prefix')) {
																	echo '<div class="alert alert-danger mt-2">' . $validation->getError('tax_invoice_prefix') . '</div>';
																}
																?>
															</div>
														</div>

													</div>
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

</body>

</html>