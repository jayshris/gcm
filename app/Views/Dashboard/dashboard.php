<!DOCTYPE html>
<html lang="en">

<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?>
</head>

<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<div class="preloader">
			<div class="preloader-blk">
				<div class="preloader__image"></div>
			</div>
		</div>
		<?= $this->include('partials/menu') ?>


		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">

				<div class="row">
					<div class="col-md-12">
						<div class="page-header">
							<?php
							$session = \Config\Services::session();
							if ($session->getFlashdata('error')) {
								echo '
								<div class="alert alert-danger">' . $session->getFlashdata("error") . '</div>
								';
							}
							?>
							<div class="row align-items-center">
								<div class="col-md-4">
									<h3 class="page-title">Dashboard</h3>
								</div>
								<div class="col-md-8 float-end ms-auto">
									<div class="d-flex title-head">
										<div class="daterange-picker d-flex align-items-center justify-content-center">
											<div class="head-icons mb-0">
												<a href="<?php echo base_url('dashboard'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
												<a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">

							<!-- Vehicles Available For Booking -->
							<div class="col-md-6 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<div class="statistic-header">
											<h4><i class="ti ti-grip-vertical me-1"></i>Vehicles Available For Booking</h4>
											<div class="card-select">
												<a class="btn btn-sm btn-secondary" href="<?= base_url('dashboard/block1') ?>">
													More&nbsp;<i class="fa fa-angle-double-right"></i>
												</a>
											</div>
										</div>
										<br>
										<div class="table-responsive">
											<table class="table table-borderless   table-sm table-hover table-striped" style="border-radius: 5px;" style="table-layout: fixed;">
												<thead class="thead-light">
													<tr>
														<th width="5%">#</th>
														<th width="15%">Type</th>
														<th width="10%">RC No.</th>
														<th width="60%">Driver</th>
														<th width="10%">Empty Since</th>
														<th width="10%">Last Drop</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1;
													if ($block1) {
														foreach ($block1 as $b1) { ?>
															<tr>
																<td><?= $i++ ?>.</td>
																<td><?= $b1['type'] ?></td>
																<td><?= $b1['rc_number'] ?></td>
																<td><?= $b1['driver_name'] ?></td>
																<td><?= date('d M Y',strtotime($b1['last_booking_date'])) ?></td>
																<td><?= $b1['drop_city'] ?></td> 
															</tr>
														<?php }
													} else { ?>
														<tr>
															<td colspan="5" align="center">No Data</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6 row">
								<!--  Vehicles on Trip -->
								<div class="col-md-12 d-flex">
									<div class="card flex-fill">
										<div class="card-body">
											<div class="statistic-header">
												<h4><i class="ti ti-grip-vertical me-1"></i> Vehicles In Unloading</h4>
												<div class="card-select">
													<a class="btn btn-sm btn-secondary" href="<?= base_url('dashboard/block2') ?>">
														More&nbsp;<i class="fa fa-angle-double-right"></i>
													</a>
												</div>
											</div>
											<br>
											<div class="table-responsive">
												<table class="table table-sm table-hover table-borderless   table-striped" style="border-radius: 5px;" style="table-layout: fixed;">
													<thead class="thead-light">
														<tr>
															<th width="5%">#</th>
															<th width="10%">RC No.</th>
															<th width="15%">Type</th>
															<th width="15%">Booking No</th>
															<th width="55%">Driver</th>
														</tr>
													</thead>
													<tbody>
														<?php $i = 1;
														if ($block2) {
															foreach ($block2 as $b2) { ?>
																<tr>
																	<td><?= $i++ ?>.</td>
																	<td><?= $b2['rc_number'] ?></td>
																	<td><?= $b2['type'] ?></td>
																	<td><?= $b2['booking_number'] ?></td>
																	<td><?= $b2['driver_name'] ?></td>
																</tr>
															<?php }
														} else { ?>
															<tr>
																<td colspan="5" align="center">No Data</td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

								<!-- Vehicles Paused -->
								<div class="col-md-12 d-flex">
									<div class="card flex-fill">
										<div class="card-body">
											<div class="statistic-header">
												<h4><i class="ti ti-grip-vertical me-1"></i>Vehicles Paused</h4>
												<div class="card-select">
													<a class="btn btn-sm btn-secondary" href="<?= base_url('dashboard/block3') ?>">
														More&nbsp;<i class="fa fa-angle-double-right"></i>
													</a>
												</div>
											</div>
											<br>
											<div class="table-responsive">
												<table class="table table-sm table-hover table-borderless   table-striped" style="border-radius: 5px;" style="table-layout: fixed;">
													<thead class="thead-light">
														<tr>
															<th width="5%">#</th>
															<th width="10%">RC No.</th>
															<th width="15%">Type</th>
															<th width="15%">Booking No</th>
															<th width="55%">Driver</th>
														</tr>
													</thead>
													<tbody>
														<?php $i = 1;
														if ($block3) {
															foreach ($block3 as $b3) { ?>
																<tr>
																	<td><?= $i++ ?>.</td>
																	<td><?= $b3['rc_number'] ?></td>
																	<td><?= $b3['type'] ?></td>
																	<td><?= $b3['booking_number'] ?></td>
																	<td><?= $b3['driver_name'] ?></td>
																</tr>
															<?php }
														} else { ?>
															<tr>
																<td colspan="5" align="center">No Data</td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>





							<!-- Vehicles Empty -->
							<div class="col-md-6 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<div class="statistic-header">
											<h4><i class="ti ti-grip-vertical me-1"></i>Vehicles Empty - No Driver</h4>
											<div class="card-select">
												<a class="btn btn-sm btn-secondary" href="<?= base_url('dashboard/block4') ?>">
													More&nbsp;<i class="fa fa-angle-double-right"></i>
												</a>
											</div>
										</div>
										<br>
										<div class="table-responsive">
											<table class="table table-sm table-hover table-borderless   table-striped" style="border-radius: 5px;" style="table-layout: fixed;">
												<thead class="thead-light">
													<tr>
														<th width="5%">#</th>
														<th width="10%">RC No.</th>
														<th width="15%">Type</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1;
													if ($block4) {
														foreach ($block4 as $b4) { ?>
															<tr>
																<td><?= $i++ ?>.</td>
																<td><?= $b4['rc_number'] ?></td>
																<td><?= $b4['type'] ?></td>
															</tr>
														<?php }
													} else { ?>
														<tr>
															<td colspan="5" align="center">No Data</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							<!-- Vehicles In Loading -->
							<div class="col-md-6 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<div class="statistic-header">
											<h4><i class="ti ti-grip-vertical me-1"></i>Vehicles In Loading</h4>
											<div class="card-select">
												<a class="btn btn-sm btn-secondary" href="<?= base_url('dashboard/block5') ?>">
													More&nbsp;<i class="fa fa-angle-double-right"></i>
												</a>
											</div>
										</div>
										<br>
										<div class="table-responsive">
											<table class="table table-sm table-hover table-borderless   table-striped" style="border-radius: 5px;" style="table-layout: fixed;">
												<thead class="thead-light">
													<tr>
														<th width="5%">#</th>
														<th width="10%">RC No.</th>
														<th width="15%">Type</th>
														<th width="15%">Booking No</th>
														<th width="55%">Driver</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1;
													if ($block5) {
														foreach ($block5 as $b5) { ?>
															<tr>
																<td><?= $i++ ?>.</td>
																<td><?= $b5['rc_number'] ?></td>
																<td><?= $b5['type'] ?></td>
																<td><?= $b5['booking_number'] ?></td>
																<td><?= $b5['driver_name'] ?></td>
															</tr>
														<?php }
													} else { ?>
														<tr>
															<td colspan="5" align="center">No Data</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							<!-- Vehicles In Running -->
							<div class="col-md-6 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<div class="statistic-header">
											<h4><i class="ti ti-grip-vertical me-1"></i>Vehicles In Running</h4>
											<div class="card-select">
												<a class="btn btn-sm btn-secondary" href="<?= base_url('dashboard/block6') ?>">
													More&nbsp;<i class="fa fa-angle-double-right"></i>
												</a>
											</div>
										</div>
										<br>
										<div class="table-responsive">
											<table class="table table-sm table-hover table-borderless   table-striped" style="border-radius: 5px;" style="table-layout: fixed;">
												<thead class="thead-light">
													<tr>
														<th width="5%">#</th>
														<th width="10%">RC No.</th>
														<th width="15%">Type</th>
														<th width="15%">Booking No</th>
														<th width="55%">Driver</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1;
													if ($block6) {
														foreach ($block6 as $b6) { ?>
															<tr>
																<td><?= $i++ ?>.</td>
																<td><?= $b6['rc_number'] ?></td>
																<td><?= $b6['type'] ?></td>
																<td><?= $b6['booking_number'] ?></td>
																<td><?= $b6['driver_name'] ?></td>
															</tr>
														<?php }
													} else { ?>
														<tr>
															<td colspan="5" align="center">No Data</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
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
	<!-- Apexchart JS -->
	<script src="<?php echo base_url(); ?>assets/plugins/apexchart/apexcharts.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/apexchart/chart-data.js"></script>
</body>

</html>