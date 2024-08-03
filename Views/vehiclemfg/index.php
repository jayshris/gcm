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
                  <div class="row">
                    <div class="col-md-9">
                      <div class="form-wrap icon-form">
                        <!-- <span class="form-icon"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search Deals"> -->
                        <?php

                        $session = \Config\Services::session();

                        if ($session->getFlashdata('success')) {
                          echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
                        }

                        ?>
                      </div>
                    </div>

                    <div class="col-md-3 text-end mb-3">
                      <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                    </div>

                  </div>
                </div>
                <!-- /Search -->


                <!-- Contact List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="vehicleBody">
                    <thead class="thead-light">
                      <tr>
                        <th>Action</th>
                        <th>Vehicle Manufacturer</th>
                        <th>Added</th>
                        <th>Last Updated</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($body_types as $body) {
                      ?>
                        <tr>
                          <td><?= makeListActions($currentController, $Action, $body['id'], 2) ?></td>
                          <td><?= $body['name'] ?></td>
                          <td><?= date('d-m-Y', strtotime($body['created_at'])) ?></td>
                          <td><?= $body['modified_at'] != '' ? date('d-m-Y', strtotime($body['modified_at'])) : '' ?></td>
                          <td>
                            <?php
                            if ($body['status']) {
                              echo '<span class="badge badge-pill bg-success">Active</span>';
                            } else echo '<span class="badge badge-pill bg-danger">Inactive</span>';
                            ?>
                          </td>
                        </tr>
                      <?php
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
      if (confirm("Are you sure you want to remove this body type ?")) {
        window.location.href = "<?php echo base_url(); ?>/vehicle-mfg/delete/" + id;
      }
      return false;
    }


    // datatable init
    if ($('#vehicleBody').length > 0) {
      $('#vehicleBody').DataTable({
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