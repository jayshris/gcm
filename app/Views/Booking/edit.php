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
 
                      <?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
                        <div class="settings-sub-header">
                          <h6>Edit Booking</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row g-3">  
                            <input type="hidden" name="id" value="<?= $token ?>"/>
                            <input type="hidden" name="pickup_seq" value="1" class="form-control">
                            <input type="hidden" name="drop_seq" value="1" class="form-control">
                            <div class="col-md-12"></div>
                             
                            <label class="col-form-label">Pickup Details<span class="text-danger">*</span></label>

                            <div class="col-md-3">
                                <label class="col-form-label">State<span class="text-danger">*</span></label>
                                <select class="form-select" name="pickup_state_id" aria-label="Default select example" required>
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $s) { ?>
                                        <option value="<?= $s['state_id'] ?>" <?= isset($booking_pickups['state']) && ($booking_pickups['state'] == $s['state_id']) ? 'selected' : '' ?>><?= $s['state_name'] ?></option>
                                        <?php } ?>
                                </select>
                                <?php
                                if ($validation->getError('pickup_state_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_state_id') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">City<span class="text-danger">*</span></label>
                                <input type="text" name="pickup_city" class="form-control" required value="<?= isset($booking_pickups['city']) ? $booking_pickups['city'] : '' ?>">
                                <?php
                                if ($validation->getError('pickup_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_city') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">PinCode</label>
                                <input type="text" name="pickup_pin" class="form-control" value="<?= isset($booking_pickups['pincode']) ? $booking_pickups['pincode'] : '' ?>">
                                <?php if ($validation->getError('pickup_pin')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_pin') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">Pickup Date <span class="text-danger">*</span></label>
                                <input type="date" required name="pickup_date" id="pickup_date" onchange="$.setDrop();" class="form-control" value="<?= isset($booking_details['pickup_date']) ? $booking_details['pickup_date'] : '' ?>">
                                <?php
                                if ($validation->getError('pickup_date')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_date') . '</div>';
                                }   
                                ?>
                            </div> 
 
                            <label class="col-form-label">Drop Details<span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <label class="col-form-label">State<span class="text-danger">*</span></label>
                                <select class="form-select" name="drop_state_id" aria-label="Default select example" required>
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $s) { ?>
                                         <option value="<?= $s['state_id'] ?>" <?= isset($booking_drops['state']) && ($booking_drops['state'] == $s['state_id']) ? 'selected' : '' ?>><?= $s['state_name'] ?></option> 
                                        <?php } ?>
                                </select>
                                <?php
                                if ($validation->getError('drop_state_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('drop_state_id') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">City<span class="text-danger">*</span></label>
                                <input type="text" name="drop_city" class="form-control" required value="<?= isset($booking_drops['city']) ? $booking_drops['city'] : '' ?>">
                                <?php
                                if ($validation->getError('drop_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('drop_city') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">PinCode</label>
                                <input type="text" name="drop_pin" class="form-control" value="<?= isset($booking_drops['pincode']) ? $booking_drops['pincode'] : '' ?>">
                                <?php if ($validation->getError('drop_pin')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('drop_pin') . '</div>';
                                }   
                                ?>
                            </div>
 
                            <div class="col-md-3">
                                <label class="col-form-label">Drop Date</label>
                                <input type="date" name="drop_date" id="drop_date" class="form-control" value="<?= isset($booking_details['drop_date']) ? $booking_details['drop_date'] : '' ?>" >
                                <?php if ($validation->getError('drop_date')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('drop_date') . '</div>';
                                }   
                                ?>
                            </div> 
   
                            <div class="col-md-12"></div>

                            <div class="col-md-3">
                              <label class="col-form-label">Rate Type <span class="text-danger">*</span></label>
                              <select class="form-select" name="rate_type" id="rate_type" onchange="$.calculation()" required>
                                <option value="">Select Rate Type</option>
                                <option value="1" <?= isset($booking_details['rate_type']) && ($booking_details['rate_type'] == 1) ? 'selected' : '' ?> >By Weight</option>
                                <option value="2" <?= isset($booking_details['rate_type']) && ($booking_details['rate_type'] == 2) ? 'selected' : '' ?> >Aggregate</option>
                              </select>
                              <?php
                              if ($validation->getError('rate_type')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('rate_type') . '</div>';
                              }   
                              ?>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Rate (Rs) <span class="text-danger">*</span> <span id="rate_msg"></span></label>
                              <input type="number" name="rate" id="rate" onchange="$.calculation()" class="form-control" required value="<?= isset($booking_details['rate']) ? $booking_details['rate'] : '' ?>">
                              <?php
                              if ($validation->getError('rate')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('rate') . '</div>';
                              }   
                              ?>
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-8">
                              <table class="table table-borderless" id="expense_table">
                                <tbody id="expense_body">
                                  <tr>
                                    <td width="40%">Expense Head</td>
                                    <td>Value</td>
                                    <td>Bill To Party</td>
                                  </tr>

                                  <?php
                                  if(isset($booking_expences) && !empty($booking_expences)){
                                  $i = 1;
                                  foreach ($booking_expences as $be) {
                                  ?>
                                    <tr id="del_expense_<?= $i ?>">
                                      <td>
                                        <select class="form-select" name="expense[]" aria-label="Default select example">
                                          <option value="">Select Expense</option>
                                          <option value="1" <?= $be['expense'] == '1' ? 'selected' : '' ?>>Loading</option>
                                          <option value="2" <?= $be['expense'] == '2' ? 'selected' : '' ?>>Unloading</option>
                                          <option value="3" <?= $be['expense'] == '3' ? 'selected' : '' ?>>Detention</option>
                                          <option value="4" <?= $be['expense'] == '4' ? 'selected' : '' ?>>Munshiana</option>
                                        </select>
                                      </td>
                                      <td><input type="number" name="expense_value[]" id="expense_<?= $i ?>" value="<?= $be['value'] ?>" class="form-control"></td>
                                      <td><input class="form-check-input" type="checkbox" name="expense_flag_<?= $i ?>" id="expense_flag_<?= $i ?>" style="height:30px; width:30px; border-radius: 50%;" onchange="$.billToParty('<?= $i ?>');" <?= $be['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                                      <td>
                                        <?php if ($i > 1) { ?>
                                          <button type="button" class="btn btn-sm btn-danger" onclick="$.delete(<?= $i ?>,'expense')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        <?php } else { ?>
                                          <button type="button" class="btn btn-sm btn-warning" onclick="$.addExpense()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        <?php } ?>

                                      </td>
                                    </tr>
                                  <?php
                                    $i++;
                                  }}else{ ?>
                                  <tr>
                                    <td>
                                      <select class="form-select" name="expense[]" aria-label="Default select example">
                                        <option value="">Select Expense</option>
                                        <option value="1">Loading</option>
                                        <option value="2">Unloading</option>
                                        <option value="3">Detention</option>
                                        <option value="4">Munshiana</option>
                                      </select>
                                    </td>
                                    <td><input type="number" name="expense_value[]" id="expense_1" class="form-control"></td>
                                    <td><input class="form-check-input" type="checkbox" name="expense_flag_1" id="expense_flag_1" style="height:30px; width:30px; border-radius: 50%;" onchange="$.billToParty('1');"></td>
                                    <td><button type="button" class="btn btn-sm btn-warning" onclick="$.addExpense()"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                                  </tr>
                                  <?php } ?>

                                </tbody>
                              </table>
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-2">
                              <label class="col-form-label">Guranteed Weight</label>
                              <input type="number" name="guranteed_wt" id="guranteed_wt" onchange="$.calculation()" class="form-control" value="<?= $booking_details['guranteed_wt'] ?>">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Total Freight</label>
                              <input type="number" name="freight" id="freight" onchange="$.calculation()" class="form-control" value="<?= $booking_details['freight'] ?>" readonly>
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Advance</label>
                              <input type="number" name="advance" id="advance" onchange="$.calculation()" class="form-control" value="<?= $booking_details['advance'] ?>">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Discount</label>
                              <input type="number" name="discount" id="discount" onchange="$.calculation()" class="form-control" value="<?= $booking_details['discount'] ?>">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Balance</label>
                              <input type="number" name="balance" id="balance" onchange="$.calculation()" class="form-control" value="<?= $booking_details['balance'] ?>" readonly>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Bill To<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="bill_to" aria-label="Default select example" onchange="">
                                <option value="">Select Party</option>
                                <?php foreach ($customers as $c) {
                                  echo '<option value="' . $c['id'] . '"' . ($booking_details['bill_to_party'] == $c['id'] ? 'selected' : '') . '>' . $c['party_name'] . '</option>';
                                } ?>
                              </select>
                              <?php if ($validation->getError('bill_to')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('bill_to') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-9">
                              <label class="col-form-label">Remarks</label>
                              <input type="text" name="remarks" class="form-control" value="<?= $booking_details['remarks'] ?>">
                            </div>

                          </div>
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary" id="save-btn">Save Changes</button>
                          <button type="reset" class="btn btn-warning">Reset</button>
                          <a href="<?php echo base_url('booking'); ?>" class="btn btn-light">Back</a>
                        </div> 

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
    $.addPickup = function() {
      var tot = $('#pickup_table').children('tbody').children('tr').length;

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('booking/addPickup'); ?>",
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
        url: "<?php echo base_url('booking/addDrop'); ?>",
        data: {
          index: tot
        },
        success: function(data) {
          $('#drop_body').append(data);
        }
      })
    }

    $.addExpense = function() {
      var tot = $('#expense_table').children('tbody').children('tr').length;

      console.log(tot);
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('booking/addExpense'); ?>",
        data: {
          index: tot
        },
        success: function(data) {
          $('#expense_body').append(data);
        }
      })
    }

    $.delete = function(index, str) {
      $('#del_' + str + '_' + index).remove();
    }

    $.getPartyType = function() {

      var customer_id = $('#customer_id').val();
      console.log(customer_id);

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

    $.billToParty = function(index) {
      if ($("#expense_flag_" + index).prop("checked")) {
        $('#expense_' + index).addClass('bill');
      } else {
        $('#expense_' + index).removeClass('bill');
      }

      $.calculation();
    }

    $.calculation = function() {
      var rate_type = parseInt($('#rate_type').val());
      var rate = parseFloat($('#rate').val());
      var freight = 0;


      if (rate_type == 1) {
        //by weight
        $('#guranteed_wt_span').html('*');
        $('#guranteed_wt').attr('required', 'required');
        $('#rate_msg').html(' - Per KG');
      } else {
        //aggregate
        $('#guranteed_wt_span').html('');
        $('#guranteed_wt').removeAttr('required');
        $('#rate_msg').html(' - Overall');
      }


      if (rate > 0) {

        var billtotal = 0;
        $('.bill').each(function() {
          billtotal += parseFloat($(this).val());
        });

        console.log(billtotal);

        freight = freight;

        // for guranteed weight
        if (rate_type == 1) {
          var guranteed_wt = parseFloat($('#guranteed_wt').val());
          freight = (rate * guranteed_wt) + billtotal;
        } else {
          freight = rate + billtotal;
        }

        $('#freight').val(freight);

        var advance = $('#advance').val();
        var discount = $('#discount').val();

        $('#balance').val(freight - advance - discount);


        console.log(rate_type, rate);
      }
    }
  </script>

</body>

</html>