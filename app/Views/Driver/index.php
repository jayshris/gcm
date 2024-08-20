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
                  <div class="row">
                    <div class="col-md-8">
                      <h4>Search / Filter</h4>
                    </div>
                    <div class="col-md-4 text-end"><?php echo makeListActions($currentController, $Action, 0, 1); ?></div>
                  </div>
                  <hr>

                  <?php
                  // print_r($driver_data);
                  ?>

                  <div class="row mt-2">

                    <div class="col-md-3">
                      <div class="form-wrap">
                        <label class="col-form-label">Driver</label>
                        <select class="form-select select2" name="driver_id" aria-label="Default select example">
                          <option value="">Select Driver</option>
                          <?php foreach ($drivers as $d) {
                            echo '<option value="' . $d['id'] . '"' . (set_value('driver_id') == $d['id'] ? 'selected' : '') . '>' . $d['driver_name'] . '</option>';
                          } ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-wrap">
                        <label class="col-form-label">Foreman</label>
                        <select class="form-select select2" name="foreman_id" aria-label="Default select example">
                          <option value="">Select Foreman</option>\
                          <?php foreach ($foremen as $f) {
                            echo '<option value="' . $f['id'] . '"' . (set_value('foreman_id') == $f['id'] ? 'selected' : '') . '>' . $f['foreman_name'] . '</option>';
                          } ?>
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

                    <div class="col-md-4">
                      <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                      <a href="./driver" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                      <button id="list" type="button" class="btn btn-warning  mt-4">Assigned List</button>
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
                        <th>Working Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($driver_data) {
                        foreach ($driver_data as $driver) {

                          // var_dump(makeListActions($currentController, $Action, $driver['id'], 2, false, $driver));

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
                            <td><?= makeListActions($currentController, $Action, $driver['id'], 2, false, $driver); ?></td>
                            <td><?= $driver['party_name'] ?></td>
                            <td><?= $driver['dl_no'] ?></td>
                            <td><?= $driver['foreman_name'] ?></td>
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

  <!-- modal  -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">List Of Assigned Drivers and Vehicles</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


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


    $(document).ready(function() {
      $('#list').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
          type: 'GET',
          url: '<?= base_url('driver/assigned_list') ?>', // replace with your URL
          data: {
            id: id
          },
          success: function(data) {
            console.log(data);
            $('#exampleModal').modal('show'); // show the modal
            $('.modal-body').html(data); // populate the modal body with the fetched data
          }
        });
      });
    });
  </script>
</body>

</html>