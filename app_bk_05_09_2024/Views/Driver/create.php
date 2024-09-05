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
                      <form method="post" id="driverform" action="<?php echo base_url('driver/create') ?>" enctype="multipart/form-data">
                        <div class="settings-sub-header">
                          <h6>Add New Driver</h6>
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
                                    <option value="<?php echo $party['id']; ?>"><?php echo ucwords($party['party_name']); ?></option>
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
                                <select class="form-class select2" id="forman_name" name="foreman_id">
                                  <option>Select Foreman</option>
                                  <?php
                                  if (isset($foreman)) {
                                    foreach ($foreman as $row) {
                                      $party = new PartyModel();
                                      $partydata = $party->where('id', $row["party_id"])->first();
                                      if ($partydata) {
                                        $name = $partydata['party_name'];
                                      } else {
                                        $name = '';
                                      }
                                  ?>
                                      <option value="<?php echo $row["id"] ?>"><?php echo $name ?></option>
                                  <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">
                                Driver Type <span class="text-danger">*</span>
                              </label><br>
                              <input type="radio" class="radio" id="Employee" value="Employee" name="driver_type" required>
                              <label for="Employee">Employee</label>&nbsp;&nbsp;&nbsp;
                              <input type="radio" class="radio" id="Contractor" value="Contractor" name="driver_type" required>
                              <label for="Contractor">Contractor</label><br>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Scheme <span class="text-danger">*</span></label>
                                <select class="form-class select2" name="scheme_id" required>
                                  <option>Select Scheme</option>
                                  <?php
                                  if (isset($schemes)) {
                                    foreach ($schemes as $row) { ?>
                                      <option value="<?php echo $row["id"] ?>"><?php echo $row["scheme_name"] . ' - ' . $row["rate"] . '/Km' ?></option>
                                  <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Email
                                </label>
                                <input readonly type="text" name="email" id="email" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Father Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" name="father_name" required id="father_name" class="form-control">
                              </div>
                            </div>
                            
                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Phone Number
                                </label>
                                <input readonly type="text" name="mobile" id="mobile" class="form-control">
                              </div>
                            </div>

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
                                <label class="col-form-label">Driving Licence Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" name="dl_expiry" min="<?= date('Y-m-d') ?>" class="form-control" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Driving Licence DOB <span class="text-danger">*</span></label>
                                <input type="date" name="dl_dob"  class="form-control" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  DL Image - Front <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="dl_image_front" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" required>
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  DL Image - Back
                                </label>
                                <input type="file" name="dl_image_back" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
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

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Profile Image 2
                                </label>
                                <input type="file" name="profile_image2" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
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

                            <h5>Current Address <span class="text-danger">*</span></h5><br /><br />
                            <div class="col-md-12">
                              <div class="form-wrap">
                                <input type="text" required name="address" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">City:<span class="text-danger">*</span></label>
                                <input type="text" required name="city" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">State<span class="text-danger">*</span></label>
                                <select class="dropdown select2" name="state">
                                  <option>Select State</option>
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

                            <div class="col-md-2">
                              <div class="form-wrap">
                                <label class="col-form-label">Zip:</label>
                                <input type="text" required name="zip" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-wrap">
                                <label class="col-form-label"> WhatsApp No.<span class="text-danger">*</span> </label>
                                <input type="text" required name="whatsapp" class="form-control">
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

                            <?php if ($last != 'create') { ?>
                              <div>
                                <input type="checkbox" id="approve" class="form-check-input" name="approve" <?php if (isset($driver_data)) {
                                                                                                              if ($driver_data['approved'] == 1) {
                                                                                                                echo 'checked';
                                                                                                              }
                                                                                                            } ?> value="1"> <label for="approve"> Approved</label>
                              </div>
                            <?php } ?>

                          </div>
                        </div>
                        <div class="submit-button">
                          <button type="submit" id="submit-btn" class="btn btn-primary">Save Changes</button>
                          <a href="<?php echo base_url(); ?>driver" class="btn btn-light">Cancel</a>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- /Settings Info -->




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


      $("#dl_no").on('change', function() {
        var dl_no = $(this).val();

        $('#span_dl').html('');
        $('#submit-btn').removeAttr('disabled');

        if (dl_no) {
          $.ajax({
            type: 'POST',
            url: 'validate_dl',
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
  </script>
</body>

</html>