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

        <div class="card main-card">
          <div class="card-body">

            <!-- Search -->
            <div class="">
              <div class="row mb-3">
                <div class="col-md-12 col-sm-12 mb-3">
                  <?php
                  $session = \Config\Services::session();

                  if ($session->getFlashdata('success')) {
                    echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
                  }

                  if ($session->getFlashdata('danger')) {
                    echo '<div class="alert alert-danger">' . $session->getFlashdata("danger") . '</div>';
                  }
                  ?>
                </div>
                <div class="col-md-12 text-end">
                  <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                </div>

              </div>
            </div>
            <!-- /Search -->

            <!-- Product Type List -->
            <div class="table-responsive custom-table">
              <table class="table" id="ProductCategory">
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Action</th>
                    <th>Name</th>
                    <th>Added</th>
                    <th>Updated</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($statuses as $s) { ?>
                    <tr>
                      <td><?= $i++; ?>.</td>
                      <td><?= makeListActions($currentController, $Action, $s['id'], 2) ?></td>
                      <td><?= $s['status_name'] ?></td>
                      <td><?= date('d M Y', strtotime($s['added_date'])) ?></td>
                      <td><?= $s['updated_date'] != '' ? date('d M Y', strtotime($s['updated_date'])) : '' ?></td>
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
            <!-- /Product Type List -->

          </div>
        </div>

      </div>
      <!-- /Page Wrapper -->


    </div>
    <!-- /Main Wrapper -->

    <!-- scripts link  -->
    <?= $this->include('partials/vendor-scripts') ?>

    <!-- page specific scripts  -->
    <script>
      // datatable init
      if ($('#ProductCategory').length > 0) {
        $('#ProductCategory').DataTable({
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