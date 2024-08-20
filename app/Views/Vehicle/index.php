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

            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('vehicle'); ?>">
              <div class="card main-card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h4>Search / Filter</h4>
                    </div>
                    <div class="col-md-4 text-end"><?php echo makeListActions($currentController, $Action, 0, 1); ?></div>
                  </div>

                  <hr>
                  <div class="row mt-2">

                    <div class="col-md-2">
                      <div class="form-wrap">
                        <label class="col-form-label">Owner</label>
                        <select class="form-select" name="owner" aria-label="Default select example">
                          <option value="">Select Owner</option>
                          <option value="company" <?= set_value('owner') == 'company' ? 'selected' : '' ?>>Company</option>
                          <option value="onhire" <?= set_value('owner') == 'onhire' ? 'selected' : '' ?>>On-Hire</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2">
                      <div class="form-wrap">
                        <label class="col-form-label">Type</label>
                        <select class="form-select" name="type" aria-label="Default select example">
                          <option value="">Select Type</option>
                          <?php
                          foreach ($vehicle_types as $row) {
                            echo '<option value="' . $row["id"] . '" "' . set_select('type', $row['id']) . '">' . ucwords($row["name"]) . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2">
                      <div class="form-wrap">
                        <label class="col-form-label">RC Number</label>
                        <select class="form-select select2" name="rc_number" aria-label="Default select example">
                          <option value="">Select RC</option>
                          <?php
                          foreach ($vehicle_data as $row) {
                            echo '<option value="' . $row["rc_number"] . '" "' . set_select('rc_number', $row['id']) . '">' . ucwords($row["rc_number"]) . '</option>';
                          }
                          ?>
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

                    <div class="col-md-2">
                      <div class="form-wrap">
                        <label class="col-form-label">Working Status</label>
                        <select class="form-select" name="working_status" aria-label="Default select example">
                          <option value="">Select Status</option>
                          <option value="1" <?= set_value('working_status') == 1 ? 'selected' : '' ?>>Not Assigned</option>
                          <option value="2" <?= set_value('working_status') == 2 ? 'selected' : '' ?>>Assigned </option>
                          <option value="3" <?= set_value('working_status') == 3 ? 'selected' : '' ?>>In Running </option>
                          <option value="4" <?= set_value('working_status') == 4 ? 'selected' : '' ?>>In Service </option>
                          <option value="5" <?= set_value('working_status') == 5 ? 'selected' : '' ?>>On Hold </option>
                          <option value="6" <?= set_value('working_status') == 6 ? 'selected' : '' ?>>Waiting for Load </option>
                          <option value="7" <?= set_value('working_status') == 7 ? 'selected' : '' ?>>Ready for Unloading </option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2 mt-4">
                      <button class="btn btn-info">Search</button>&nbsp;&nbsp;
                      <a href="./vehicle" class="btn btn-warning">Reset</a>&nbsp;&nbsp;
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
                  <table class="table" id="vehicle-table">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Vehicle Owner</th>
                        <th>Vehicle Type</th>
                        <th>RC No</th>
                        <th>Status</th>
                        <th>Working Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($vehicle_data) {
                        $i = 1;
                        foreach ($vehicle_data as $row) {
                          if ($row['status']) {
                            $status = '<span class="badge badge-pill bg-success">Active</span>';
                          } else {
                            $status = '<span class="badge badge-pill bg-danger">Inactive</span>';
                          }

                          //working status
                          $ws = '';
                          switch ($row['working_status']) {
                            case "1":
                              $ws = '<span class="badge badge-pill bg-danger">Not Assigned</span>';
                              break;
                            case "2":
                              $ws = '<span class="badge badge-pill bg-success">Assigned</span>';
                              break;
                            case "3":
                              $ws = '<span class="badge badge-pill bg-warning">In Running</span>';
                              break;
                            case "4":
                              $ws = '<span class="badge badge-pill bg-warning">In Service</span>';
                              break;
                            case "5":
                              $ws = '<span class="badge badge-pill bg-warning">On Hold</span>';
                              break;
                            case "6":
                              $ws = '<span class="badge badge-pill bg-warning">Waiting For Load</span>';
                              break;
                            case "7":
                              $ws = '<span class="badge badge-pill bg-warning">Waiting For Unload</span>';
                              break;
                            default:
                              $ws = '<span class="badge badge-pill bg-warning">N/A</span>';
                          }


                          $created_at_str = '';
                          $updated_at_str = '';
                          if (isset($row["created_at"])) {
                            $created_at_str = strtotime($row["created_at"]);
                            $strtime = date('d-m-Y', $created_at_str);
                          }
                          if (isset($row["updated_at"]) && ($row["updated_at"] != '0000-00-00 00:00:00')) {
                            $updated_at_str = strtotime($row["updated_at"]);
                            $strtime1 = date('d-m-Y', $updated_at_str);
                          } else {
                            $strtime1 = '-';
                          }
                          echo '
                                <tr>
                                    <td>' . $i++ . '.</td>
                                    <td>' . makeListActions($currentController, $Action, $row['id'], 2) . '</td>
                                    <td>' . ucwords($row["owner"]) . '</td>
                                    <td>' . ucwords($row["vehiclename"]) . '</td>
                                    <td>' . ucwords($row["rc_number"]) . '</td>
                                    <td>' . $status . '</td>
                                    <td>' . $ws . '</td>
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
        window.location.href = "<?php echo base_url(); ?>/vehicle/delete/" + id;
      }
      return false;
    }

    // datatable init
    if ($('#vehicle-table').length > 0) {
      $('#vehicle-table').DataTable({
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