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
                                                                <h6>Employee Details</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%">Name </td>
                                                            <td width="35%"><?= $employee_data['name'] ?></td>
                                                            <td rowspan="5" width="55%" align="center">
                                                                <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_data['profile_image1'] ?>" style="width: 150px;">&nbsp;&nbsp;
                                                                <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_data['profile_image2'] ?>" style="width: 150px;">
                                                                <!-- <h6 class="text-center">Profile Images</h6> -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Company </td>
                                                            <td><?= $employee_data['company_name'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Branch </td>
                                                            <td><?= $employee_data['office_name'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mobile No. </td>
                                                            <td><?= $employee_data['mobile'] ?>, <?= $employee_data['alternate_mobile'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email ID</td>
                                                            <td><?= $employee_data['email'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" align="center" style="background-color: #e7e7e7;">
                                                                <h6>Identification Details</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="center">Aadhaar Number : <?= $employee_data['adhaar_number'] ?></td>
                                                            <td align="center">IT Pan Number : <?= $employee_data['it_pan_card'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="center">
                                                                <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_data['aadhar_img_front'] ?>" style="width: 150px;">&nbsp;&nbsp;
                                                                <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_data['aadhar_img_back'] ?>" style="width: 150px;">
                                                            </td>
                                                            <td align="center">
                                                                <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_data['image_front'] ?>" style="width: 150px;">&nbsp;&nbsp;
                                                                <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_data['image_back'] ?>" style="width: 150px;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" align="center" style="background-color: #e7e7e7;">
                                                                <h6>Banking Details</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>UPI ID </td>
                                                            <td><?= $employee_data['upi_id'] ?></td>
                                                            <td rowspan="5" align="center">
                                                                <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_data['upi_img'] ?>" style="width: 150px;">&nbsp;&nbsp;
                                                                <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_data['digital_sign'] ?>" style="width: 150px;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank A/C No. </td>
                                                            <td><?= $employee_data['bank_account_number'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank IFSC </td>
                                                            <td><?= $employee_data['bank_ifsc_code'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Em. Person </td>
                                                            <td><?= $employee_data['emergency_person'] ?> ( <?= $employee_data['relation'] ?> )</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Em. Contact</td>
                                                            <td><?= $employee_data['emergency_contact_number'] ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </div>

                                            <button class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i> Print</button>

                                            <?php
                                            // echo '<pre>';
                                            // print_r($employee_data);
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