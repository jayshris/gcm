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
           .sidebar, .mobile_btn, .mobile-user-menu,.header{
            display: none !important;
           } 

           .print-header,.print-footer{
            display: block !important;
          }
            
          #print-driver-div{
            display: block !important;
           } 
          .page-wrapper{
            margin: 0;padding: 0;min-height: 0;
          }
          .page-wrapper .content{
            padding: 0;
          }
          #debug-icon{
            display: none !important;
           }
           .padtb-5{
            padding: 5px 0 5px 0;
           }
           
           #print-driver-div tbody, td, tfoot, th, thead, tr{
            border: 1px solid black;
            border-width: 1px;
            padding: 5px !important;

           }
        }   
          
    </style>
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
         <!-- Page Header -->
         <div class="page-header noprint">
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="page-title">Vehicle Booking Assigned List</h4>
                </div>
                <div class="col-4 text-end">
                  <div class="head-icons">
                    <a href="<?= base_url($currentController.'/'.$currentMethod) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Page Header -->

            <div class="card main-card">
              <div class="card-body noprint">   
                <div class="row">
                  <div class="col-md-8">
                    <h4>Vehicle RC Number: <?= $vehicle['rc_number'] ?></h4>
                  </div> 
                </div>

                <!-- Contact List -->
                <div class="table-responsive custom-table noprint  mt-4"> 
                    <table class="table table-bordered" id="driver-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Sl.No.</th> 
                                <th>Booking Number</th>
                                <th>Vehicle Type</th>
                                <th>Assigned On</th>
                                <th>Booking Date</th>
                                <th>Pickup City</th>
                                <th>Drop City</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($assigned_list) {
                                foreach ($assigned_list as $item) {
                            ?>
                                    <tr>
                                        <td><?= $i++ ?>.</td> 
                                        <td><?= $item['booking_number'] ?></td>
                                        <td><?= isset($item['vehicle_type_nm']) ? $item['vehicle_type_nm'] : '-' ?></td>
                                        <td><?= date('d-m-Y', strtotime($item['assign_date']))  ?></td>
                                        <td><?= date('d-m-Y', strtotime($item['booking_date']))  ?></td>
                                        <td><?= isset($item['pickup_city']) ? $item['pickup_city'] : '-' ?></td>
                                        <td><?= isset($item['drop_city']) ? $item['drop_city'] : '-' ?></td>
                                    </tr>
                            <?php
                                }
                            }  
                            ?>
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
    if ($('#driver-table').length > 0) {
      $('#driver-table').DataTable({
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
        }
      });
    }
 
    function printDiv(divId) 
    {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        document.title = 'Driver Assigned List';
        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
  </script>
</body>

</html>

