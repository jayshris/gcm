<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('partials/title-meta') ?>
    <?= $this->include('partials/head-css') ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>


    <div class="container">
        <div class="content">

            <div class="row">
                <div class="col-xl-12 col-lg-12 mt-3">
                    <div class="settings-sub-header text-center">
                        <h2>Party KYC Form</h2>
                    </div>
                    <?php $validation = \Config\Services::validation(); ?>
                    <!-- Settings Info -->
                    <form method="post" action="<?php echo base_url('kyc/register/' . $token) ?>" enctype="multipart/form-data">
                        <div class="card" style="background-color: lightgrey;">
                            <div class="card-body">

                                <div class="row g-3">


                                    <div class="col-md-6">
                                        <label class="col-form-label"> Party Name <span class="text-danger">*</span> </label>
                                        <input type="text" required name="party_name" class="form-control" value="<?= set_value('party_name') ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label"> Contact Person </label>
                                        <input type="text" name="contact_person" class="form-control" value="<?php echo set_value('contact_person') ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label"> Business Name / Alias </label>
                                        <input type="text" name="alias" class="form-control" value="<?php echo set_value('alias') ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="col-form-label"> Registered Address <span class="text-danger">*</span></label>
                                        <input type="text" required name="business_address" id="address_p" class="form-control" value="<?php echo set_value('business_address'); ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-form-label"> City <span class="text-danger">*</span> </label>
                                        <input type="text" required name="business_city" id="city_p" class="form-control" value="<?php echo set_value('business_city'); ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-form-label"> State <span class="text-danger">*</span> </label>
                                        <select class="dropdown selectopt" name="business_state" id="state_p">
                                            <option>Select</option>
                                            <?php
                                            if (isset($state)) {
                                                foreach ($state as $row) { ?>
                                                    <option value="<?php echo $row["state_id"]; ?>" <?= set_value('business_state') == $row['state_id'] ? 'selected' : '' ?>><?php echo ucwords($row["state_name"]); ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label"> Postcode <span class="text-danger">*</span> </label>
                                        <input type="number" required name="business_postcode" id="zip_p" class="form-control" value="<?php echo set_value('business_postcode') ?>">

                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label"> Primary Contact Number <span class="text-danger">*</span> </label>
                                        <input type="number" required name="business_primary_phone" class="form-control" value="<?php echo set_value('primary_phone') ?>">

                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label"> Email </label>
                                        <input type="email" name="business_email" class="form-control" value="<?php echo set_value('email') ?>">

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
                                    <div class="target row mt-3" id="target"> </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label">Office Name<span class="text-danger">*</span></label>
                                        <select class="form-select select2" required name="office_name">
                                            <option value="">Select Office Name</option>
                                            <option value="Head Office">Head Office</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="Parking">Parking</option>
                                            <option value="Branch 1">Branch 1</option>
                                            <option value="Branch 2">Branch 2</option>
                                            <option value="Branch 3">Branch 3</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label">GST Number (Branch)</label>
                                        <input type="text" class="form-control" name="office_gst" value="<?php echo set_value('office_gst') ?>">
                                    </div>

                                    <div class="col-md-4 count">
                                        <label class="col-form-label">Contact Person Name<span class="text-danger">*</span></label>
                                        <input type="text" required class="form-control" name="office_person" value="<?php echo set_value('office_person') ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="col-form-label">Designation<span class="text-danger">*</span></label>
                                        <input type="text" required class="form-control" name="office_designation" value="<?php echo set_value('office_designation') ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Phone No.<span class="text-danger">*</span></label>
                                        <input type="number" required class="form-control" name="office_phone" value="<?php echo set_value('office_phone') ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Email</label>
                                        <input type="email" class="form-control" name="office_email" value="<?php echo set_value('office_email') ?>">
                                    </div>

                                    <div class="form-wrap">
                                        <input class="form-check-input" type="checkbox" id="copy_address">&nbsp; same as above
                                    </div>

                                    <div class="col-md-12">
                                        <label class="col-form-label">Office Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="office_address" id="address" value="<?php echo set_value('office_address') ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-form-label">Office City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="office_city" id="city" value="<?php echo set_value('office_city') ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-form-label">Office State <span class="text-danger">*</span></label>
                                        <select class="form-select" name="office_state_id" id="state" required>
                                            <option value="">Select State</option>
                                            <?php foreach ($state as $row) { ?>
                                                <option value="<?php echo $row["state_id"]; ?>"><?php echo ucwords($row["state_name"]); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-form-label">Office Postcode <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="office_postcode" id="zip" required value="<?php echo set_value('office_postcode') ?>">
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

    <?= $this->include('partials/vendor-scripts') ?>

    <script>
        jQuery(document).ready(function($) {

            $('#copy_address').change(function() {
                if ($(this).is(':checked')) {

                    $('#address').val($('#address_p').val());
                    $('#city').val($('#city_p').val());
                    $('#state').val($('#state_p').val());
                    $('#zip').val($('#zip_p').val());
                } else {
                    $('#address').val('');
                    $('#city').val('');
                    $('#state').val('');
                    $('#zip').val('');
                }
            });

            $("#business_type_id").on('change', function() {
                $("#target").empty();
                var level = $(this).val();
                if (level) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('kyc/get_flags_fields') ?>',
                        data: {
                            business_type: '' + level + ''
                        },
                        success: function(htmlresponse) {
                            $('#target').append(htmlresponse);
                        }
                    });
                }
            });


            $.validate = function(flag_id) {

                $('#span_' + flag_id).html('');
                $('#submit-btn').removeAttr('disabled');

                var numbr = $('#num_' + flag_id).val();

                $.ajax({
                    method: 'POST',
                    url: '<?= base_url('kyc/validate_doc') ?> ',
                    data: {
                        flag_id: flag_id,
                        number: numbr
                    },
                    success: function(response) {
                        if (response == '1') {
                            $('#span_' + flag_id).html(' document number already exists !!');
                            $('#submit-btn').attr('disabled', 'disabled');
                        }
                    }
                });
            }

            $.addMore = function() {
                var count = $('.count').length;

                $.ajax({
                    url: "<?= base_url('customer-branch/addPerson/') ?>" + (count + 1),
                    type: "GET",
                    data: {
                        count: count
                    },
                    success: function(data) {
                        $('.fill').after(data);
                    }
                })
            }

            $.delete = function(index) {
                $('.del' + index).remove();
            }

        });

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