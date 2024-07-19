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
                                    <h2>Party KYC Form</h2>
                                </div>
                                <?php $validation = \Config\Services::validation(); ?>
                                <!-- Settings Info -->
                                <form method="post" action="<?php echo base_url('KYC/approve/' . $pc_data['id']) ?>" enctype="multipart/form-data">

                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <label class="col-form-label"> Party Name <span class="text-danger">*</span> </label>
                                                    <input type="text" required name="party_name" class="form-control" value="<?= $pc_data['party_name'] ?>">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="col-form-label"> Contact Person </label>
                                                    <input type="text" name="contact_person" class="form-control" value="<?= $pc_data['contact_person'] ?>">
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="col-form-label">Party Types<span class="text-danger">*</span></label><br>

                                                    <?php foreach ($partytype as $pt) { ?>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input checkbx" type="checkbox" name="party_type[]" id="chk<?= $pt['name'] ?>" value="<?= $pt['id'] ?>" <?= !isset($customer_detail) ? 'required' : '' ?> <?= isset($customer_detail) && in_array($pt['id'], $typeArr) ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="chk<?= $pt['name'] ?>"><?= $pt['name'] ?></label>
                                                        </div>
                                                    <?php } ?>
                                                </div>


                                                <div class="col-md-6">
                                                    <label class="col-form-label"> Business Name / Alias </label>
                                                    <input type="text" name="alias" class="form-control" value="<?= $pc_data['alias'] ?>">
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="col-form-label"> Registered Address <span class="text-danger">*</span></label>
                                                    <input type="text" required name="business_address" class="form-control" value="<?= $pc_data['business_address'] ?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="col-form-label"> City <span class="text-danger">*</span> </label>
                                                    <input type="text" required name="business_city" class="form-control" value="<?= $pc_data['city'] ?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="col-form-label"> State <span class="text-danger">*</span> </label>
                                                    <select class="dropdown selectopt" name="business_state">
                                                        <option>Select</option>
                                                        <?php
                                                        if (isset($state)) {
                                                            foreach ($state as $row) { ?>
                                                                <option value="<?php echo $row["state_id"]; ?>" <?= $pc_data['state_id'] == $row['state_id'] ? 'selected' : '' ?>><?php echo ucwords($row["state_name"]); ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="col-form-label"> Postcode <span class="text-danger">*</span> </label>
                                                    <input type="number" required name="business_postcode" class="form-control" value="<?= $pc_data['postcode'] ?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="col-form-label"> Primary Contact Number <span class="text-danger">*</span> </label>
                                                    <input type="number" required name="business_primary_phone" class="form-control" value="<?= $pc_data['primary_phone'] ?>">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="col-form-label"> Email </label>
                                                    <input type="email" name="business_email" class="form-control" value="<?= $pc_data['email'] ?>">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="col-form-label"> Business Type <span class="text-danger">*</span> </label>
                                                    <select class="dropdown selectopt" name="business_type_id" id="business_type_id">
                                                        <option>Select</option>
                                                        <?php
                                                        if (isset($businesstype)) {
                                                            foreach ($businesstype as $row) { ?>
                                                                <option value="<?php echo $row["id"]; ?>" <?php
                                                                                                            if (isset($pc_data['business_type_id'])) {
                                                                                                                if ($pc_data['business_type_id'] == $row['id']) {
                                                                                                                    echo 'selected';
                                                                                                                }
                                                                                                            } ?>><?php echo ucwords($row["company_structure_name"]); ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <!-- for doc populate  -->
                                                <div class="target row mt-3" id="target">
                                                    <?php
                                                    foreach ($partyDocs as $flag) {
                                                    ?>

                                                        <div class="col-md-6">
                                                            <div class="form-wrap">
                                                                <label class="col-form-label"><?= $flag['title'] ?> <?= $flag['mandatory'] ? '<span class="text-danger">*</span>' : '' ?><span class="text-danger" id="span_<?= $flag['flag_id'] ?>"></span></label>
                                                                <input type="text" name="number_<?= $flag['flag_id'] ?>" id="num_<?= $flag['flag_id'] ?>" onchange="$.validate(<?= $flag['flag_id'] ?>);" value="<?= $flag['number'] ?>" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-wrap">
                                                                <label class="col-form-label"><?= $flag['title'] ?> Image 1 <?= $flag['mandatory'] ? '<span class="text-danger">*</span>' : '' ?></label>
                                                                <?php if ($flag['img1'] != '') { ?>
                                                                    <img src="<?= base_url('public/uploads/partyDocs/') . $flag['img1'] ?>" style="height: 150px;">
                                                                <?php } ?>
                                                                <input type="file" name="img_<?= $flag['flag_id'] ?>_1" class="form-control" <?= $flag['mandatory'] && $flag['img1'] == '' ? 'required' : '' ?> accept="image/png, image/gif, image/jpeg">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-wrap">
                                                                <label class="col-form-label"><?= $flag['title'] ?> Image 2</label>

                                                                <?php if ($flag['img2'] != '') { ?>
                                                                    <img src="<?= base_url('public/uploads/partyDocs/') . $flag['img2'] ?>" style="height: 150px;">
                                                                <?php } ?>

                                                                <input type="file" name="img_<?= $flag['flag_id'] ?>_2" class="form-control" accept="image/png, image/gif, image/jpeg">
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="flag_id[]" value="<?= $flag['flag_id'] ?>">

                                                    <?php
                                                    }
                                                    ?>

                                                </div>

                                                <div class="col-md-6">
                                                    <label class="col-form-label">Office Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" required name="office_name" value="<?= $customer_details['office_name'] ?>">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="col-form-label">GST Number (Branch)</label>
                                                    <input type="text" class="form-control" name="office_gst" value="<?= $customer_details['gst'] ?>">
                                                </div>

                                                <div class="col-md-4 count">
                                                    <label class="col-form-label">Contact Person Name<span class="text-danger">*</span></label>
                                                    <input type="text" required class="form-control" name="office_person" value="<?= $customer_details['name'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="col-form-label">Designation<span class="text-danger">*</span></label>
                                                    <input type="text" required class="form-control" name="office_designation" value="<?= $customer_details['designation'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-form-label">Phone No.<span class="text-danger">*</span></label>
                                                    <input type="number" required class="form-control" name="office_phone" value="<?= $customer_details['phone'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-form-label">Email</label>
                                                    <input type="email" class="form-control" name="office_email" value="<?= $customer_details['email'] ?>">
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="col-form-label">Office Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" required name="office_address" value="<?= $customer_details['address'] ?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="col-form-label">Office City <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" required name="office_city" value="<?= $customer_details['city'] ?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="col-form-label">Office State <span class="text-danger">*</span></label>
                                                    <select class="form-select select2" name="office_state_id" required>
                                                        <option value="">Select State</option>
                                                        <?php foreach ($state as $row) { ?>
                                                            <option value="<?php echo $row["state_id"]; ?>" <?= $customer_details['state_id'] == $row['state_id'] ? 'selected' : '' ?>><?php echo ucwords($row["state_name"]); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="col-form-label">Office Postcode <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="office_postcode" required value="<?= $customer_details['pincode'] ?>">
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <input type="checkbox" id="approve" class="form-check-input" name="approve" value="1" style="height: 25px; width:25px;"> <label for="approve"> Approve</label>
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

            // $.toggle();

            $("#business_type_id").on(' change', function() {
                $("#target").empty();
                var level = $(this).val();
                if (level) {
                    $.ajax({
                        type: 'POST',
                        url: '../get_flags_fields_cond',
                        data: {
                            business_type: '' + level + ''
                        },
                        success: function(htmlresponse) {
                            $('#target').append(htmlresponse);
                        }
                    });
                }
            })
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