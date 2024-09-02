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


                <form method="post" enctype="multipart/form-data" action="<?php echo base_url('foreman'); ?>">
                  <div class="search-section">
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-wrap icon-form">
                          <?php
                          $session = \Config\Services::session();
                          if ($session->getFlashdata('success')) {
                            echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
                          }
                          ?>
                        </div>
                      </div>

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



                      <div class="col-md-5">
                        <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                        <a href="./foreman" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                      </div>

                      <div class="col-md-5 text-end">
                        <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                      </div>

                    </div>
                  </div>
                </form>

                <!-- Contact List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="foreman-table">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Foreman Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      foreach ($foreman_data as $foreman) {
                      ?>
                        <tr>
                          <td><?= $i++ ?>.</td>
                          <td><?= makeListActions($currentController, $Action, $foreman['id'], 2) ?></td>
                          <td><?= $foreman['party_name'] ?></td>
                          <td><?= $foreman['mobile'] ?></td>
                          <td><?= $foreman['email'] ?></td>
                          <td><?= $foreman['status'] ? '<span class="badge badge-pill bg-success">Active</span>' : '<span class="badge badge-pill bg-danger">Inactive</span>' ?></td>
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