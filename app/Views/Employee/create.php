<!doctypehtml>
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
                        <form action="<?php echo base_url(); ?>employee/create" enctype="multipart/form-data" method="post">

                          <div class="settings-sub-header">
                            <h6>Add Employee</h6>
                          </div>

                          <div class="profile-details">
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Company Name <span class="text-danger">*</span></label>
                                  <select class="select" id="company" name="company_name" required>
                                    <option value="">Select Company</option><?php if (isset($company)) {
                                                                              foreach ($company as $row) {
                                                                                echo '<option value="' . $row["id"] . '" "' . set_select('company_name', $row['id']) . '">' . $row["name"] . '</option>';
                                                                              }
                                                                            } ?>
                                  </select>
                                  <?php if ($validation->getError('company_name')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('company_name') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap"><label class="col-form-label">Office Location <span class="text-danger">*</span></label>
                                  <select class="select" id="office_location" name="office_location" required>
                                    <option value="">Select Location</option>
                                  </select><?php if ($validation->getError('office_location')) {
                                              echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_location') . '</div>';
                                            } ?>
                                </div>
                              </div>

                              <!-- <div class="col-md-4">
                                <div class="form-wrap"><label class="col-form-label">Department <span class="text-danger">*</span></label>
                                  <select class="select" id="dept_id" name="dept_id" required>
                                    <option value="">Select Department</option>
                                    <?php
                                    // foreach ($departments as $row) {
                                    //   echo '<option value="' . $row["id"] . '" "' . set_select('dept_id', $row['id']) . '">' . $row["dept_name"] . '</option>';
                                    // }
                                    ?>
                                  </select>
                                </div>
                              </div> -->

                              <div class="col-md-6">
                                <div class="form-wrap"><label class="col-form-label">Employee Name <span class="text-danger">*</span></label>
                                  <input class="form-control" name="name" value="<?= set_value('name') ?>" required>
                                  <?php if ($validation->getError('name')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('name') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-wrap"><label class="col-form-label">Primary Mobile No<span class="text-danger">*</span></label>
                                  <input class="form-control" name="mobile" type="number" title="Mobile number must be a 10-digit number" maxlength="10" oninput="validateMobile(event)" value="<?= set_value('mobile') ?>" required>
                                  <?php if ($validation->getError('mobile')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('mobile') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-wrap"><label class="col-form-label">Alternate Mobile No</label>
                                  <input class="form-control" name="alternate_mobile" type="number" title="Mobile number must be a 10-digit number" maxlength="10" oninput="validateMobile(event)" value="<?= set_value('alternate_mobile') ?>">
                                  <?php if ($validation->getError('alternate_mobile')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('alternate_mobile') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-wrap">
                                  <label class="col-form-label">Email ID<span class="text-danger"></span></label>
                                  <input class="form-control" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" <?= set_value('email') ?>>
                                  <?php if ($validation->getError('email')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('email') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <br>
                              <hr><br>

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Aadhaar Card No<span class="text-danger">*</span></label>
                                  <input class="form-control" name="aadhaar" type="number" title="Aadhaar number must be a 12-digit number" maxlength="12" oninput="validateAdhaar(event)" value="<?= set_value('aadhaar') ?>" required pattern="\d{12}">
                                  <?php if ($validation->getError('aadhaar')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('aadhaar') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Aadhaar Image - Front<span class="text-danger">*</span></label>
                                  <input class="form-control" name="aadhaarfront" type="file" required>
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('aadhaarfront')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('aadhaarfront') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Aadhaar Image - Back<span class="text-danger"></span></label>
                                  <input class="form-control" name="aadhaarback" type="file">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('aadhaarback')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('aadhaarback') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <!-- Added 19-7-24 start -->
                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">IT PAN Number</label>
                                  <input class="form-control" name="it_pan_card" title="IT PAN Number" value="<?= set_value('it_pan_card') ?>" style="text-transform:uppercase">
                                  <?php if ($validation->getError('it_pan_card')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('it_pan_card') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Image - Front</label>
                                  <input class="form-control" name="image_front" type="file">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('image_front')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('image_front') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Image - Back<span class="text-danger"></span></label>
                                  <input class="form-control" name="image_back" type="file">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('image_back')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('image_back') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <br>
                              <hr><br>

                              <!-- current Address start -->
                              <div class="col-md-12">
                                <div class="form-wrap">
                                  <label class="col-form-label">Current Address</label>
                                  <input type="text" class="form-control" name="current_address" id="address" value="<?= set_value('current_address') ?>">
                                  <?php if ($validation->getError('current_address')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('current_address') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">City</label>
                                  <input class="form-control" name="current_city" id="city" type="text">
                                  <?php if ($validation->getError('current_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('current_city') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">State</label>
                                  <br>
                                  <select class="form-select" name="current_state" id="state">
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
                                  <?php if ($validation->getError('current_state')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('current_state') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Pincode</label>
                                  <input class="form-control" name="current_pincode" id="zip" type="text">
                                  <?php if ($validation->getError('current_pincode')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('current_pincode') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <!-- current Address end -->
                              <br>
                              <hr><br>

                              <div class="form-wrap">
                                <input class="form-check-input" type="checkbox" id="copy_address">&nbsp; same as above
                              </div>

                              <!-- permanent Address start -->
                              <div class="col-md-12">
                                <div class="form-wrap">
                                  <label class="col-form-label">Permanent Address</label>
                                  <input type="text" class="form-control" name="permanent_address" id="address_p" value="<?= set_value('permanent_address') ?>">
                                  <?php if ($validation->getError('permanent_address')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('permanent_address') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-wrap">
                                  <label class="col-form-label">City</label>
                                  <input class="form-control" name="permanent_city" id="city_p" type="text">
                                  <?php if ($validation->getError('permanent_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('permanent_city') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">State</label>
                                  <br>
                                  <select class="form-select" name="permanent_state" id="state_p">
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
                                  <?php
                                  if ($validation->getError('permanent_state')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('permanent_state') . '</div>';
                                  }
                                  ?>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-wrap">
                                  <label class="col-form-label">Pincode</label>
                                  <input class="form-control" name="permanent_pincode" id="zip_p" type="text">
                                  <?php if ($validation->getError('permanent_pincode')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('permanent_pincode') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-wrap">
                                  <label class="col-form-label">Phone</label>
                                  <input class="form-control" name="permanent_phone" maxlength="10" type="text">
                                  <?php if ($validation->getError('permanent_phone')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('permanent_phone') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <!-- permenant Address end -->

                              <!-- Added 19-7-24 end -->

                              <br>
                              <hr><br>

                              <div class="col-md-3">
                                <div class="form-wrap">
                                  <label class="col-form-label">Company Mobile No 1</label>
                                  <input class="form-control" name="comp_mobile" type="number" title="Mobile number must be a 10-digit number" maxlength="10" oninput="validateMobile(event)" value="<?= set_value('comp_mobile') ?>">
                                  <?php if ($validation->getError('comp_mobile')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('comp_mobile') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-wrap">
                                  <label class="col-form-label">Company Mobile No 2</label>
                                  <input class="form-control" name="comp_mobile2" type="number" title="Mobile number must be a 10-digit number" maxlength="10" oninput="validateMobile(event)" value="<?= set_value('comp_mobile2') ?>">
                                  <?php if ($validation->getError('comp_mobile2')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('comp_mobile2') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Company Email ID</label>
                                  <input class="form-control" name="comp_email" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" <?= set_value('comp_email') ?>>
                                  <?php if ($validation->getError('comp_email')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('comp_email') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <br>
                              <hr><br>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Emergency Contact Person</label>
                                  <input class="form-control" name="emergency_person" type="text" value="<?= set_value('emergency_person') ?>">
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Relation</label>
                                  <input class="form-control" name="relation" type="text" value="<?= set_value('relation') ?>">
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Emergency Contact Number</label>
                                  <input class="form-control" name="emergency_phone" type="number" <?= set_value('emergency_phone') ?>>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Bank A/C No:<span class="text-danger"></span></label>
                                  <input class="form-control" name="bank_account_number" type="number" value="<?= set_value('bank_account_number') ?>" oninput="validateAccountno(event)" min="0">
                                  <?php if ($validation->getError('bank_account_number')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('bank_account_number') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Bank IFSC<span class="text-danger"></span></label>
                                  <input class="form-control" name="bank_ifsc_code" value="<?= set_value('bank_ifsc_code') ?>">
                                  <?php if ($validation->getError('bank_ifsc_code')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('bank_ifsc_code') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Profile Image 1<span class="text-danger">*</span></label>
                                  <input class="form-control" name="image1" type="file" required accept="image/*">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('image1')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('image1') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Profile Image 2</label>
                                  <input class="form-control" name="image2" type="file" accept="image/*">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('image2')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('image2') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Joining Date<span class="text-danger">*</span></label>
                                  <input class="form-control" name="joiningdate" type="date" <?= set_value('joiningdate') ?>required>
                                  <?php if ($validation->getError('joiningdate')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('joiningdate') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Releaveing Date<span class="text-danger">*</span></label>
                                  <input class="form-control" name="releaveing_date" type="date" <?= set_value('releaveing_date') ?>required>
                                  <?php if ($validation->getError('releaveing_date')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('releaveing_date') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Digital Signature</label>
                                  <input class="form-control" name="digital_sign" type="file" accept="image/*" <?= set_value('digital_sign') ?>>
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('digital_sign')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('digital_sign') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">UPI ID</label>
                                  <input class="form-control" name="upi" <?= set_value('upi') ?>>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">UPI ID Image<span class="text-danger"></span></label>
                                  <input class="form-control" name="upi_id" type="file" title="Image size should be less than 100 KB" <?= set_value('upi_id') ?>>
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('upi_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('upi_id') . '</div>';
                                  } ?>
                                </div>
                              </div>

                            </div>
                          </div>
                          <div class="submit-button">
                            <input class="btn btn-primary" name="add_profile" type="submit" value="Save Changes">
                            <a href="./create" class="btn btn-warning">Reset</a>
                            <a class="btn btn-light" href="<?php echo base_url(); ?>employee">Cancel</a>
                          </div>
                        </form>
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
      $(document).ready(function() {
        $("#company").change(function() {
          var o = $(this).val();
          $.ajax({
            url: "<?= base_url('employee/getOfficeLocations') ?>",
            method: "POST",
            data: {
              company_id: o
            },
            dataType: "json",
            success: function(o) {
              $("#office_location").empty(), $("#office_location").append('<option value="">Select Location</option>'), $.each(o, function(o, n) {
                $("#office_location").append('<option value="' + n.id + '">' + n.name + "</option>")
              })
            }
          })
        })

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
      })
    </script>
  </body>

  </html>