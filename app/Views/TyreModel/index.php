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

            <form method="post" enctype="multipart/form-data" action="<?php echo base_url($currentController); ?>">

              <div class="card main-card">
                <div class="card-body">

                  <!-- Search -->
                  <div class="search-section">
                    <div class="row g-3">

                      <!-- Page Header -->
                      <div class="col-md-12 page-header mb-0">
                        <div class="row align-items-center">
                          <div class="col-8">
                            <h4 class="page-title">Tyre Models</h4>
                          </div>
                          <div class="col-4 text-end">
                            <div class="head-icons">
                              <a href="<?= base_url('tyremodel') ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                              <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /Page Header -->

                      <div class="col-md-2">
                        <label class="col-form-label">Status</label>
                        <select class="form-select" name="status" aria-label="Default select example">
                          <option value="">Select Status</option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                      </div>

                      <div class="col-md-3">
                        <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                        <a href="<?= base_url($currentController) ?>" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                      </div>

                      <div class="col-md-7 text-end mt-4">
                        <?php echo makeListActions($currentController, $Action, 0, 1); ?>
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
                  <!-- /Search -->

                  <!-- Contact List -->
                  <div class="table-responsive custom-table">
                    <table class="table" id="ftypeTable">
                      <thead class="thead-light">
                        <tr>
                          <th>#</th>
                          <th>Action</th>
                          <th>Model Name</th>
                          <th>Added</th>
                          <th>Updated</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 1;
                        foreach ($tyremodels as $t) {
                        ?>
                          <tr>
                            <td><?= $i++ ?>.</td>
                            <td><?= makeListActions($currentController, $Action, $t['id'], 2) ?></td>
                            <td><?= $t['model'] ?></td>
                            <td><?= date('d M Y', strtotime($t['added_date'])); ?></td>
                            <td><?= $t['updated_date'] != '' ? date('d M Y', strtotime($t['updated_date'])) : ''; ?></td>
                            <td><?= $t['status'] ? '<span class="badge badge-pill bg-success">Active</span>' : '<span class="badge badge-pill bg-danger">Inactive</span>'; ?></td>
                          </tr>
                        <?php } ?>
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

            </form>

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
        window.location.href = "<?php echo base_url(); ?>/fueltype/delete/" + id;
      }
      return false;
    }

    // datatable init
    if ($('#ftypeTable').length > 0) {
      $('#ftypeTable').DataTable({
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
              render: DataTable.render.datetime( "DD MMM YYYY" )
            },
            { 
              target: 4,  
              render: DataTable.render.datetime( "DD MMM YYYY" )
            } 
          ]
      });
    }
  </script>
</body>

</html>