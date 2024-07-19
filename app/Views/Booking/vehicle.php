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

                      <?php
                      // print_r($booking_details);
                      // print_r($offices);
                      ?>
                      <form method="post" enctype="multipart/form-data" action="<?php echo base_url('booking/assign_vehicle/' . $booking_details['id']); ?>">

                        <div class="settings-sub-header">
                          <h6>Assign Vehicle To Booking</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row g-3">


                            <div class="col-md-6">
                              <label class="col-form-label">Booking For</label>
                              <select class="form-select " disabled name="booking_for" id="booking_for" aria-label="Default select example">
                                <option value="">Select Material</option>
                                <option value="1" <?= $booking_details['booking_for'] == '1' ? 'selected' : '' ?>>Material 1</option>
                                <option value="2" <?= $booking_details['booking_for'] == '2' ? 'selected' : '' ?>>Material 2</option>
                                <option value="3" <?= $booking_details['booking_for'] == '3' ? 'selected' : '' ?>>Material 3</option>
                                <option value="4" <?= $booking_details['booking_for'] == '4' ? 'selected' : '' ?>>Material 4</option>
                              </select>
                            </div>

                            <div class="col-md-6">
                              <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                              <select class="form-select " disabled name="office_id" id="office_id" aria-label="Default select example">
                                <option value="">Select Office</option>
                                <?php foreach ($offices as $o) {
                                  echo '<option value="' . $o['id'] . '"  ' . ($booking_details['office_id'] == $o['id'] ? 'selected' : '') . '>' . $o['name'] . '</option>';
                                } ?>
                              </select>
                            </div>



                            <div class="col-md-4">
                              <label class="col-form-label">Customer Name<span class="text-danger">*</span></label>
                              <select class="form-select " disabled name="customer_id" id="customer_id" aria-label="Default select example" onchange="$.getPartyType();">
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $c) {
                                  echo '<option value="' . $c['id'] . '" ' . ($booking_details['customer_id'] == $c['id'] ? 'selected' : '') . '>' . $c['party_name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Customer Branch<span class="text-danger">*</span></label>
                              <select class="form-select" name="customer_branch" disabled id="customer_branch" aria-label="Default select example">
                                <option value="">Select Branch</option>
                              </select>
                              <label id="msg" class="text-danger"></label>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Customer Type</label>
                              <select class="form-select" name="customer_type" disabled id="customer_type" aria-label="Default select example">
                                <option value="">Select Type</option>
                              </select>
                            </div>

                            <div class="col-md-12"></div>


                            <div class="col-md-9">

                              <label class="col-form-label">Pickup Details<span class="text-danger">*</span></label>
                              <table class="table table-borderless" id="pickup_table">
                                <tbody id="pickup_body">
                                  <tr>
                                    <td width="15%">Sequence</td>
                                    <td width="25%">State<span class="text-danger">*</span></td>
                                    <td width="40%">City<span class="text-danger">*</span></td>
                                    <td width="20%">PinCode</td>
                                  </tr>

                                  <?php
                                  $i = 1;
                                  foreach ($booking_pickups as $bp) { ?>

                                    <tr <?= $i > 1 ? 'id="del_pickup_' . $i . '"' : '' ?>>
                                      <td>
                                        <input type="number" name="pickup_seq[]" disabled value="<?= $bp['sequence'] ?>" class="form-control">
                                      </td>
                                      <td>
                                        <select class="form-select" name="pickup_state_id[]" disabled aria-label="Default select example">
                                          <option value="">Select State</option>
                                          <?php foreach ($states as $s) {
                                            echo '<option value="' . $s['state_id'] . '" ' . ($bp['state'] == $s['state_id'] ? 'selected' : '') . '>' . $s['state_name'] . '</option>';
                                          } ?>
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" name="pickup_city[]" disabled class="form-control" value="<?= $bp['city'] ?>">
                                      </td>
                                      <td>
                                        <input type="text" name="pickup_pin[]" disabled class="form-control" value="<?= $bp['pincode'] ?>">
                                      </td>

                                    </tr>

                                  <?php $i++;
                                  } ?>

                                </tbody>
                              </table>
                            </div>


                            <div class="col-md-9">
                              <label class="col-form-label">Drop Details<span class="text-danger">*</span></label>
                              <table class="table table-borderless" id="drop_table">
                                <tbody id="drop_body">
                                  <tr>
                                    <td width="15%">Sequence</td>
                                    <td width="25%">State<span class="text-danger">*</span></td>
                                    <td width="40%">City<span class="text-danger">*</span></td>
                                    <td width="20%">PinCode</td>
                                  </tr>

                                  <?php
                                  $i = 1;
                                  foreach ($booking_drops as $bd) { ?>

                                    <tr <?= $i > 1 ? 'id="del_drop_' . $i . '"' : '' ?>>
                                      <td>
                                        <input type="number" name="drop_seq[]" value="<?= $bd['sequence'] ?>" disabled class="form-control">
                                      </td>
                                      <td>
                                        <select class="form-select" name="drop_state_id[]" aria-label="Default select example" disabled>
                                          <option value="">Select State</option>
                                          <?php foreach ($states as $s) {
                                            echo '<option value="' . $s['state_id'] . '" ' . ($bd['state'] == $s['state_id'] ? 'selected' : '') . '>' . $s['state_name'] . '</option>';
                                          } ?>
                                        </select>
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" name="drop_city[]" class="form-control" value="<?= $bd['city'] ?>" disabled>
                                      </td>
                                      <td>
                                        <input type="text" name="drop_pin[]" class="form-control" value="<?= $bd['pincode'] ?>" disabled>
                                      </td>

                                    </tr>

                                  <?php $i++;
                                  } ?>
                                </tbody>
                              </table>
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-2">
                              <label class="col-form-label">Pickup Date <span class="text-danger">*</span></label>
                              <input type="date" disabled name="pickup_date" id="pickup_date" value="<?= $booking_details['pickup_date'] ?>" class="form-control">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Drop Date</label>
                              <input type="date" name="drop_date" disabled id="drop_date" value="<?= $booking_details['drop_date'] ?>" class="form-control">
                            </div>



                            <div class="col-md-2">
                              <label class="col-form-label">Booking Date<span class="text-danger">*</span></label>
                              <input type="date" disabled name="booking_date" value="<?= $booking_details['booking_date'] ?>" class="form-control">
                            </div>


                            <div class="col-md-3">
                              <label class="col-form-label">Rate Type</label>
                              <select class="form-select" name="rate_type" disabled>
                                <option value="">Select Rate Type</option>
                                <option value="1" <?= $booking_details['rate_type'] == '1' ? 'selected' : '' ?>>By Weight</option>
                                <option value="2" <?= $booking_details['rate_type'] == '2' ? 'selected' : '' ?>>Aggregate</option>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Rate (Rs)</label>
                              <input type="number" name="rate" disabled class="form-control" value="<?= $booking_details['rate'] ?>">
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-6">
                              <table class="table table-borderless">
                                <tbody>
                                  <tr>
                                    <td>Expense Head</td>
                                    <td>Value</td>
                                    <td>Bill To Party</td>
                                  </tr>
                                  <tr>
                                    <td><input type="text" disabled name="expense_1" value="<?= isset($booking_expences[0]) ? $booking_expences[0]['expense'] : '' ?>" class="form-control"></td>
                                    <td><input type="text" disabled name="expense_value_1" value="<?= isset($booking_expences[0]) ? $booking_expences[0]['value'] : '' ?>" class="form-control"></td>
                                    <td><input class="form-check-input" disabled type="checkbox" name="expense_flag_1" id="flexCheckDefault" style="height:30px; width:30px; border-radius: 50%;" <?= isset($booking_expences[0]) && $booking_expences[0]['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                                  </tr>
                                  <tr>
                                    <td><input type="text" disabled name="expense_2" value="<?= isset($booking_expences[1]) ? $booking_expences[1]['expense'] : '' ?>" class="form-control"></td>
                                    <td><input type="text" disabled name="expense_value_2" value="<?= isset($booking_expences[1]) ? $booking_expences[1]['value'] : '' ?>" class="form-control"></td>
                                    <td><input class="form-check-input" disabled type="checkbox" name="expense_flag_2" id="flexCheckDefault" style="height:30px; width:30px; border-radius: 50%;" <?= isset($booking_expences[1]) && $booking_expences[1]['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                                  </tr>
                                  <tr>
                                    <td><input type="text" disabled name="expense_3" value="<?= isset($booking_expences[2]) ? $booking_expences[2]['expense'] : '' ?>" class="form-control"></td>
                                    <td><input type="text" disabled name="expense_value_3" value="<?= isset($booking_expences[2]) ? $booking_expences[2]['value'] : '' ?>" class="form-control"></td>
                                    <td><input class="form-check-input" disabled type="checkbox" name="expense_flag_3" id="flexCheckDefault" style="height:30px; width:30px; border-radius: 50%;" <?= isset($booking_expences[2]) && $booking_expences[2]['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                                  </tr>
                                  <tr>
                                    <td><input type="text" disabled name="expense_4" value="<?= isset($booking_expences[3]) ? $booking_expences[3]['expense'] : '' ?>" class="form-control"></td>
                                    <td><input type="text" disabled name="expense_value_4" value="<?= isset($booking_expences[3]) ? $booking_expences[3]['value'] : '' ?>" class="form-control"></td>
                                    <td><input class="form-check-input" disabled type="checkbox" name="expense_flag_4" id="flexCheckDefault" style="height:30px; width:30px; border-radius: 50%;" <?= isset($booking_expences[3]) && $booking_expences[3]['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                                  </tr>
                                  <tr>
                                    <td><input type="text" disabled name="expense_5" value="<?= isset($booking_expences[4]) ? $booking_expences[4]['expense'] : '' ?>" class="form-control"></td>
                                    <td><input type="text" disabled name="expense_value_5" value="<?= isset($booking_expences[4]) ? $booking_expences[4]['value'] : '' ?>" class="form-control"></td>
                                    <td><input class="form-check-input" disabled type="checkbox" name="expense_flag_5" id="flexCheckDefault" style="height:30px; width:30px; border-radius: 50%;" <?= isset($booking_expences[4]) && $booking_expences[4]['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                                  </tr>
                                  <tr>
                                    <td><input type="text" disabled name="expense_6" value="<?= isset($booking_expences[5]) ? $booking_expences[5]['expense'] : '' ?>" class="form-control"></td>
                                    <td><input type="text" disabled name="expense_value_6" value="<?= isset($booking_expences[5]) ? $booking_expences[5]['value'] : '' ?>" class="form-control"></td>
                                    <td><input class="form-check-input" disabled type="checkbox" name="expense_flag_6" id="flexCheckDefault" style="height:30px; width:30px; border-radius: 50%;" <?= isset($booking_expences[5]) && $booking_expences[5]['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-6">
                              <label class="col-form-label">Vehicle Type<span class="text-danger">*</span></label>
                              <select class="form-select" name="vehicle_type" id="vehicle_type" disabled aria-label="Default select example" onchange="$.getVehicles();">
                                <option value="">Select Vehicle Type</option>
                                <?php foreach ($vehicle_types as $vt) {
                                  echo '<option value="' . $vt['id'] . '"  ' . ($booking_details['vehicle_type_id'] == $vt['id'] ? 'selected' : '') . '>' . $vt['name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-5">
                              <label class="col-form-label">Vehicle RC -- Driver <span class="text-danger">*</span></label>
                              <select class="form-select select2" name="vehicle_rc" id="vehicle_rc" aria-label="Default select example" required>
                                <option value="">Select RC</option>
                                <?php foreach ($vehicle_rcs as $rc) {
                                  echo '<option value="' . $rc['id'] . '" ' . ($booking_details['vehicle_id'] == $rc['id'] ? 'selected' : '') . '>' . $rc['rc_number'] . ' -- ' . $rc['party_name'] . '</option>';
                                } ?>
                              </select>
                            </div>



                          </div>
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary" id="save-btn">Save Changes</button>
                          <a href="./<?= $booking_details['id'] ?>" class="btn btn-warning">Reset</a>
                          <a href="<?php echo base_url('booking'); ?>" class="btn btn-light">Back</a>
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
      $.getPartyType();
    });


    $.addPickup = function() {
      var tot = $('#pickup_table').children('tbody').children('tr').length;

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('booking/add-pickup'); ?>",
        data: {
          index: tot
        },
        success: function(data) {
          $('#pickup_body').append(data);
        }
      })
    }

    $.addDrop = function() {
      var tot = $('#drop_table').children('tbody').children('tr').length;

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('booking/add-drop'); ?>",
        data: {
          index: tot
        },
        success: function(data) {
          $('#drop_body').append(data);
        }
      })
    }

    $.delete = function(index, str) {
      $('#del_' + str + '_' + index).remove();
    }

    $.getPartyType = function() {

      var customer_id = $('#customer_id').val();

      $.ajax({
        method: "POST",
        url: '<?php echo base_url('booking/getCustomerType') ?>',
        data: {
          customer_id: customer_id
        },
        success: function(response) {
          $('#customer_type').html(response);
        }
      });

      $.ajax({
        method: "POST",
        url: '<?php echo base_url('booking/getCustomerBranch') ?>',
        data: {
          customer_id: customer_id
        },
        success: function(response) {
          if (response != '') {
            $('#customer_branch').html(response);
            $('#msg').html('');
            $('#save-btn').removeAttr('disabled');
          } else {
            $('#msg').html('branch not created for customer');
            $('#save-btn').attr('disabled', 'disabled');
          }
        }
      });

    }

    $.getVehicles = function() {
      var vehicle_type = $('#vehicle_type').val();

      $.ajax({
        method: "POST",
        url: '<?php echo base_url('booking/getVehicles') ?>',
        data: {
          vehicle_type: vehicle_type
        },
        success: function(response) {
          $('#vehicle_rc').html(response);
        }
      });
    }

    $.setDrop = function() {
      var pickup_date = $('#pickup_date').val();
      console.log(pickup_date);
      $('#drop_date').attr('min', pickup_date);
    }
  </script>

</body>

</html>