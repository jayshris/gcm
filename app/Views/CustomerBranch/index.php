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

            <!-- Page Header -->
            <div class="page-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="page-title">Branches</h4>
                </div>
                <div class="col-4 text-end">
                  <div class="head-icons">
                    <a href="<?= base_url('customerbranch') ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Page Header -->

            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('customerbranch'); ?>">
              <div class="card main-card">
                <div class="card-body">
                  <h4>Search / Filter</h4>
                  <hr>
                  <div class="row mt-2">

                    <div class="col-md-3">
                      <label class="col-form-label">Customers<span class="text-danger">*</span></label>
                      <select class="form-select select2" required name="party_id">
                        <option value="">Select Customer</option>
                        <?php foreach ($customers as $c) { ?>
                           <option value="<?= $c['id'] ?>" <?= set_value('party_id') == $c['id'] ? 'selected' : '' ?>><?= $c['party_name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    
                    <div class="col-md-3">
                      <div class="form-wrap">
                        <label class="col-form-label">Status</label>
                        <select class="form-select" name="status" aria-label="Default select example">
                          <option value="">Select Status</option>
                          <option value="1" <?= set_value('status') == 1 ? 'selected' : '' ?>>Active</option>
                          <option value="0" <?= set_value('status') == 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                      <a href="./customerbranch" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                    </div>

                    <div class="col-md-3" style="margin-top: 23px;">
                      <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                    </div>
                  </div>
                </div>
              </div>
            </form>


            <div class="card main-card">
              <div class="card-body">

                <!-- Search -->
                <div class="">
                  <div class="row">
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

                  </div>
                </div>
                <!-- /Search -->

                <!-- Product Type List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="customerTable">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Customer Name</th>
                        <th>Branch Name</th>
                        <th>Phone</th>
                        <th>Added</th>
                        <th>Updated</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      foreach ($branches as $b) { ?>
                        <tr>
                          <td><?= $i++; ?>.</td>
                          <td><?= makeListActions($currentController, $Action, $b['id'], 2) ?></td>
                          <td><?= $b['party_name'] ?></td>
                          <td><?= $b['office_name'] ?></td>
                          <td><?= $b['phone'] ?></td>
                          <td><?= date('d M Y', strtotime($b['added_date'])) ?></td>
                          <td><?= $b['modify_date'] != '' ? date('d M Y', strtotime($b['modify_date'])) : '' ?></td>
                          <td>
                            <?php if ($b['status']) {
                              echo '<span class="badge badge-pill bg-success">Active</span>';
                            } else echo '<span class="badge badge-pill bg-danger">Inactive</span>';
                            ?>
                          </td>
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

        </div>
      </div>
      <!-- /Page Wrapper -->


    </div>
    <!-- /Main Wrapper -->

    <!-- scripts link  -->
    <?= $this->include('partials/vendor-scripts') ?>

    <!-- page specific scripts  -->
    <script>
      // function delete_data(id) {
      //   if (confirm("Are you sure you want to remove this product ?")) {
      //     window.location.href = "<?php echo base_url('warehouses-delete/'); ?>" + id;
      //   }
      //   return false;
      // }


      // datatable init
      if ($('#customerTable').length > 0) {
        $('#customerTable').DataTable({
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
              target: 5,  
              render: DataTable.render.datetime( "DD MMM YYYY" )
            },
            { 
              target: 6,  
              render: DataTable.render.datetime( "DD MMM YYYY" )
            } 
          ]
        });
      }
    </script>
</body>

</html>