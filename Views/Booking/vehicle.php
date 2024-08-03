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
                            <div class="col-md-12"></div> 

                            <div class="col-md-9">

                              <label class="col-form-label">Pickup Details<span class="text-danger">*</span></label>
                              <table class="table table-borderless" id="pickup_table">
                                <tbody id="pickup_body">
                                  <tr> 
                                    <td width="25%">State<span class="text-danger">*</span></td>
                                    <td width="40%">City<span class="text-danger">*</span></td>
                                    <td width="20%">PinCode</td>
                                  </tr>

                                  <?php
                                  $i = 1;
                                  foreach ($booking_pickups as $bp) { ?>

                                    <tr <?= $i > 1 ? 'id="del_pickup_' . $i . '"' : '' ?>>
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
                                    <td width="25%">State<span class="text-danger">*</span></td>
                                    <td width="40%">City<span class="text-danger">*</span></td>
                                    <td width="20%">PinCode</td>
                                  </tr>

                                  <?php
                                  $i = 1;
                                  foreach ($booking_drops as $bd) { ?>

                                    <tr <?= $i > 1 ? 'id="del_drop_' . $i . '"' : '' ?>>
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

                            <div class="col-md-6">
                              <label class="col-form-label">Vehicle Type<span class="text-danger">*</span></label>
                              <select class="form-select" name="vehicle_type" id="vehicle_type" aria-label="Default select example" onchange="$.getVehicles();">
                                <option value="">Select Vehicle Type</option>
                                <?php foreach ($vehicle_types as $vt) {
                                  echo '<option value="' . $vt['id'] . '"  ' . ($booking_details['vehicle_type_id'] == $vt['id'] ? 'selected' : '') . '>' . $vt['name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-5">
                              <label class="col-form-label">Vehicle Number<span class="text-danger">*</span></label>
                              <select class="form-select select2" name="vehicle_rc" id="vehicle_rc" aria-label="Default select example" required  onchange="$.getBookingVehicleDetails();">
                                <option value="">Select Vehicle</option>
                                <?php foreach ($vehicle_rcs as $rc) {
                                  echo '<option value="' . $rc['id'] . '" ' . ($booking_details['vehicle_id'] == $rc['id'] ? 'selected' : '') . '>' . $rc['rc_number'] . ' - ' . $rc['party_name'] . '</option>';
                                } ?>
                              </select>
                            </div> 

                            <div class="row g-3 vehicle_booking_detais">
                              
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
      $.getVehicles();
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
        url: '<?php echo base_url('booking/getUnassignVehicles') ?>',
        data: {
          vehicle_type: vehicle_type,
          booking_id:<?= $booking_details['id'] ?>
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

    $.getBookingVehicleDetails = function() {
      var vehicle_rc = $('#vehicle_rc').val();
      if(vehicle_rc >0 ){
        $.ajax({
          method: "POST",
          url: '<?php echo base_url('booking/getBookingVehicleDetails') ?>',
          data: {
            vehicle_id: vehicle_rc,
            booking_id:<?= $booking_details['id'] ?>
          },
          dataType:'json',
          success: function(response) {
            var booking_details = '';
            $.each(response, function(i, val) {
              booking_details +='<div class="col-md-12"><label class="col-form-label"><b>Customer Name :</b>  '+val.party_name+'</label></div>';

              booking_details +='<div class="col-md-6">'; 
              booking_details +='<h6>Pickup Details</h6><br>';
              booking_details +='<div class="col-md-6"><label class="col-form-label">State :  '+val.bpcity+'</label></div>';
              booking_details +='<div class="col-md-6"><label class="col-form-label">City :  '+val.bpstate+'</label></div>';
              booking_details +='<div class="col-md-6"><label class="col-form-label">PinCode :  '+val.bppin+'</label></div>'; 
              booking_details +='</div>';

              booking_details +='<div class="col-md-6">'; 
              booking_details +='<h6>Pickup Details</h6><br>';
              booking_details +='<div class="col-md-6"><label class="col-form-label">State :  '+val.city+'</label></div>';
              booking_details +='<div class="col-md-6"><label class="col-form-label">City :  '+val.bdstate+'</label></div>';
              booking_details +='<div class="col-md-6"><label class="col-form-label">PinCode :  '+val.pincode+'</label></div>'; 
              booking_details +='</div>';
 
              booking_details +='<br/><hr/>';
            });
           
            $('.vehicle_booking_detais').html(booking_details);
          }
        });
      } 
    }
  </script>

</body>

</html>