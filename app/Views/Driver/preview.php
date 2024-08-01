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
                                                            transform: scale(1);
                                                            transform-origin: 0 0;
                                                        }
                                                    }
                                                </style>

                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="3" align="center" style="background-color: #e7e7e7;">
                                                                <h6>Driver Details</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%">Name </td>
                                                            <td width="35%"><?= $driver_data['driver_name'] ?></td>
                                                            <td rowspan="5" width="55%" align="center">
                                                                <img src="<?= base_url('public/uploads/driverDocs/') . $driver_data['profile_image1'] ?>" style="width: 150px;">&nbsp;&nbsp;
                                                                <img src="<?= base_url('public/uploads/driverDocs/') . $driver_data['profile_image2'] ?>" style="width: 150px;">
                                                                <!-- <h6 class="text-center">Profile Images</h6> -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Foreman Name </td>
                                                            <td><?= $driver_data['foreman_name'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Driver Type </td>
                                                            <td><?= $driver_data['driver_type'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mobile No. </td>
                                                            <td><?= $driver_data['primary_phone'] ?>, <?= $driver_data['other_phone'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email ID</td>
                                                            <td><?= $driver_data['email'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" align="center" style="background-color: #e7e7e7;">
                                                                <h6>Identification Details</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>DL No. </td>
                                                            <td><?= $driver_data['dl_no'] ?></td>
                                                            <td align="center" rowspan="4">
                                                                <img src="<?= base_url('public/uploads/driverDocs/') . $driver_data['dl_image_front'] ?>" style="width: 150px;">&nbsp;&nbsp;
                                                                <img src="<?= base_url('public/uploads/driverDocs/') . $driver_data['dl_image_back'] ?>" style="width: 150px;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>DL Authority </td>
                                                            <td><?= $driver_data['dl_authority'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>DL Expiry </td>
                                                            <td><?= $driver_data['dl_expiry'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mobile No. </td>
                                                            <td><?= $driver_data['primary_phone'] ?>, <?= $driver_data['other_phone'] ?></td>
                                                        </tr>


                                                        <tr>
                                                            <td colspan="3" align="center" style="background-color: #e7e7e7;">
                                                                <h6>Banking Details</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>UPI ID </td>
                                                            <td><?= $driver_data['upi_text'] ?></td>
                                                            <td rowspan="5" align="center">
                                                                <img src="<?= base_url('public/uploads/driverDocs/') . $driver_data['upi_id'] ?>" style="width: 150px;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank A/C No. </td>
                                                            <td><?= $driver_data['bank_ac'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank IFSC </td>
                                                            <td><?= $driver_data['bank_ifsc'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Em. Person </td>
                                                            <td><?= $driver_data['emergency_person'] != '' ? $driver_data['emergency_person'] : '' ?> <?= $driver_data['emergency_relation'] != '' ? '( ' . $driver_data['emergency_relation'] . ' )' : '' ?> </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Em. Contact</td>
                                                            <td><?= $driver_data['emergency_contact'] ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </div>

                                            <button class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i> Print</button>

                                            <?php
                                            // echo '<pre>';
                                            // print_r($driver_data);
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

            document.body.innerHTML = originalContents;
        }
    </script>

</body>

</html>