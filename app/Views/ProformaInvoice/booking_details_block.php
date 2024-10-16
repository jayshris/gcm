<?php if(!empty($bookings)){ foreach($bookings as $booking){ ?> 
<div class="col-md-1">
<input type="checkbox" class="form-check-input" name="booking_id" id="booking_id" value="<?= $booking['id'] ?>" style="height: 25px; width:25px;margin-top: 34px;" /> 
<input type="hidden" name="rate_type[]" id="rate_type_<?= $booking['id'] ?>" value="<?= isset($booking['rate_type']) && ($booking['rate_type']) ? $booking['rate_type'] : '' ?>" />
<input type="hidden" name="customer_id[]" id="customer_id_<?= $booking['id'] ?>" value="<?= isset($booking['c_id']) && ($booking['c_id']>0) ? $booking['c_id'] : 0 ?>" />
</div>
<div class="col-md-4"> 
    <label class="col-form-label">Booking Order No<span class="text-danger">*</span></label> 
    <input type="text" readonly name="booking_id[]" id="booking_id_<?= $booking['id'] ?>" class="form-control" value="<?= isset($booking['booking_number']) && ($booking['booking_number']) ? $booking['booking_number'] : '' ?>"/>   
</div>

<div class="col-md-4">
    <label class="col-form-label">Customer Name</label>
    <input type="text" readonly id="customer_name[]" class="form-control" value="<?= isset($booking['party_name']) && ($booking['party_name']) ? $booking['party_name'] : '' ?>"/>
</div>	

<div class="row g-3"> 
    <div class="col-md-1"></div>
    <div class="col-md-4"><label class="col-form-label"><b>Particulars: <?= ($booking['particulars']) ? $booking['particulars'] : '-' ?></b></label></div>
    <div class="col-md-4"><label class="col-form-label" style="float: right;"><b>HSN Code: <?= ($booking['hsn_code']) ? $booking['hsn_code'] : '-' ?></b></label></div>
</div> 
<?php }}?>
<div class="alert alert-danger" id="error_msg" hidden></div>
<div class="submit-button">
    <input type="button" class="btn btn-success"  value="Show Data" onclick="show_data()"> 
</div>