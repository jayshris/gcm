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
          <div class="col-md-12 p-3">

            <?= $this->include('partials/page-title') ?>



            <div class="card main-card">
              <div class="card-body">
                <!-- Search -->
                <div class="mb-3">
                  <div class="row">
                    <div class="col-md-12">
                      <a href="<?php echo base_url('foremankyc/create'); ?>" class="btn btn-info" role="button">Generate Link</a>
                    </div>
                  </div>
                </div>


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
                        <th>Action</th>
                        <th>Driver Name</th>
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($party_data) {
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


                          echo '
                                <tr>
                                    <td><a href="foremankyc/approve/' . $party['id'] . '" class="btn btn-info btn-sm" role="button">Approve <i class="fa fa-check" aria-hidden="true"></i></a></td>                                    
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