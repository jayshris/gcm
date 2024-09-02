<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->include('partials/title-meta') ?>
<?= $this->include('partials/head-css') ?>
	<!-- Summernote CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/summernote/summernote-lite.min.css">

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

						<div class="card main-card">
							<div class="card-body">

								<!-- Search -->
								<div class="search-section">
									<div class="row">
										<div class="col-md-5 col-sm-4">
											<div class="form-wrap icon-form">
												<span class="form-icon"><i class="ti ti-search"></i></span>
												<input type="text" class="form-control" placeholder="Search User">
											</div>							
										</div>		
										<div class="col-md-7 col-sm-8">					
											<div class="export-list text-sm-end">
												<ul>
													<li>
														<div class="export-dropdwon">
															<a href="javascript:void(0);" class="dropdown-toggle"  data-bs-toggle="dropdown"><i class="ti ti-package-export"></i>Export</a>
															<div class="dropdown-menu  dropdown-menu-end">
				    											<ul>
				    												<li>
				    													<a href="javascript:void(0);"><i class="ti ti-file-type-pdf text-danger"></i>Export as PDF</a>
				    												</li>
				    												<li>
				    													<a href="javascript:void(0);"><i class="ti ti-file-type-xls text-green"></i>Export as Excel </a>
				    												</li>
				    											</ul>
				  											</div>
														</div>
													</li>									
													<li>
														<a href="javascript:void(0);" class="btn btn-primary add-popup"><i class="ti ti-square-rounded-plus"></i>Add User</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<!-- /Search -->

								<!-- Filter -->
								<div class="filter-section filter-flex">
									
									<div class="sortby-list">
										<ul>
											<li>
												<div class="sort-dropdown drop-down">
													<a href="javascript:void(0);" class="dropdown-toggle"  data-bs-toggle="dropdown"><i class="ti ti-sort-ascending-2"></i>Sort </a>
													<div class="dropdown-menu  dropdown-menu-start">
					    								<ul>
					    									<li>
					    										<a href="javascript:void(0);">
					    											<i class="ti ti-circle-chevron-right"></i>Ascending
					    										</a>
					    									</li>
					    									<li>
					    										<a href="javascript:void(0);">
					    											<i class="ti ti-circle-chevron-right"></i>Descending
					    										</a>
					    									</li>
					    									<li>
					    										<a href="javascript:void(0);">
					    											<i class="ti ti-circle-chevron-right"></i>Recently Viewed
					    										</a>
					    									</li>
					    									<li>
					    										<a href="javascript:void(0);">
					    											<i class="ti ti-circle-chevron-right"></i>Recently Added
					    										</a>
					    									</li>
					    								</ul>
					  								</div>
												</div>
											</li>
											<li>
												<div class="form-wrap icon-form">
													<span class="form-icon"><i class="ti ti-calendar"></i></span>
													<input type="text" class="form-control bookingrange" placeholder="">
												</div>
											</li>
										</ul>
									</div>
									<div class="filter-list">
										<ul>
											<li>
												<div class="manage-dropdwon">
													<a href="javascript:void(0);" class="btn btn-purple-light"  data-bs-toggle="dropdown"  data-bs-auto-close="false"><i class="ti ti-columns-3"></i>Manage Columns</a>
													<div class="dropdown-menu  dropdown-menu-md-end">
														<h4>Want to manage datatables?</h4>
														<p>Please drag and drop your column to reorder your table and enable see option as you want.</p>
														<ul>
															<li>
																<p><i class="ti ti-grip-vertical"></i>Name</p>
																<div class="status-toggle">
																	<input type="checkbox" id="col-name" class="check">
																	<label for="col-name" class="checktoggle"></label>
																</div>
															</li>
															<li>
																<p><i class="ti ti-grip-vertical"></i>Phone</p>
																<div class="status-toggle">
																	<input type="checkbox" id="col-phone" class="check">
																	<label for="col-phone" class="checktoggle"></label>
																</div>
															</li>
															<li>
																<p><i class="ti ti-grip-vertical"></i>Email</p>
																<div class="status-toggle">
																	<input type="checkbox" id="col-email" class="check">
																	<label for="col-email" class="checktoggle"></label>
																</div>
															</li>
															<li>
																<p><i class="ti ti-grip-vertical"></i>Location</p>
																<div class="status-toggle">
																	<input type="checkbox" id="col-tag" class="check">
																	<label for="col-tag" class="checktoggle"></label>
																</div>
															</li>
															<li>
																<p><i class="ti ti-grip-vertical"></i>Created Date</p>
																<div class="status-toggle">
																	<input type="checkbox" id="col-loc" class="check">
																	<label for="col-loc" class="checktoggle"></label>
																</div>
															</li>
															<li>
																<p><i class="ti ti-grip-vertical"></i>Last Activity</p>
																<div class="status-toggle">
																	<input type="checkbox" id="col-rate" class="check">
																	<label for="col-rate" class="checktoggle"></label>
																</div>
															</li>
															<li>
																<p><i class="ti ti-grip-vertical"></i>Status</p>
																<div class="status-toggle">
																	<input type="checkbox" id="col-owner" class="check">
																	<label for="col-owner" class="checktoggle"></label>
																</div>
															</li>
															<li>
																<p><i class="ti ti-grip-vertical"></i>Action</p>
																<div class="status-toggle">
																	<input type="checkbox" id="col-contact" class="check" checked="">
																	<label for="col-contact" class="checktoggle"></label>
																</div>
															</li>										
														</ul>
													</div>
												</div>
											</li>
											<li>
												<div class="form-sorts dropdown">
													<a href="javascript:void(0);" data-bs-toggle="dropdown"  data-bs-auto-close="false"><i class="ti ti-filter-share"></i>Filter</a>
													<div class="filter-dropdown-menu dropdown-menu  dropdown-menu-md-end">
														<div class="filter-set-view">
															<div class="filter-set-head">
																<h4><i class="ti ti-filter-share"></i>Filter</h4>
																<a href="#" data-bs-toggle="modal" data-bs-target="#save_view">Save View</a>
															</div>
															<div class="header-set">
																<select class="select">
																	<option>Select a View</option>
																	<option>Contact View List</option>
																	<option>Contact Location View</option>
																</select>
																<div class="radio-btn-items">
																	<div class="radio-btn">
																		<input type="radio" class="status-radio" id="pdf" name="export-type" checked="">
																		<label for="pdf">Just For Me</label>
																	</div>
																	<div class="radio-btn">
																		<input type="radio" class="status-radio" id="share" name="export-type">
																		<label for="share">Share Filter with Everyone </label>
																	</div>
																</div>
															</div>
															<div class="accordion" id="accordionExample">
																<div class="filter-set-content">
																	<div class="filter-set-content-head">
																		<a href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Name</a>
																	</div>
																	<div class="filter-set-contents accordion-collapse collapse show" id="collapseTwo" data-bs-parent="#accordionExample">
																		<div class="filter-content-list">
																			<div class="form-wrap icon-form">
																				<span class="form-icon"><i class="ti ti-search"></i></span>
																				<input type="text" class="form-control" placeholder="Search Name">
																			</div>
																			<ul>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox" checked>
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>Darlee Robertson</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>Sharon Roy</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>Vaughan</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>Jessica</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>Carol Thomas</h5>
																					</div>
																				</li>
																			</ul>
																		</div>
																	</div>
																</div>
																<div class="filter-set-content">
																	<div class="filter-set-content-head">
																		<a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#owner" aria-expanded="false" aria-controls="owner">Phone</a>
																	</div>
																	<div class="filter-set-contents accordion-collapse collapse" id="owner" data-bs-parent="#accordionExample">
																		<div class="filter-content-list">
																			<ul>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox" checked>
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>+1 875455453</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>+1 989757485</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>+1 546555455</h5>
																					</div>
																				</li>											
																			</ul>
																		</div>
																	</div>
																</div>
																<div class="filter-set-content">
																	<div class="filter-set-content-head">
																		<a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#Status" aria-expanded="false" aria-controls="Status">Email</a>
																	</div>
																	<div class="filter-set-contents accordion-collapse collapse" id="Status" data-bs-parent="#accordionExample">
																		<div class="filter-content-list">
																			<ul>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox" checked>
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>robertson@example.com</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>sharon@example.com</h5>
																					</div>
																				</li>
																			</ul>
																		</div>
																	</div>
																</div>
																<div class="filter-set-content">
																	<div class="filter-set-content-head">
																		<a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Loaction</a>
																	</div>
																	<div class="filter-set-contents accordion-collapse collapse" id="collapseOne" data-bs-parent="#accordionExample">
																		<div class="filter-content-list">
																			<ul>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox" checked>
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>Germany</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>USA</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>Canada</h5>
																					</div>
																				</li>
																			</ul>
																		</div>
																	</div>
																</div>
																<div class="filter-set-content">
																	<div class="filter-set-content-head">
																		<a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Created Date</a>
																	</div>
																	<div class="filter-set-contents accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionExample">
																		<div class="filter-content-list">
																			<ul>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox" checked>
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>25 Sep 2023, 12:12 pm</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>27 Sep 2023, 07:40 am</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>29 Sep 2023, 08:20 am</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>02 Oct 2023, 10:10 am</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>17 Oct 2023, 04:25 pm</h5>
																					</div>
																				</li>
																			</ul>
																		</div>
																	</div>
																</div>
																<div class="filter-set-content">
																	<div class="filter-set-content-head">
																		<a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">Status</a>
																	</div>
																	<div class="filter-set-contents accordion-collapse collapse" id="collapseSix" data-bs-parent="#accordionExample">
																		<div class="filter-content-list">
																			<ul>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox" checked>
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>Active</h5>
																					</div>
																				</li>
																				<li>
																					<div class="filter-checks">
																						<label class="checkboxs">
																							<input type="checkbox">
																							<span class="checkmarks"></span>
																						</label>
																					</div>
																					<div class="collapse-inside-text">
																						<h5>Inactive</h5>
																					</div>
																				</li>
																			</ul>
																		</div>
																	</div>
																</div>
															</div>													
															<div class="filter-reset-btns">
																<div class="row">
																	<div class="col-6">
																		<a href="#" class="btn btn-light">Reset</a>
																	</div>
																	<div class="col-6">
																		<a href="<?php echo base_url(); ?>manage-users" class="btn btn-primary">Filter</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<!-- /Filter -->

								<!-- Manage Users List -->
								<div class="table-responsive custom-table">
									<table class="table" id="manage-users-list">
										<thead class="thead-light">
											<tr>
												<th class="no-sort"><label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label></th>
												<th class="no-sort"></th>
												<th>Name</th>
												<th>Phone</th>
												<th>Email</th>
												<th>Location</th>
												<th>Created</th>
												<th>Last Activity</th>
												<th>Status</th>
												<th class="text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="datatable-length"></div>
									</div>
									<div class="col-md-6">
										<div class="datatable-paginate"></div>
									</div>
								</div>
								<!-- /Manage Users List -->

							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
		<!-- /Page Wrapper -->

		<!-- Add User -->
		<div class="toggle-popup">
			<div class="sidebar-layout">
				<div class="sidebar-header">
					<h4>Add New User</h4>
					<a href="#" class="sidebar-close toggle-btn"><i class="ti ti-x"></i></a>
				</div>
				<div class="toggle-body">
					<div class="pro-create">
						<form action="manage-users">							
							<div class="accordion-lists" id="list-accord">

								<!-- Basic Info -->
								<div class="manage-user-modal">
									<div class="manage-user-modals">
										<div class="row">
											<div class="col-md-12">
												<div class="profile-pic-upload">
													<div class="profile-pic">
														<span><i class="ti ti-photo"></i></span>
													</div>
													<div class="upload-content">
														<div class="upload-btn">
															<input type="file">
															<span>
																<i class="ti ti-file-broken"></i>Upload File
															</span>
														</div>
														<p>JPG, GIF or PNG. Max size of 800K</p>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label"> Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">User Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control">
												</div>
											</div>										
											<div class="col-md-6">
												<div class="form-wrap">
													<div class="d-flex justify-content-between align-items-center">
														<label class="col-form-label">Email <span class="text-danger">*</span></label>
														<div class="status-toggle small-toggle-btn d-flex align-items-center">
															<span class="me-2 label-text">Email Opt Out</span>
															<input type="checkbox" id="user1" class="check" checked="">
															<label for="user1" class="checktoggle"></label>
														</div>
													</div>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Role <span class="text-danger">*</span></label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Phone 1 <span class="text-danger">*</span></label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Phone 2</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Password <span class="text-danger">*</span></label>
													<div class="icon-form-end">
														<span class="form-icon"><i class="ti ti-eye-off"></i></span>
														<input type="password" class="form-control">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Repeat Password <span class="text-danger">*</span></label>
													<div class="icon-form-end">
														<span class="form-icon"><i class="ti ti-eye-off"></i></span>
														<input type="password" class="form-control">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Location <span class="text-danger">*</span></label>
													<select class="select">
														<option>Choose</option>
														<option>Germany</option>
														<option>USA</option>
														<option>Canada</option>
														<option>India</option>
														<option>China</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="radio-wrap">
													<label class="col-form-label">Status</label>
													<div class="d-flex flex-wrap">
														<div class="radio-btn">
															<input type="radio" class="status-radio" id="active1" name="status" checked="">
															<label for="active1">Active</label>
														</div>
														<div class="radio-btn">
															<input type="radio" class="status-radio" id="inactive1" name="status">
															<label for="inactive1">Inactive</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Basic Info -->

							</div>
							<div class="submit-button text-end">
								<a href="#" class="btn btn-light sidebar-close">Cancel</a>
								<button type="submit" class="btn btn-primary">Create</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /Add User -->

		<!-- Edit User -->
		<div class="toggle-popup1">
			<div class="sidebar-layout">
				<div class="sidebar-header">
					<h4>Edit User</h4>
					<a href="#" class="sidebar-close1 toggle-btn"><i class="ti ti-x"></i></a>
				</div>
				<div class="toggle-body">
					<div class="pro-create">
						<form action="manage-users">							
							<div class="accordion-lists" id="list-accords">

								<!-- Basic Info -->
								<div class="manage-user-modal">
									<div class="manage-user-modals">
										<div class="row">
											<div class="col-md-12">
												<div class="profile-pic-upload">
													<div class="profile-pic">
														<span><i class="ti ti-photo"></i></span>
													</div>
													<div class="upload-content">
														<div class="upload-btn">
															<input type="file">
															<span>
																<i class="ti ti-file-broken"></i>Upload File
															</span>
														</div>
														<p>JPG, GIF or PNG. Max size of 800K</p>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label"> Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control" value="Darlee Robertson">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">User Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control" value="Darlee_47">
												</div>
											</div>										
											<div class="col-md-6">
												<div class="form-wrap">
													<div class="d-flex justify-content-between align-items-center">
														<label class="col-form-label">Email <span class="text-danger">*</span></label>
														<div class="status-toggle small-toggle-btn d-flex align-items-center">
															<span class="me-2 label-text">Email Opt Out</span>
															<input type="checkbox" id="user" class="check" checked="">
															<label for="user" class="checktoggle"></label>
														</div>
													</div>
													<input type="text" class="form-control" value="robertson@example.com">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Role <span class="text-danger">*</span></label>
													<input type="text" class="form-control" value="Facility Manager">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Phone 1 <span class="text-danger">*</span></label>
													<input type="text" class="form-control" value="+1 875455453">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Phone 2</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Password <span class="text-danger">*</span></label>
													<div class="icon-form-end">
														<span class="form-icon"><i class="ti ti-eye-off"></i></span>
														<input type="password" class="form-control" value="********">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Repeat Password <span class="text-danger">*</span></label>
													<div class="icon-form-end">
														<span class="form-icon"><i class="ti ti-eye-off"></i></span>
														<input type="password" class="form-control" value="********">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-wrap">
													<label class="col-form-label">Location <span class="text-danger">*</span></label>
													<select class="select">
														<option>Germany</option>
														<option>USA</option>
														<option>Canada</option>
														<option>India</option>
														<option>China</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="radio-wrap">
													<label class="col-form-label">Status</label>
													<div class="d-flex flex-wrap">
														<div class="radio-btn">
															<input type="radio" class="status-radio" id="active" name="status" checked="">
															<label for="active">Active</label>
														</div>
														<div class="radio-btn">
															<input type="radio" class="status-radio" id="inactive" name="status">
															<label for="inactive">Inactive</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Basic Info -->

							</div>

							<div class="submit-button text-end">
								<a href="#" class="btn btn-light sidebar-close1">Cancel</a>
								<button type="submit" class="btn btn-primary">Save Changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /Edit User -->

		<!-- Delete User -->
		<div class="modal custom-modal fade" id="delete_contact" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header border-0 m-0 justify-content-end">
						<button  class="btn-close" data-bs-dismiss="modal" aria-label="Close">	
							<i class="ti ti-x"></i>
						</button>
					</div>
					<div class="modal-body">
						<div class="success-message text-center">
							<div class="success-popup-icon">
								<i class="ti ti-trash-x"></i>
							</div>
							<h3>Remove User?</h3>
							<p class="del-info">Are you sure you want to remove it.</p>
							<div class="col-lg-12 text-center modal-btn">
								<a href="#" class="btn btn-light" data-bs-dismiss="modal">Cancel</a>
								<a href="<?php echo base_url(); ?>manage-users" class="btn btn-danger">Yes, Delete it</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Delete User -->


	</div>
	<!-- /Main Wrapper -->

	<?= $this->include('partials/vendor-scripts') ?>

	<!-- Summernote JS -->
	<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-lite.min.js"></script>

</body>
</html>