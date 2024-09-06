<?php
    $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $last = array_pop($uriSegments);
    if ($last == 'create') {
    $action = 'loadingreceipt/create';
    } else {
    $action = 'loadingreceipt/edit';
    } 
    $validation = \Config\Services::validation();
?>
<div class="profile-details">
    <div class="row g-3">
        <!-- <div class="col-md-4">
            <label class="col-form-label">Vehicle Number</label> 
            <select class="form-select select2" name="vehicle_id" id="vehicle_number" aria-label="Default select example" onchange="$.getVehicleBookings();">
                <option value="">Select</option>
                <?php foreach ($vehicles as $o) { ?> 
                    <option value="<?= $o['id'] ?>"  <?= (isset($loading_receipts['vehicle_id']) && ($loading_receipts['vehicle_id'] == $o['id'])) ? 'selected' : ''?>><?= $o['rc_number'] ?></option> 
                <?php } ?>
            </select>
            <?php
            if ($validation->getError('booking_date')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_date') . '</div>';
            }
            ?>
        </div>

        <div class="col-md-4">
            <label class="col-form-label">Booking Order No<span class="text-danger">*</span></label>
            <select class="form-select select2" required name="booking_id" id="booking_id" aria-label="Default select example"  onchange="$.getBookingDetails();">
                <option value="">Select Booking</option>
                <?php foreach ($bookings as $o) { ?>
                  <option value="<?= $o['id'] ?>" <?= (isset($loading_receipts['booking_id']) && ($loading_receipts['booking_id'] == $o['id'])) ? 'selected' : ''?> ><?= $o['booking_number'] ?></option> 
                <?php } ?>
            </select>
            <?php
            if ($validation->getError('booking_number')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_number') . '</div>';
            }
            ?>
        </div>

        <div class="col-md-4">
            <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
            <select class="form-select select2" required name="office_id" id="office_id" aria-label="Default select example" disabled>
                <option value="">Select Office</option>
                <?php foreach ($offices as $o) {?> 
                <option value="<?= $o['id'] ?>" <?= (isset($loading_receipts['office_id']) && ($loading_receipts['office_id'] == $o['id'])) ? 'selected' : ''?>><?= $o['name'] ?></option>
                <?php  } ?>
            </select>
            <?php
            if ($validation->getError('office_id')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
            }
            ?>
        </div>

        <div class="col-md-4">
            <label class="col-form-label">Booking Date<span class="text-danger">*</span></label>
            <input type="date" name="booking_date" id="booking_date" class="form-control" required value="<?= (isset($loading_receipts['booking_date'])) ?  $loading_receipts['booking_date'] : ''?>">
            <?php
            if ($validation->getError('booking_date')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_date') . '</div>';
            }
            ?>
        </div>
        
        <div class="col-md-4">
            <label class="col-form-label">Loading Station<span class="text-danger">*</span></label>
            <input type="text" name="loading_station" id="loading_station" class="form-control" required value="<?= (isset($loading_receipts['loading_station'])) ?  $loading_receipts['loading_station'] : ''?>">
            <?php
            if ($validation->getError('loading_station')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('loading_station') . '</div>';
            }
            ?>
        </div>

        <div class="col-md-4">
            <label class="col-form-label">Delivery Station<span class="text-danger">*</span></label>
            <input type="text" name="delivery_station" id="delivery_station" class="form-control" required value="<?= (isset($loading_receipts['delivery_station'])) ?  $loading_receipts['delivery_station'] : ''?>">
            <?php
            if ($validation->getError('delivery_station')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('delivery_station') . '</div>';
            }
            ?>
        </div>

        <div class="col-md-4">
            <label class="col-form-label">Consignment Date<span class="text-danger">*</span></label>
            <input type="date" required name="consignment_date" id="consignment_date" min="<?= (isset($loading_receipts['booking_date'])) ?  $loading_receipts['booking_date'] : '' ?>"  class="form-control" value="<?= (isset($loading_receipts['consignment_date'])) ?  $loading_receipts['consignment_date'] : ''?>">
            <?php
            if ($validation->getError('consignment_date')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignment_date') . '</div>';
            }
            ?>
        </div>   														

        <div class="col-md-4">
            <label class="col-form-label">Customer Name</label>
            <input type="text" readonly name="customer_name" id="customer_name"  class="form-control" value="<?= (isset($loading_receipts['customer_name'])) ?  $loading_receipts['customer_name'] : ''?>">
            <?php
            if ($validation->getError('customer_name')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('customer_name') . '</div>';
            }
            ?>
        </div>

        <div class="col-md-4"></div>

        <div class="col-md-4" id="transporter_bilti_no_div" hidden>
            <?php $label = 'Transporter Bilti No';?>
            <label class="col-form-label"><?php echo $label;?><span class="text-danger" <?php echo isset($loading_receipts['transporter_bilti_no']) && ($loading_receipts['transporter_bilti_no'] != '' ) ? '' : 'hidden';?>  id="transporter_bilti_no_span">*</span></label>
            <input type="number" name="transporter_bilti_no" id="transporter_bilti_no" <?= isset($loading_receipts['transporter_bilti_no']) && ($loading_receipts['transporter_bilti_no'] != '') ? 'required' : 'readonly' ?>  class="form-control" value="<?= (isset($loading_receipts['transporter_bilti_no'])) ?  $loading_receipts['transporter_bilti_no'] : ''?>" placeholder="<?php echo $label;?>" autocomplete="off">
            <?php
            if ($validation->getError('transporter_bilti_no')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_bilti_no') . '</div>';
            }
            ?>
        </div>   

        <div class="col-md-4"  id="e_way_bill_no_div" hidden>
            <?php $label = 'E-Way Bill No';?>
            <label class="col-form-label"><?php echo $label;?><span class="text-danger" <?= isset($loading_receipts['e_way_bill_number']) && ($loading_receipts['e_way_bill_number'] != '' ) ? '' : 'hidden' ?> id="e_way_bill_no_span">*</span></label>
            <input type="number" name="e_way_bill_number" id="e_way_bill_no" <?= isset($loading_receipts['e_way_bill_number']) && ($loading_receipts['e_way_bill_number'] != '') ? 'required' : 'readonly' ?> class="form-control" value="<?= (isset($loading_receipts['e_way_bill_number'])) ?  $loading_receipts['e_way_bill_number'] : ''?>" placeholder="<?php echo $label;?>" autocomplete="off">
            <?php
            if ($validation->getError('e_way_bill_number')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('e_way_bill_number') . '</div>';
            }
            ?>
        </div>         
        <div id="transporter_div" class="row g-3" <?= (isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] > 0)) ? '' : 'hidden' ?>>
        <hr>
            <h6>Transporter Details:</h6><br>
            <div class="col-md-4">
                <label class="col-form-label">Transporter Name<span class="text-danger">*</span></label> 
                 <select class="form-select tr-req" name="transporter_id" id="transporter_id" aria-label="Default select example" >
                        <option value="">Select </option> 
                        <?php if(!empty($transporters)){ ?>
                            <?php foreach($transporters as $key => $c){ ?>
                            <option value="<?php echo $c['id'];?>" <?= (isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] == $c['id']) ? 'selected' : '') ?>><?php echo $c['party_name'];?></option>
                            <?php }?>
                        <?php } ?>
                </select>
                <?php
                if ($validation->getError('transporter_id')) {
                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_id') . '</div>';
                }
                ?>
            </div>

            <div class="col-md-4">
                <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                <select class="form-select select2 tr-req"  name="transporter_office_id" id="transporter_office_id" aria-label="Default select example">
                    <option value="">Select Office</option>
                    <?php foreach ($offices as $o) {?> 
                    <option value="<?= $o['id'] ?>" <?= (isset($loading_receipts['transporter_office_id']) && ($loading_receipts['transporter_office_id'] == $o['id'])) ? 'selected' : ''?>><?= $o['name'] ?></option>
                    <?php  } ?>
                </select>
                <?php
                if ($validation->getError('office_id')) {
                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
                }
                ?>
            </div>

            <div class="col-md-12">
                <label class="col-form-label">Address<span class="text-danger">*</span></label>
                <input type="text" name="transporter_address" id="transporter_address" class="form-control tr-req" value="<?= (isset($loading_receipts['transporter_address'])) ?  $loading_receipts['transporter_address'] : ''?>">
                <?php
                if ($validation->getError('transporter_address')) {
                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_address') . '</div>';
                }
                ?>
            </div>

            <div class="col-md-4">
                <label class="col-form-label">City<span class="text-danger">*</span></label>
                <input type="text" name="transporter_city" id="transporter_city" class="form-control tr-req" value="<?= (isset($loading_receipts['transporter_city'])) ?  $loading_receipts['transporter_city'] : ''?>">
                <?php
                if ($validation->getError('transporter_city')) {
                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_city') . '</div>';
                }
                ?>
            </div>

            <div class="col-md-4">
                <label class="col-form-label">State<span class="text-danger">*</span></label> 
                <select class="form-select select2 tr-req" name="transporter_state" id="transporter_state" aria-label="Default select example">
                    <option value="">Select</option>
                    <?php foreach ($states as $o) { ?>
                    <option value="<?= $o['state_id']?>" <?= (isset($loading_receipts['transporter_state']) && ($loading_receipts['transporter_state'] == $o['state_id'])) ? 'selected' : ''?>><?= $o['state_name'] ?></option>
                    <?php } ?>
                </select>
                <?php
                if ($validation->getError('transporter_state')) {
                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_state') . '</div>';
                }
                ?>
            </div>

            <div class="col-md-4">
                <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                <input type="number" name="transporter_pincode" id="transporter_pincode" class="form-control tr-req" value="<?= (isset($loading_receipts['transporter_pincode'])) ?  $loading_receipts['transporter_pincode'] : ''?>">
                <?php
                if ($validation->getError('transporter_pincode')) {
                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_pincode') . '</div>';
                }
                ?>
            </div>

            <div class="col-md-4">
                <label class="col-form-label">GSTIN</label>
                <input type="text" name="transporter_GSTIN" id="transporter_GSTIN" class="form-control tr-req" value="<?= (isset($loading_receipts['transporter_GSTIN'])) ?  $loading_receipts['transporter_GSTIN'] : ''?>">
                <?php
                if ($validation->getError('transporter_GSTIN')) {
                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_GSTIN') . '</div>';
                }
                ?>
            </div>          
        </div>
        <hr> -->

        <div class="col-lg-12 col-md-12 d-flex">
            <div class="security-grid flex-fill">
                <div class="security-header">
                    <div class="security-heading">
                        <h4>Booking Detail:</h4>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="col-form-label">Vehicle Number</label> 
                            <select class="form-select select2" <?= (isset($loading_receipts['is_approved']) && $loading_receipts['is_approved'] == 1) ? 'disabled' : '' ?> name="vehicle_id" id="vehicle_number" aria-label="Default select example" onchange="$.getVehicleBookings();">
                                <option value="">Select Vehicle</option>
                                <?php foreach ($vehicles as $o) { ?> 
                                    <option value="<?= $o['id'] ?>"  <?= (isset($loading_receipts['vehicle_id']) && ($loading_receipts['vehicle_id'] == $o['id'])) ? 'selected' : ''?>><?= $o['rc_number'] ?></option> 
                                <?php } ?>
                            </select>
                            <?php
                            if ($validation->getError('booking_date')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_date') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">Booking Order No<span class="text-danger">*</span></label>
                            <?php if(isset($loading_receipts['is_approved']) && $loading_receipts['is_approved'] == 1){ ?>
                                <input type="hidden" name="booking_id"  value="<?= $loading_receipts['booking_id']?>">
                            <?php } ?>
                            <select class="form-select select2" required <?= (isset($loading_receipts['is_approved']) && $loading_receipts['is_approved'] == 1) ? 'disabled' : '' ?> name="booking_id" id="booking_id" aria-label="Default select example"  onchange="$.getBookingDetails();">
                                <option value="">Select Booking Order</option>
                                <?php foreach ($bookings as $o) { ?>
                                <option value="<?= $o['id'] ?>" <?= (isset($loading_receipts['booking_id']) && ($loading_receipts['booking_id'] == $o['id'])) ? 'selected' : ''?> ><?= $o['booking_number'] ?></option> 
                                <?php } ?>
                            </select> 
                            <?php
                            if ($validation->getError('booking_id')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_id') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                            <select class="form-select select2" required name="office_id" id="office_id" aria-label="Default select example" disabled>
                                <option value="">Select Office</option>
                                <?php foreach ($offices as $o) {?> 
                                <option value="<?= $o['id'] ?>" <?= (isset($loading_receipts['office_id']) && ($loading_receipts['office_id'] == $o['id'])) ? 'selected' : ''?>><?= $o['name'] ?></option>
                                <?php  } ?>
                            </select>
                            <?php
                            if ($validation->getError('office_id')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">Booking Date<span class="text-danger">*</span></label>
                            <input type="date" name="booking_date" id="booking_date" class="form-control" required value="<?= (isset($loading_receipts['booking_date'])) ?  $loading_receipts['booking_date'] : ''?>">
                            <?php
                            if ($validation->getError('booking_date')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking_date') . '</div>';
                            }
                            ?>
                        </div>
                        
                        <div class="col-md-4">
                            <?php 
                            $label = 'Loading Station';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'loading_station','id'=>'loading_station','value'=>set_value('loading_station', (isset($loading_receipts['loading_station']) ? $loading_receipts['loading_station'] : '')),'class'=>'form-control '.(($validation->getError('loading_station')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('loading_station')) ? '<div class="invalid-feedback">'.$validation->getError('loading_station').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'Delivery Station';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'delivery_station','id'=>'delivery_station','value'=>set_value('delivery_station', (isset($loading_receipts['delivery_station']) ? $loading_receipts['delivery_station'] : '')),'class'=>'form-control '.(($validation->getError('delivery_station')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('delivery_station')) ? '<div class="invalid-feedback">'.$validation->getError('delivery_station').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">Consignment Date<span class="text-danger">*</span></label>
                            <input type="date" required name="consignment_date" id="consignment_date" min="<?= (isset($loading_receipts['booking_date'])) ?  $loading_receipts['booking_date'] : '' ?>"  class="form-control" value="<?= (isset($loading_receipts['consignment_date'])) ?  $loading_receipts['consignment_date'] : ''?>">
                            <?php
                            if ($validation->getError('consignment_date')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignment_date') . '</div>';
                            }
                            ?>
                        </div>   														

                        <div class="col-md-4">
                            <?php 
                            $label = 'Customer Name';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'customer_name','id'=>'customer_name','value'=>set_value('customer_name', (isset($loading_receipts['customer_name']) ? $loading_receipts['customer_name'] : '')),'class'=>'form-control '.(($validation->getError('customer_name')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'readonly'=>'readonly']);
                            echo ($validation->getError('customer_name')) ? '<div class="invalid-feedback">'.$validation->getError('customer_name').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4"></div>

                        <div class="col-md-4" id="transporter_bilti_no_div" <?= isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] > 0) ? '' : 'Hidden' ?>>
                            <?php $label = 'Transporter Bilti No';?>
                            <label class="col-form-label"><?php echo $label;?></label>
                            <input type="text" name="transporter_bilti_no" id="transporter_bilti_no" <?= isset($loading_receipts['transporter_bilti_no']) && ($loading_receipts['transporter_bilti_no'] != '') ? '' : 'readonly' ?>  class="form-control" value="<?= (isset($loading_receipts['transporter_bilti_no'])) ?  $loading_receipts['transporter_bilti_no'] : ''?>" placeholder="<?php echo $label;?>" autocomplete="off">
                            <?php
                            if ($validation->getError('transporter_bilti_no')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_bilti_no') . '</div>';
                            }
                            ?>
                        </div>   

                        <div class="col-md-4"  id="e_way_bill_no_div" <?= isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] > 0) ? '' : 'Hidden' ?>>
                            <?php $label = 'E-Way Bill No';?>
                            <label class="col-form-label"><?php echo $label;?></label>
                            <input type="text" name="e_way_bill_number" id="e_way_bill_no" <?= isset($loading_receipts['e_way_bill_number']) && ($loading_receipts['e_way_bill_number'] != '') ? '' : 'readonly' ?> class="form-control" value="<?= (isset($loading_receipts['e_way_bill_number'])) ?  $loading_receipts['e_way_bill_number'] : ''?>" placeholder="<?php echo $label;?>" autocomplete="off">
                            <?php
                            if ($validation->getError('e_way_bill_number')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('e_way_bill_number') . '</div>';
                            }
                            ?>
                        </div>

                        <div id="transporter_div" class="row g-3" <?= (isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] > 0)) ? '' : 'hidden' ?>>
                        <hr>
                            <h6>Transporter Details:</h6><br>
                            <div class="col-md-4">
                                <label class="col-form-label">Transporter Name<span class="text-danger">*</span></label> 
                                <select class="form-select tr-req" name="transporter_id" id="transporter_id" aria-label="Default select example"  onchange="transportedBranches( $(this).find(':selected').val(),'transporter')">
                                        <option value="">Select </option> 
                                        <?php if(!empty($transporters)){ ?>
                                            <?php foreach($transporters as $key => $c){ ?>
                                            <option value="<?php echo $c['id'];?>" <?= (isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] == $c['id']) ? 'selected' : '') ?>><?php echo $c['party_name'];?></option>
                                            <?php }?>
                                        <?php } ?>
                                </select>
                                <?php
                                if ($validation->getError('transporter_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_id') . '</div>';
                                }
                                ?>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                                <select class="form-select select2 tr-req"  name="transporter_office_id" id="transporter_office_id" <?= isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] >0) ? 'required' : 'disabled' ?> >
                                    <option value="">Select Office</option>
                                    <?php foreach ($transport_offices as $o) {?> 
                                    <option value="<?= $o['id'] ?>" <?= (isset($loading_receipts['transporter_office_id']) && ($loading_receipts['transporter_office_id'] == $o['id'])) ? 'selected' : ''?>><?= $o['office_name'] ?></option>
                                    <?php  } ?>
                                </select>
                                <?php
                                if ($validation->getError('office_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
                                }
                                ?>
                            </div>

                            <div class="col-md-12">
                                <label class="col-form-label">Address<span class="text-danger">*</span></label>
                                <input type="text" name="transporter_address" id="transporter_address" class="form-control tr-req" value="<?= (isset($loading_receipts['transporter_address'])) ?  $loading_receipts['transporter_address'] : ''?>">
                                <?php
                                if ($validation->getError('transporter_address')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_address') . '</div>';
                                }
                                ?>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label">City<span class="text-danger">*</span></label>
                                <input type="text" name="transporter_city" id="transporter_city" class="form-control tr-req" value="<?= (isset($loading_receipts['transporter_city'])) ?  $loading_receipts['transporter_city'] : ''?>">
                                <?php
                                if ($validation->getError('transporter_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_city') . '</div>';
                                }
                                ?>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label">State<span class="text-danger">*</span></label> 
                                <select class="form-select select2 tr-req" name="transporter_state" id="transporter_state" aria-label="Default select example">
                                    <option value="">Select</option>
                                    <?php foreach ($states as $o) { ?>
                                    <option value="<?= $o['state_id']?>" <?= (isset($loading_receipts['transporter_state']) && ($loading_receipts['transporter_state'] == $o['state_id'])) ? 'selected' : ''?>><?= $o['state_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <?php
                                if ($validation->getError('transporter_state')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_state') . '</div>';
                                }
                                ?>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                <input type="number" name="transporter_pincode" id="transporter_pincode" class="form-control tr-req" value="<?= (isset($loading_receipts['transporter_pincode'])) ?  $loading_receipts['transporter_pincode'] : ''?>">
                                <?php
                                if ($validation->getError('transporter_pincode')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_pincode') . '</div>';
                                }
                                ?>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label">GSTIN<span class="text-danger">*</span></label>
                                <input type="text" name="transporter_GSTIN" id="transporter_GSTIN" class="form-control tr-req" value="<?= (isset($loading_receipts['transporter_GSTIN'])) ?  $loading_receipts['transporter_GSTIN'] : ''?>">
                                <?php
                                if ($validation->getError('transporter_GSTIN')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('transporter_GSTIN') . '</div>';
                                }
                                ?>
                            </div>          
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 d-flex">
            <div class="security-grid flex-fill">
                <div class="security-header">
                    <div class="security-heading">
                        <h4>Supplier:</h4>
                    </div><hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">Consignor Name<span class="text-danger">*</span></label> 
                            <input type="hidden"  name="consignor_id" id="consignor_id" class="form-control" value="<?= isset($loading_receipts['consignor_id']) ? $loading_receipts['consignor_id'] : '' ?>">   
                            <select class="form-select" name="consignor_name" id="consignor_name" aria-label="Default select example" required onchange="customerBranches( $(this).find(':selected').attr('consignor_id'),'consignor')">
                                    <option value="">Select Consignor</option> 
                                    <?php if(!empty($consignors)){ ?>
                                        <?php foreach($consignors as $key => $c){ ?>
                                        <option value="<?php echo $c;?>" <?= (isset($selected_consignor_name) && ($selected_consignor_name == $c) ? 'selected' : '') ?> consignor_id="<?php echo $key;?>"><?php echo $c;?></option>
                                        <?php }?>
                                    <?php } ?>
                            </select>
                            <?php
                            if ($validation->getError('consignor_name')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignor_name') . '</div>';
                            }
                            ?>
                        </div>

                        <!-- <div class="col-md-4">
                            <label class="col-form-label">Branch Name<span class="text-danger"  <?= isset($loading_receipts['consignor_id']) && ($loading_receipts['consignor_id'] >0 ) ? '' : 'hidden' ?>  id="consignor_branch_span">*</span></label>
                            <select class="form-select select2" <?= isset($loading_receipts['consignor_id']) && ($loading_receipts['consignor_id'] >0) ? 'required' : 'disabled' ?> name="consignor_office_id" id="consignor_office_id" aria-label="Default select example"  onchange="changeIdIpt($(this).val(),$('#consignor_id').val(),'consignor_id')"  >
                                <option value="">Select Branch</option> 
                                <?php if(isset($consignor_branches)) { foreach ($consignor_branches as $o) {?> 
                                <option value="<?= $o['office_name'] ?>" <?= (isset($loading_receipts['consignor_office']) && ($loading_receipts['consignor_office'] == $o['office_name'])) ? 'selected' : ''?>><?= $o['office_name'] ?></option>
                                <?php  }} ?>
                            </select>
                            <?php
                            if ($validation->getError('office_id')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
                            }
                            ?>
                        </div> -->

                        <div class="col-md-12">
                            <?php 
                            $label = 'Address';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>'; ?>
                             <input type="text" name="consignor_address" id="consignor_address" class="form-control <?= (($validation->getError('consignor_address')) ? 'is-invalid' : '') ?>" required value="<?= set_value('consignor_address', (isset($loading_receipts['consignor_address']) ? $loading_receipts['consignor_address'] : '')) ?>"  placeholder='<?=  $label?>'  autocomplete='off'>
                          <?php echo ($validation->getError('consignor_address')) ? '<div class="invalid-feedback">'.$validation->getError('consignor_address').'</div>' : ''; ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'City';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'consignor_city','id'=>'consignor_city','value'=>set_value('consignor_city', (isset($loading_receipts['consignor_city']) ? $loading_receipts['consignor_city'] : '')),'class'=>'form-control '.(($validation->getError('consignor_city')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('consignor_city')) ? '<div class="invalid-feedback">'.$validation->getError('consignor_city').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">State<span class="text-danger">*</span></label> 
                            <select class="form-select select2" required name="consignor_state" id="consignor_state" aria-label="Default select example">
                                <option value="">Select State</option>
                                <?php foreach ($states as $o) { ?>
                                <option value="<?= $o['state_id']?>" <?= (isset($loading_receipts['consignor_state']) && ($loading_receipts['consignor_state'] == $o['state_id'])) ? 'selected' : ''?>><?= $o['state_name'] ?></option>
                                <?php } ?>
                            </select>
                            <?php
                            if ($validation->getError('consignor_state')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignor_state') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'Pincode';
                            echo '<label class="col-form-label">'.$label.'</label>';
                            echo form_input(['name'=>'consignor_pincode','id'=>'consignor_pincode','value'=>set_value('consignor_pincode', (isset($loading_receipts['consignor_pincode']) ? $loading_receipts['consignor_pincode'] : '')),'class'=>'form-control '.(($validation->getError('consignor_pincode')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'oninput'=>"this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"]);
                            echo ($validation->getError('consignor_pincode')) ? '<div class="invalid-feedback">'.$validation->getError('consignor_pincode').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-6">
                            <?php 
                            $isrequired = ($currentMethod=='approve') ? ['required' => 'required'] : [];  
                            $required = ($currentMethod=='approve') ? '<span class="text-danger">*</span>' : '';  
                            $label = 'GSTIN '; 
                            echo '<label class="col-form-label">'.$label.$required.' </label>';
                            echo form_input(['name'=>'consignor_GSTIN','id'=>'consignor_GSTIN','value'=>set_value('consignor_GSTIN', (isset($loading_receipts['consignor_GSTIN']) ? $loading_receipts['consignor_GSTIN'] : '')),'class'=>'form-control '.(($validation->getError('consignor_GSTIN')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off'] + $isrequired);
                            echo ($validation->getError('consignor_GSTIN')) ? '<div class="invalid-feedback">'.$validation->getError('consignor_GSTIN').'</div>' : '';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 d-flex">
            <div class="security-grid flex-fill">
                <div class="security-header">
                    <div class="security-heading">
                        <h4>Dispatch From:</h4>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                            $label = 'Name';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'place_of_dispatch_name','id'=>'place_of_dispatch_name','value'=>set_value('place_of_dispatch_name', (isset($loading_receipts['place_of_dispatch_name']) ? $loading_receipts['place_of_dispatch_name'] : '')),'class'=>'form-control '.(($validation->getError('place_of_dispatch_name')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('place_of_dispatch_name')) ? '<div class="invalid-feedback">'.$validation->getError('place_of_dispatch_name').'</div>' : '';
                            ?>
                        </div> 

                        <div class="col-md-4">
                            <label class="col-form-label">Branch Name<span class="text-danger"  <?= isset($loading_receipts['consignor_id']) && ($loading_receipts['consignor_id'] >0 ) ? '' : 'hidden' ?>  id="consignor_branch_span">*</span></label>
                            <select class="form-select select2" <?= isset($loading_receipts['consignor_id']) && ($loading_receipts['consignor_id'] >0) ? 'required' : 'disabled' ?> name="consignor_office_id" id="consignor_office_id" aria-label="Default select example"  onchange="changeIdIpt($(this).val(),$('#consignor_id').val(),'consignor_id')"  >
                                <option value="">Select Branch</option> 
                                <?php if(isset($consignor_branches)) { foreach ($consignor_branches as $o) {?> 
                                <option value="<?= $o['office_name'] ?>" <?= (isset($loading_receipts['consignor_office']) && ($loading_receipts['consignor_office'] == $o['office_name'])) ? 'selected' : ''?>><?= $o['office_name'] ?></option>
                                <?php  }} ?>
                            </select>
                            <?php
                            if ($validation->getError('office_id')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-12">
                            <?php 
                            $label = 'Address';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'place_of_dispatch_address','id'=>'place_of_dispatch_address','value'=>set_value('place_of_dispatch_address', (isset($loading_receipts['place_of_dispatch_address']) ? $loading_receipts['place_of_dispatch_address'] : '')),'class'=>'form-control '.(($validation->getError('place_of_dispatch_address')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('place_of_dispatch_address')) ? '<div class="invalid-feedback">'.$validation->getError('place_of_dispatch_address').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'City';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'place_of_dispatch_city','id'=>'place_of_dispatch_city','value'=>set_value('place_of_dispatch_city', (isset($loading_receipts['place_of_dispatch_city']) ? $loading_receipts['place_of_dispatch_city'] : '')),'class'=>'form-control '.(($validation->getError('place_of_dispatch_city')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('place_of_dispatch_city')) ? '<div class="invalid-feedback">'.$validation->getError('place_of_dispatch_city').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">State<span class="text-danger">*</span></label> 
                            <select class="form-select select2" required name="place_of_dispatch_state" id="place_of_dispatch_state" aria-label="Default select example">
                                <option value="">Select State</option>
                                <?php foreach ($states as $o) { ?> 
                                <option value="<?= $o['state_id'] ?>" <?= (isset($loading_receipts['place_of_dispatch_state']) && ($loading_receipts['place_of_dispatch_state'] == $o['state_id'])) ? 'selected' : ''?> ><?= $o['state_name'] ?></option> 
                                <?php } ?>
                            </select> 
                            <?php
                            if ($validation->getError('place_of_dispatch_state')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_dispatch_state') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'Pincode';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'place_of_dispatch_pincode','id'=>'place_of_dispatch_pincode','value'=>set_value('place_of_dispatch_pincode', (isset($loading_receipts['place_of_dispatch_pincode']) ? $loading_receipts['place_of_dispatch_pincode'] : '')),'class'=>'form-control '.(($validation->getError('place_of_dispatch_pincode')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'oninput'=>"this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');",]);
                            echo ($validation->getError('place_of_dispatch_pincode')) ? '<div class="invalid-feedback">'.$validation->getError('place_of_dispatch_pincode').'</div>' : '';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>   

        <div class="col-lg-6 col-md-6 d-flex">
            <div class="security-grid flex-fill">
                <div class="security-header">
                    <div class="security-heading">
                        <h4>Recipient:</h4>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">Consignee Name<span class="text-danger">*</span></label>
                            <input type="hidden"  name="consignee_id" id="consignee_id" class="form-control" value="<?= isset($loading_receipts['consignor_id']) ? $loading_receipts['consignor_id'] : '' ?>">   
                            <select class="form-select" name="consignee_name" id="consignee_name" aria-label="Default select example" required onchange="customerBranches( $(this).find(':selected').attr('consignee_id'),'consignee')">
                                    <option value="">Select Consignee</option> 
                                    <?php if(!empty($consignees)){ ?>
                                        <?php foreach($consignees as $key => $c){ ?>
                                        <option value="<?php echo $c;?>" <?= ((isset($selected_consignee_name)) && ($selected_consignee_name == $c) ? 'selected' : '') ?> consignee_id="<?php echo $key;?>"><?php echo $c;?></option>
                                        <?php }?>
                                    <?php } ?>
                            </select>
                            <?php
                            if ($validation->getError('consignee_name')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignee_name') . '</div>';
                            }
                            ?>
                        </div>

                        <!-- <div class="col-md-4">
                            <label class="col-form-label">Branch Name<span class="text-danger" <?= isset($loading_receipts['consignee_id']) && ($loading_receipts['consignee_id'] >0 ) ? '' : 'hidden' ?>   id="consignee_branch_span">*</span></label>
                            <select class="form-select select2" <?= isset($loading_receipts['consignee_id']) && ($loading_receipts['consignee_id'] >0) ? 'required' : 'disabled' ?> name="consignee_office_id" id="consignee_office_id" aria-label="Default select example"  onchange="changeIdIpt($(this).val(),$('#consignee_id').val(),'consignee_id','consignee')" >
                                <option value="">Select Branch</option>
                                <?php if(isset($consignee_branches)) { foreach ($consignee_branches as $o) {?> 
                                <option value="<?= $o['office_name'] ?>" <?= (isset($loading_receipts['consignee_office']) && ($loading_receipts['consignee_office'] == $o['office_name'])) ? 'selected' : ''?>><?= $o['office_name'] ?></option>
                                <?php  }} ?>
                            </select>
                            <?php
                            if ($validation->getError('office_id')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
                            }
                            ?>
                        </div> -->

                        <div class="col-md-12">
                            <?php 
                            $label = 'Address';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'consignee_address','id'=>'consignee_address','value'=>set_value('consignee_address', (isset($loading_receipts['consignee_address']) ? $loading_receipts['consignee_address'] : '')),'class'=>'form-control '.(($validation->getError('consignee_address')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('consignee_address')) ? '<div class="invalid-feedback">'.$validation->getError('consignee_address').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'City';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'consignee_city','id'=>'consignee_city','value'=>set_value('consignee_city', (isset($loading_receipts['consignee_city']) ? $loading_receipts['consignee_city'] : '')),'class'=>'form-control '.(($validation->getError('consignee_city')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('consignee_city')) ? '<div class="invalid-feedback">'.$validation->getError('consignee_city').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">State<span class="text-danger">*</span></label> 
                            <select class="form-select select2" required name="consignee_state" id="consignee_state" aria-label="Default select example">
                                <option value="">Select State</option>
                                <?php foreach ($states as $o) { ?> 
                                <option value="<?= $o['state_id'] ?>" <?= (isset($loading_receipts['consignee_state']) && ($loading_receipts['consignee_state'] == $o['state_id'])) ? 'selected' : ''?> ><?= $o['state_name'] ?></option> 
                                <?php } ?>
                            </select>
                            <?php
                            if ($validation->getError('consignee_state')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignee_state') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'Pincode';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'consignee_pincode','id'=>'consignee_pincode','value'=>set_value('consignee_pincode', (isset($loading_receipts['consignee_pincode']) ? $loading_receipts['consignee_pincode'] : '')),'class'=>'form-control '.(($validation->getError('consignee_pincode')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'oninput'=>"this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"]);
                            echo ($validation->getError('consignee_pincode')) ? '<div class="invalid-feedback">'.$validation->getError('consignee_pincode').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $isrequired = ($currentMethod=='approve') ? ['required' => 'required'] : [];  
                            $required = ($currentMethod=='approve') ? '<span class="text-danger">*</span>' : '';  
                            $label = 'GSTIN';
                            echo '<label class="col-form-label">'.$label.$required.'</label>';
                            echo form_input(['name'=>'consignee_GSTIN','id'=>'consignee_GSTIN','value'=>set_value('consignee_GSTIN', (isset($loading_receipts['consignee_GSTIN']) ? $loading_receipts['consignee_GSTIN'] : '')),'class'=>'form-control '.(($validation->getError('consignee_GSTIN')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off']+$isrequired);
                            echo ($validation->getError('consignee_GSTIN')) ? '<div class="invalid-feedback">'.$validation->getError('consignee_GSTIN').'</div>' : '';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 d-flex">
            <div class="security-grid flex-fill">
                <div class="security-header">
                    <div class="security-heading">
                        <h4>Ship To:</h4>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                            $label = 'Name';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'place_of_delivery_name','id'=>'place_of_delivery_name','value'=>set_value('place_of_delivery_name', (isset($loading_receipts['place_of_delivery_name']) ? $loading_receipts['place_of_delivery_name'] : '')),'class'=>'form-control '.(($validation->getError('place_of_delivery_name')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('place_of_delivery_name')) ? '<div class="invalid-feedback">'.$validation->getError('place_of_delivery_name').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">Branch Name<span class="text-danger" <?= isset($loading_receipts['consignee_id']) && ($loading_receipts['consignee_id'] >0 ) ? '' : 'hidden' ?>   id="consignee_branch_span">*</span></label>
                            <select class="form-select select2" <?= isset($loading_receipts['consignee_id']) && ($loading_receipts['consignee_id'] >0) ? 'required' : 'disabled' ?> name="consignee_office_id" id="consignee_office_id" aria-label="Default select example"  onchange="changeIdIpt($(this).val(),$('#consignee_id').val(),'consignee_id','consignee')" >
                                <option value="">Select Branch</option>
                                <?php if(isset($consignee_branches)) { foreach ($consignee_branches as $o) {?> 
                                <option value="<?= $o['office_name'] ?>" <?= (isset($loading_receipts['consignee_office']) && ($loading_receipts['consignee_office'] == $o['office_name'])) ? 'selected' : ''?>><?= $o['office_name'] ?></option>
                                <?php  }} ?>
                            </select>
                            <?php
                            if ($validation->getError('office_id')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-12">
                            <?php 
                            $label = 'Address';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'place_of_delivery_address','id'=>'place_of_delivery_address','value'=>set_value('place_of_delivery_address', (isset($loading_receipts['place_of_delivery_address']) ? $loading_receipts['place_of_delivery_address'] : '')),'class'=>'form-control '.(($validation->getError('place_of_delivery_address')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('place_of_delivery_address')) ? '<div class="invalid-feedback">'.$validation->getError('place_of_delivery_address').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'City';
                            echo '<label class="col-form-label">'.$label.' <span class="text-danger">*</span></label>';
                            echo form_input(['name'=>'place_of_delivery_city','id'=>'place_of_delivery_city','value'=>set_value('place_of_delivery_city', (isset($loading_receipts['place_of_delivery_city']) ? $loading_receipts['place_of_delivery_city'] : '')),'class'=>'form-control '.(($validation->getError('place_of_delivery_city')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'required'=>'required']);
                            echo ($validation->getError('place_of_delivery_city')) ? '<div class="invalid-feedback">'.$validation->getError('place_of_delivery_city').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">State<span class="text-danger">*</span></label> 
                            <select class="form-select select2" required name="place_of_delivery_state" id="place_of_delivery_state" aria-label="Default select example">
                                <option value="">Select State</option>
                                <?php foreach ($states as $o) { ?> 
                                <option value="<?= $o['state_id'] ?>" <?= (isset($loading_receipts['place_of_delivery_state']) && ($loading_receipts['place_of_delivery_state'] == $o['state_id'])) ? 'selected' : ''?> ><?= $o['state_name'] ?></option> 
                                <?php } ?>
                            </select>
                            <?php
                            if ($validation->getError('place_of_delivery_state')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_delivery_state') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'Pincode';
                            echo '<label class="col-form-label">'.$label.'</label>';
                            echo form_input(['name'=>'place_of_delivery_pincode','id'=>'place_of_delivery_pincode','value'=>set_value('place_of_delivery_pincode', (isset($loading_receipts['place_of_delivery_pincode']) ? $loading_receipts['place_of_delivery_pincode'] : '')),'class'=>'form-control '.(($validation->getError('place_of_delivery_pincode')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off', 'oninput'=>"this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"]);
                            echo ($validation->getError('place_of_delivery_pincode')) ? '<div class="invalid-feedback">'.$validation->getError('place_of_delivery_pincode').'</div>' : '';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           

        <div class="col-lg-12 col-md-12 d-flex">
            <div class="security-grid flex-fill">
                <div class="security-header">
                    <div class="security-heading">
                        <h4>Material Details:</h4>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <?php 
                            $label = 'Particulars';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'particulars','id'=>'particulars','value'=>set_value('particulars', (isset($loading_receipts['particulars']) ? $loading_receipts['particulars'] : '')),'class'=>'form-control '.(($validation->getError('particulars')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off']);
                            echo ($validation->getError('particulars')) ? '<div class="invalid-feedback">'.$validation->getError('particulars').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'HSN Code';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'hsn_code','id'=>'hsn_code','value'=>set_value('hsn_code', (isset($loading_receipts['hsn_code']) ? $loading_receipts['hsn_code'] : '')),'class'=>'form-control '.(($validation->getError('hsn_code')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"]);
                            echo ($validation->getError('hsn_code')) ? '<div class="invalid-feedback">'.$validation->getError('hsn_code').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'No. of Packages';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'no_of_packages','id'=>'no_of_packages','value'=>set_value('no_of_packages', (isset($loading_receipts['no_of_packages']) ? $loading_receipts['no_of_packages'] : '')),'class'=>'form-control '.(($validation->getError('no_of_packages')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off']);
                            echo ($validation->getError('no_of_packages')) ? '<div class="invalid-feedback">'.$validation->getError('no_of_packages').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'Actual Weight';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'actual_weight','id'=>'actual_weight','value'=>set_value('actual_weight', (isset($loading_receipts['actual_weight']) ? $loading_receipts['actual_weight'] : '')),'class'=>'form-control '.(($validation->getError('actual_weight')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"]);
                            echo ($validation->getError('actual_weight')) ? '<div class="invalid-feedback">'.$validation->getError('actual_weight').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'Charge Weight';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'charge_weight','id'=>'charge_weight','value'=>set_value('charge_weight', (isset($loading_receipts['charge_weight']) ? $loading_receipts['charge_weight'] : '')),'class'=>'form-control '.(($validation->getError('charge_weight')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"]);
                            echo ($validation->getError('charge_weight')) ? '<div class="invalid-feedback">'.$validation->getError('charge_weight').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4" id="payment_terms_div" hidden>
                            <?php 
                            $label = 'Terms';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'payment_terms','id'=>'payment_terms','value'=>set_value('payment_terms', (isset($loading_receipts['payment_terms']) ? $loading_receipts['payment_terms'] : '')),'class'=>'form-control '.(($validation->getError('payment_terms')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off']);
                            echo ($validation->getError('payment_terms')) ? '<div class="invalid-feedback">'.$validation->getError('payment_terms').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4" id="e_way_bill_number_div" <?= isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] > 0) ? 'Hidden' : '' ?>>
                            <?php 
                            $label = 'E-Way Bill No';
                            $isdisabled= isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] > 0) ? 'disabled' : '';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'e_way_bill_number','id'=>'e_way_bill_number','value'=>set_value('e_way_bill_number', (isset($loading_receipts['e_way_bill_number']) ? $loading_receipts['e_way_bill_number'] : '')),'class'=>'form-control '.(($validation->getError('e_way_bill_number')) ? 'is-invalid' : ''), 'placeholder'=>$label, 'autocomplete'=>'off','disabled' => $isdisabled]);
                            echo ($validation->getError('e_way_bill_number')) ? '<div class="invalid-feedback">'.$validation->getError('e_way_bill_number').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-4" id="e_way_expiry_date_div" <?= isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] > 0) ? 'Hidden' : '' ?>>
                            <label class="col-form-label">E-WAY Bill Expiry Date</label>
                            <input type="date" name="e_way_expiry_date" id="e_way_expiry_date" class="form-control" value="<?= (isset($loading_receipts['e_way_expiry_date'])) ?  $loading_receipts['e_way_expiry_date'] : ''?>">
                            <?php
                            if ($validation->getError('e_way_expiry_date')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('e_way_expiry_date') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php 
                            $label = 'Freight Charges Amount';
                            echo '<label class="col-form-label">'.$label.' </label>';
                            echo form_input(['name'=>'freight_charges_amount','id'=>'freight_charges_amount','value'=>set_value('freight_charges_amount', (isset($loading_receipts['freight_charges_amount']) ? $loading_receipts['freight_charges_amount'] : '')),'class'=>'form-control '.(($validation->getError('freight_charges_amount')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"]);
                            echo ($validation->getError('freight_charges_amount')) ? '<div class="invalid-feedback">'.$validation->getError('freight_charges_amount').'</div>' : '';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

        <div class="col-lg-4 col-md-4 d-flex">
            <div class="security-grid flex-fill">
                <div class="security-header">
                    <div class="security-heading">
                        <h4>Party Document Details:</h4>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                            $label = 'Invoice/BOE No.';
                            echo '<label class="col-form-label">'.$label.'</label>';
                            echo form_input(['name'=>'invoice_boe_no','id'=>'invoice_boe_no','value'=>set_value('invoice_boe_no', (isset($loading_receipts['invoice_boe_no']) ? $loading_receipts['invoice_boe_no'] : '')),'class'=>'form-control '.(($validation->getError('invoice_boe_no')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off']);
                            echo ($validation->getError('invoice_boe_no')) ? '<div class="invalid-feedback">'.$validation->getError('invoice_boe_no').'</div>' : '';
                            ?>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label">Invoice/BOE Date</label>
                            <input type="datetime-local" name="invoice_boe_date" id="invoice_boe_date" class="form-control" value="<?= (isset($loading_receipts['invoice_boe_date'])) ?  $loading_receipts['invoice_boe_date'] : ''?>">
                            <?php
                            if ($validation->getError('invoice_boe_date')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('invoice_boe_date') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-6">
                            <?php 
                            $label = 'Invoice Value';
                            echo '<label class="col-form-label">'.$label.'</label>';
                            echo form_input(['name'=>'invoice_value','id'=>'invoice_value','value'=>set_value('invoice_value', (isset($loading_receipts['invoice_value']) ? $loading_receipts['invoice_value'] : '')),'class'=>'form-control '.(($validation->getError('invoice_value')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off', 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"]);
                            echo ($validation->getError('invoice_value')) ? '<div class="invalid-feedback">'.$validation->getError('invoice_value').'</div>' : '';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

        <div class="col-lg-4 col-md-4 d-flex">
            <div class="security-grid flex-fill">
                <div class="security-header">
                    <div class="security-heading">
                        <h4>Transit Insurance (Dispatch Details):</h4>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">Reporting Date/Time</label>
                            <input type="datetime-local" name="reporting_datetime" id="reporting_datetime" class="form-control" value="<?= (isset($loading_receipts['reporting_datetime'])) ?  $loading_receipts['reporting_datetime'] : ''?>">
                            <?php
                            if ($validation->getError('reporting_datetime')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('reporting_datetime') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label">Releasing Date/Time</label>
                            <input type="datetime-local" name="releasing_datetime" id="releasing_datetime" class="form-control" value="<?= (isset($loading_receipts['releasing_datetime'])) ?  $loading_receipts['releasing_datetime'] : ''?>">
                            <?php
                            if ($validation->getError('releasing_datetime')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('releasing_datetime') . '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

        <div class="col-lg-4 col-md-4 d-flex">
            <div class="security-grid flex-fill">
                <div class="security-header">
                    <div class="security-heading">
                        <h4>Transit Insurance (Insurance Co.):</h4>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">Policy Date</label>
                            <input type="date" name="policy_date" id="policy_date" class="form-control" value="<?= (isset($loading_receipts['policy_date'])) ?  $loading_receipts['policy_date'] : ''?>">
                            <?php
                            if ($validation->getError('policy_date')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('policy_date') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="col-md-6">
                            <?php 
                            $label = 'Policy Number';
                            echo '<label class="col-form-label">'.$label.'</label>';
                            echo form_input(['name'=>'policy_no','id'=>'policy_no','value'=>set_value('policy_no', (isset($loading_receipts['policy_no']) ? $loading_receipts['policy_no'] : '')),'class'=>'form-control '.(($validation->getError('policy_no')) ? 'is-invalid' : ''),'placeholder'=>$label,'autocomplete'=>'off']);
                            echo ($validation->getError('policy_no')) ? '<div class="invalid-feedback">'.$validation->getError('policy_no').'</div>' : '';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <h6>Supplier:</h6>
        <div class="col-md-4">
            <label class="col-form-label">Consignor Name<span class="text-danger">*</span></label> 
            <input type="hidden"  name="consignor_id" id="consignor_id" class="form-control" value="<?= isset($loading_receipts['consignor_id']) ? $loading_receipts['consignor_id'] : '' ?>">   
            <select class="form-select" name="consignor_name" id="consignor_name" aria-label="Default select example" required onchange="customerBranches( $(this).find(':selected').attr('consignor_id'),'consignor')">
                    <option value="">Select </option> 
                    <?php if(!empty($consignors)){ ?>
                        <?php foreach($consignors as $key => $c){ ?>
                        <option value="<?php echo $c;?>" <?= (isset($selected_consignor_name) && ($selected_consignor_name == $c) ? 'selected' : '') ?> consignor_id="<?php echo $key;?>"><?php echo $c;?></option>
                        <?php }?>
                    <?php } ?>
            </select>
            <?php
            if ($validation->getError('consignor_name')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignor_name') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Branch Name<span class="text-danger"  <?= isset($loading_receipts['consignor_id']) && ($loading_receipts['consignor_id'] >0 ) ? '' : 'hidden' ?>  id="consignor_branch_span">*</span></label>
            <select class="form-select select2" <?= isset($loading_receipts['consignor_id']) && ($loading_receipts['consignor_id'] >0) ? 'required' : 'disabled' ?> name="consignor_office_id" id="consignor_office_id" aria-label="Default select example"  onchange="changeIdIpt($(this).val(),$('#consignor_id').val(),'consignor_id')"  >
                <option value="">Select Office</option> 
                <?php if(isset($consignor_branches)) { foreach ($consignor_branches as $o) {?> 
                <option value="<?= $o['office_name'] ?>" <?= (isset($loading_receipts['consignor_office']) && ($loading_receipts['consignor_office'] == $o['office_name'])) ? 'selected' : ''?>><?= $o['office_name'] ?></option>
                <?php  }} ?>
            </select>
            <?php
            if ($validation->getError('office_id')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-12">
            <label class="col-form-label">Address<span class="text-danger">*</span></label>
            <input type="text" name="consignor_address" id="consignor_address" class="form-control" required value="<?= (isset($loading_receipts['consignor_address'])) ?  $loading_receipts['consignor_address'] : ''?>">
            <?php
            if ($validation->getError('consignor_address')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignor_address') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">City<span class="text-danger">*</span></label>
            <input type="text" name="consignor_city" id="consignor_city" class="form-control" required value="<?= (isset($loading_receipts['consignor_city'])) ?  $loading_receipts['consignor_city'] : ''?>">
            <?php
            if ($validation->getError('consignor_city')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignor_city') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">State<span class="text-danger">*</span></label> 
            <select class="form-select select2" required name="consignor_state" id="consignor_state" aria-label="Default select example">
                <option value="">Select</option>
                <?php foreach ($states as $o) { ?>
                  <option value="<?= $o['state_id']?>" <?= (isset($loading_receipts['consignor_state']) && ($loading_receipts['consignor_state'] == $o['state_id'])) ? 'selected' : ''?>><?= $o['state_name'] ?></option>
                <?php } ?>
            </select>
            <?php
            if ($validation->getError('consignor_state')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignor_state') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
            <input type="number" name="consignor_pincode" id="consignor_pincode" class="form-control" required  value="<?= (isset($loading_receipts['consignor_pincode'])) ?  $loading_receipts['consignor_pincode'] : ''?>">
            <?php
            if ($validation->getError('consignor_pincode')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignor_pincode') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">GSTIN</label>
            <input type="text" name="consignor_GSTIN" id="consignor_GSTIN" class="form-control" value="<?= (isset($loading_receipts['consignor_GSTIN'])) ?  $loading_receipts['consignor_GSTIN'] : ''?>">
            <?php
            if ($validation->getError('consignor_GSTIN')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignor_GSTIN') . '</div>';
            }
            ?>
        </div>       
        <hr>
        
        <h6>Recipient:</h6>        
        <div class="col-md-4">
            <label class="col-form-label">Consignee Name<span class="text-danger">*</span></label>
            <input type="hidden"  name="consignee_id" id="consignee_id" class="form-control" value="<?= isset($loading_receipts['consignor_id']) ? $loading_receipts['consignor_id'] : '' ?>">   
            <select class="form-select" name="consignee_name" id="consignee_name" aria-label="Default select example" required onchange="customerBranches( $(this).find(':selected').attr('consignee_id'),'consignee')">
                    <option value="">Select </option> 
                    <?php if(!empty($consignees)){ ?>
                        <?php foreach($consignees as $key => $c){ ?>
                        <option value="<?php echo $c;?>" <?= ((isset($selected_consignee_name)) && ($selected_consignee_name == $c) ? 'selected' : '') ?> consignee_id="<?php echo $key;?>"><?php echo $c;?></option>
                        <?php }?>
                    <?php } ?>
            </select>
            <?php
            if ($validation->getError('consignee_name')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignee_name') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Branch Name<span class="text-danger" <?= isset($loading_receipts['consignee_id']) && ($loading_receipts['consignee_id'] >0 ) ? '' : 'hidden' ?>   id="consignee_branch_span">*</span></label>
            <select class="form-select select2" <?= isset($loading_receipts['consignee_id']) && ($loading_receipts['consignee_id'] >0) ? 'required' : 'disabled' ?> name="consignee_office_id" id="consignee_office_id" aria-label="Default select example"  onchange="changeIdIpt($(this).val(),$('#consignee_id').val(),'consignee_id','consignee')" >
                <option value="">Select Office</option>
                <?php if(isset($consignee_branches)) { foreach ($consignee_branches as $o) {?> 
                <option value="<?= $o['office_name'] ?>" <?= (isset($loading_receipts['consignee_office']) && ($loading_receipts['consignee_office'] == $o['office_name'])) ? 'selected' : ''?>><?= $o['office_name'] ?></option>
                <?php  }} ?>
            </select>
            <?php
            if ($validation->getError('office_id')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('office_id') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-12">
            <label class="col-form-label">Address<span class="text-danger">*</span></label>
            <input type="text" name="consignee_address" id="consignee_address" class="form-control" required value="<?= (isset($loading_receipts['consignee_address'])) ?  $loading_receipts['consignee_address'] : ''?>">
            <?php
            if ($validation->getError('consignee_address')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignee_address') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">City<span class="text-danger">*</span></label>
            <input type="text" name="consignee_city" id="consignee_city" class="form-control" required value="<?= (isset($loading_receipts['consignee_city'])) ?  $loading_receipts['consignee_city'] : ''?>">
            <?php
            if ($validation->getError('consignee_city')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignee_city') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">State<span class="text-danger">*</span></label> 
            <select class="form-select select2" required name="consignee_state" id="consignee_state" aria-label="Default select example">
                <option value="">Select</option>
                <?php foreach ($states as $o) { ?> 
                 <option value="<?= $o['state_id'] ?>" <?= (isset($loading_receipts['consignee_state']) && ($loading_receipts['consignee_state'] == $o['state_id'])) ? 'selected' : ''?> ><?= $o['state_name'] ?></option> 
                <?php } ?>
            </select>
            <?php
            if ($validation->getError('consignee_state')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignee_state') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
            <input type="number" name="consignee_pincode" id="consignee_pincode" class="form-control" required value="<?= (isset($loading_receipts['consignee_pincode'])) ?  $loading_receipts['consignee_pincode'] : ''?>">
            <?php
            if ($validation->getError('consignee_pincode')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignee_pincode') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">GSTIN</label>
            <input type="text" name="consignee_GSTIN" id="consignee_GSTIN" class="form-control" value="<?= (isset($loading_receipts['consignee_GSTIN'])) ?  $loading_receipts['consignee_GSTIN'] : ''?>">
            <?php
            if ($validation->getError('consignee_GSTIN')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('consignee_GSTIN') . '</div>';
            }
            ?>
        </div>
        <hr>
        
        <h6>Ship To:</h6>
        <div class="col-md-12">
            <label class="col-form-label">Address<span class="text-danger">*</span></label>
            <input type="text" name="place_of_delivery_address" id="place_of_delivery_address" class="form-control" required value="<?= (isset($loading_receipts['place_of_delivery_address'])) ?  $loading_receipts['place_of_delivery_address'] : ''?>">
            <?php
            if ($validation->getError('place_of_delivery_address')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_delivery_address') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">City<span class="text-danger">*</span></label>
            <input type="text" name="place_of_delivery_city" id="place_of_delivery_city" class="form-control" required value="<?= (isset($loading_receipts['place_of_delivery_city'])) ?  $loading_receipts['place_of_delivery_city'] : ''?>">
            <?php
            if ($validation->getError('place_of_delivery_city')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_delivery_city') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">State<span class="text-danger">*</span></label> 
            <select class="form-select select2" required name="place_of_delivery_state" id="place_of_delivery_state" aria-label="Default select example">
                <option value="">Select</option>
                <?php foreach ($states as $o) { ?> 
                 <option value="<?= $o['state_id'] ?>" <?= (isset($loading_receipts['place_of_delivery_state']) && ($loading_receipts['place_of_delivery_state'] == $o['state_id'])) ? 'selected' : ''?> ><?= $o['state_name'] ?></option> 
                <?php } ?>
            </select>
            <?php
            if ($validation->getError('place_of_delivery_state')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_delivery_state') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
            <input type="number" name="place_of_delivery_pincode" id="place_of_delivery_pincode" class="form-control" required value="<?= (isset($loading_receipts['place_of_delivery_pincode'])) ?  $loading_receipts['place_of_delivery_pincode'] : ''?>">
            <?php
            if ($validation->getError('place_of_delivery_pincode')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_delivery_pincode') . '</div>';
            }
            ?>
        </div>
        <hr>

        <h6>Dispatch From:</h6>
        <div class="col-md-12">
            <label class="col-form-label">Address<span class="text-danger">*</span></label>
            <input type="text" name="place_of_dispatch_address" id="place_of_dispatch_address" class="form-control" required value="<?= (isset($loading_receipts['place_of_dispatch_address'])) ?  $loading_receipts['place_of_dispatch_address'] : ''?>">
            <?php
            if ($validation->getError('place_of_dispatch_address')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_dispatch_address') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">City<span class="text-danger">*</span></label>
            <input type="text" name="place_of_dispatch_city" id="place_of_dispatch_city" class="form-control" required value="<?= (isset($loading_receipts['place_of_dispatch_city'])) ?  $loading_receipts['place_of_dispatch_city'] : ''?>">
            <?php
            if ($validation->getError('place_of_dispatch_city')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_dispatch_city') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">State<span class="text-danger">*</span></label> 
            <select class="form-select select2" required name="place_of_dispatch_state" id="place_of_dispatch_state" aria-label="Default select example">
                <option value="">Select</option>
                <?php foreach ($states as $o) { ?> 
                 <option value="<?= $o['state_id'] ?>" <?= (isset($loading_receipts['place_of_dispatch_state']) && ($loading_receipts['place_of_dispatch_state'] == $o['state_id'])) ? 'selected' : ''?> ><?= $o['state_name'] ?></option> 
                <?php } ?>
            </select> 
            <?php
            if ($validation->getError('place_of_dispatch_state')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_dispatch_state') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
            <input type="number" name="place_of_dispatch_pincode" id="place_of_dispatch_pincode" class="form-control" required value="<?= (isset($loading_receipts['place_of_dispatch_pincode'])) ?  $loading_receipts['place_of_dispatch_pincode'] : ''?>">
            <?php
            if ($validation->getError('place_of_dispatch_pincode')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('place_of_dispatch_pincode') . '</div>';
            }
            ?>
        </div>
        <hr>

        <div class="col-md-4">
            <label class="col-form-label">Particulars<span class="text-danger">*</span></label>
            <input type="text" name="particulars" id="particulars" class="form-control" required value="<?= (isset($loading_receipts['particulars'])) ?  $loading_receipts['particulars'] : ''?>">
            <?php
            if ($validation->getError('particulars')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('particulars') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">HSN Code<span class="text-danger">*</span></label>
            <input type="number" name="hsn_code" id="hsn_code" class="form-control" required value="<?= (isset($loading_receipts['hsn_code'])) ?  $loading_receipts['hsn_code'] : ''?>">
            <?php
            if ($validation->getError('hsn_code')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('hsn_code') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">No. of Packages<span class="text-danger">*</span></label>
            <input type="text" name="no_of_packages" id="no_of_packages" class="form-control" required value="<?= (isset($loading_receipts['no_of_packages'])) ?  $loading_receipts['no_of_packages'] : ''?>">
            <?php
            if ($validation->getError('no_of_packages')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('no_of_packages') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Actual Weight<span class="text-danger">*</span></label>
            <input type="text" name="actual_weight" id="actual_weight" class="form-control" required value="<?= (isset($loading_receipts['actual_weight'])) ?  $loading_receipts['actual_weight'] : ''?>">
            <?php
            if ($validation->getError('actual_weight')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('actual_weight') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Charge Weight<span class="text-danger">*</span></label>
            <input type="text" name="charge_weight" id="charge_weight" class="form-control" required value="<?= (isset($loading_receipts['charge_weight'])) ?  $loading_receipts['charge_weight'] : ''?>">
            <?php
            if ($validation->getError('charge_weight')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('charge_weight') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Payment Terms<span class="text-danger">*</span></label>
            <input type="text" name="payment_terms" id="payment_terms" class="form-control" required value="<?= (isset($loading_receipts['payment_terms'])) ?  $loading_receipts['payment_terms'] : ''?>">
            <?php
            if ($validation->getError('payment_terms')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('payment_terms') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <?php $label = 'E-Way Bill No';?>
            <label class="col-form-label"><?php echo $label;?><span class="text-danger">*</span></label>
            <input type="number" name="e_way_bill_number" id="e_way_bill_no" required="required" class="form-control" value="<?= (isset($loading_receipts['e_way_bill_number'])) ?  $loading_receipts['e_way_bill_number'] : ''?>" placeholder="<?php echo $label;?>" autocomplete="off">
            <?php
            if ($validation->getError('e_way_bill_number')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('e_way_bill_number') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">E-WAY Bill Expiry Date<span class="text-danger">*</span></label>
            <input type="date" name="e_way_expiry_date" id="e_way_expiry_date" class="form-control" required value="<?= (isset($loading_receipts['e_way_expiry_date'])) ?  $loading_receipts['e_way_expiry_date'] : ''?>">
            <?php
            if ($validation->getError('e_way_expiry_date')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('e_way_expiry_date') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Freight Charges Amount<span class="text-danger">*</span></label>
            <input type="number" name="freight_charges_amount" id="freight_charges_amount" class="form-control" required value="<?= (isset($loading_receipts['freight_charges_amount'])) ?  $loading_receipts['freight_charges_amount'] : ''?>">
            <?php
            if ($validation->getError('freight_charges_amount')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('freight_charges_amount') . '</div>';
            }
            ?>
        </div>
        <hr>
        
        <h6>Party Document Details</h6>
        <div class="col-md-4">
            <label class="col-form-label">Invoice/BOE No.</label>
            <input type="number" name="invoice_boe_no" id="invoice_boe_no" class="form-control" value="<?= (isset($loading_receipts['invoice_boe_no'])) ?  $loading_receipts['invoice_boe_no'] : ''?>">
            <?php
            if ($validation->getError('invoice_boe_no')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('invoice_boe_no') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Invoice/BOE Date</label>
            <input type="datetime-local" name="invoice_boe_date" id="invoice_boe_date" class="form-control" value="<?= (isset($loading_receipts['invoice_boe_date'])) ?  $loading_receipts['invoice_boe_date'] : ''?>">
            <?php
            if ($validation->getError('invoice_boe_date')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('invoice_boe_date') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Invoice Value</label>
            <input type="number" name="invoice_value" id="invoice_value" class="form-control" value="<?= (isset($loading_receipts['invoice_value'])) ?  $loading_receipts['invoice_value'] : ''?>">
            <?php
            if ($validation->getError('invoice_value')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('invoice_value') . '</div>';
            }
            ?>
        </div>
        <hr>

        <h6>Transit Insurance</h6>
        <h6>Dispatch Details:</h6>
        <div class="col-md-4">
            <label class="col-form-label">Reporting Date/Time</label>
            <input type="datetime-local" name="reporting_datetime" id="reporting_datetime" class="form-control" value="<?= (isset($loading_receipts['reporting_datetime'])) ?  $loading_receipts['reporting_datetime'] : ''?>">
            <?php
            if ($validation->getError('reporting_datetime')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('reporting_datetime') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Releasing Date/Time</label>
            <input type="datetime-local" name="releasing_datetime" id="releasing_datetime" class="form-control" value="<?= (isset($loading_receipts['releasing_datetime'])) ?  $loading_receipts['releasing_datetime'] : ''?>">
            <?php
            if ($validation->getError('releasing_datetime')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('releasing_datetime') . '</div>';
            }
            ?>
        </div>

        <h6>Insurance Co.:</h6>
        <div class="col-md-4">
            <label class="col-form-label">Policy Date</label>
            <input type="date" name="policy_date" id="policy_date" class="form-control" value="<?= (isset($loading_receipts['policy_date'])) ?  $loading_receipts['policy_date'] : ''?>">
            <?php
            if ($validation->getError('policy_date')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('policy_date') . '</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <label class="col-form-label">Policy Number</label>
            <input type="number" name="policy_no" id="policy_no" class="form-control" value="<?= (isset($loading_receipts['policy_no'])) ?  $loading_receipts['policy_no'] : ''?>">
            <?php
            if ($validation->getError('policy_no')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('policy_no') . '</div>';
            }
            ?>
        </div> -->

        <?php if($currentMethod == 'approve'){ ?> 
        <div class="col-md-12 mb-3">
            <input type="checkbox" id="approved" class="form-check-input" name="approved" value="1"  > 
            <label class="form-check-label" for="approve"> Approve</label>
            <br/>
            <!-- <span class="text-info">Loading Receipt can not be allow to update after approve.</span> -->
        </div>  
        <?php } ?>
    </div>
    <br>
</div> 

<div class="submit-button">
    <input type="submit" name="add_loadingreceipt" class="btn btn-primary" value="Save">
    <a href="<?php echo base_url(); ?>loadingreceipt" class="btn btn-light">Cancel</a>
</div>