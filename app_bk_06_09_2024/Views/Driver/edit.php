<!DOCTYPE html>
<html lang="en">
<head>
  <?= $this->include('partials/title-meta') ?>
  <?= $this->include('partials/head-css') ?>
  <style type="text/css">
	.check-form { border: 1px solid #ccc; background: #fff; padding: 5px; height: 160px; overflow: auto; }
	.check-form .checkbox { margin-top: 0; }
	</style>
</head>
<body>
  <div class="main-wrapper">
    <?= $this->include('partials/menu') ?>

    <div class="page-wrapper">
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <?= $this->include('partials/page-title') ?>
            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <?php 
                $validation = \Config\Services::validation();
                use App\Models\UserTypePermissionModel;
                use App\Models\PartyModel;
                ?>

                <div class="card">
                  <div class="card-body">
                    <div class="settings-form">
                      <?php
                      $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
                      $last = array_pop($uriSegments);
                      $userPermissions = new UserTypePermissionModel();
                      ?>
                      <form method="post" id="driverform" action="<?php echo base_url('driver/edit/' . $driver_data['id']) ?>" enctype="multipart/form-data">
                        <div class="settings-sub-header">
                          <h6>Update Driver</h6>
                        </div>

                        <div class="profile-details">
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Driver Name <span class="text-danger">*</span>
                                </label>

                                <select class="form-control select2" name="party_id" id="party_id" style="pointer-events: none;">
                                  <option>Select Driver</option>
                                  <?php
                                  foreach ($parties as $party) {
                                  ?>
                                    <option value="<?php echo $party['id']; ?>" <?= $driver_data['party_id'] == $party['id'] ? 'selected' : '' ?>><?php echo ucwords($party['party_name']); ?></option>
                                  <?php
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Foreman Name <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2" id="forman_name" name="foreman_id" style="pointer-events: none;">
                                  <option>Select</option>
                                  <?php
                                  foreach ($foreman as $fm) {
                                  ?>
                                    <option value="<?php echo $fm["id"] ?>" <?= $driver_data['foreman_id'] == $fm['id'] ? 'selected' : '' ?>><?php echo $fm['party_name'] ?></option>
                                  <?php
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">
                                Driver Type <span class="text-danger">*</span>
                              </label><br>
                              <input type="radio" class="radio" id="Employee" value="Employee" <?= $driver_data['driver_type'] == 'Employee' ? 'checked' : '' ?> name="driver_type" required>
                              <label for="Employee">Employee</label>&nbsp;&nbsp;&nbsp;
                              <input type="radio" class="radio" id="Contractor" value="Contractor" <?= $driver_data['driver_type'] == 'Contractor' ? 'checked' : '' ?> name="driver_type" required>
                              <label for="Contractor">Contractor</label><br>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Scheme <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="scheme_id" required>
                                  <option value="">Select Scheme</option>
                                  <?php
                                  if (isset($schemes)) {
                                    foreach ($schemes as $row) { ?>
                                      <option value="<?php echo $row["id"] ?>" <?= isset($driver_scheme) && $driver_scheme['scheme_id'] == $row['id'] ? 'selected' : '' ?>><?php echo $row["scheme_name"] . ' - ' . $row["rate"] . '/Km' ?></option>
                                  <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-12"></div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Email
                                </label>
                                <input readonly type="text" name="email" id="email" value="<?= $driver_data['email'] ?>" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Father Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" name="father_name" required id="father_name" class="form-control" value="<?= isset($driver_data['father_name']) ? $driver_data['father_name'] : '' ?>">
                              </div>
                            </div>
                            
                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Phone Number
                                </label>
                                <input readonly type="text" name="mobile" id="mobile" value="<?= $driver_data['primary_phone'] ?>" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Bank A/C No:
                                </label>
                                <input type="text" name="bank_account_number" value="<?= $driver_data['bank_ac'] ?>" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Bank IFSC:
                                </label>
                                <input type="text" name="bank_ifsc_code" value="<?= $driver_data['bank_ifsc'] ?>" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Driving Licence Number <span class="text-danger">*</span></label>
                                <input type="text" name="dl_no" value="<?= $driver_data['dl_no'] ?>" class="form-control" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Driving Licence Issue Auth. <span class="text-danger">*</span></label>
                                <input type="text" name="dl_authority" value="<?= $driver_data['dl_authority'] ?>" class="form-control" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Driving Licence Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" name="dl_expiry" min="<?= date('Y-m-d') ?>" value="<?= $driver_data['dl_expiry'] ?>" class="form-control" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Driving Licence DOB <span class="text-danger">*</span></label>
                                <input type="date" name="dl_dob" class="form-control" value="<?= $driver_data['dl_dob'] ?>" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> DL Image - Front <span class="text-danger">*</span></label><br>
                                <?php if (isset($driver_data) && $driver_data['dl_image_front'] != '' && file_exists('public/uploads/driverDocs/'.$driver_data['dl_image_front'])) {
                                  if (pathinfo($driver_data['dl_image_front'], PATHINFO_EXTENSION) != 'pdf') {
                                    echo '<img src="' . base_url('public/uploads/driverDocs/') . $driver_data['dl_image_front'] . '" style="height: 150px;">';
                                  } else {
                                    echo '<a href="' . base_url('public/uploads/driverDocs/') . $driver_data['dl_image_front'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                  }
                                }
                                ?>
                                <input type="file" name="dl_image_front" class="form-control">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> DL Image - Back </label><br>
                                <?php if (isset($driver_data) && $driver_data['dl_image_back'] != '' && file_exists('public/uploads/driverDocs/'.$driver_data['dl_image_back'])) {
                                  if (pathinfo($driver_data['dl_image_back'], PATHINFO_EXTENSION) != 'pdf') {
                                    echo '<img src="' . base_url('public/uploads/driverDocs/') . $driver_data['dl_image_back'] . '" style="height: 150px;">';
                                  } else {
                                    echo '<a href="' . base_url('public/uploads/driverDocs/') . $driver_data['dl_image_back'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                  }
                                }
                                ?>
                                <input type="file" name="dl_image_back" class="form-control">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Profile Image 1 <span class="text-danger">*</span></label><br>
                                <?php if (isset($driver_data) && $driver_data['profile_image1'] != '' && file_exists('public/uploads/driverDocs/'.$driver_data['profile_image1'])) {
                                  if (pathinfo($driver_data['profile_image1'], PATHINFO_EXTENSION) != 'pdf') {
                                    echo '<img src="' . base_url('public/uploads/driverDocs/') . $driver_data['profile_image1'] . '" style="height: 150px;">';
                                  } else {
                                    echo '<a href="' . base_url('public/uploads/driverDocs/') . $driver_data['profile_image1'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                  }
                                }
                                ?>
                                <input type="file" name="profile_image1" class="form-control">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Profile Image 2 </label><br>
                                <?php if (isset($driver_data) && $driver_data['profile_image2'] != '' && file_exists('public/uploads/driverDocs/'.$driver_data['profile_image2'])) {
                                  if (pathinfo($driver_data['profile_image2'], PATHINFO_EXTENSION) != 'pdf') {
                                    echo '<img src="' . base_url('public/uploads/driverDocs/') . $driver_data['profile_image2'] . '" style="height: 150px;">';
                                  } else {
                                    echo '<a href="' . base_url('public/uploads/driverDocs/') . $driver_data['profile_image2'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                  }
                                }
                                ?>
                                <input type="file" name="profile_image2" class="form-control">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">UPI ID</label>
                                <input type="text" name="upi" value="<?= $driver_data['upi_text'] ?>" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> UPI ID Image </label><br>
                                <?php if (isset($driver_data) && $driver_data['upi_id'] != '' && file_exists('public/uploads/driverDocs/'.$driver_data['upi_id'])) {
                                  if (pathinfo($driver_data['upi_id'], PATHINFO_EXTENSION) != 'pdf') {
                                    echo '<img src="' . base_url('public/uploads/driverDocs/') . $driver_data['upi_id'] . '" style="height: 150px;">';
                                  } else {
                                    echo '<a href="' . base_url('public/uploads/driverDocs/') . $driver_data['upi_id'] . '" target="_blank"><span class="text-danger">Click To View PDF</span></a>';
                                  }
                                }
                                ?>
                                <input type="file" name="upi_id" class="form-control">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                              </div>
                            </div>

                            <h5>Current Address <span class="text-danger">*</span></h5><br><br>
                            <div class="col-md-12">
                              <div class="form-wrap">
                                <!-- <label class="col-form-label">
                                  Address<span class="text-danger">*</span>
                                </label> -->
                                <input type="text" required name="address" value="<?= $driver_data['address'] ?>" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">City:<span class="text-danger">*</span></label>
                                <input type="text" required name="city" value="<?= $driver_data['city'] ?>" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">State<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="state">
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

                            <div class="col-md-2">
                              <div class="form-wrap">
                                <label class="col-form-label">Zip:</label>
                                <input type="text" required name="zip" value="<?= $driver_data['zip'] ?>" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-wrap">
                                <label class="col-form-label"> WhatsApp No.<span class="text-danger">*</span> </label>
                                <input type="text" required name="whatsapp" value="<?= $driver_data['whatsapp_no'] ?>" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Vehicle Type</label><br>
                                <div class="check-form">
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
                                  <div class="checkbox">
                                    <input class="form-check-input chk" type="checkbox" name="vehicle_types[]" id="id_<?php echo $type["id"]; ?>" value="<?php echo $type["id"]; ?>" <?php if (in_array($type['id'], $vehicletypesitem)) { echo "checked"; } ?>>
                                    <label for="id_<?php echo $type["id"]; ?>" class="col-form-label" style=" margin: 0px 20px 0px 3px;">
                                      &nbsp;<?php echo ucwords($type["name"]); ?>
                                    </label>
                                  </div>
                                  <?php } }
                                  if ($validation->getError('vehicle_type')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('vehicle_type') . '</div>';
                                  }
                                  ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary">Save Changes</button>
                          <a href="<?php echo base_url(); ?>driver" class="btn btn-light">Cancel</a>
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
  <script>
    jQuery(document).ready(function($) {
      $("#party_id").on('change', function() {
        var level = $(this).val();
        if (level) {
          $.ajax({
            type: 'POST',
            url: 'populate_fields_data',
            data: {
              party_id: '' + level + ''
            },
            success: function(htmlresponse) {
              var res = JSON.parse(htmlresponse);
              if (res != null) {
                $('#email').val(res.email);
                $('#mobile').val(res.primary_phone);
                $('#adhaar_number').val(res.aadhaar);
              } else {
                $('#email').val('');
                $('#mobile').val('');
                $('#adhaar_number').val('');
              }
            }
          });
        }
      });

      $(".chk").on('change', function() {
        if ($('.chk:checked').length > 0) {
          console.log('yes');
          $('.chk').removeAttr('required');
        } else {
          console.log('no');
          $('.chk').attr('required', 'required');
        }
      })
    });
  </script>
</body>
</html>