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

            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('driver'); ?>">
              <div class="card main-card">
                <div class="card-body">
                  <h4>Search / Filter</h4>
                  <hr>
                  <div class="row mt-2">

                    <div class="col-md-2">
                      <div class="form-wrap">
                        <label class="col-form-label">Status</label>
                        <select class="form-select" name="status" aria-label="Default select example">
                          <option value="">Select Status</option>
                          <option value="1" <?= set_value('status') == 1 ? 'selected' : '' ?>>Active</option>
                          <option value="0" <?= set_value('status') == 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2">
                      <div class="form-wrap">
                        <label class="col-form-label">Working Status</label>
                        <select class="form-select" name="working_status" aria-label="Default select example">
                          <option value="">Select Status</option>
                          <option value="1" <?= set_value('working_status') == 1 ? 'selected' : '' ?>>Not Assigned</option>
                          <option value="2" <?= set_value('working_status') == 2 ? 'selected' : '' ?>>Assigned </option>
                          <option value="3" <?= set_value('working_status') == 3 ? 'selected' : '' ?>>On Trip </option>
                          <option value="4" <?= set_value('working_status') == 4 ? 'selected' : '' ?>>Waiting For Trip </option>
                          <option value="5" <?= set_value('working_status') == 5 ? 'selected' : '' ?>>Absconding </option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-5">
                      <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                      <a href="./driver" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                    </div>

                    <div class="col-md-2 text-end mt-4">
                      <a href="<?= base_url('driver/assigned-list') ?>" class="btn btn-warning">Assigned List</a>

                    </div>

                    <div class="col-md-1 text-end mt-4">
                      <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                    </div>



                  </div>

                  <div class="col-md-12">
                    <?php
                    $session = \Config\Services::session();

                    if ($session->getFlashdata('success')) {
                      echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
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
                  <table class="table" id="driver-table">
                    <thead class="thead-light">
                      <tr>
                        <th>Action</th>
                        <th>Driver Name</th>
                        <th>DL No.</th>
                        <th>Foreman Name</th>
                        <th>Trip Status</th>
                        <th>Current Trip</th>
                        <th>No. of Trips</th>
                        <th>Status</th>
                        <th>Wroking Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($driver_data) {
                        foreach ($driver_data as $driver) {

                          //working status
                          $ws = '';
                          switch ($driver['working_status']) {
                            case "1":
                              $ws = '<span class="badge badge-pill bg-danger">Not Assigned</span>';
                              break;
                            case "2":
                              $ws = '<span class="badge badge-pill bg-success">Assigned</span>';
                              break;
                            case "3":
                              $ws = '<span class="badge badge-pill bg-warning">On Trip</span>';
                              break;
                            case "4":
                              $ws = '<span class="badge badge-pill bg-warning">Waiting For Trip</span>';
                              break;
                            case "5":
                              $ws = '<span class="badge badge-pill bg-warning">Absconding</span>';
                              break;
                            default:
                              $ws = '<span class="badge badge-pill bg-warning">N/A</span>';
                          }
                      ?>
                          <tr>
                            <td><?= makeListActions($currentController, $Action, $driver['id'], 2) ?></td>
                            <td><?= $driver['party_name'] ?></td>
                            <td><?= $driver['dl_no'] ?></td>
                            <td><?= $driver['foreman_name'] ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                              <?php
                              if ($driver['status'] == 'Inactive') {
                                echo '<span class="badge badge-pill bg-danger">Inactive</span>';
                              } else {
                                echo '<span class="badge badge-pill bg-success">Active</span>';
                              }
                              ?>
                            </td>
                            <td><?= $ws ?></td>
                          </tr>

                      <?php

                        }
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
    function delete_data(id) {
      if (confirm("Are you sure you want to remove it?")) {
        window.location.href = "<?php echo base_url(); ?>/driver/delete/" + id;
      }
      return false;
    }

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