<?php

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
                    <div class="col-md-9 col-sm-4">
                      <div class="form-wrap icon-form">
                        <?php
                        $session = \Config\Services::session();
                        if ($session->getFlashdata('success')) {
                          echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
                        }
                        ?>
                      </div>
                    </div>

                    <div class="col-md-3 text-end">
                      <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                    </div>

                  </div>
                </div>



                <!-- Contact List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="foreman-table">
                    <thead class="thead-light">
                      <tr>
                        <th>Action</th>
                        <!-- <th>Thumbnail Image</th> -->
                        <th>Foreman Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <!-- <th>Status</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($foreman_data) {
                        foreach ($foreman_data as $foreman) {
                          if ($foreman['status'] == 'Inactive') {
                            $status = '<span class="badge badge-pill bg-danger">Inactive</span>';
                          } else {
                            $status = '<span class="badge badge-pill bg-success">Active</span>';
                          }
                          $created_at_str = '';
                          $updated_at_str = '';
                          if (isset($foreman["created_at"])) {
                            $created_at_str = strtotime($foreman["created_at"]);
                            $created_at_str = date('d-m-Y', $created_at_str);
                          }
                          if (isset($foreman["updated_at"])) {
                            $updated_at_str = strtotime($foreman["updated_at"]);
                            $updated_at_str = date('d-m-Y', $updated_at_str);
                          }

                          if ($foreman['approved'] == NULL) {
                            $bun = '<a href="foreman/approve/' . $foreman['id'] . '" class="btn btn-success btn-sm" role="button">Approve</a>';
                          } else {
                            $bun = '<strong>Approved</strong>';
                          }

                          $party = new PartyModel();
                          $partydata = $party->where('id', $foreman["name"])->first();
                          if ($partydata) {
                            $name = $partydata['party_name'];
                          } else {
                            $name = '';
                          }
                          echo '
                                <tr>
                                    <td>' . makeListActions($currentController, $Action, $foreman['id'], 2) . '</td>
                                    <td>' . $name . '</td>
                                    <td>' . $foreman['mobile'] . '</td>
                                    <td>' . $foreman['email'] . '</td>
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
        window.location.href = "<?php echo base_url(); ?>/foreman/delete/" + id;
      }
      return false;
    }


    // datatable init
    if ($('#foreman-table').length > 0) {
      $('#foreman-table').DataTable({
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