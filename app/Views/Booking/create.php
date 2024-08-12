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
                          <h6>Add Booking</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row g-3">

                          <?php if(isset($booking_type) && ($booking_type== 'PTL' || $booking_type== 'FTL')){ ?>
                            <input type="hidden" name="booking_details" value="<?= $booking_type ?>"/>
                            <input type="hidden" name="id" value="<?= $booking_id ?>"/>
                            <input type="hidden" name="pickup_seq" value="1" class="form-control">
                            <input type="hidden" name="drop_seq" value="1" class="form-control">
                            <div class="col-md-12"></div>
                              
                            <h6>Booking Number: <?= $booking_number ?></h6>  
                            <br/>
                            <h6>Customer: <?= isset($booking_customer['party_name']) ? $booking_customer['party_name'] : '' ?></h6>  
                            <label class="col-form-label">Pickup Details<span class="text-danger">*</span></label>

                            <div class="col-md-3">
                                <label class="col-form-label">State<span class="text-danger">*</span></label>
                                <select class="form-select" name="pickup_state_id" aria-label="Default select example" required onchange="getCitiesByState(this.value,'pickup_city')">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $s) {
                                        echo '<option value="' . $s['state_id'] . '">' . $s['state_name'] . '</option>';
                                        } ?>
                                </select>
                                <?php
                                if ($validation->getError('pickup_state_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_state_id') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">City<span class="text-danger">*</span></label> 
                                <input type="hidden"  name="pickup_city_id" id="pickup_city_id" class="form-control">   
                                <select class="form-select" name="pickup_city" id="pickup_city" aria-label="Default select example" required  onchange="changeCity(this,$(this).find(':selected').attr('pickup_city_id'),'pickup_city_id')">
                                        <option value="">Select </option> 
                                </select>

                                <?php
                                if ($validation->getError('pickup_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_city') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">PinCode</label>
                                <input type="text" name="pickup_pin" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">Pickup Date <span class="text-danger">*</span></label>
                                <input type="date" required name="pickup_date" id="pickup_date"  min="<?= $booking_details['booking_date'] ?>" onchange="$.setDrop();" class="form-control">
                                <?php
                                if ($validation->getError('pickup_date')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_date') . '</div>';
                                }   
                                ?>
                            </div> 
 
                            <label class="col-form-label">Drop Details<span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <label class="col-form-label">State<span class="text-danger">*</span></label>
                                <select class="form-select" name="drop_state_id" aria-label="Default select example" required onchange="getCitiesByState(this.value,'drop_city')">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $s) {
                                        echo '<option value="' . $s['state_id'] . '">' . $s['state_name'] . '</option>';
                                        } ?>
                                </select>
                                <?php
                                if ($validation->getError('drop_state_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('drop_state_id') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">City<span class="text-danger">*</span></label>
                                <input type="hidden"  name="drop_city_id" id="drop_city_id" class="form-control">                               
                                <select class="form-select" name="drop_city" id="drop_city" aria-label="Default select example" required  onchange="changeCity(this,$(this).find(':selected').attr('drop_city_id'),'drop_city_id')">
                                        <option value="">Select </option> 
                                </select>
 
                                <?php
                                if ($validation->getError('drop_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('drop_city') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">PinCode</label>
                                <input type="text" name="drop_pin" class="form-control">
                            </div>
 
                            <div class="col-md-3">
                                <label class="col-form-label">Drop Date</label>
                                <input type="date" name="drop_date" id="drop_date" class="form-control">
                            </div> 
   
                            <div class="col-md-12"></div>

                            <div class="col-md-3">
                              <label class="col-form-label">Rate Type <span class="text-danger">*</span></label>
                              <select class="form-select" name="rate_type" id="rate_type" onchange="$.calculation()" required>
                                <option value="">Select Rate Type</option>
                                <option value="1">By Weight</option>
                                <option value="2">Aggregate</option>
                              </select>
                              <?php
                              if ($validation->getError('rate_type')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('rate_type') . '</div>';
                              }   
                              ?>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Rate (Rs) <span class="text-danger">*</span> <span id="rate_msg"></span></label>
                              <input type="number" name="rate" id="rate" onchange="$.calculation()" class="form-control" required>
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
                                  <tr>
                                    <td>
                                      <select class="form-select" name="expense[]" aria-label="Default select example">
                                        <option value="">Select Expense</option>
                                        <?php if(isset($expense_heads)){
                                          foreach($expense_heads as $val){ ?> 
                                                <option value="<?= $val['id'] ?>"><?= $val['head_name'] ?></option>
                                         <?php }
                                        } ?>
                                        <!-- <option value="1">Loading</option>
                                        <option value="2">Unloading</option>
                                        <option value="3">Detention</option>
                                        <option value="4">Munshiana</option> -->
                                      </select>
                                    </td>
                                    <td><input type="number" name="expense_value[]" id="expense_1" class="form-control not_to_bill" onchange="$.billToParty('1');"></td>
                                    <td><input class="form-check-input" type="checkbox" name="expense_flag_1" id="expense_flag_1" style="height:30px; width:30px; border-radius: 50%;" onchange="$.billToParty('1');"></td>
                                    <td><button type="button" class="btn btn-sm btn-warning" onclick="$.addExpense()"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-3">
                              <label class="col-form-label">Guaranteed / Charged Weight <span class="text-danger" id="guranteed_wt_span"></span></label>
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
                              <input type="number" name="discount" id="discount" onchange="$.calculation()" class="form-control" readonly>
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Balance</label>
                              <input type="number" name="balance" id="balance" class="form-control" readonly>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Bill To<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="bill_to" aria-label="Default select example" onchange="">
                                <option value="">Select Cutomer</option>
                                <?php 
                                $customer_id = isset($booking_details['customer_id']) && ($booking_details['customer_id']>0) ?  $booking_details['customer_id'] : 0;
                                foreach ($customers as $c) { ?>
                                  <option value="<?= $c['id'] ?>" <?= ($customer_id==$c['id']) ? 'selected' : '' ?>><?= $c['party_name'] ?></option>
                                <?php } ?>
                              </select>
                              <?php
                              if ($validation->getError('bill_to')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('bill_to') . '</div>';
                              }   
                              ?>
                            </div>

                            <div class="col-md-9">
                              <label class="col-form-label">Remarks</label>
                              <input type="text" name="remarks" class="form-control">
                            </div>
                          <?php }else { ?>
                            <div class="col-md-3">
                              <label class="col-form-label">Booking For</label>
                              <select class="form-select select2" name="booking_for" id="booking_for" aria-label="Default select example">
                                <option value="">Select Material</option>
                                <option value="1">Material 1</option>
                                <option value="2">Material 2</option>
                                <option value="3">Material 3</option>
                                <option value="4">Material 4</option>
                              </select>
                              <?php
                              if ($validation->getError('booking_for')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_for') . '</div>';
                              }   
                              ?>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="office_id" id="office_id" aria-label="Default select example">
                                <option value="">Select Office</option>
                                <?php foreach ($offices as $o) {
                                  echo '<option value="' . $o['id'] . '">' . $o['name'] . '</option>';
                                } ?>
                              </select>
                              <?php
                              if ($validation->getError('office_id')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
                              }   
                              ?>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Vehicle Type<span class="text-danger">*</span></label>
                              <select class="form-select " required name="vehicle_type" id="vehicle_type" aria-label="Default select example" onchange="$.getVehicles();">
                                <option value="">Select Vehicle Type</option>
                                <?php foreach ($vehicle_types as $vt) {
                                  echo '<option value="' . $vt['id'] . '">' . $vt['name'] . '</option>';
                                } ?>
                              </select>
                              <?php
                              if ($validation->getError('vehicle_type')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('vehicle_type') . '</div>';
                              }   
                              ?>
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
                              <?php
                              if ($validation->getError('customer_id')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('customer_id') . '</div>';
                              }   
                              ?>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Customer Branch<span class="text-danger">*</span></label>
                              <select class="form-select" name="customer_branch" required id="customer_branch" aria-label="Default select example">
                                <option value="">Select Branch</option>
                              </select>
                              <?php
                              if ($validation->getError('customer_branch')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('customer_branch') . '</div>';
                              }   
                              ?>
                              <label id="msg" class="text-danger"></label>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Customer Type</label>
                              <select class="form-select" name="customer_type" id="customer_type" aria-label="Default select example">
                                <option value="">Select Type</option>
                              </select>
                              <input type="hidden" name="lr_first_party" id="lr-txt" />
                              <span class="text-info" id="lr-info"></span>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Booking By<span class="text-danger">*</span></label>
                              <select class="form-select" required name="booking_by" aria-label="Default select example" onchange="">
                                <option value="">Select Employee</option>
                                <?php foreach ($employees as $e) {
                                  echo '<option value="' . $e['id'] . '">' . $e['name'] . '</option>';
                                } ?>
                              </select>
                              <?php
                              if ($validation->getError('booking_by')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_by') . '</div>';
                              }   
                              ?>
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Booking Date<span class="text-danger">*</span></label>
                              <input type="date" required name="booking_date" value="<?= date('Y-m-d') ?>" class="form-control">
                              <?php
                              if ($validation->getError('booking_date')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_date') . '</div>';
                              }   
                              ?>
                            </div>

                            <div class="form-wrap col-md-12"> 
                                <label class="col-form-label" style="padding-right: 10px;">
                                    Booking Type<span class="text-danger">*</span>
                                </label>
                                <input type="radio" name="booking_type" id="FTL" value="FTL" checked required>
                                <label for="FTL" style="padding-right:15px">FTL</label>
                                <input type="radio" name="booking_type" id="PTL" value="PTL" required>
                                <label for="PTL">PTL</label> 

                                <?php
                                if ($validation->getError('booking_type')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_type') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="form-wrap col-md-12"> 
                                <input type="radio" name="next_or_generate_link" id="next" value="next" checked required>
                                <label for="next" style="padding-right:15px">Next</label>
                                <input type="radio" name="next_or_generate_link" id="generate_link" value="generate_link" required>
                                <label for="generate_link">Generate Link</label> 

                                <?php
                                if ($validation->getError('booking_type')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_type') . '</div>';
                                }   
                                ?>
                            </div>

                            <?php } ?>
                          </div>
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary" id="save-btn">Save Changes</button>
                          <a href="./create" class="btn btn-warning">Reset</a>
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
   
    $(function() {        
        $("#customer_type").change(function() {
            if($('option:selected', this).val() > 0){
                $.ajax({
                  method: "POST",
                  url: '<?php echo base_url('booking/getPatyTypeDetails') ?>',
                  data: {
                    customer_id: $('option:selected', this).val()
                  },
                  success: function(response) {
                    $('#lr-txt').val(response); 
                    if(response == 1){
                      $('#lr-info').html('LR is mandatory');                     
                    }else{
                      $('#lr-info').html(''); 
                    }
                    
                  }
                });
            }
        });
    });
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
      $.calculation();
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
          $("#customer_type").trigger('change');
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
        $('#expense_' + index).removeClass('not_to_bill');
      } else {
        $('#expense_' + index).addClass('not_to_bill');
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

      var notbilltotal = 0;
      $('.not_to_bill').each(function() {
        notbilltotal += parseFloat($(this).val());
      });
      $('#discount').val(notbilltotal);

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
 
    function getCitiesByState(val,changed_id){ 
      if(val > 0){
            $.ajax({
              method: "POST",
              url: '<?php echo base_url('booking/getCitiesByState') ?>',
              data: {
                state_id: val
              },
              dataType:'json',
              success: function(response) {
                console.log(response);
                var html ='<option value="0">Select</option>';
                if(response){
                  response.forEach(function(val) {
                      html += '<option value="'+val.city+'" '+changed_id+'_id="'+val.id+'" >'+val.city+'</option>'
                  });
                }
                $('#'+changed_id).html(html);
                $('#'+changed_id).trigger('change');
              }
            });
        }
    }
    $(document).ready(function() {
      var pickup_city =  $("#pickup_city").select2({
        tags: true
      }); 
      var drop_city =  $("#drop_city").select2({
        tags: true
      }); 
    });

    function changeCity(thisv,city_id_val,id){   
      $('#'+id).val( (city_id_val) > 0 ? city_id_val : 0) ;
    }
  </script>

</body>

</html>