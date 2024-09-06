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
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 mt-3">
                                <div class="settings-sub-header">
                                    <h2>Driver KYC Form</h2>
                                </div>
                                <?php $validation = \Config\Services::validation(); ?>
                                <!-- Settings Info -->
                                <form method="post" class="from-control" action="<?php echo base_url('driverkyc/approve/' . $driver_data['id']) ?>" enctype="multipart/form-data">

                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row g-2">

                                                <div class="col-md-6">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label"> Foreman Name <span class="text-danger">*</span> </label>
                                                        <select class="dropdown select2 form-control" name="foreman_id" required>
                                                            <option>Select Foreman</option>
                                                            <?php
                                                            if (isset($foreman)) {
                                                                foreach ($foreman as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row["id"] ?>" <?= $driver_data['foreman_id'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['party_name'] ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="col-form-label">
                                                        Driver Type <span class="text-danger">*</span>
                                                    </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" class="radio" id="Employee" value="Employee" name="driver_type" required <?= $driver_data['driver_type'] == "Employee" ? 'checked' : '' ?>>
                                                    <label for="Employee">Employee</label>&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" class="radio" id="Contractor" value="Contractor" name="driver_type" required <?= $driver_data['driver_type'] == "Contractor" ? 'checked' : '' ?>>
                                                    <label for="Contractor">Contractor</label><br>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label"> Driver Name <span class="text-danger">*</span> </label>
                                                        <input type="text" required name="driver_name" class="form-control" value="<?= $party_data['party_name'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label"> Profile Image 1 <span class="text-danger">*</span> </label><br>
                                                        <?php if (isset($driver_data) && $driver_data['profile_image1'] != '') {
                                                            if (pathinfo($driver_data['profile_image1'], PATHINFO_EXTENSION) != 'pdf') {
                                                                echo '<img src="' . base_url('public/uploads/driverDocs/') . $driver_data['profile_image1'] . '" style="height: 150px;">';
                                                            } else {
                                                                echo '<a href="' . base_url('public/uploads/driverDocs/') . $driver_data['profile_image1'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                                            }
                                                        }
                                                        ?>
                                                        <input type="file" name="profile_image1" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                                        <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">
                                                        Father Name<span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" name="father_name" required id="father_name"  value="<?= isset($driver_data['father_name']) ? $driver_data['father_name'] : '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <hr>

                                                <h5>Contact Details</h5>
                                                <div class="col-md-6">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">
                                                            WhatsApp Number <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="number" name="whatsapp" class="form-control" value="<?= $party_data['primary_phone'] ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">
                                                            Alternate Phone Number
                                                        </label>
                                                        <input type="number" name="mobile" class="form-control" value="<?= $party_data['other_phone'] ?>">
                                                    </div>
                                                </div>

                                                <hr>

                                                <h5>Driving Licence Details</h5>
                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">Driving Licence Number <span class="text-danger">*</span></label>
                                                        <input type="text" name="dl_no" class="form-control" required value="<?= $driver_data['dl_no'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">Driving Licence Issue Auth. <span class="text-danger">*</span></label>
                                                        <input type="text" name="dl_authority" class="form-control" required value="<?= $driver_data['dl_authority'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">Driving Licence Expiry Date <span class="text-danger">*</span></label>
                                                        <input type="date" name="dl_expiry" min="<?= date('Y-m-d') ?>" class="form-control" required value="<?= $driver_data['dl_expiry'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">Driving Licence DOB <span class="text-danger">*</span></label>
                                                        <input type="date" name="dl_dob" class="form-control" required value="<?= $driver_data['dl_dob'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label"> DL Image - Front </label><br>
                                                        <?php if (isset($driver_data) && $driver_data['dl_image_front'] != '') {
                                                            if (pathinfo($driver_data['dl_image_front'], PATHINFO_EXTENSION) != 'pdf') {
                                                                echo '<img src="' . base_url('public/uploads/driverDocs/') . $driver_data['dl_image_front'] . '" style="height: 150px;">';
                                                            } else {
                                                                echo '<a href="' . base_url('public/uploads/driverDocs/') . $driver_data['dl_image_front'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                                            }
                                                        }
                                                        ?>
                                                        <input type="file" name="dl_image_front" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                                        <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label"> DL Image - Back </label><br>
                                                        <?php if (isset($driver_data) && $driver_data['dl_image_back'] != '') {
                                                            if (pathinfo($driver_data['dl_image_back'], PATHINFO_EXTENSION) != 'pdf') {
                                                                echo '<img src="' . base_url('public/uploads/driverDocs/') . $driver_data['dl_image_back'] . '" style="height: 150px;">';
                                                            } else {
                                                                echo '<a href="' . base_url('public/uploads/driverDocs/') . $driver_data['dl_image_back'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                                            }
                                                        }
                                                        ?>
                                                        <input type="file" name="dl_image_back" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                                        <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                                    </div>
                                                </div>

                                                <hr>
                                                <h5>Identification Documents</h5>
                                                <?php
                                                foreach ($party_docs as $flag) {

                                                    echo '<div class="col-md-6">
                                                            <div class="form-wrap">
                                                                <label class="col-form-label" >' . $flag['title'] . ' ' . ($flag['mandatory'] ? '<span class="text-danger">*</span>' : '') . '<span class="text-danger" id="span_' . $flag['flags_id'] . '"></span></label>
                                                                <input type="text" ' . ($flag['mandatory'] ? 'required' : '') . ' name="number_' . $flag['flags_id'] . '" id="num_' . $flag['flags_id'] . '" onchange="$.validate(' . $flag['flags_id'] . ');" class="form-control" value="' . $flag['number'] . '">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-wrap">
                                                                <label class="col-form-label">' . $flag['title'] . ' Image 1 <span class="text-danger" id="span_' . $flag['flags_id'] . '"></span></label><br>';

                                                    if (isset($flag) && $flag['img1'] != '') {
                                                        if (pathinfo($flag['img1'], PATHINFO_EXTENSION) != 'pdf') {
                                                            echo '<img src="' . base_url('public/uploads/partyDocs/') . $flag['img1'] . '" style="height: 150px;">';
                                                        } else {
                                                            echo '<a href="' . base_url('public/uploads/partyDocs/') . $flag['img1'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                                        }
                                                    }

                                                    echo '<input type="file" name="img_' . $flag['flags_id'] . '_1" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" >
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-wrap">
                                                                <label class="col-form-label">' . $flag['title'] . '  Image 2</label><br>';

                                                    if (isset($flag) && $flag['img2'] != '') {
                                                        if (pathinfo($flag['img2'], PATHINFO_EXTENSION) != 'pdf') {
                                                            echo '<img src="' . base_url('public/uploads/partyDocs/') . $flag['img2'] . '" style="height: 150px;">';
                                                        } else {
                                                            echo '<a href="' . base_url('public/uploads/partyDocs/') . $flag['img2'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                                        }
                                                    }

                                                    echo '<input type="file" name="img_' . $flag['flags_id'] . '_2" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" >
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="flag_id[]" value="' . $flag['flags_id'] . '">
                                                        ';
                                                }
                                                ?>

                                                <hr>
                                                <h5>Current Address</h5><br /><br />

                                                <div class="col-md-12">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">
                                                            Address <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" required name="address" id="address" class="form-control" value="<?= $driver_data['address'] ?>">
                                                    </div>
                                                </div>



                                                <div class="col-md-4">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">City <span class="text-danger">*</span></label>
                                                        <input type="text" required name="city" id="city" class="form-control" value="<?= $driver_data['city'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">State <span class="text-danger">*</span></label>
                                                        <select class="dropdown form-control" name="state" id="state" required>
                                                            <option>Select</option>
                                                            <?php
                                                            if (isset($state)) {
                                                                foreach ($state as $row) { ?>
                                                                    <option value="<?php echo $row["state_id"] ?>" <?= $driver_data['state'] == $row['state_id'] ? 'selected' : '' ?>><?php echo $row["state_name"] ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">Zip <span class="text-danger">*</span></label>
                                                        <input type="number" required name="zip" id="zip" class="form-control" value="<?= $driver_data['zip'] ?>">
                                                    </div>
                                                </div>

                                                <hr>
                                                <h5>Permanent Address</h5>
                                                <div class="form-wrap">
                                                    <input class="form-check-input" type="checkbox" id="copy_address">&nbsp; same as above
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">
                                                            Address <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" required name="address_p" id="address_p" class="form-control" value="<?= $party_data['business_address'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">City <span class="text-danger">*</span></label>
                                                        <input type="text" required name="city_p" id="city_p" class="form-control" value="<?= $party_data['city'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">State <span class="text-danger">*</span></label>
                                                        <select class="dropdown form-control" name="state_p" id="state_p" required>
                                                            <option>Select</option>
                                                            <?php
                                                            if (isset($state)) {
                                                                foreach ($state as $row) { ?>
                                                                    <option value="<?php echo $row["state_id"] ?>" <?= $party_data['state_id'] == $row['state_id'] ? 'selected' : '' ?>><?php echo $row["state_name"] ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">Zip <span class="text-danger">*</span></label>
                                                        <input type="number" required name="zip_p" id="zip_p" class="form-control" value="<?= $party_data['postcode'] ?>">
                                                    </div>
                                                </div>

                                                <hr>
                                                <h5>Banking Details</h5>
                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">
                                                            Bank A/C No:
                                                        </label>
                                                        <input type="text" name="bank_account_number" class="form-control" value="<?= $driver_data['bank_ac'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">
                                                            Bank IFSC:
                                                        </label>
                                                        <input type="text" name="bank_ifsc_code" class="form-control" value="<?= $driver_data['bank_ifsc'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">UPI ID</label>
                                                        <input type="text" name="upi" class="form-control" value="<?= $driver_data['upi_text'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label"> UPI ID Image </label><br>
                                                        <?php if (isset($driver_data) && $driver_data['upi_id'] != '') {
                                                            if (pathinfo($driver_data['upi_id'], PATHINFO_EXTENSION) != 'pdf') {
                                                                echo '<img src="' . base_url('public/uploads/driverDocs/') . $driver_data['upi_id'] . '" style="height: 150px;">';
                                                            } else {
                                                                echo '<a href="' . base_url('public/uploads/driverDocs/') . $driver_data['upi_id'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                                            }
                                                        }
                                                        ?>
                                                        <input type="file" name="upi_id" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                                        <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                                    </div>
                                                </div>
                                                <hr>

                                                <h5>Emergency Contact</h5>
                                                <div class="col-md-4">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label"> Emergency Contact Person <span class="text-danger">*</span></label>
                                                        <input type="text" required name="emergency_person" class="form-control" value="<?= $driver_data['emergency_person'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label"> Relation <span class="text-danger">*</span></label>
                                                        <input type="text" required name="emergency_relation" class="form-control" value="<?= $driver_data['emergency_relation'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label"> Contact Number <span class="text-danger">*</span></label>
                                                        <input type="number" required name="emergency_contact" class="form-control" value="<?= $driver_data['emergency_contact'] ?>">
                                                    </div>
                                                </div>
                                                <hr>

                                                <div class="col-md-6">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">
                                                            Vehicle Type <span class="text-danger">*</span>
                                                        </label><br>
                                                        <?php
                                                        $vehicletypesitem = [];
                                                        if (isset($vehicletypes)) {
                                                            foreach ($vehicletypes as $row => $type) {
                                                                if (isset($vehicletypesdriver)) {
                                                                    foreach ($vehicletypesdriver as $key => $value) {
                                                                        $vehicletypesitem[] = $value['vehicle_type_id'];
                                                                    }
                                                                }
                                                        ?>
                                                                <input class="form-check-input" type="checkbox" name="vehicle_types[]" id="id_<?php echo $type["id"]; ?>" value="<?php echo $type["id"]; ?>" <?php if (in_array($type['id'], $vehicletypesitem)) {
                                                                                                                                                                                                                    echo "checked";
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?>><label for="id_<?php echo $type["id"]; ?>" class="col-form-label" style=" margin: 0px 20px 0px 3px;">
                                                                    <?php echo ucwords($type["name"]); ?></label>
                                                        <?php
                                                            }
                                                        }
                                                        if ($validation->getError('vehicle_type')) {
                                                            echo '<div class="alert alert-danger mt-2">' . $validation->getError('vehicle_type') . '</div>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-wrap">
                                                        <label class="col-form-label">Scheme <span class="text-danger">*</span></label>
                                                        <select class="dropdown form-control" name="scheme_id" required>
                                                            <option>Select Scheme</option>
                                                            <?php
                                                            if (isset($schemes)) {
                                                                foreach ($schemes as $row) { ?>
                                                                    <option value="<?php echo $row["id"] ?>" <?= $driver_scheme['scheme_id'] == $row['id'] ? 'selected' : '' ?>><?php echo $row["scheme_name"] . ' - ' . $row["rate"] . '/Km' ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4 text-center">
                                        <button type="submit" id="submit-btn" class="btn btn-danger">Submit</button>&nbsp;&nbsp;
                                        <button onclick="location.reload();" type="button" class="btn btn-warning">Reset</button>
                                    </div>
                                </form>
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
        $(document).ready(function() {

            $('#copy_address').change(function() {
                if ($(this).is(':checked')) {

                    $('#address_p').val($('#address').val());
                    $('#whatsapp_p').val($('#whatsapp').val());
                    $('#city_p').val($('#city').val());
                    $('#state_p').val($('#state').val());
                    $('#zip_p').val($('#zip').val());
                } else {
                    $('#address_p').val('');
                    $('#whatsapp_p').val('');
                    $('#city_p').val('');
                    $('#state_p').val('');
                    $('#zip_p').val('');
                }
            });

        });

        $.validate = function(flag_id) {

            $('#span_' + flag_id).html('');
            $('#submit-btn').removeAttr('disabled');

            var numbr = $('#num_' + flag_id).val();

            $.ajax({
                method: 'POST',
                url: '../validate_doc',
                data: {
                    flag_id: flag_id,
                    number: numbr
                },
                success: function(response) {

                    if (response == '1') {
                        $('#span_' + flag_id).html(' - document number already exists !!');
                        $('#submit-btn').attr('disabled', 'disabled');
                    }
                }
            });
        }

        var checkboxes = $('.checkbx');
        checkboxes.change(function() {
            if ($('.checkbx:checked').length > 0) {
                checkboxes.removeAttr('required');
            } else {
                checkboxes.attr('required', 'required');
            }
        });
    </script>

</body>

</html>