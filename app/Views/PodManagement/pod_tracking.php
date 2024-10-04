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

            <!-- Page Header -->
            <div class="page-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="page-title">POD Tracking</h4>
                </div>
                <div class="col-4 text-end">
                  <div class="head-icons">
                    <a href="<?= base_url('booking') ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Page Header --> 
            <form method="post" enctype="multipart/form-data" action="<?= base_url($currentController.'/'.$currentMethod) ?>" id="myForm">
                
              <div class="card main-card">
                <div class="card-body"> 
                  <div class="row mb-3">
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
                    </div>
                  </div>
                  <!-- /Search -->

                  <!-- Product Type List -->
                  <div class="table-responsive custom-table">
                    <table class="table" id="ProductCategory">
                      <thead class="thead-light">
                        <tr>
                          <th>#</th> 
                          <th>Booking No.</th> 
                          <th>Vehicle No.</th> 
                          <th>Customer</th> 
                          <th>Transporter</th>  
                          <th>POD Receive Date</th> 
                          <th>Courier Date</th> 
                          <th>Tracking No</th>
                          <th>Courier Delivery Date</th> 
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 1;
                        foreach ($bookings as $b) {  ?>
                          <tr>
                            <td><?= $i++; ?>.</td>  
                            <td><?= $b['booking_number'] ?></td> 
                            <td><?= $b['rc_number'] ? $b['rc_number'] : '-' ?></td>  
                            <td><?= $b['party_name'] ? $b['party_name'] : '-' ?></td>  
                            <td><?= $b['transporter_name'] ? $b['transporter_name'] : '-' ?></td>   
                            <td><?= $b['pod_received_date'] ? date('d M Y',strtotime($b['pod_received_date'])) : '-' ?></td>  
                            <td><?= $b['courier_date'] ? date('d M Y',strtotime($b['courier_date'])) : '-' ?></td>
                            <td><?= $b['tracking_no'] ? $b['tracking_no'] : '-' ?></td>   
                            <td>
                                <input type="hidden" name="id[]" value="<?= $b['id']?>" id="booking_id_<?= $b['id']?>" />
                                <input type="date" class="form-control pod-inpt" required name="courier_delivery_date[]" id="courier_delivery_date_<?= $b['id']?>" min="<?= date('Y-m-d',strtotime($b['courier_date'])) ?>" />
                            </td>
                          </tr>
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

                  <?php if($bookings){ ?> 
                  <div class="col-md-12">
                    <button class="btn btn-success mt-4" type="submit">Save Changes</button>
                  </div>
                  <?php } ?>

                </div>
              </div>  

            </form> 

          </div>
        </div>

      </div>
    </div>
    <!-- /Page Wrapper -->


  </div>
  <!-- /Main Wrapper -->
  
  <!-- scripts link  -->
  <?= $this->include('partials/vendor-scripts') ?>

  <!-- page specific scripts  -->
  <script> 

    // datatable init
    if ($(' #ProductCategory').length > 0) {
      $('#ProductCategory').DataTable({
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
        "bPaginate": false,
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [8] },  
        ],
          columnDefs: [{ 
              target: 5,  
              render: DataTable.render.datetime( "DD MMM YYYY" )
            },
            { 
              target: 6,  
              render: DataTable.render.datetime( "DD MMM YYYY" )
            }
          ]
      });
    } 
  </script>
</body>

</html>