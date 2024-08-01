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
                                <h4>Generate KYC Link For Driver</h4><br><br>

                                <div class="search-section">

                                    <div class="row g-4 mb-3">
                                        <div class="col-md-12">
                                            <h6 class="text-danger">Note : click generate link button to generate unique link for KYC, copy and send. Link is valid for 24 hrs only. </h6>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Generate For <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" id="gen_for">
                                        </div>

                                        <div class="col-md-2 pt-4">
                                            <button type="button" class="btn btn-danger w-100" onclick="$.getLink();">Generate Link</button>
                                        </div>

                                        <div class="col-md-7">
                                            <div class="input-group pt-4">
                                                <input type="text" class="form-control" id="myInput" placeholder="click generate button to generate new link" style="width: 100%;">
                                                <button class="btn btn-warning" onclick="myFunction()"><i class="fa fa-clone" aria-hidden="true"></i></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="table-responsive custom-table">
                                    <table class="table" id="linkTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Generated Links</th>
                                                <th>Generated For</th>
                                                <th>Generation Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($gen_links as $l) { ?>
                                                <tr>
                                                    <td><?= $i++ ?>.</td>
                                                    <td><?= base_url('Driverkyc/register/') . $l['token'] ?></td>
                                                    <td><?= $l['gen_for'] ?></td>
                                                    <td><?= date('d-m-Y h:i:s a', strtotime($l['gen_date'])) ?></td>
                                                    <td>
                                                    <?php
                                                        $dateProvided = $l['gen_date'];
                                                        $dateProvidedTimestamp = strtotime($dateProvided) + (24 * 60 * 60);

                                                        $currentDateTimestamp = time();

                                                        if ($l['link_used'] != 0) {
                                                            echo '<span class="badge badge-pill bg-success">Submitted</span>';
                                                        } else if ($dateProvidedTimestamp < $currentDateTimestamp) {
                                                            echo '<span class="badge badge-pill bg-danger">Expired</span>';
                                                        } else {
                                                            echo '<span class="badge badge-pill bg-warning">Active</span>';
                                                        } ?>
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
        $.getLink = function() {
            $('#myInput').val('');
            var gen_for = $('#gen_for').val();
            if (gen_for != "") {
                $.ajax({
                    method: 'POST',
                    url: 'getLink',
                    data: {
                        gen_for: gen_for
                    },
                    success: function(response) {

                        console.log(response);

                        $('#myInput').val(response);

                    }
                });
            } else {
                alert('please enter the name for which you want to generate link for');
            }
        }

        function myFunction() {
            // Get the text field
            var copyText = document.getElementById("myInput");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            // Alert the copied text
            alert("Link Copied : " + copyText.value);
        }

        // datatable init
        if ($('#linkTable').length > 0) {
            $('#linkTable').DataTable({
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