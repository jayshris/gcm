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
                        <h2>Foreman KYC Form</h2>
                    </div>
                    <?php $validation = \Config\Services::validation(); ?>
                    <!-- Settings Info -->
                    <form method="post" action="<?php echo base_url('foremankyc/register/' . $token) ?>" enctype="multipart/form-data" autocomplete="off">
                        <div class="card" style="background-color: lightgrey;">
                            <div class="card-body">

                                <div class="row g-2">

                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label"> Foreman Name <span class="text-danger">*</span> </label>
                                            <input type="text" required name="foreman_name" class="form-control" value="<?= set_value('foreman_name') ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-wrap">
                                            <label class="col-form-label">
                                                Profile Image 1 <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" name="profile_image1" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" required>
                                            <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                        </div>
                                    </div>
                                    <hr>

                                    <h5>Contact Details</h5>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">
                                                WhatsApp Number <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" name="whatsapp" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">
                                                Alternate Phone Number
                                            </label>
                                            <input type="number" name="mobile" class="form-control">
                                        </div>
                                    </div>

                                    <hr>

                                    <h5>Driving Licence Details</h5>
                                    <div class="col-md-3">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Driving Licence Number <span class="text-danger">*</span> <span class="text-danger" id="span_dl"></span></label>
                                            <input type="text" name="dl_no" id="dl_no" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Driving Licence Issue Auth. <span class="text-danger">*</span></label>
                                            <input type="text" name="dl_authority" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Driving Licence DOB <span class="text-danger">*</span></label>
                                            <input type="date" name="dl_dob" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Driving Licence Expiry Date <span class="text-danger">*</span></label>
                                            <input type="date" name="dl_expiry" min="<?= date('Y-m-d') ?>" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">
                                                DL Image - Front <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" name="dl_image_front" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" required>
                                            <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">
                                                DL Image - Back
                                            </label>
                                            <input type="file" name="dl_image_back" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                            <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                        </div>
                                    </div>

                                    <hr>
                                    <h5>Identification Documents</h5>
                                    <?php
                                    foreach ($flagData as $flag) {

                                        echo '<div class="col-md-6">
                                          <div class="form-wrap">
                                            <label class="col-form-label" >' . $flag['title'] . ' ' . ($flag['mandatory'] ? '<span class="text-danger">*</span>' : '') . '<span class="text-danger" id="span_' . $flag['flags_id'] . '"></span></label>
                                            <input type="text" ' . ($flag['mandatory'] ? 'required' : '') . ' name="number_' . $flag['flags_id'] . '" id="num_' . $flag['flags_id'] . '" onchange="$.validate(' . $flag['flags_id'] . ');" class="form-control">
                                          </div>
                                        </div>
                        
                                        <div class="col-md-3">
                                          <div class="form-wrap">
                                            <label class="col-form-label">' . $flag['title'] . ' Image 1 ' . ($flag['mandatory'] ? '<span class="text-danger">*</span>' : '') . '<span class="text-danger" id="span_' . $flag['flags_id'] . '"></span></label>
                                            <input type="file" ' . ($flag['mandatory'] ? 'required' : '') . ' name="img_' . $flag['flags_id'] . '_1" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" >
                                          </div>
                                        </div>
                        
                                        <div class="col-md-3">
                                          <div class="form-wrap">
                                            <label class="col-form-label">' . $flag['title'] . '  Image 2</label>
                                            <input type="file" name="img_' . $flag['flags_id'] . '_2" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" >
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
                                            <input type="text" required name="address" id="address" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-wrap">
                                            <label class="col-form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" required name="city" id="city" class="form-control">
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
                                                        <option value="<?php echo $row["state_id"] ?>"><?php echo $row["state_name"] ?></option>
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
                                            <input type="number" required name="zip" id="zip" class="form-control">
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
                                            <input type="text" required name="address_p" id="address_p" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-wrap">
                                            <label class="col-form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" required name="city_p" id="city_p" class="form-control">
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
                                                        <option value="<?php echo $row["state_id"] ?>"><?php echo $row["state_name"] ?></option>
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
                                            <input type="number" required name="zip_p" id="zip_p" class="form-control">
                                        </div>
                                    </div>

                                    <hr>
                                    <h5>Banking Details</h5>
                                    <div class="col-md-3">
                                        <div class="form-wrap">
                                            <label class="col-form-label">
                                                Bank A/C No:
                                            </label>
                                            <input type="text" name="bank_account_number" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-wrap">
                                            <label class="col-form-label">
                                                Bank IFSC:
                                            </label>
                                            <input type="text" name="bank_ifsc_code" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-wrap">
                                            <label class="col-form-label">UPI ID</label>
                                            <input type="text" name="upi" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-wrap">
                                            <label class="col-form-label">
                                                UPI ID Image
                                            </label>
                                            <input type="file" name="upi_id" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                            <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                        </div>
                                    </div>
                                    <hr>

                                    <h5>Emergency Contact</h5>
                                    <div class="col-md-4">
                                        <div class="form-wrap">
                                            <label class="col-form-label"> Emergency Contact Person <span class="text-danger">*</span></label>
                                            <input type="text" required name="emergency_person" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-wrap">
                                            <label class="col-form-label"> Relation <span class="text-danger">*</span></label>
                                            <input type="text" required name="emergency_relation" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-wrap">
                                            <label class="col-form-label"> Contact Number <span class="text-danger">*</span></label>
                                            <input type="number" required name="emergency_contact" class="form-control">
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

    <?= $this->include('partials/vendor-scripts') ?>

    <script>
        jQuery(document).ready(function($) {

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


            $.validate = function(flag_id) {

                $('#span_' + flag_id).html('');
                $('#submit-btn').removeAttr('disabled');

                var numbr = $('#num_' + flag_id).val();

                $.ajax({
                    method: 'POST',
                    url: '<?= base_url('driverkyc/validate_doc') ?> ',
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


            $("#dl_no").on('change', function() {
                var dl_no = $(this).val();

                $('#span_dl').html('');
                $('#submit-btn').removeAttr('disabled');

                if (dl_no) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('foremankyc/validate_dl') ?> ',
                        data: {
                            dl_no: dl_no
                        },
                        success: function(response) {
                            if (response == '1') {
                                $('#span_dl').html('DL already exists !!');
                                $('#submit-btn').attr('disabled', 'disabled');
                            }
                        }
                    });
                }
            });

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