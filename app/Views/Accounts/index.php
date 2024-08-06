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


                        <div class="card main-card">
                            <div class="card-body">
                                <h4>Search / Filter</h4>
                                <hr>

                                <?php echo form_open_multipart(base_url() . $currentController . '/' . $currentMethod . (($token > 0) ? '/' . $token : ''), ['name' => 'actionForm', 'id' => 'actionForm']); ?>
                                <div class="row mt-2">

                                    <div class="col-md-12">
                                        <?php
                                        $session = \Config\Services::session();

                                        if ($session->getFlashdata('success')) {
                                            echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
                                        }
                                        ?>
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

                                    <div class="col-md-8">
                                        <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                                        <a href="<?= base_url($currentController) ?>" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                                    </div>

                                    <div class="col-md-2 text-end mt-4">
                                        <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                                    </div>

                                </div>
                                <?php echo form_close(); ?>

                                <!-- Contact List -->
                                <div class="table-responsive custom-table">
                                    <table class="table" id="accounts-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Action</th>
                                                <th>Account Name</th>
                                                <th>Account For</th>
                                                <th>Account Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($accounts as $a) {
                                            ?>
                                                <tr>
                                                    <td><?= $i++ ?>.</td>
                                                    <td><?= makeListActions($currentController, $Action, $a['id'], 2) ?></td>
                                                    <td><?= $a['ac_name'] ?></td>
                                                    <td><?= $a['ac_for'] == '1' ? 'Balance Sheet' : 'Profit And Loss' ?></td>
                                                    <td><?= $a['ac_type'] == '1' ? 'Asset' : 'Liability' ?></td>
                                                    <td><?= $a['status'] == '1' ? '<span class="badge badge-pill bg-success">Active</span>' : '<span class="badge badge-pill bg-danger">Inactive</span>' ?></td>
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
        // datatable init
        if ($('#accounts-table').length > 0) {
            $('#accounts-table').DataTable({
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