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
                  <h4 class="page-title">Receive POD</h4>
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
            <form method="post" enctype="multipart/form-data" action="<?= base_url($currentController.'/'.$currentMethod) ?>">
              <div class="card main-card">
                <div class="card-body">
                    <div class="row"> 
                        <div class="col-md-8">
                        <h4>Search / Filter</h4>
                        </div>
                        
                        <div class="row mt-2">
                            <hr>
                            <div class="col-md-3"> 
                                <label class="col-form-label">Vehicle Number</label>
                                <select class="form-select select2" name="vehicle_id">
                                    <option value="">Select Vehicle No.</option>
                                    <?php foreach ($vehicles as $s) { ?>
                                    <option value="<?= $s['id'] ?>" <?= (set_value('vehicle_id') == $s['id']) ? 'selected' : '' ?>><?= $s['rc_number'] ?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                                <a href="<?= base_url($currentController.'/'.$currentMethod) ?>" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                            </div>
                        </div>

                    </div>
                  </div> 
                </div>  
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
                          <th>Booking No</th> 
                          <th>Customer Name</th> 
                          <th>Transporter Name</th> 
                          <th>Pickup</th>
                          <th>Drop</th>
                          <th>Unloading Date </th>
                          <th>Received POD</th>
                          <th>POD Receive Date</th> 
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 1;
                        foreach ($bookings as $k => $b) {  ?>
                          <tr>
                            <td><?= $i++; ?>.</td>  
                            <td><?= $b['booking_number'] ?></td> 
                            <td><?= $b['party_name'] ? $b['party_name'] : '-' ?></td>  
                            <td><?= $b['transporter_name'] ? $b['transporter_name'] : '-' ?></td>  
                            <td><?= isset($b['bp_city']) ? $b['bp_city'] : '-' ?></td>
                            <td><?= isset($b['bd_city']) ? $b['bd_city'] : '-' ?></td> 
                            <td><?= ($b['unloading_date']) ? date('d M Y',strtotime($b['unloading_date'])) : '-'  ?></td>  
                            <td>
                              <input type="hidden" name="id[]" value="<?= $b['id']?>" id="booking_id_<?= $b['id']?>" />
                              <input type="checkbox" class="form-check-input" style="height: 25px; width:25px;" name="is_physical_pod_received_<?= $k?>" id="is_physical_pod_received_<?= $b['id']?>" value="1" onchange="validateInpt(<?= $b['id']?>)"/> 
                            </td> 
                            <td><input type="date" class="form-control pod-inpt" name="pod_received_date[]" id="pod_received_date_<?= $b['id']?>" min="<?= date('Y-m-d',strtotime($b['booking_date'])) ?>" max="<?= date('Y-m-d')?>" onchange="validateInpt(<?= $b['id']?>);"/></td>
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
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 7,8] },  
        ],
        columnDefs: [{ 
            target: 6,  
            render: DataTable.render.datetime( "DD MMM YYYY" )
          } 
        ]
      });
    }

    function validateInpt(id){
      // alert($('#is_physical_pod_received_'+id+'').is(":checked") + ' dt = '+$('#pod_received_date_'+id+'').val());
      if($('#is_physical_pod_received_'+id+'').is(":checked") && $('#pod_received_date_'+id+'').val() ==''){
        $('#pod_received_date_'+id+'').css('border-color','red');
        $('#pod_received_date_'+id+'').attr('required','required');
      }else{
        $('.pod-inpt').removeAttr('required');
        $('.pod-inpt').css('border-color','#E8E8E8');
      }
    }
  </script>
</body>

</html>