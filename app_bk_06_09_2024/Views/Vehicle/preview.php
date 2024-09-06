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

                                                <table class="table table-bordered text-capitalize">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="4" align="center" style="background-color: #e7e7e7;">
                                                                <h6>Vehicle Details</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%">Vehicle Type </td>
                                                            <td width="40%"><?= $vehicle_data['type_name'] ?></td>
                                                            <td width="10%">Model Number </td>
                                                            <td width="40%"><?= $vehicle_data['model_no'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Owner </td>
                                                            <td><?= $vehicle_data['owner'] ?></td>
                                                            <td>MFG </td>
                                                            <td><?= date('m-Y', strtotime($vehicle_data['mfg'])) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>RC Number </td>
                                                            <td><?= $vehicle_data['rc_number'] ?></td>
                                                            <td>RC Date </td>
                                                            <td><?= date('d-m-Y', strtotime($vehicle_data['rc_date'])) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Chassis Number </td>
                                                            <td><?= $vehicle_data['chassis_number'] ?></td>
                                                            <td>Engine Number </td>
                                                            <td><?= $vehicle_data['engine_number'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Invoice Number</td>
                                                            <td><?= $vehicle_data['invoice_no'] ?></td>
                                                            <td>Invoice Date</td>
                                                            <td><?= date('d-m-Y', strtotime($vehicle_data['invoice_date'])) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Colour</td>
                                                            <td><?= $vehicle_data['colour'] ?></td>
                                                            <td>Seating</td>
                                                            <td><?= $vehicle_data['seating'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Laden Weight</td>
                                                            <td><?= $vehicle_data['laden_wt'] ?></td>
                                                            <td>Unladen Weight</td>
                                                            <td><?= $vehicle_data['unladen_wt'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align="center">
                                                                <img src="<?= base_url('public/uploads/vehicles/') . $vehicle_data['image1'] ?>" style="width: 150px;">&nbsp;&nbsp;
                                                                <img src="<?= base_url('public/uploads/vehicles/') . $vehicle_data['image2'] ?>" style="width: 150px;">&nbsp;&nbsp;
                                                                <img src="<?= base_url('public/uploads/vehicles/') . $vehicle_data['image3'] ?>" style="width: 150px;">&nbsp;&nbsp;
                                                                <img src="<?= base_url('public/uploads/vehicles/') . $vehicle_data['image4'] ?>" style="width: 150px;">
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                                <div class="row w-100 g-0">
                                                    <?php $i = 1;
                                                    foreach ($v_tyres as $vt) {
                                                        echo ' <div class="col-2 text-center" style="border: 0.5px solid;"><span>Tyre ' . $i++ . '<br>' . $vt['tyre_serial_text'] . '</span></div> ';
                                                    } ?>

                                                </div>

                                            </div>

                                            <button class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i> Print</button>&nbsp;&nbsp;
                                            <a href="<?php echo base_url($currentController); ?>" class="btn btn-warning">Back</a>
                                            <?php
                                            // echo '<pre>';
                                            // print_r($v_tyres);
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