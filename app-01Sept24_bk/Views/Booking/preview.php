<!DOCTYPE html>
<html lang="en">
<head>
  <?= $this->include('partials/title-meta') ?>
  <?= $this->include('partials/head-css') ?>
  <style>
        @media print {
           .noprint {
              /* visibility: hidden; */
              display: none;
           }
           .sidebar, .mobile_btn, .mobile-user-menu,.header{
            display: none !important;
           } 

           .print-header,.print-footer{
            display: block !important;
          }
           
          .page-wrapper{
             margin:0;
             padding: 0;
           }
           .row>*{
            margin-top: 0 !important;
           }
           .print-tbl tr td{
            padding:2px !important;
            font-size: 10px !important;
           }
           .print-heder{
            text-align: center;
            padding-bottom: 10px !important;
            /* margin-bottom: 15px !important; */
            border-bottom: none !important;
           }
           .debug-icon{
            display: none !important;
           }
        }  
        .prheader{ 
          line-height: 31pt;
          float: right;
          font-weight: bold;
          font-size: 25px;
          text-decoration: underline;
          text-align: center;
        }
        .sub-headerpr{
          text-align: center;font-weight: bold;
          margin-bottom: 0 !important;
        }
        .prdheader{
          display: flex; 
        }
        .prfooter-txt{
          text-align: justify;
        }
        .prfooter{
          text-align: center;
          margin-bottom: 0 !important;
        }
        
    </style>
