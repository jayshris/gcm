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
                                                    <h6>Upload POD</h6>
                                                </div>
                                                <div class="profile-details">
                                                    <div class="row mb-3 g-3">
                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Upload Doc<span class="text-danger">*</span></label>
                                                            <input type="file" name="upload_doc" class="form-control" required accept=".png, .jpg, .jpeg,.pdf">
                                                            <?php
                                                            if ($validation->getError('upload_doc')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('upload_doc') . '</div>';
                                                            }   
                                                            ?>
                                                            <span class="text-info" id="lr-info">JPEG,PNG,PDF</span>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Received By<span class="text-danger">*</span></label>
                                                            <input type="text" name="received_by" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="col-form-label">POD Date<span class="text-danger">*</span></label>
                                                            <input type="date" required name="pod_date" min="<?= date('Y-m-d',strtotime($booking_details['booking_date'])) ?>" value="<?= date('Y-m-d');?>" max="<?= date('Y-m-d');?>"  class="form-control">
                                                            <?php
                                                            if ($validation->getError('pod_date')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('pod_date') . '</div>';
                                                            }   
                                                            ?>
                                                        </div> 

                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Remarks</label>
                                                            <input type="text" name="remarks" class="form-control">
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
                                                                    <?php if(isset($expense_heads)){
                                                                        foreach($expense_heads as $val){ ?> 
                                                                            <option value="<?= $val['id'] ?>" <?= $be['expense'] == $val['id'] ? 'selected' : '' ?> ><?= $val['head_name'] ?></option>
                                                                    <?php }
                                                                    } ?> 
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" name="expense_value[]" id="expense_<?= $i ?>" value="<?= $be['value'] ?>" class="form-control <?= $be['bill_to_party'] != 1 ? 'not_to_bill' : 'bill' ?>" onchange="$.billToParty('<?= $i ?>');"></td>
                                                                <td><input class="form-check-input" type="checkbox" name="expense_flag_<?= $i ?>" id="expense_flag_<?= $i ?>" style="height:30px; width:30px; border-radius: 50%;" onchange="$.billToParty('<?= $i ?>');" <?= $be['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                                                                <td>
                                                                    <?php if ($i > 1) { ?>
                                                                    <!-- <button type="button" class="btn btn-sm btn-danger" onclick="$.delete(<?= $i ?>,'expense')"><i class="fa fa-trash" aria-hidden="true"></i></button> -->
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
                                                                    <?php if(isset($expense_heads)){
                                                                    foreach($expense_heads as $val){ ?> 
                                                                            <option value="<?= $val['id'] ?>"><?= $val['head_name'] ?></option>
                                                                    <?php }
                                                                    } ?>
                                                                </select>
                                                                </td>
                                                                <td><input type="number" name="expense_value[]" id="expense_1" class="form-control not_to_bill" onchange="$.billToParty('1');"></td>
                                                                <td><input class="form-check-input" type="checkbox" name="expense_flag_1" id="expense_flag_1" style="height:30px; width:30px; border-radius: 50%;" onchange="$.billToParty('1');"></td>
                                                                <td><button type="button" class="btn btn-sm btn-warning" onclick="$.addExpense()"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                                                            </tr>
                                                            <?php } ?>

                                                            </tbody>
                                                        </table>
                                                        </div>
                                                        

                                                        <div class="col-md-12"></div>

<div class="col-md-6">
    <label class="col-form-label">Rate Type</label>
    <input type="hidden" name="rate_type" value="<?= isset($booking_details['rate_type']) ? $booking_details['rate_type'] : 0; ?>"/>
    <select class="form-select" name="rate_type" disabled id="rate_type" onchange="$.calculation()">
    <option value="">Select Rate Type</option>
    <option value="1" <?= isset($booking_details['rate_type']) && ($booking_details['rate_type'] == 1) ? 'selected' : '' ?> >By Weight</option>
    <option value="2" <?= isset($booking_details['rate_type']) && ($booking_details['rate_type'] == 2) ? 'selected' : '' ?> >Aggregate</option>
    </select> 
</div>

<div class="col-md-6">
    <label class="col-form-label">Rate (Rs)</label>
    <input type="number" step="0.01"  name="rate" id="rate" readonly onchange="$.calculation()" class="form-control"  value="<?= isset($booking_details['rate']) ? $booking_details['rate'] : '' ?>">     
</div>
<div class="col-md-3">
    <label class="col-form-label">Guaranteed / Charged Weight</label>
    <input type="number" step="0.01" name="guranteed_wt" id="guranteed_wt" onchange="$.calculation()" class="form-control" value="<?= ($booking_details['guranteed_wt'] > 0) ? $booking_details['guranteed_wt'] : 0 ?>">
</div> 

<div class="col-md-3">
    <label class="col-form-label">Total Freight<span class="text-danger">*</span></label>
    <input type="decimal" step="0.01" id="freight" class="form-control" required name="freight" readonly value="<?= isset($booking_details['freight'])  ? $booking_details['freight'] : 0 ?>" >
</div>	

<div class="col-md-2">
    <label class="col-form-label">Advance</label>
    <input type="number" name="advance" id="advance" readonly onchange="$.calculation()" class="form-control" value="<?= $booking_details['advance'] ?>">
</div>

<div class="col-md-2">
    <label class="col-form-label">Discount</label>
    <input type="number" name="discount" id="discount" readonly onchange="$.calculation()" class="form-control" value="<?= $booking_details['discount'] ?>">
</div>

<div class="col-md-2">
    <label class="col-form-label">Balance</label>
    <input type="number" name="balance" id="balance" readonly onchange="$.calculation()" class="form-control" value="<?= $booking_details['balance'] ?>" >
</div>
                                                    </div>
                                                </div>
                                                <div class="submit-button mt-3">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    <button type="reset" class="btn btn-info">Reset</button>
                                                    <a href="<?php echo base_url().$currentController; ?>" class="btn btn-light">Back</a>
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

      var notbilltotal = 0;
        $('.not_to_bill').each(function() {
          notbilltotal += parseFloat($(this).val());
        });
        $('#discount').val(notbilltotal.toFixed(2)); 
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

        $('#freight').val(freight.toFixed(2));
		
        var advance = ($('#advance').val());
        var discount = ($('#discount').val());
        var balance = (freight - advance - discount).toFixed(2); 
		// alert(freight + advance +discount + '= '+balance);
        $('#balance').val(balance); 
      }
	  calculate_tax_percent('all'); 
    }

	$.delete = function(index, str) {
      $('#del_' + str + '_' + index).remove();
      $.calculation();
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
    </script>                                                                  
</body>

</html>