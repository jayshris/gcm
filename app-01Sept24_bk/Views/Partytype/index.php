<!DOCTYPE html>
<html lang="en">

<head>
  <?= $this->include('partials/title-meta') ?>
  <?= $this->include('partials/head-css') ?>
  <!-- Summernote CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/summernote/summernote-lite.min.css">
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

                <?php

                $session = \Config\Services::session();
                if ($session->getFlashdata('success')) {
                  echo '
    <div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
    ';
                }
                ?>
                <div class="row">
                  <div class="col-md-12">
                    <form method="post" action="<?php echo base_url() ?>partytype/searchByStatus">
                      <!-- Search -->
                      <div class="search-section">
                        <div class="row">
                          <div class="col-md-1 col-sm-3">
                            <label class="col-form-label">
                              Status
                            </label>
                          </div>
                          <div class="col-md-3 col-sm-3">
                            <div class="form-wrap">
                              <select class="form-control" name="status">
                                <option>Select</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3 col-sm-3">
                            <input type="submit" value="Submit" class="btn btn-primary">
                          </div>
                          <div class="col-md-5 text-end">
                            <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- Contact List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="ptTable">
                    <thead class="thead-light">
                      <tr>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Sale</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($partytype_data) {
                        foreach ($partytype_data as $partytype) {

                          $token = isset($partytype['id']) ? $partytype['id'] : 0;

                          if ($partytype['status'] == 'Inactive') {
                            $status = '<span class="badge badge-pill bg-danger">Inactive</span>';
                          } else {
                            $status = '<span class="badge badge-pill bg-success">Active</span>';
                          }

                          $btn = '';
                          if ($partytype["status"] == 'Active') {
                            $btn = 'Inactive';
                          } elseif ($partytype['status'] == 'Inactive') {
                            $btn = 'Active';
                          }
                          echo '
                                <tr>
                                    <td>' . makeListActions($currentController, $Action, $token, 2) . '</td>                                    
                                    <td>' . $partytype['name'] . '</td>
                                    <td>' . ($partytype['sale'] ? 'Yes' : 'No') . '</td>
                                    <td>' . $status . '</td>
                                </tr>';
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
        window.location.href = "<?php echo base_url(); ?>/partytype/delete/" + id;
      }
      return false;
    }

    // datatable init
    if ($('#ptTable').length > 0) {
      $('#ptTable').DataTable({
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