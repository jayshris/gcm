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
            <?php $validation = \Config\Services::validation();
            ?>

            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <!-- Settings Info -->
                <div class="card">
                  <div class="card-body">
                    <div class="settings-form">
                      <form action="<?php echo base_url(); ?>vehicle/create" method="post" enctype="multipart/form-data">
                        <div class="settings-sub-header">
                          <h6>Add Vehicle</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label" style="padding-right: 10px;">
                                  Vehicle Owner <span class="text-danger">*</span>
                                </label>
                                <input type="radio" name="owner" id="owner1" value="company" onchange="$.radio('company');" required>
                                <label for="owner1" style="padding-right:15px">Company</label>
                                <input type="radio" name="owner" id="owner2" value="onhire" onchange="$.radio('onhire');" required>
                                <label for="owner2">On Hire</label>
                              </div>

                              <div class="form-wrap onhire" style="display: none;">
                                <label class="col-form-label"> Vendor Name<span class="text-danger">*</span> </label>
                                <select class="select" id="vendor_id" name="vendor_id">
                                  <option value="">Select</option>
                                  <?php
                                  if (isset($vendors)) {
                                    foreach ($vendors as $row) {
                                      echo '<option value="' . $row["id"] . '" "' . set_select('vendor_id', $row['id']) . '">' . ucwords($row["customer_name"]) . '</option>';
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-12"></div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Vehicle Type <span class="text-danger">*</span>
                                </label>
                                <select class="select" id="vehicletype" name="vehicletype" required>
                                  <option value="">Select</option>
                                  <?php
                                  if (isset($vehicletype_data)) {
                                    foreach ($vehicletype_data as $row) {
                                      echo '<option value="' . $row["id"] . '" "' . set_select('name', $row['id']) . '">' . ucwords($row["name"]) . '</option>';
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label"> Vehicle Model <span class="text-danger">*</span> </label>
                                <select class="select" id="model_no" name="model_no" onchange="$.getModelDetails();" required>
                                  <option value="">Select</option>
                                </select>
                              </div>
                            </div>

                            <hr>
                            <h6>RC DETAILS:</h6>
                            <br>
                            <br>
                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> RC No <span class="text-danger">*</span> <span class="text-danger" id="span_rc"></span></label>
                                <input type="text" name="rc" id="rc_no" class="form-control" value="<?= set_value('rc') ?>" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> RC Date <span class="text-danger">*</span></label>
                                <input type="date" name="rc_date" class="form-control" value="<?= set_value('rc_date') ?>" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Mfg. Month & Year </label>
                                <input type="month" name="mfg" class="form-control" value="<?= set_value('mfg') ?>">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Vehicle Class</label>
                              <select class="form-select select2" name="vehicle_class_id" id="vehicle_class_id" aria-label="Default select example">
                                <option value="">Select</option>
                                <?php foreach (VEHICLE_CLASSES as $key => $val) { ?>
                                  <option value="<?= $key ?>"><?= $val ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label"> Chassis No <span class="text-danger cm">*</span> <span class="text-danger" id="span_chassis"></span></label>
                                <input type="text" name="chassis" id="chassis" class="form-control" value="<?= set_value('chassis') ?>" required>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label"> Engine No <span class="text-danger em">*</span> <span class="text-danger" id="span_engine"></span></label>
                                <input type="text" name="engine" id="engine" class="form-control" value="<?= set_value('engine') ?>" required>
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-wrap">
                                <label class="col-form-label"> Colour</label>
                                <input type="text" name="colour" class="form-control" value="<?= set_value('colour') ?>">
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-wrap">
                                <label class="col-form-label"> Seating / Standing </label>
                                <input type="text" name="seating" class="form-control" value="<?= set_value('seating') ?>">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Unladen/Empty Weight (KG)</label>
                                <input type="text" name="unladen_wt" class="form-control" id="unladen_wt" value="<?= set_value('unladen_wt') ?>">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Laden/Gross Weight (KG)</label>
                                <input type="text" name="laden_wt" class="form-control" id="laden_wt" value="<?= set_value('laden_wt') ?>">
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-wrap">
                                <label class="col-form-label"> Charge Weight (KG) <span class="text-danger">*</span></label>
                                <input type="text" name="charge_wt" class="form-control" id="charge_wt" value="<?= set_value('charge_wt') ?>" required>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-wrap">
                                <label class="col-form-label"> Address </label>
                                <input type="text" name="address" class="form-control" value="<?= set_value('address') ?>">
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label"> City</label>
                                <input type="text" name="city" class="form-control" value="<?= set_value('city') ?>">
                              </div>
                            </div>

                            <div class="col-md-4">
                              <label class="col-form-label">State</label>
                              <select class="form-select select2" name="state_id" id="state_id" aria-label="Default select example">
                                <option value="">Select</option>
                                <?php foreach ($states as $o) {
                                  echo '<option value="' . $o['state_id'] . '">' . $o['state_name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label">Pincode</label>
                                <input type="number" name="pincode" class="form-control" value="<?= set_value('pincode') ?>">
                              </div>
                            </div>

                            <hr>

                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label"> Invoice Number </label>
                                <input type="text" name="inv_no" class="form-control" value="<?= set_value('inv_no') ?>">
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label"> Invoice Date </label>
                                <input type="date" name="inv_date" class="form-control" value="<?= set_value('inv_date') ?>">
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-wrap">
                                <label class="col-form-label"> KM reading at Start </label>
                                <input type="number" name="km" class="form-control" value="<?= set_value('km') ?>" min="0" step="1">
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Image 1
                                </label>
                                <input type="file" accept="image/*" name="image1" class="form-control" title="Image less than 100 KB">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                <?php
                                if ($validation->getError('image1')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('image1') . '</div>';
                                }
                                ?>

                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Image 2
                                </label>
                                <input type="file" accept="image/*" name="image2" class="form-control" title="Image less than 100 KB">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                <?php
                                if ($validation->getError('image2')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('image2') . '</div>';
                                }
                                ?>

                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Image 3
                                </label>
                                <input type="file" accept="image/*" name="image3" class="form-control" title="Image less than 100 KB">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                <?php
                                if ($validation->getError('image3')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('image3') . '</div>';
                                }
                                ?>

                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Image 4
                                </label>
                                <input type="file" accept="image/*" name="image4" class="form-control" title="Image less than 100 KB">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>
                                <?php
                                if ($validation->getError('image4')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('image4') . '</div>';
                                }
                                ?>

                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label"> Vehicle Tyres <span class="text-danger">*</span> </label>
                              </div>
                            </div>

                            <div id="vehicletyre" class="row g-2"></div>

                          </div>
                        </div>
                        <div class="submit-button">
                          <input type="submit" id="submit-btn" name="add_vehicle" class="btn btn-primary" value="Save Changes">
                          <a href="./create" class="btn btn-warning">Reset</a>
                          <a href="<?php echo base_url(); ?>vehicle" class="btn btn-light">Cancel</a>
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
    $(document).ready(function() {
      $('#vehicletype').change(function() {
        var vehicletypeId = $(this).val();

        var owner = $('input[name="owner"]:checked').val();

        var req = (owner == "company" ? "required" : '');
        console.log(req);


        $.ajax({
          url: '<?= base_url('vehicle/getVehicletypedetails') ?>',
          method: 'POST',
          data: {
            vehicletype_id: vehicletypeId
          },
          dataType: 'json',
          success: function(response) {
            $('#model_no').empty();
            $('#model_no').append('<option value="">Select</option>');
            $.each(response.vehiclemodels, function(key, value) {
              $('#model_no').append('<option value="' + value.id + '">' + value.model_no + '</option>');
            });

            let textboxContainer = $('#vehicletyre');
            textboxContainer.empty();
            response.vehicletyres1.forEach(item => {
              textboxContainer.append(`
                              <div class="col-md-3">
                                  <label class="col-form-label" for="fuel_types${item[0].id}">${item[0].name}</label>
                                  <input type="text" class="form-control tyre" id="fuel_types${item[0].id}" name="fuel_types[]" ` + req + `>
                              </div>
                          `);
            });
          }
        });
      });

      // rc validation
      $("#rc_no").on('change', function() {
        var rc_no = $(this).val();

        $('#span_rc').html('');
        $('#submit-btn').removeAttr('disabled');

        if (rc_no) {
          $.ajax({
            type: 'POST',
            url: 'validate_rc',
            data: {
              rc_no: rc_no
            },
            success: function(response) {
              if (response == '1') {
                $('#span_rc').html('RC already added !!');
                $("#rc_no").val('');
                $('#submit-btn').attr('disabled', 'disabled');
              }
            }
          });
        }
      });

      // chassis validation
      $("#chassis").on('change', function() {
        var chassis = $(this).val();

        $('#span_chassis').html('');
        $('#submit-btn').removeAttr('disabled');

        if (rc_no) {
          $.ajax({
            type: 'POST',
            url: 'validate_chassis',
            data: {
              chassis: chassis
            },
            success: function(response) {
              if (response == '1') {
                $('#span_chassis').html('Chassis number already added !!');
                $('#submit-btn').attr('disabled', 'disabled');
              }
            }
          });
        }
      });

      // engine validation
      $("#engine").on('change', function() {
        var engine = $(this).val();

        $('#span_engine').html('');
        $('#submit-btn').removeAttr('disabled');

        if (rc_no) {
          $.ajax({
            type: 'POST',
            url: 'validate_engine',
            data: {
              engine: engine
            },
            success: function(response) {
              if (response == '1') {
                $('#span_engine').html('Engine number already added !!');
                $('#submit-btn').attr('disabled', 'disabled');
              }
            }
          });
        }
      });

    });

    $.radio = function(str) {
      if (str == 'onhire') {
        $('.onhire').show();
        $('#vendor_id').attr('required', 'required');
        $('#chassis').removeAttr('required');
        $('#engine').removeAttr('required');
        $('.cm').html('');
        $('.em').html('');
        $('.tyre').removeAttr('required');
      } else {
        $('.onhire').hide();
        $('#vendor_id').removeAttr('required');
        $('#chassis').attr('required', 'required');
        $('#engine').attr('required', 'required');
        $('.cm').html('*');
        $('.em').html('*');
        $('.tyre').attr('required', 'required');
      }
    }

    $.getModelDetails = function() {

      var model_id = $('#model_no').val();

      $.ajax({
        url: '<?= base_url('vehicle/getVehicleModelDetails') ?>',
        method: 'POST',
        data: {
          model_id: model_id
        },
        success: function(response) {

          $('#unladen_wt').val(response.unladen_weight);
          $('#laden_wt').val(response.laden_weight);
        }
      })

    }
  </script>
</body>

</html>