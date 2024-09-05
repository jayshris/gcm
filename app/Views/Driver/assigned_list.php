<?php

use App\Models\ForemanModel;
use App\Models\PartyModel;

?>
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

            <form method="post" enctype="multipart/form-data" action="<?php echo base_url($currentController.'/'.$currentMethod); ?>">
              <div class="card main-card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h4>Search / Filter</h4>
                    </div> 
                  </div>
                  <hr> 

                  <div class="row mt-2">

                    <div class="col-md-3">
                      <div class="form-wrap">
                        <label class="col-form-label">Vehicle</label>
                        <select class="form-select select2" name="vehicle_id" aria-label="Default select example">
                          <option value="">Select Vehicle</option>
                          <?php foreach ($vehicles as $d) {
                            echo '<option value="' . $d['id'] . '"' . (set_value('rc_number') == $d['id'] ? 'selected' : '') . '>' . $d['rc_number'] . '</option>';
                          } ?>
                        </select>
                      </div>
                    </div>
 

                    <div class="col-md-4">
                      <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                      <a href="<?php echo base_url($currentController.'/'.$currentMethod); ?>"  class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp; 
                    </div>

                  </div>

                  <div class="col-md-12">
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
              </div>
            </form>

            <div class="card main-card">
              <div class="card-body">



                <!-- Contact List -->
                <div class="table-responsive custom-table"> 
                    <table class="table table-bordered" id="driver-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Sl.No.</th>
                                <th>Vehicle RC Number</th>
                                <th>Driver's Name</th>
                                <th>Vehicle Type</th>
                                <th>Assigned On</th>
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
                                        <td><?= $item['rc_number'] ?></td>
                                        <td><?= $item['party_name'] ?></td>
                                        <td><?= isset($item['vehicle_type_nm']) ? $item['vehicle_type_nm'] : '-' ?></td>
                                        <td><?= date('d-m-Y', strtotime($item['assign_date']))  ?></td>
                                        
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr align="center">
                                <td colspan="2"></td>
                                <td>No Assignments Found</td>
                                <td></td>
                                <td></td></tr>';
                            }
                            ?>
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
 
  </script>
</body>

</html>

