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

            <div class="card main-card">
              <div class="card-body">

                <!-- Search -->
                <div class="search-section">
                  <div class="row mb-3">
                    <div class="col-md-8">
                      <div class="form-wrap icon-form">
                        <?php
                        $session = \Config\Services::session();
                        if ($session->getFlashdata('success')) {
                          echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
                        }
                        ?>
                      </div>
                    </div>

                    <div class="col-md-4 text-sm-end">
                      <a href="<?= base_url('driver/assigned-list') ?>" class="btn btn-warning">Assigned List</a>
                      <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                    </div>

                  </div>
                </div>

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
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($driver_data) {
                        foreach ($driver_data as $driver) {

                          if (!$driver['assigned']) {
                            $assign_link = '<a href="' . base_url() . 'driver/assign-vehicle/' . $driver['id'] . '" class="btn btn-info btn-sm" role="button"><i class="fa fa-bus" data-bs-toggle="tooltip" aria-label="fa fa-bus" data-bs-original-title="Assign Vehicle To Driver"></i></a>';
                          } else
                            $assign_link = '<a href="' . base_url() . 'driver/unassign-vehicle/' . $driver['id'] . '" class="btn btn-success btn-sm" role="button"><i class="fa fa-bus" data-bs-toggle="tooltip" aria-label="fa fa-bus" data-bs-original-title="Unassign Vehicle From Driver"></i></a>';

                          $edit_link = '<a href="' . base_url() . 'driver/edit/' . $driver['id'] . '" class="btn btn-warning btn-sm" role="button"><i class="fa fa-pencil" data-bs-toggle="tooltip" aria-label="fa fa-pencil" data-bs-original-title="Edit"></i></a>';

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