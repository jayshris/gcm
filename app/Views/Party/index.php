<?php

use App\Models\PartyClassificationModel;
use App\Models\PartytypeModel;
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

            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('party'); ?>">
              <div class="card main-card">
                <div class="card-body">
                  <h4>Search / Filter</h4>
                  <hr>
                  <div class="row mt-2">

                    <div class="col-md-3">
                      <div class="form-wrap">
                        <label class="col-form-label">Party Name</label>
                        <select class="form-select select2" name="party_id" aria-label="Default select example">
                          <option value="">Select Party</option>
                          <?php foreach ($party_data as $p) {
                            echo '<option value="' . $p['id'] . '"' . (set_value('party_id') == $p['id'] ? 'selected' : '') . '>' . $p['party_name'] . '</option>';
                          } ?>
                        </select>
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
                      <a href="./party" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                    </div>

                    <div class="col-md-2 text-end">
                      <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                    </div>
                  </div>
                </div>
              </div>
            </form>

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
                <!-- Contact List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="partyTable">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Party Name</th>
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($party_data) {
                        $i = 1;
                        foreach ($party_data as $party) {
                          $pcustomertype = new PartytypeModel();
                          $pcustomertype = $pcustomertype->where('id', $party['id'])->findAll();


                          if (!$party['approved']) {
                            $status = '<span class="badge badge-pill bg-info">Not Approved</span>';
                          } else if ($party['status'] == '0') {
                            $status = '<span class="badge badge-pill bg-danger">Inactive</span>';
                          } else {
                            $status = '<span class="badge badge-pill bg-success">Active</span>';
                          }

                          if (!$party['approved']) {
                            $bun = '<a href="party/approve/' . $party['id'] . '" class="dropdown-item btn btn-info btn-sm" role="button">Approve</a>';
                          } else if ($party['status'] == '1') {
                            $bun = '<a href="party/status/' . $party['id'] . '" class="dropdown-item btn btn-danger btn-sm" role="button">Inactive</a>';
                          } else {
                            $bun = '<a href="party/status/' . $party['id'] . '" class="dropdown-item btn btn-success btn-sm" role="button">Active</a>';
                          }
                          echo '
                                <tr>
                                    <td>' . $i++ . '.</td>
                                    <td>' . makeListActions($currentController, $Action, $party['id'], 2) . '</td>
                                    
                                    <td>' . $party['party_name'] . '</td>
                                    <td>' . $party['contact_person'] . '</td>
                                    <td>' . $party['primary_phone'] . '</td>
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
        window.location.href = "<?php echo base_url(); ?>/party/delete/" + id;
      }
      return false;
    }


    // datatable init
    if ($('#partyTable').length > 0) {
      $('#partyTable').DataTable({
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