</head>
<body>
  <!-- Main Wrapper -->
  <div class="main-wrapper">
    <?php echo $this->include('partials/menu') ?>
    <?php echo $this->include('partials/print-header') ?>
    <hr>
    
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
                        <div class="settings-sub-header print-heder">
                          <h6>Booking Note</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row g-3">
                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Customer: </b></label>
                                <label class="col-form-label"><?= isset($booking_details['customer']) && !empty($booking_details['customer']) ? $booking_details['customer'] : '-' ?></label>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Customer City: </b></label>
                                <label class="col-form-label"><?= isset($booking_details['cb_city']) && !empty($booking_details['cb_city']) ? $booking_details['cb_city'] : '-' ?></label>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Booking Number: </b></label>
                                <label class="col-form-label"><?= isset($booking_details['booking_number']) && !empty($booking_details['booking_number']) ? $booking_details['booking_number'] : '-' ?></label>
                            </div> 

                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Booking Type: </b></label>
                                <label class="col-form-label"><?= isset($booking_details['booking_type']) && !empty($booking_details['booking_type']) ? $booking_details['booking_type'] : '-' ?></label>
                            </div> 

                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Booking Date: </b></label>
                                <label class="col-form-label"><?= isset($booking_details['booking_date']) && !empty(strtotime($booking_details['booking_date']) > 0) ? date('d-F-Y',strtotime($booking_details['booking_date'])) : '-' ?></label>
                            </div> 
                            
                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Booking By: </b></label>
                                <label class="col-form-label"><?= isset($booking_details['booking_by_name']) && !empty($booking_details['booking_by_name']) ? $booking_details['booking_by_name'] : '-' ?></label>
                            </div>   
                            
                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Booking For: </b></label>
                                <label class="col-form-label">
                                  <?= isset($booking_details['booking_for']) && $booking_details['booking_for'] == '1' ? 'Material 1' : '' ?>
                                  <?= isset($booking_details['booking_for']) && $booking_details['booking_for'] == '2' ? 'Material 2' : '' ?>
                                  <?= isset($booking_details['booking_for']) && $booking_details['booking_for'] == '3' ? 'Material 3' : '' ?>
                                  <?= isset($booking_details['booking_for']) && $booking_details['booking_for'] == '4' ? 'Material 4' : '' ?>
                                </label>
                            </div> 

                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Vehicle RC: </b></label>
                                <label class="col-form-label"><?= isset($booking_details['rc_number']) && !empty($booking_details['rc_number']) ? $booking_details['rc_number'] : '-' ?></label>
                            </div> 

                            <div class="col-md-6 col-sm-6">
                              <label class="col-form-label"><b>Bill To: </b></label>
                              <label class="col-form-label"><?= isset($booking_details['bill_to_party_name']) && !empty($booking_details['bill_to_party_name']) ? $booking_details['bill_to_party_name'] : '-' ?></label>                                
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Driver Name: </b></label>
                                <label class="col-form-label"><?= isset($driver['driver_name']) && !empty($driver['driver_name']) ? $driver['driver_name'] : '-' ?></label>
                            </div> 

                            <div class="col-md-6 col-sm-6">
                                <label class="col-form-label"><b>Driver Phone No.: </b></label>
                                <label class="col-form-label"><?= isset($driver['primary_phone']) && !empty($driver['primary_phone']) ? $driver['primary_phone'] : '-' ?></label>
                            </div>

                            <hr/>
  
                            <div class="col-md-12 col-sm-12">
                              <h6>Pickup Details:</h6>
                            </div> 

                            <div class="col-md-3 col-sm-3">
                                <label class="col-form-label"><b>State: </b> </label><br/>
                                <label class="col-form-label"><?= isset($booking_pickups_state['state_name']) && !empty($booking_pickups_state['state_name']) ? $booking_pickups_state['state_name'] : '-' ?></label>
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <label class="col-form-label"><b>City: </b> </label><br/>
                                <label class="col-form-label"><?= isset($booking_pickups['city']) && !empty($booking_pickups['city']) ? $booking_pickups['city'] : '-' ?></label>
                            </div>
                            
                            <div class="col-md-3 col-sm-3">
                                <label class="col-form-label"><b>Pincode: </b> </label><br/>
                                <label class="col-form-label"><?= isset($booking_pickups['pincode']) && !empty($booking_pickups['pincode']) ? $booking_pickups['pincode'] : '-' ?></label>
                            </div>
 
                            <div class="col-md-3 col-sm-3">
                                <label class="col-form-label"><b>Pickup Date: </b> </label><br/>
                                <label class="col-form-label"><?= isset($booking_details['pickup_date']) && (strtotime($booking_details['pickup_date']) > 0) ? date('d-F-Y',strtotime($booking_details['pickup_date'])) : '-' ?></label>
                            </div>

                            <hr/>

                            <div class="col-md-12 col-sm-12">
                              <h6>Drop Details:</h6> 
                            </div>
                            
                            <div class="col-md-3 col-sm-3">
                                <label class="col-form-label"><b>State: </b> </label><br/>
                                <label class="col-form-label"><?= isset($booking_drops_state['state_name']) && !empty($booking_drops_state['state_name']) ? $booking_drops_state['state_name'] : '-' ?></label>
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <label class="col-form-label"><b>City: </b> </label><br/>
                                <label class="col-form-label"><?= isset($booking_drops['city']) && !empty($booking_drops['city']) ? $booking_drops['city'] : '-' ?></label>
                            </div>
                            
                            <div class="col-md-3 col-sm-3">
                                <label class="col-form-label"><b>Pincode: </b> </label><br/>
                                <label class="col-form-label"><?= isset($booking_drops['pincode']) && !empty($booking_drops['pincode']) ? $booking_drops['pincode'] : '-' ?></label>
                            </div>
 
                            <div class="col-md-3 col-sm-3">
                                <label class="col-form-label"><b>Drop Date: </b> </label><br/>
                                <label class="col-form-label"><?= isset($booking_details['drop_date']) && (strtotime($booking_details['drop_date']) > 0) ? date('d-F-Y',strtotime($booking_details['drop_date'])) : '-' ?></label>
                            </div>

                            <hr/>
                            <?php  $guranteed_wt = isset($booking_details['guranteed_wt']) && !empty($booking_details['guranteed_wt']) ? $booking_details['guranteed_wt'].'kg' : '' ?>
                            <?php if($guranteed_wt) { ?>
                            <div class="col-md-6 col-sm-6">
                              <label class="col-form-label"><b>Guaranteed / Charged Weight: </b></label>
                              <label class="col-form-label"><?=  $guranteed_wt; ?></label> 
                            </div>
                            <?php } ?>    
                            
                            <?php  $freight = isset($booking_details['freight']) && !empty($booking_details['freight']) ? 'Rs '.$booking_details['freight'] : ''; ?>
                            <?php if($freight) { ?>
                            <div class="col-md-6 col-sm-6">
                              <label class="col-form-label"><b>Total Freight: </b></label>
                              <label class="col-form-label"><?= $freight ?></label> 
                            </div>
                            <?php } ?>  

                            <?php  $advance = isset($booking_details['advance']) && !empty($booking_details['advance']) ? 'Rs '.$booking_details['advance'] : ''; ?>
                            <?php if($advance) { ?>
                            <div class="col-md-6 col-sm-6">
                              <label class="col-form-label"><b>Advance: </b></label>
                              <label class="col-form-label"><?= $advance ?></label> 
                            </div>
                            <?php } ?>  

                            <?php  $discount = isset($booking_details['discount']) && !empty($booking_details['discount']) ? 'Rs '.$booking_details['discount'] : ''; ?>
                            <?php if($discount) { ?>
                            <div class="col-md-6 col-sm-6">
                              <label class="col-form-label"><b>Discount: </b></label>
                              <label class="col-form-label"><?= $discount ?></label> 
                            </div>
                            <?php } ?> 

                            <?php  $balance = isset($booking_details['balance']) && !empty($booking_details['balance']) ? 'Rs '.$booking_details['balance'] : ''; ?>
                            <?php if($balance) { ?>
                            <div class="col-md-6 col-sm-6">
                              <label class="col-form-label"><b>Balance: </b></label>
                              <label class="col-form-label"><?= $balance  ?></label> 
                            </div> 
                            <?php } ?> 

                            <hr/>
                            <?php if(isset($booking_expences) && !empty($booking_expences)){?>
                            <div class="col-md-12 col-sm-12">
                              <h6>Expense: </h6>
                            </div>
                            
                            <div class="col-md-4 col-sm-4">
                              <table class="table table-bordered print-tbl">
                                <tbody>
                                  <tr class="noprint">
                                    <td>Head</td>
                                    <td>Value</td>
                                  </tr>   
                                  <?php
                                  $i = 1;
                                  foreach ($booking_expences as $be) {
                                  ?>
                                    <tr id="del_expense_<?= $i ?>">
                                      <td> 
                                      <?= isset($be['head_name']) && !empty($be['head_name']) ? $be['head_name'].' (Rs.)' : '-' ?>
                                      </td>  
                                      <td> 
                                      <?= isset($be['value']) && !empty($be['value']) ? $be['value'] : '-' ?>
                                      </td>
                                    </tr>
                                  <?php
                                    $i++;
                                  } ?> 
                                </tbody>
                              </table>
                            </div>
                            <div class="col-md-12 col-sm-12"></div>
                            <?php } ?>
                           
                            <div class="col-md-4 col-sm-4">
                              <label class="col-form-label"><b>Remarks: </b></label>
                              <label class="col-form-label"><?= isset($booking_details['remarks']) && !empty($booking_details['remarks']) ? $booking_details['remarks'] : '-' ?></label>          
                            </div> 

                          </div>
                        </div>
                        <div class="submit-button noprint">  
                          <button type="button" class="btn btn-danger" onclick="window.print();"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
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
    <!-- /Page Wrapper -->
    <hr>
    <?php echo $this->include('partials/print-footer') ?>
  </div>  

  <?= $this->include('partials/vendor-scripts') ?>
  <script> 
  </script>

</body>

</html>