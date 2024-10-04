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
                                <h4>Booking Links</h4><br><br> 
                                <div class="row mb-3">
                                    <div class="col-md-12 col-sm-12">
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

                                <div class="table-responsive custom-table">
                                    <table class="table" id="linkTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Generated Links</th> 
                                                <th>Generation Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;    
                                            foreach ($booking_links as $l) {  
                                                $encode_url_id = str_replace(['+','/','=','%'], ['-','_','',''],base64_encode($l['booking_id']));
                                                ?>
                                                <tr>
                                                    <td><?= $i++ ?>.</td>
                                                    <td> 
                                                        <input type="hidden" id="myInput"  style="width: 100%;" value="<?= base_url('bookinglinks/edit/').$encode_url_id  .'/'. $l['token'] ?> ">
                                                        <?= base_url('bookinglinks/edit/').$encode_url_id  .'/'. $l['token'] ?> &nbsp;
                                                        <button class="btn btn-warning" onclick="myFunction()"><i class="fa fa-clone" aria-hidden="true" title="Copy link"></i></button>
                                                    </td> 
                                                    <td><?= date('d M Y h:i:s a', strtotime($l['gen_date'])) ?></td>
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
                },
                columnDefs: [{ 
                    target: 2,  
                    render: DataTable.render.datetime( "DD MMM YYYY" )
                } 
                ]
            });
        }

        function myFunction() {
            // Get the text field
            var copyText = document.getElementById("myInput");

            // Select the text field
            copyText.select();
            // copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            // Alert the copied text
            alert("Link Copied : " + copyText.value);
        }
    </script>
</body>

</html>