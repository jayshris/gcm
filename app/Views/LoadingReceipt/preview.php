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
                        <?php
                            $session = \Config\Services::session();
                            if($session->getFlashdata('success'))
                            {
                                echo '
                                <div class="alert alert-success">'.$session->getFlashdata("success").'</div>
                                ';
                            }
                        ?>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <!-- Settings Info -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="settings-form">
                                            <div class="settings-sub-header">
                                                <h4>Preview Loading Receipt</h4>
                                            </div>
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Booking Order No: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['booking_number'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Branch Name: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['branch_name'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Booking Date: </label>
                                                        <label class="col-form-label"><?= ($loading_receipts['booking_date']) ?  date('d M Y', strtotime($loading_receipts['booking_date'])) : '-' ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Vehicle Number: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['rc_number'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Loading Station: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['loading_station'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Delivery Station: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['delivery_station'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Consignment Date: </label>
                                                        <label class="col-form-label"><?= ($loading_receipts['consignment_date']) ? date('d M Y',strtotime($loading_receipts['consignment_date'])) : '-' ?></label> 
                                                    </div>   														

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Seal No.: </label>
                                                        <label class="col-form-label"><?= ($loading_receipts['seal_no']) ? $loading_receipts['seal_no'] : '-' ?></label> 
                                                    </div>

                                                    <hr> 
                                                    <?php //if (isset($loading_receipts['transporter_id']) && ($loading_receipts['transporter_id'] > 0)) { ?>

                                                        <h6>Transporter Details: </h6>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Transporter Bilti No.: </label>
                                                            <label class="col-form-label"><?= ($loading_receipts['transporter_id'] > 0) ? $loading_receipts['transporter_bilti_no'] : $loading_receipts['consignment_no'] ?></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">E-Way Bill No.: </label>
                                                            <label class="col-form-label"><?= ($loading_receipts['e_way_bill_number']) ? $loading_receipts['e_way_bill_number'] : '-' ?></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Transporter Name: </label>
                                                            <label class="col-form-label"><?= ($loading_receipts['transporter_id'] > 0) ? $loading_receipts['transporter_name'] : $profile_data['company_name'] ?></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Branch Name: </label>
                                                            <label class="col-form-label"><?= ($loading_receipts['transporter_id'] > 0) ? $loading_receipts['transporter_branch_name'] : '-' ?></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Address: </label>
                                                            <label class="col-form-label"><?= ($loading_receipts['transporter_address']) ? $loading_receipts['transporter_address'] : $profile_data['company_business_address'] ?></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">City: </label>
                                                            <label class="col-form-label"><?= ($loading_receipts['transporter_city']) ? $loading_receipts['transporter_city'] : $profile_data['city'] ?></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">State: </label>
                                                            <label class="col-form-label"><?= ($loading_receipts['transporter_state_name']) ? $loading_receipts['transporter_state_name'] : $profile_data['state_name']?></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Pincode: </label>
                                                            <label class="col-form-label"><?= ($loading_receipts['transporter_pincode']) ? $loading_receipts['transporter_pincode'] : $profile_data['pincode'] ?></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">GSTN: </label>
                                                            <label class="col-form-label"><?= ($loading_receipts['transporter_GSTIN']) ? $loading_receipts['transporter_GSTIN'] : $profile_data['gst'] ?></label>
                                                        </div>
                                                        <hr>
                                                    <?php //} ?>

                                                    <h6>Supplier:</h6>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Consignor Name: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_name'] ?></label>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label">Address: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_address'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">City: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_city'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">State: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_state'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Pincode: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_pincode'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">GSTIN: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignor_GSTIN'] ?></label>
                                                    </div>

                                                    <hr>

                                                    <h6>Recipient:</h6>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Consignee Name: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_name'] ?></label>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-form-label">Address: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_address'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">City: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_city'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">State: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_state'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Pincode: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_pincode'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">GSTIN: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['consignee_GSTIN'] ?></label>
                                                    </div>

                                                    <hr>

                                                    <h6>Ship To:</h6>
                                                    <div class="col-md-12">
                                                        <label class="col-form-label">Address: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_delivery_address'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">City: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_delivery_city'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">State: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_delivery_state'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Pincode: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_delivery_pincode'] ?></label>
                                                    </div>

                                                    <hr>

                                                    <h6>Dispatch From:</h6>
                                                    <div class="col-md-12">
                                                        <label class="col-form-label">Address: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_dispatch_address'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">City: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_dispatch_city'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">State: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_dispatch_state'] ?></label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Pincode: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['place_of_dispatch_pincode'] ?></label>
                                                    </div>

                                                    <hr>

                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Particulars: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['particulars'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">HSN Code: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['hsn_code'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">No. of Packages: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['no_of_packages'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Actual Weight: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['actual_weight'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Charge Weight: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['charge_weight'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Payment Terms: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['payment_terms'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">E-WAY Bill Number: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['e_way_bill_number'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">E-WAY Bill Expiry Date: </label>
                                                        <label class="col-form-label"><?= ($loading_receipts['e_way_expiry_date']) ? date('d M Y', strtotime($loading_receipts['e_way_expiry_date'])) : '-' ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Freight Charges Amount: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['freight_charges_amount'] ?></label>
                                                    </div>

                                                    <hr>

                                                    <h6>Party Document Details</h6>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Invoice/BOE No.: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['invoice_boe_no'] ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Invoice/BOE Date: </label>
                                                        <label class="col-form-label"><?= ($loading_receipts['invoice_boe_date']) ? date('d M Y', strtotime($loading_receipts['invoice_boe_date'])) : '-' ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Invoice Value: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['invoice_value'] ?></label>
                                                    </div>

                                                    <hr>
                                                    <h6>Transit Insurance</h6>
                                                    <h6>Dispatch Details:</h6>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Reporting Date/Time: </label>
                                                        <label class="col-form-label"><?= ($loading_receipts['reporting_datetime']) ? date('d M Y', strtotime($loading_receipts['reporting_datetime'])) : '-' ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Releasing Date/Time: </label>
                                                        <label class="col-form-label"><?= ($loading_receipts['releasing_datetime']) ? date('d M Y', strtotime($loading_receipts['releasing_datetime'])) : '-' ?></label>
                                                    </div>
                                                    <h6>Insurance Co.:</h6>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Policy Date: </label>
                                                        <label class="col-form-label"><?= ($loading_receipts['policy_date']) ? date('d M Y', strtotime($loading_receipts['policy_date'])) : '-' ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Policy Number: </label>
                                                        <label class="col-form-label"><?= $loading_receipts['policy_no'] ?></label>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="submit-button">
                                                <?php if (isset($loading_receipts['approved']) && ($loading_receipts['approved'] == 1)) { ?>
                                                    <!-- <a href="<?php //echo base_url('consignmentnote/preview/' . $loading_receipts['id']); ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> &nbsp; Print</a>&nbsp; -->
                                                   
                                                    <a href="<?= base_url($lr_file_path) ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> &nbsp; Print</a>&nbsp;
                                                     
                                                    <!-- <a href="<?php echo base_url('consignmentnote/preview/' . $loading_receipts['id'] . '?print=1'); ?>" class="btn btn-success"><i class="ti ti-mail" aria-hidden="true"></i> Send Email</a> -->
                                                    <button class="btn btn-success sendmail"><i class="ti ti-mail" aria-hidden="true"></i> Send Email</button>
                                                <?php } ?>
                                                <a href="<?php echo base_url(); ?>loadingreceipt" class="btn btn-light">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mailModal" tabindex="-1" aria-labelledby="gcmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.((isset($loading_receipts['id']) && $loading_receipts['id']>0) ? '/'.$loading_receipts['id'] : ''), ['name'=>'mailForm', 'id'=>'mailForm']);?>
                <div class="modal-header">
                  <h5 class="modal-title">Send Loading Receipt Email</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?php
                $fromName = 'GAE CARGO MOVERS PVT LTD';//(isset($loading_receipts['consignor_name']) && !empty($loading_receipts['consignor_name'])) ? $loading_receipts['consignor_name'] : 'GAE Group';
                $fileName = (isset($loading_receipts['consignment_no']) && !empty($loading_receipts['consignment_no'])) ? str_replace('/','_',$loading_receipts['consignment_no']) : 'loading_receipt_'.$id;
                $filePath = base_url().'public/uploads/loading_receipts/'.$fileName.'.pdf';
                ?>

                <div class="modal-body mailbody">
                  <div class="col-md-12">
                    <label class="col-form-label">Email From : <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="email_from" value="<?php echo $fromName;?>" autocomplete="off" required>
                    <input type="hidden" class="form-control" name="id" value="<?php echo $loading_receipts['id'];?>">
                  </div>
                  <div class="col-md-12"><br>
                    <label class="col-form-label">Email To : <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email_to" autocomplete="off" required>
                  </div>
                  <div class="col-md-12"><br>
                    <label class="col-form-label">Email Subject : <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="email_subject" value="Loading Receipt of Consignment <?php echo $loading_receipts['consignment_no'];?>" autocomplete="off" required>
                  </div>
                  <div class="col-md-12"><br>
                    <label class="col-form-label">Email Message : <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="email_body" rows="5" required></textarea>
                  </div>
                  <div class="col-md-12"><br>
                    <a href="<?php echo $filePath;?>" class="product-img d-flex align-items-center" target="_blank">
                        <img src="<?php echo base_url();?>public/assets/img/icons/pdf-02.svg" alt="Product" class="me-2">
                        <span><?php echo $fileName;?>.pdf</span>
                    </a>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"><i class="ti ti-mail" aria-hidden="true"></i> Send Email</button>
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <?php echo $this->include('partials/vendor-scripts');?>
    <script type="text/javascript">
        $(function () {
            $(".sendmail").click(function () {
                $.ajax({
                    method: "GET",
                    url: "<?php echo base_url('consignmentnote/preview/' . $loading_receipts['id'] . '?print=1');?>",
                    success: function(resp) {
                        $('#mailModal').modal('toggle');
                    }
                });
            });
        });
    </script>
</body>
</html>