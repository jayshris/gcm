<?php

use App\Models\ForemanModel;
use App\Models\PartyModel;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?= $this->include('partials/title-meta') ?>
  <?= $this->include('partials/head-css') ?>
  <style>
    @media print {
      .noprint {
        /* visibility: hidden; */
        display: none;
      }

      .sidebar,
      .mobile_btn,
      .mobile-user-menu,
      .header {
        display: none !important;
      }

      .print-header,
      .print-footer {
        display: block !important;
      }

      #print-div-b4 {
        display: block !important;
      }

      .page-wrapper {
        margin: 0;
        padding: 0;
        min-height: 0;
      }

      .page-wrapper .content {
        padding: 0;
      }

      #debug-icon {
        display: none !important;
      }

      .padtb-5 {
        padding: 5px 0 5px 0;
      }

      #print-div-b4 tbody,
      td,
      tfoot,
      th,
      thead,
      tr {
        border: 1px solid black;
        border-width: 1px;
        padding: 5px !important;

      }
    }
  </style>
</head>

<body>

  <!-- for print  -->
  <div id="print-div-b4" style="display: none;">
    <h4 class="padtb-5">
      <center>Vehicles Empty</center>
    </h4>

    <table style="width: 100%;">
      <thead class="thead-light">
        <tr>
          <th>#</th>
          <th>RC No.</th>
          <th>Type</th>
          <th>Empty Since</th>
					<th>Last Drop</th>
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
              <td><?= ($b4['last_booking_date']) ? date('d M Y',strtotime($b4['last_booking_date'])) : '-' ?></td>
							<td><?= ($b4['drop_city']) ? $b4['drop_city'] : '-' ?></td> 
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


  <!-- Main Wrapper -->
  <div class="main-wrapper">

    <?= $this->include('partials/menu') ?>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
      <div class="content">

        <div class="row">
          <div class="col-md-12">

            <?= $this->include('partials/page-title') ?>
            <!-- Page Header -->
            <div class="page-header noprint">
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="page-title">Vehicles Empty</h4>
                </div>
                <div class="col-4 text-end">
                  <div class="head-icons">
                    <a href="<?= base_url($currentController . '/' . $currentMethod) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Page Header -->



            <div class="card main-card">
              <div class="card-body noprint">
                <!-- Contact List -->
                <div class="table-responsive custom-table noprint">
                  <table class="table table-bordered" id="vehicle-table">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>RC No.</th>
                        <th>Type</th>
                        <th>Empty Since</th>
												<th>Last Drop</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1;
                      foreach ($block4 as $b4) { ?>
                        <tr>
                          <td><?= $i++ ?>.</td>
                          <td><?= $b4['rc_number'] ?></td>
                          <td><?= $b4['type'] ?></td>
                          <td><?= ($b4['last_booking_date']) ? date('d M Y',strtotime($b4['last_booking_date'])) : '-' ?></td>
							            <td><?= ($b4['drop_city']) ? $b4['drop_city'] : '-' ?></td> 
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>

                </div>
                <div class="row align-items-center noprint">
                  <div class="col-md-6">
                    <div class="datatable-length"></div>
                  </div>
                  <div class="col-md-6">
                    <div class="datatable-paginate"></div>
                  </div>
                </div>
                <!-- /Contact List -->

              </div>
            </div>

            <button type="button" class="btn btn-danger mt-4 noprint" onclick="window.print();"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            <a href="<?php echo base_url($currentController); ?>" class="btn btn-light mt-4 noprint">Back</a>
          </div>
        </div>

      </div>
    </div>
    <!-- /Page Wrapper -->


  </div>
  <!-- /Main Wrapper -->



  <?= $this->include('partials/vendor-scripts') ?>
  <script>
    // datatable init
    if ($('#vehicle-table').length > 0) {
      $('#vehicle-table').DataTable({
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
              target: 3,  
              render: DataTable.render.datetime( "DD MMM YYYY" )
          }, 
        ]
      });
    }

    function printDiv(divId) {
      var printContents = document.getElementById(divId).innerHTML;
      var originalContents = document.body.innerHTML;
      document.title = 'Vehicle Available';
      document.body.innerHTML = printContents;

      window.print();

      document.body.innerHTML = originalContents;
    }
  </script>
</body>

</html>