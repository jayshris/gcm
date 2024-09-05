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
                    <?php
                    $session = \Config\Services::session();
                    if ($session->getFlashdata('success')) {
                      echo '
                              <div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
                              ';
                    }
                    ?>
                    <div class="col-md-5 col-sm-4">
                      <div class="form-wrap icon-form">
                        <span class="form-icon"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search Deals">
                      </div>
                    </div>
                    <div class="col-md-7 text-end">
                      <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                    </div>

                  </div>
                </div>

                <!-- Contact List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="btTable">
                    <thead class="thead-light">
                      <tr>
                        <th>Action</th>
                        <th>Company Structure Type</th>
                        <th>Flags</th>
                        <th>Added</th>
                        <th>Status</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($businestsype_data) {
                        foreach ($businestsype_data as $business) {

                          $token = isset($business['id']) ? $business['id'] : 0;

                          $btn = '';
                          if ($business["condition"] == 'Enable') {
                            $btn = 'Disable';
                          } elseif ($business['condition'] == 'Disable') {
                            $btn = 'Enable';
                          }
                          $created_at_str = '';
                          $updated_at_str = '';
                          if (isset($business["created_at"])) {
                            $created_at_str = strtotime($business["created_at"]);
                            $strtime = date('d-m-Y', $created_at_str);
                          }
                          if (isset($business["updated_at"]) && ($business["updated_at"] != '0000-00-00 00:00:00')) {
                            $updated_at_str = strtotime($business["updated_at"]);
                            $strtime1 = date('d-m-Y', $updated_at_str);
                          } else {
                            $strtime1 = '-';
                          }
                          echo '
                                <tr>
                                    <td>' . makeListActions($currentController, $Action, $token, 2) . '</td>
                                    <td>' . ucwords($business["company_structure_name"]) . '</td>
                                    <td>' . $business["flags_names"] . '</td>
                                    <td>' . $strtime . '</td>
                                    <td>' . $business["condition"] . '</td>
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
  <!-- Summernote JS -->
  <script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-lite.min.js"></script>
  <script>
    function delete_data(id) {
      if (confirm("Are you sure you want to remove it?")) {
        window.location.href = "<?php echo base_url(); ?>/businesstype/delete/" + id;
      }
      return false;
    }

    // datatable init
    if ($('#btTable').length > 0) {
      $('#btTable').DataTable({
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