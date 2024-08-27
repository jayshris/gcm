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
                        <form action="<?php echo base_url('employee/edit/' . $employee_detail['id']); ?>" enctype="multipart/form-data" method="post">

                          <div class="settings-sub-header">
                            <h6>Edit Employee</h6>
                          </div>


                          <div class="profile-details">
                            <div class="row">

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Company Name <span class="text-danger">*</span></label>
                                  <select class="select" id="company" name="company_name" required>
                                    <option value="">Select Company</option>
                                    <?php if (isset($company)) {
                                      foreach ($company as $row) {
                                        echo '<option value="' . $row["id"] . '" ' . ($employee_detail['company_id'] == $row['id'] ? 'selected' : '') . '>' . $row["name"] . '</option>';
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
                                    <?php if (isset($office_data)) {
                                      foreach ($office_data as $row) {
                                        echo '<option value="' . $row["id"] . '" ' . ($employee_detail['branch_id'] == $row['id'] ? 'selected' : '') . '>' . $row["name"] . '</option>';
                                      }
                                    } ?>
                                  </select><?php if ($validation->getError('office_location')) {
                                              echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_location') . '</div>';
                                            } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap"><label class="col-form-label">Department <span class="text-danger">*</span></label>
                                  <select class="select" id="dept_id" name="dept_id" required>
                                    <option value="">Select Department</option>
                                    <?php
                                    foreach ($departments as $row) {
                                      echo '<option value="' . $row["id"] . '" ' . ($employee_detail['dept_id'] == $row['id'] ? 'selected' : '') . '>' . $row["dept_name"] . '</option>';
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap"><label class="col-form-label">Employee Name <span class="text-danger">*</span></label>
                                  <input class="form-control" name="name" value="<?= $employee_detail['name'] ?>" required>
                                  <?php if ($validation->getError('name')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('name') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-wrap"><label class="col-form-label">Primary Mobile No<span class="text-danger">*</span></label>
                                  <input class="form-control" name="mobile" type="number" title="Mobile number must be a 10-digit number" maxlength="10" oninput="validateMobile(event)" value="<?= $employee_detail['mobile'] ?>" required>
                                  <?php if ($validation->getError('mobile')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('mobile') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-wrap"><label class="col-form-label">Alternate Mobile No</label>
                                  <input class="form-control" name="alternate_mobile" type="number" title="Mobile number must be a 10-digit number" maxlength="10" oninput="validateMobile(event)" value="<?= $employee_detail['alternate_mobile'] ?>">
                                  <?php if ($validation->getError('alternate_mobile')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('alternate_mobile') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-wrap">
                                  <label class="col-form-label">Email ID<span class="text-danger"></span></label>
                                  <input class="form-control" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?= $employee_detail['email'] ?>">
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
                                  <input class="form-control" name="aadhaar" type="number" title="Aadhaar number must be a 12-digit number" maxlength="12" oninput="validateAdhaar(event)" value="<?= $employee_detail['adhaar_number'] ?>" required pattern="\d{12}">
                                  <?php if ($validation->getError('aadhaar')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('aadhaar') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Aadhaar Image - Front</label><br>
                                  <?php if (isset($employee_detail) && $employee_detail['aadhar_img_front'] != '') { ?>
                                    <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_detail['aadhar_img_front'] ?>" style="height: 150px;">
                                  <?php } ?>
                                  <input class="form-control" name="aadhaarfront" type="file">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('aadhaarfront')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('aadhaarfront') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Aadhaar Image - Back</label><br>
                                  <?php if (isset($employee_detail) && $employee_detail['aadhar_img_back'] != '') { ?>
                                    <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_detail['aadhar_img_back'] ?>" style="height: 150px;">
                                  <?php } ?>
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
                                  <input class="form-control" name="it_pan_card" title="IT PAN Number" value="<?= $employee_detail['it_pan_card'] ?>" style="text-transform:uppercase">
                                  <?php if ($validation->getError('it_pan_card')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('it_pan_card') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Image - Front</label><br>
                                  <?php if (isset($employee_detail) && $employee_detail['image_front'] != '') { ?>
                                    <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_detail['image_front'] ?>" style="height: 150px;">
                                  <?php } ?>
                                  <input class="form-control" name="image_front" type="file">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('image_front')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('image_front') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">Image - Back</label><br>
                                  <?php if (isset($employee_detail) && $employee_detail['image_back'] != '') { ?>
                                    <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_detail['image_back'] ?>" style="height: 150px;">
                                  <?php } ?>
                                  <input class="form-control" name="image_back" type="file">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('image_back')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('image_back') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <!-- Added 19-7-24 end -->
                              <br>
                              <hr><br>
                              <!-- current Address start -->
                              <div class="col-md-12">
                                <div class="form-wrap">
                                  <label class="col-form-label">Current Address</label>
                                  <input type="text" class="form-control" name="current_address" value="<?= $employee_detail['current_address'] ?> " />
                                  <?php if ($validation->getError('current_address')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('current_address') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">City</label>
                                  <input class="form-control" name="current_city" type="text" value="<?= $employee_detail['current_city'] ?>">
                                  <?php if ($validation->getError('current_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('current_city') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">State</label>
                                  <br>
                                  <select class="form-select" name="current_state">
                                    <option>Select</option>
                                    <?php
                                    if (isset($state)) {
                                      foreach ($state as $row) { ?>
                                        <option value="<?php echo $row["state_id"] ?>" <?php
                                                                                        if (isset($employee_detail)) {
                                                                                          if ($employee_detail['current_state'] == $row["state_id"]) echo 'selected';
                                                                                        } ?>><?php echo $row["state_name"] ?></option>
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
                                  <input class="form-control" name="current_pincode" type="text" value="<?= $employee_detail['current_pincode'] ?>">
                                  <?php if ($validation->getError('current_pincode')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('current_pincode') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <!-- current Address end -->
                              <br>
                              <hr><br>
                              <!-- permanent Address start -->
                              <div class="col-md-12">
                                <div class="form-wrap">
                                  <label class="col-form-label">Permanent Address</label>
                                  <input type="text" class="form-control" class="form-control" name="permanent_address" value="<?= $employee_detail['permanent_address'] ?>" />
                                  <?php if ($validation->getError('permanent_address')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('permanent_address') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-wrap">
                                  <label class="col-form-label">City</label>
                                  <input class="form-control" name="permanent_city" type="text" value="<?= $employee_detail['permanent_city'] ?>">
                                  <?php if ($validation->getError('permanent_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('permanent_city') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-wrap">
                                  <label class="col-form-label">State</label>
                                  <br>
                                  <select class="form-select" name="permanent_state">
                                    <option>Select</option>
                                    <?php
                                    if (isset($state)) {
                                      foreach ($state as $row) { ?>
                                        <option value="<?php echo $row["state_id"] ?>" <?php
                                                                                        if (isset($employee_detail)) {
                                                                                          if ($employee_detail['permanent_state'] == $row["state_id"]) echo 'selected';
                                                                                        } ?>><?php echo $row["state_name"] ?></option>
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
                                  <input class="form-control" name="permanent_pincode" type="text" value="<?= $employee_detail['permanent_pincode'] ?>">
                                  <?php if ($validation->getError('permanent_pincode')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('permanent_pincode') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-wrap">
                                  <label class="col-form-label">Phone</label>
                                  <input class="form-control" name="permanent_phone" type="text" maxlength="10" value="<?= $employee_detail['permanent_phone'] ?>">
                                  <?php if ($validation->getError('permanent_phone')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('permanent_phone') . '</div>';
                                  } ?>
                                </div>
                              </div>
                              <!-- permenant Address end -->
                              <br>
                              <hr><br>
                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Company Mobile No 1</label>
                                  <input class="form-control" name="comp_mobile" type="number" title="Mobile number must be a 10-digit number" maxlength="10" oninput="validateMobile(event)" value="<?= $employee_detail['company_phone'] ?>">
                                  <?php if ($validation->getError('comp_mobile')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('comp_mobile') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Company Mobile No 2</label>
                                  <input class="form-control" name="comp_mobile2" type="number" title="Mobile number must be a 10-digit number" maxlength="10" oninput="validateMobile(event)" value="<?= $employee_detail['comp_mobile2'] ?>">
                                  <?php if ($validation->getError('comp_mobile2')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('comp_mobile2') . '</div>';
                                  } ?>
                                </div>
                              </div>


                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Company Email ID</label>
                                  <input class="form-control" name="comp_email" type="email" value="<?= $employee_detail['company_email'] ?>">
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
                                  <input class="form-control" name="emergency_person" type="text" value="<?= $employee_detail['emergency_person'] ?>">
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Relation</label>
                                  <input class="form-control" name="relation" type="text" value="<?= $employee_detail['relation'] ?>">
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Emergency Contact Number</label>
                                  <input class="form-control" name="emergency_phone" type="number" value="<?= $employee_detail['emergency_contact_number'] ?>">
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Bank A/C No:<span class="text-danger"></span></label>
                                  <input class="form-control" name="bank_account_number" type="number" value="<?= $employee_detail['bank_account_number'] ?>" oninput="validateAccountno(event)" min="0">
                                  <?php if ($validation->getError('bank_account_number')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('bank_account_number') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Bank IFSC<span class="text-danger"></span></label>
                                  <input class="form-control" name="bank_ifsc_code" value="<?= $employee_detail['bank_ifsc_code'] ?>">
                                  <?php if ($validation->getError('bank_ifsc_code')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('bank_ifsc_code') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Profile Image 1</label><br>
                                  <?php if (isset($employee_detail) && $employee_detail['profile_image1'] != '') { ?>
                                    <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_detail['profile_image1'] ?>" style="height: 150px;">
                                  <?php } ?>
                                  <input class="form-control" name="image1" type="file" accept="image/*">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('image1')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('image1') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Profile Image 2</label><br>
                                  <?php if (isset($employee_detail) && $employee_detail['profile_image2'] != '') { ?>
                                    <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_detail['profile_image2'] ?>" style="height: 150px;">
                                  <?php } ?>
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
                                  <input class="form-control" name="joiningdate" type="date" value="<?= $employee_detail['joining_date'] ?>" required>
                                  <?php if ($validation->getError('joiningdate')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('joiningdate') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">Digital Signature</label><br>
                                  <?php if (isset($employee_detail) && $employee_detail['digital_sign'] != '') { ?>
                                    <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_detail['digital_sign'] ?>" style="height: 150px;">
                                  <?php } ?>
                                  <input class="form-control" name="digital_sign" type="file" accept="image/*" value="<?= set_value('digital_sign') ?>">
                                  <p style="color:#00f"><em>(jpg,jpeg,png,pdf)</em></p>
                                  <?php if ($validation->getError('digital_sign')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('digital_sign') . '</div>';
                                  } ?>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">UPI ID</label>
                                  <input class="form-control" name="upi" value="<?= $employee_detail['upi_id'] ?>">
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-wrap">
                                  <label class="col-form-label">UPI ID Image<span class="text-danger"></span></label><br>
                                  <?php if (isset($employee_detail) && $employee_detail['upi_img'] != '') { ?>
                                    <img src="<?= base_url('public/uploads/employeeDocs/') . $employee_detail['upi_img'] ?>" style="height: 150px;">
                                  <?php } ?>
                                  <input class="form-control" name="upi_id" type="file" value="<?= set_value('upi_id') ?>">
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
                            <a href="./<?= $employee_detail['id'] ?>" class="btn btn-warning">Reset</a>
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
      })
    </script>
  </body>

  </html>