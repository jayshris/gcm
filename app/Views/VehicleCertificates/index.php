<!DOCTYPE html>
<html lang="en">

<head>
  <?= $this->include('partials/title-meta') ?>
  <?= $this->include('partials/head-css') ?>
</head>


<body>

  <!-- Main Wrapper -->
  <div class="main-wrapper">

    <?= $this->include('partials/menu'); ?>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
      <div class="content">

        <div class="row">
          <div class="col-md-12">

            <!-- Page Header -->
            <div class="page-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="page-title">Vehicle Certificates</h4>
                </div>
                <div class="col-4 text-end">
                  <div class="head-icons">
                    <a href="<?= base_url('vehicle-certificates') ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Page Header -->

            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('vehicle-certificates'); ?>">
              <div class="card main-card">
                <div class="card-body">
                  <h4>Search / Filter</h4>
                  <hr>
                  <div class="row mt-2">

                    <div class="col-md-3">
                      <label class="col-form-label">Vehicle Number</label>
                      <select class="form-select select2" name="vehicle_id" aria-label="Default select example">
                        <option value="">Select Vehicle</option>
                        <?php foreach ($vehicles as $v) {
                          echo '<option value="' . $v['id'] . '" ' . (set_value('vehicle_id') == $v['id'] ? 'selected' : '') . '>' . $v['rc_number'] . '</option>';
                        } ?>
                      </select>
                    </div>

                    <div class="col-md-3">
                      <label class="col-form-label">Certificate Type</label>
                      <select class="form-select select2" name="certificate_id" aria-label="Default select example">
                        <option value="">Select Certificate</option>
                        <?php foreach ($cert_type as $c) {
                          echo '<option value="' . $c['id'] . '" ' . (set_value('certificate_id') == $c['id'] ? 'selected' : '') . '>' . $c['name'] . '</option>';
                        } ?>
                      </select>
                    </div>

                    <div class="col-md-3">
                      <label class="col-form-label">Vendor</label>
                      <select class="form-select select2" name="party_id" aria-label="Default select example">
                        <option value="">Select Vendor</option>
                        <?php foreach ($party as $p) {
                          echo '<option value="' . $p['id'] . '" ' . (set_value('party_id') == $p['id'] ? 'selected' : '') . '>' . $p['party_name'] . '</option>';
                        } ?>
                      </select>
                    </div>

                    <div class="col-md-2">
                      <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                      <a href="./vehicle-certificates" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
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
                  <table class="table" id="certTable">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Vehicle Number</th>
                        <th>Certificate</th>
                        <th>Vendor</th>
                        <th>Document Number</th>
                        <th>Issue Date</th>
                        <th>Expiry Date</th>
                        <th>Download</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      foreach ($certificates as $c) { ?>
                        <tr>
                          <td><?= $i++; ?>.</td>
                          <td>
                            <button type="button" onclick="delete_data('<?= $c['id'] ?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                          </td>
                          <td><?= $c['rc_number'] ?></td>
                          <td><?= $c['name'] ?></td>
                          <td><?= $c['party_name'] ?></td>
                          <td><?= $c['certificate_no'] ?></td>
                          <td><?= date('d M Y', strtotime($c['issue_date'])) ?></td>
                          <td><?= date('d M Y', strtotime($c['expiry_date'])) ?></td>
                          <td>
                            <button type="button" onclick="downloadPdf('<?= base_url('public/uploads/vehicle_certificates/' . $c['img1']) ?>','<?= $c['rc_number'] . '_' . $c['img1'] ?>')" class="btn btn-info btn-sm"><i class="fa fa-arrow-down"></i>1</button>

                            <?php if ($c['img2'] != '') { ?>
                              <button type="button" onclick="downloadPdf('<?= base_url('public/uploads/vehicle_certificates/' . $c['img2']) ?>','<?= $c['rc_number'] . '_' . $c['img2'] ?>')" class="btn btn-info btn-sm"><i class="fa fa-arrow-down"></i>2</button>
                            <?php } ?>
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
      function delete_data(id) {
        if (confirm("Are you sure you want to remove this certificate ?")) {
          window.location.href = "<?php echo base_url('vehicle-certificates-delete/'); ?>" + id;
        }
        return false;
      }

      function downloadPdf(url, filename) {
        if (confirm("Do you want to download this certificate ?")) {
          const link = document.createElement('a');

          link.href = url;
          link.download = filename;

          link.target = '_blank';

          document.body.appendChild(link);

          link.click();
          link.remove();
        }
        return false;
      }


      // datatable init
      if ($('#certTable').length > 0) {
        $('#certTable').DataTable({
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
          searching: false,
          initComplete: (settings, json) => {
            $('.dataTables_paginate').appendTo('.datatable-paginate');
            $('.dataTables_length').appendTo('.datatable-length');

          }
        });
      }
    </script>
</body>

</html>