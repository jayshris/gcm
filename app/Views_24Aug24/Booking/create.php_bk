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
                      // print_r($party);
                      ?>
                      <form method="post" enctype="multipart/form-data" action="<?php echo base_url('booking/create'); ?>">

                        <div class="settings-sub-header">
                          <h6>Add Booking</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row g-3">


                            <div class="col-md-3">
                              <label class="col-form-label">Booking For</label>
                              <select class="form-select select2" required name="booking_for" id="booking_for" aria-label="Default select example">
                                <option value="">Select Material</option>
                                <option value="1">Material 1</option>
                                <option value="2">Material 2</option>
                                <option value="3">Material 3</option>
                                <option value="4">Material 4</option>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="office_id" id="office_id" aria-label="Default select example">
                                <option value="">Select Office</option>
                                <?php foreach ($offices as $o) {
                                  echo '<option value="' . $o['id'] . '">' . $o['name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Vehicle Type<span class="text-danger">*</span></label>
                              <select class="form-select " required name="vehicle_type" id="vehicle_type" aria-label="Default select example" onchange="$.getVehicles();">
                                <option value="">Select Vehicle Type</option>
                                <?php foreach ($vehicle_types as $vt) {
                                  echo '<option value="' . $vt['id'] . '">' . $vt['name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Vehicle RC</label>
                              <select class="form-select select2" name="vehicle_rc" id="vehicle_rc" aria-label="Default select example">
                                <option value="">Select Type</option>
                              </select>
                            </div>

                            <div class="col-md-4">
                              <label class="col-form-label">Customer Name<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="customer_id" id="customer_id" aria-label="Default select example" onchange="$.getPartyType();">
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $c) {
                                  echo '<option value="' . $c['id'] . '">' . $c['party_name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Customer Branch<span class="text-danger">*</span></label>
                              <select class="form-select" name="customer_branch" required id="customer_branch" aria-label="Default select example">
                                <option value="">Select Branch</option>
                              </select>
                              <label id="msg" class="text-danger"></label>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Customer Type</label>
                              <select class="form-select" name="customer_type" id="customer_type" aria-label="Default select example">
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
                                  <tr>
                                    <td>
                                      <input type="number" name="pickup_seq[]" value="1" class="form-control">
                                    </td>
                                    <td>
                                      <select class="form-select" name="pickup_state_id[]" aria-label="Default select example" required>
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $s) {
                                          echo '<option value="' . $s['state_id'] . '">' . $s['state_name'] . '</option>';
                                        } ?>
                                      </select>
                                    </td>
                                    <td>
                                      <input type="text" name="pickup_city[]" class="form-control" required>
                                    </td>
                                    <td>
                                      <input type="text" name="pickup_pin[]" class="form-control">
                                    </td>
                                    <td><button type="button" class="btn btn-sm btn-warning" onclick="$.addPickup()"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                                  </tr>

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
                                  <tr>
                                    <td>
                                      <input type="number" name="drop_seq[]" value="1" class="form-control">
                                    </td>
                                    <td>
                                      <select class="form-select" name="drop_state_id[]" aria-label="Default select example" required>
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $s) {
                                          echo '<option value="' . $s['state_id'] . '">' . $s['state_name'] . '</option>';
                                        } ?>
                                      </select>
                                      </select>
                                    </td>
                                    <td>
                                      <input type="text" name="drop_city[]" class="form-control" required>
                                    </td>
                                    <td>
                                      <input type="text" name="drop_pin[]" class="form-control">
                                    </td>
                                    <td><button type="button" class="btn btn-sm btn-warning" onclick="$.addDrop()"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-2">
                              <label class="col-form-label">Pickup Date <span class="text-danger">*</span></label>
                              <input type="date" required name="pickup_date" id="pickup_date" min="<?= date('Y-m-d') ?>" onchange="$.setDrop();" class="form-control">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Drop Date</label>
                              <input type="date" name="drop_date" id="drop_date" class="form-control">
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Booking By<span class="text-danger">*</span></label>
                              <select class="form-select" required name="booking_by" aria-label="Default select example" onchange="">
                                <option value="">Select Employee</option>
                                <?php foreach ($employees as $e) {
                                  echo '<option value="' . $e['id'] . '">' . $e['first_name'] . ' ' . $e['last_name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Booking Date<span class="text-danger">*</span></label>
                              <input type="date" required name="booking_date" min="<?= date('Y-m-d', strtotime('-30 days')) ?>" class="form-control">
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-3">
                              <label class="col-form-label">Rate Type <span class="text-danger">*</span></label>
                              <select class="form-select" name="rate_type" id="rate_type" onchange="$.calculation()" required>
                                <option value="">Select Rate Type</option>
                                <option value="1">By Weight</option>
                                <option value="2">Aggregate</option>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Rate (Rs) <span class="text-danger">*</span> <span id="rate_msg"></span></label>
                              <input type="number" name="rate" id="rate" onchange="$.calculation()" class="form-control" required>
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
                                </tbody>
                              </table>
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-2">
                              <label class="col-form-label">Guranteed Weight <span class="text-danger" id="guranteed_wt_span"></span></label>
                              <input type="number" name="guranteed_wt" id="guranteed_wt" onchange="$.calculation()" class="form-control">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Total Freight</label>
                              <input type="number" name="freight" id="freight" onchange="$.calculation()" class="form-control" readonly>
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Advance</label>
                              <input type="number" name="advance" id="advance" onchange="$.calculation()" class="form-control">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Discount</label>
                              <input type="number" name="discount" id="discount" onchange="$.calculation()" class="form-control">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Balance</label>
                              <input type="number" name="balance" id="balance" class="form-control" readonly>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Bill To<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="bill_to" aria-label="Default select example" onchange="">
                                <option value="">Select Cutomer</option>
                                <?php foreach ($customers as $c) {
                                  echo '<option value="' . $c['id'] . '">' . $c['party_name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-9">
                              <label class="col-form-label">Remarks</label>
                              <input type="text" name="remarks" class="form-control">
                            </div>


                          </div>
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary" id="save-btn">Save Changes</button>
                          <a href="./create" class="btn btn-warning">Reset</a>
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