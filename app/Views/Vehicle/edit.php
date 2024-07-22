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
                      <form action="<?php echo base_url(); ?>vehicle/edit" method="post" enctype="multipart/form-data">
                        <div class="settings-sub-header">
                          <h6>Edit Vehicle</h6>
                        </div>
                        <div class="profile-details">
                          <input type="hidden" name="id" value="<?php
                                                                if (isset($vehicle_data)) {
                                                                  echo $vehicle_data['id'];
                                                                }
                                                                ?>">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label" style="padding-right: 10px;">
                                  Vehicle Owner <span class="text-danger">*</span>
                                </label>
                                <input type="radio" name="owner" id="company" value="company" onchange="$.radio('company');" <?= $vehicle_data['owner'] === 'company' ? 'checked' : '' ?> required>
                                <label for="company" style="padding-right:15px">Company</label>
                                <input type="radio" name="owner" id="owner" value="onhire" onchange="$.radio('onhire');" <?= $vehicle_data['owner'] === 'onhire' ? 'checked' : '' ?> required>
                                <label for="owner">On Hire</label>
                                <?php
                                if ($validation->getError('owner')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('owner') . '</div>';
                                }
                                ?>
                              </div>



                              <div class="form-wrap onhire" <?= $vehicle_data['owner'] == 'onhire' ? '' : 'style="display: none;"' ?>>
                                <label class="col-form-label"> Vendor Name<span class="text-danger">*</span> </label>
                                <select class="select" id="vendor_id" name="vendor_id">
                                  <option value="">Select</option>
                                  <?php
                                  if (isset($party)) {
                                    foreach ($party as $row) {
                                      echo '<option value="' . $row["id"] . '" ' . ($row['id'] == $vehicle_data['party_id'] ? 'selected' : '') . ' >' . ucwords($row["party_name"]) . '</option>';
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
                                    foreach ($vehicletype_data as $row) { ?>
                                      <option value="<?= $row['id'] ?>" <?= $row['id'] == $vehicle_data['vehicle_type_id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
                                  <?php  }
                                  }
                                  ?>
                                </select>
                                <?php
                                if ($validation->getError('vehicletype')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('vehicletype') . '</div>';
                                }
                                ?>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Vehicle Model <span class="text-danger">*</span>
                                </label>
                                <select class="select" id="model_no" name="model_no" required>
                                  <option value="">Select</option>
                                  <?php foreach ($vehiclemodel_data as $row) : if ($row['id'] === $vehicle_data['model_number_id']) { ?>
                                      <option value="<?= $row['id'] ?>" <?= $row['id'] == $vehicle_data['model_number_id'] ? 'selected' : '' ?>>
                                        <?= $row['model_no'] ?>
                                      </option>
                                    <?php } ?>
                                  <?php endforeach; ?>
                                </select>
                                <?php
                                if ($validation->getError('model_no')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('model_no') . '</div>';
                                }
                                ?>
                              </div>
                            </div>

                            <hr> 
                            <h6>RC DETAILS:</h6>
                            <br>
                            <br>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> RC No <span class="text-danger">*</span> </label>
                                <input type="text" name="rc" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['rc_number'] : '' ?>" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> RC Date </label>
                                <input type="date" name="rc_date" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['rc_date'] : '' ?>">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Mfg. Month & Year </label>
                                <input type="month" name="mfg" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['mfg'] : '' ?>">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Vehicle Class</label> 
															<select class="form-select select2" name="vehicle_class_id" id="vehicle_class_id" aria-label="Default select example">
																<option value="">Select</option> 
                                <?php foreach(VEHICLE_CLASSES as $key=> $val){ ?>
                                  <option value="<?= $key?>" <?= ($vehicle_data['vehicle_class_id']==$key) ? 'selected' : '' ?>><?= $val?></option>
                                <?php } ?>
															</select>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label"> Chassis No <span class="text-danger">*</span> </label>
                                <input type="text" name="chassis" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['chassis_number'] : '' ?>" required>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label"> Engine No <span class="text-danger">*</span> </label>
                                <input type="text" name="engine" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['engine_number'] : '' ?>" required>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Colour</label>
                                <input type="text" name="colour" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['colour'] : '' ?>">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Seating / Standing </label>
                                <input type="text" name="seating" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['seating'] : '' ?>">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Unladen/Empty Weight (KG)</label>
                                <input type="text" name="unladen_wt" class="form-control" id="unladen_wt" value="<?= isset($vehicle_data) ? $vehicle_data['unladen_wt'] : '' ?>">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label"> Laden/Gross Weight (KG)</label>
                                <input type="text" name="laden_wt" class="form-control" id="laden_wt" value="<?= isset($vehicle_data) ? $vehicle_data['laden_wt'] : '' ?>">
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-wrap">
                                <label class="col-form-label"> Address </label>
                                <input type="text" name="address" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['address'] : set_value('address') ?> ">
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label"> City</label>
                                <input type="text" name="city" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['city'] : set_value('city') ?>">
                              </div>
                            </div>

                            <div class="col-md-4">
                              <label class="col-form-label">State</label> 
															<select class="form-select select2" name="state_id" id="state_id" <?= $vehicle_data['state_id'] ?> aria-label="Default select example">
																<option value="">Select</option>
																<?php foreach ($states as $o) {
                                   $selected = ($vehicle_data['state_id']==$o['state_id']) ? 'selected': '';?>
																  <option value="<?= $o['state_id'] ?>" <?= $selected ?>><?= $o['state_name'] ?></option>
																<?php } ?>
															</select>
                            </div>

                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label">Pincode</label>
                                <input type="number" name="pincode" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['city'] : set_value('pincode') ?>">
                              </div>
                            </div>

                            <hr>

                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label"> Invoice Number </label>
                                <input type="text" name="inv_no" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['invoice_no'] : '' ?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-wrap">
                                <label class="col-form-label"> Invoice Date </label>
                                <input type="date" name="inv_date" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['invoice_date'] : '' ?>">
                              </div>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-wrap">
                                <label class="col-form-label"> KM reading at Start</label>
                                <input type="number" name="km" class="form-control" value="<?= isset($vehicle_data) ? $vehicle_data['km_reading_start'] : '' ?>" min="0" step="1">
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label"> Image 1 </label><br>
                                <?php if (isset($vehicle_data) &&  $vehicle_data['image1'] != '') { ?>
                                  <img src="<?= base_url('public/uploads/vehicles/') . $vehicle_data['image1'] ?>" style="height: 150px;">
                                <?php } ?>

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
                                <label class="col-form-label"> Image 2 </label><br>
                                <?php if (isset($vehicle_data) &&  $vehicle_data['image2'] != '') { ?>
                                  <img src="<?= base_url('public/uploads/vehicles/') . $vehicle_data['image2'] ?>" style="height: 150px;">
                                <?php } ?>

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
                                <label class="col-form-label"> Image 3 </label><br>
                                <?php if (isset($vehicle_data) &&  $vehicle_data['image3'] != '') { ?>
                                  <img src="<?= base_url('public/uploads/vehicles/') . $vehicle_data['image3'] ?>" style="height: 150px;">
                                <?php } ?>

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
                                <label class="col-form-label"> Image 4 </label><br>
                                <?php if (isset($vehicle_data) &&  $vehicle_data['image4'] != '') { ?>
                                  <img src="<?= base_url('public/uploads/vehicles/') . $vehicle_data['image4'] ?>" style="height: 150px;">
                                <?php } ?>

                                <input type="file" accept="image/*" name="image4" class="form-control" title="Image less than 100 KB">
                                <span class="text-info ">(PNG,JPEG,JPG,PDF)</span>  
                                <?php
                                if ($validation->getError('image4')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('image4') . '</div>';
                                }
                                ?>

                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Vehicle Tyres <span class="text-danger">*</span>
                                </label>

                                <div id="vehicletyre" class="row">
                                  <?php
                                  if (isset($vehicle_data)) {
                                    $subcnt = substr_count($vehicle_data['tyre_serial_text'], ",");
                                    if ($subcnt > 0) {
                                      $a = explode(',', $vehicle_data['tyre_serial_text']);
                                      for ($i = 0; $i < count($a); $i++) {
                                  ?>
                                        <div class="col-md-3">
                                          <label for="fuel_types">Tyre <?= $i + 1; ?></label>
                                          <input type="text" class="form-control" id="fuel_types" name="fuel_types[]" value="<?php echo $a[$i]; ?>" required>
                                        </div>

                                  <?php
                                      }
                                    }
                                  }
                                  ?>

                                </div>


                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <input type="checkbox" id="active" class="form-check-input" name="active" <?= $vehicle_data['status'] == 'Active' ? 'checked' : '' ?> value="1">
                                <label for="active">Active</label>
                              </div>
                            </div>

                            <?php
                            if ($validation->getError('vehicletyre')) {
                              echo '<div class="alert alert-danger mt-2">' . $validation->getError('vehicletyre') . '</div>';
                            }
                            ?>
                          </div>
                        </div>
                        <div class="submit-button">
                          <input type="submit" name="add_vehicle" class="btn btn-primary" value="Save Changes">
                          <a href="./<?= $vehicle_data['id'] ?>" class="btn btn-warning">Reset</a>
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
                                              <label for="fuel_types${item[0].id}">${item[0].name}</label>
                                              <input type="text" class="form-control" id="fuel_types${item[0].id}" name="fuel_types[]"  required>
                                          </div>
                                      `);
            });
          }
        });
      });
    });


    $.radio = function(str) {
      if (str == 'onhire') {
        $('.onhire').show();
        $('#vendor_id').attr('required', 'required');
      } else {
        $('.onhire').hide();
        $('#vendor_id').removeAttr('required');
        $('#vendor_id').val('company');
      }
    }
  </script>

</body>

</html>