<html lang="en">

<head>
    <?= $this->include('partials/title-meta') ?>
    <?= $this->include('partials/head-css') ?>
</head>

<body>
    <div class="main-wrapper">

        <?= $this->include('partials/menu') ?>

        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-md-12">

                        <?= $this->include('partials/page-title') ?>
                        <?php $validation = \Config\Services::validation(); ?>

                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="settings-form">

                                            <div class="settings-sub-header" id="printableArea">

                                                <style>
                                                    @media print {
                                                        body {
                                                            margin-top: 5px;
                                                            margin-left: 10px;
                                                            transform: scale(0.98);
                                                            transform-origin: 0 0;
                                                        }
                                                    }
                                                </style>

                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="4" align="center" style="background-color: #e7e7e7;">
                                                                <h6>Party Details</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%">Party Name </td>
                                                            <td width="40%"><?= $party_details['party_name'] ?></td>
                                                            <td width="10%">Alias </td>
                                                            <td width="40%"><?= $party_details['alias'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Contact Person</td>
                                                            <td><?= $party_details['contact_person'] ?></td>
                                                            <td>Email</td>
                                                            <td><?= $party_details['email'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Contact No. </td>
                                                            <td><?= $party_details['primary_phone'] ?></td>
                                                            <td>Other Contact</td>
                                                            <td><?= $party_details['other_phone'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address </td>
                                                            <td colspan="3"><?= $party_details['business_address'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>City</td>
                                                            <td><?= $party_details['city'] ?></td>
                                                            <td>State</td>
                                                            <td><?= $party_details['state_name'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Post Code</td>
                                                            <td><?= $party_details['postcode'] ?></td>
                                                            <td>Business Type</td>
                                                            <td><?= $party_details['business_type'] ?></td>
                                                        </tr>

                                                        <?php foreach ($party_docs as $pd) { ?>
                                                            <tr>
                                                                <td><?= $pd['title'] ?> No.</td>
                                                                <td colspan="3"><?= $pd['number'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><?= $pd['title'] ?> Images</td>
                                                                <td align="center" colspan="3">
                                                                    <img src="<?= base_url('public/uploads/partyDocs/') . $pd['img1'] ?>" style="height: 150px;">&nbsp;&nbsp;
                                                                    <img src="<?= base_url('public/uploads/partyDocs/') . $pd['img2'] ?>" style="height: 150px;">
                                                                </td>
                                                            </tr>
                                                        <?php } ?>



                                                    </tbody>
                                                </table>

                                            </div>

                                            <button class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i> Print </button>&nbsp;&nbsp;
                                            <a href="<?php echo base_url($currentController); ?>" class="btn btn-warning">Back</a>

                                            <?php
                                            // echo '<pre>';
                                            // print_r($party_details);
                                            // echo '</pre>';
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('partials/vendor-scripts') ?>
    <script src="<?php echo base_url(); ?>public/assets/js/common.js"></script>

    <script>
        function printDiv(divId) {

            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            window.location.reload();
        }
    </script>

</body>

</html>