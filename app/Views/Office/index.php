<?php

use App\Models\CompanyModel;

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
                  <div class="row">
                    <?php
                    $session = \Config\Services::session();

                    if ($session->getFlashdata('success')) {
                      echo '
                            <div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
                            ';
                    }
                    ?>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <form method="post" action="<?php echo base_url() ?>office/searchByStatus">
                      <!-- Search -->
                      <div class="search-section">
                        <div class="row">
                          <div class="col-md-2 col-sm-3">
                            <label class="col-form-label">
                              Search By Status
                            </label>
                          </div>
                          <div class="col-md-3 col-sm-3">
                            <div class="form-wrap">
                              <select class="form-control" name="status">
                                <option>Select</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3 col-sm-3">
                            <input type="submit" value="Submit" class="btn btn-primary">
                          </div>
                          <div class="col-md-4 text-end">
                            <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <!-- Contact List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="officeTable">
                    <thead class="thead-light">
                      <tr>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Added</th>
                        <th>Updated</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      if ($office_data) {
                        foreach ($office_data as $office) {
                          $company = new CompanyModel();

                          $token = isset($office['id']) ? $office['id'] : 0;

                          $companydata = $company->where('id', $office['company_id'])->first();
                          if ($office['status'] == 0) {
                            $status = '<span class="badge badge-pill bg-danger">Inactive</span>';
                          } else {
                            $status = '<span class="badge badge-pill bg-success">Active</span>';
                          }
                          $strtime = strtotime($office["created_at"]);
                          $strtime2 = '';
                          if (isset($office["updated_at"])) {
                            $strtime2 = strtotime($office["updated_at"]);
                            $strtime2 = date('d M Y h:i:sa', $strtime2);
                          } else {
                            $strtime2 = '';
                          }
                          if ($companydata['status'] == 'Active') {
                            if ($office['status'] == 1) {
                              $bun = '<a href="office/status/' . $office['id'] . '" class="btn btn-danger btn-sm" role="button">Inactive</a>';
                            } else {
                              $bun = '<a href="office/status/' . $office['id'] . '" class="btn btn-success btn-sm" role="button">Active</a>';
                            }
                          } else {
                            $bun = '';
                          }

                          echo '
                                <tr>
                                    <td>' . makeListActions($currentController, $Action, $token, 2) . '</td>
                                    <td>' . $office["name"] . '</td>
                                    <td>' . @$companydata['name'] . '</td>
                                    <td>' . date('d M Y h:i:sa', $strtime) . '</td>
                                    <td>' . $strtime2 . '</td>
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
        window.location.href = "<?php echo base_url(); ?>/office/delete/" + id;
      }
      return false;
    }

    // datatable init
    if ($('#officeTable').length > 0) {
      $('#officeTable').DataTable({
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
              render: DataTable.render.datetime( "DD MMM YYYY h:i:sa" )
            },
            { 
              target: 4,  
              render: DataTable.render.datetime( "DD MMM YYYY h:i:sa" )
            } 
          ]
      });
    }
  </script>
</body>

</html>