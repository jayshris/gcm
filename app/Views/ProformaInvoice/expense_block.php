    <div class="col-md-12 table-responsive">
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
                <tr id="del_expense_<?= $i ?>" class="<?= ($be['bill_to_party'] == 1) ? 'tr-block' : 'tr-readonly'; ?>">
                    <td>
                    <select class="form-select" name="expense[]" aria-label="Default select example">
                        <option value="">Select Expense</option>
                        <?php if(isset($expense_heads) && !empty($expense_heads)){
                        foreach($expense_heads as $val){ ?> 
                                <option value="<?= $val['id'] ?>" <?= $be['expense'] == $val['id'] ? 'selected' : '' ?> ><?= $val['head_name'] ?></option>
                        <?php }
                        } ?> 
                    </select>
                    </td>
                    <td><input type="number" name="expense_value[]" id="expense_<?= $i ?>" value="<?= $be['value'] ?>" class="form-control <?= $be['bill_to_party'] != 1 ? 'not_to_bill' : 'bill' ?>" onchange="$.billToParty('<?= $i ?>');"></td>
                    <td><input class="form-check-input" type="checkbox" name="expense_flag_<?= $i ?>" id="expense_flag_<?= $i ?>" style="height:30px; width:30px; border-radius: 50%;" onchange="$.billToParty('<?= $i ?>');" <?= $be['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                    <td class="tr-block">
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
                    <?php if(isset($expense_heads) && !empty($expense_heads)){
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
    <div class="row g-3">
    <div class="col-md-12"></div>

    <div class="col-md-6">
        <label class="col-form-label">Rate Type</label>
        <input type="hidden" name="rate_type" value="<?= isset($booking_details['rate_type']) ? $booking_details['rate_type'] : 0; ?>"/>
        <select class="form-select" name="rate_type" id="rate_type" onchange="$.calculation()">
        <option value="">Select Rate Type</option>
        <option value="1" <?= isset($booking_details['rate_type']) && ($booking_details['rate_type'] == 1) ? 'selected' : '' ?> >By Weight</option>
        <option value="2" <?= isset($booking_details['rate_type']) && ($booking_details['rate_type'] == 2) ? 'selected' : '' ?> >Aggregate</option>
        </select> 
    </div>

    <div class="col-md-6">
        <label class="col-form-label">Rate (Rs)</label>
        <input type="number" step="0.01"  name="rate" id="rate" onchange="$.calculation()" class="form-control"  value="<?= isset($booking_details['rate']) ? $booking_details['rate'] : '' ?>">     
    </div>
    <div class="col-md-3">
        <label class="col-form-label">Guaranteed / Charged Weight</label>
        <input type="number" step="0.01" name="guranteed_wt" id="guranteed_wt" onchange="$.calculation()" class="form-control" value="<?= ($booking_details['guranteed_wt'] > 0) ? $booking_details['guranteed_wt'] : (isset($booking_vehicle_details['charge_wt']) ? $booking_vehicle_details['charge_wt'] : '') ?>">
    </div> 

    <div class="col-md-3">
        <label class="col-form-label">Total Freight<span class="text-danger">*</span></label>
        <input type="decimal" step="0.01" id="freight" class="form-control" required name="total_freight" readonly value="<?= isset($booking_details['total_freight'])  ? $booking_details['total_freight'] : $booking_details['freight'] ?>" >
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
   
    
