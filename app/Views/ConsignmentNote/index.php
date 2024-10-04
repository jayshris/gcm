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

            <!-- Page Header -->
            <div class="page-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="page-title">Consignment Note</h4>
                </div>
                <div class="col-4 text-end">
                  <div class="head-icons">
                    <a href="<?= base_url().$currentController ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Page Header -->

            <?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
              <div class="card main-card">
                <div class="card-body">
                  <h4>Search / Filter</h4>
                  <hr>
                  <div class="row mt-2"> 
                    <div class="col-md-3">
                      <label class="col-form-label">Booking No.</label>
                      <select class="form-select select2" name="booking_id">
                        <option value="">Select </option>
                        <?php foreach ($bookings as $booking) {
                          echo '<option value="' . $booking['id'] . '" ' . (set_value('booking_id') == $booking['id'] ? 'selected' : '') . '>' . $booking['booking_number'] . '</option>';
                        } ?>
                      </select>
                    </div>

                    <div class="col-md-2">
                      <div class="form-wrap">
                        <label class="col-form-label">Vehicle RC </label>
                        <select class="form-select" name="vehicle_id" aria-label="Default select example">
                          <option value="">Select </option> 
                          <?php foreach ($rc_number as $no) {
                            echo '<option value="' . $no['id'] . '" ' . (set_value('vehicle_id') == $no['id'] ? 'selected' : '') . '>' . $no['rc_number'] . '</option>';
                          } ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                      <a href="<?= base_url().$currentController ?>" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                    </div>
 
                  </div>
                </div>
              </div>
            </form> 

            <div class="card main-card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<?php
										$session = \Config\Services::session();
										if ($session->getFlashdata('success')) {
										echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
										}
										if ($session->getFlashdata('danger')) {
										echo '<div class="alert alert-danger">' . $session->getFlashdata("danger") . '</div>';
										}
										?>
										<br>
									</div>
								</div>
								<!-- /Search -->

								<!-- Product Type List -->
								<div class="table-responsive custom-table">
									<table class="table" id="loading-receipt-table">
										<thead class="thead-light">
										<tr>
											<th>#</th>
											<th>Action</th>
											<th>Consignment No.</th>
											<th>Booking Number</th>
											<th>Branch Name</th>
											<th>Booking Date</th> 
										</tr>
										</thead>
										<tbody>
                      <?php if(!empty($loading_receipts)){ ?>
                        <?php
                        $i = 1;
                        foreach ($loading_receipts as $b) {
                        ?>
                        <tr>
                          <td><?= $i++; ?>.</td> 
                          <td><?= makeListActions($currentController, $Action, $b['id'], 2) ?></td>
                          <td><?= $b['consignment_no'] ?></td>
                          <td><?= $b['booking_number'] ?></td>
                          <td><?= $b['branch_name'] ?></td>
                          <td><?= date('d M Y', strtotime($b['booking_date'])) ?></td> 
                        </td>
                        </tr>
                      <?php } ?>
                      <?php }else{ ?>
                        <tr><td colspan="6">Records not found!</td></tr>
                      <?php } ?>
											
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
								<!-- /Product Type List -->

							</div>
						</div>              

          </div>

        </div>
      </div>
      <!-- /Page Wrapper -->


    </div>
    <!-- /Main Wrapper -->

    <!-- scripts link  -->
    <?= $this->include('partials/vendor-scripts') ?>

    <script>
    $(document).ready(function() {  
    // datatable init
    if ($(' #loading-receipt-table').length > 0) {
      $('#loading-receipt-table').DataTable({
        "bFilter": false,
        "bInfo": false,
        "autoWidth": true,
        "language": {
          search: ' ',
          sLengthMenu: '_MENU_',
          searchPlaceholder: "Search",
          info: "_START_ - _END_ of _TOTAL_ items",
          "lengthMenu": "Show _MENU_ entries",
          paginate: {
            next: 'Next <i class=" fa fa-angle-right"></i> ',
            previous: '<i class="fa fa-angle-left"></i> Prev '
          },
        },
        initComplete: (settings, json) => {
          $('.dataTables_paginate').appendTo('.datatable-paginate');
          $('.dataTables_length').appendTo('.datatable-length');
        },
        columnDefs: [{ 
            target: 5,  
            render: DataTable.render.datetime( "DD MMM YYYY" )
          } 
        ]
      });
    }

    }); 
    </script>
    </body>

    </html>