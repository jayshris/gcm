<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->include('partials/title-meta') ?>
  <?php echo $this->include('partials/head-css') ?>
  <style>
        @media print {
           .noprint {
              /* visibility: hidden; */
              display: none;
           }
           .sidebar, .mobile_btn, .mobile-user-menu,.header{
            display: none !important;
           } 

           .print-header,.print-footer,.hrcl{
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
           #debug-icon{
            display: none !important;
           }

           .page-wrapper .content, .card .card-body{
            padding: 0;
           }
           .print-header{
            border-bottom: 1px solid #E8E8E8;
           }
           .prdheader img{
            height: 34px !important;
           }

           .pagebreak {
                clear: both !important;
                page-break-after: always !important;
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
          margin-left: 25% !important;
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
  <div class="main-wrapper">
    <?php echo $this->include('partials/menu') ?>
    <?php echo $this->include('partials/print-header') ?> 

    <div class="page-wrapper">
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <?php echo $this->include('partials/page-title') ?>
            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="settings-form">                                           
                        <div class="settings-sub-header print-heder">
                          <h3>Booking Report</h3> 
                        </div>                        

                        <div class="profile-details">
                          <div class="row g-3">
                            <!-- Booking Details -->
                            <div class="col-lg-4 col-md-4 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Booking Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                    <div class="col-md-5"><span class="fw-bold">Booking Number: </span></div>
                                    <div class="col-md-7">
                                      <?php echo isset($booking_details['booking_number']) && !empty($booking_details['booking_number']) ? $booking_details['booking_number'] : '-';?>
                                    </div>

                                    <div class="col-md-5"><span class="fw-bold">Booking Date: </span></div>
                                    <div class="col-md-7">
                                      <?php echo isset($booking_details['booking_date']) && !empty($booking_details['booking_date']) ? date('d-F-Y',strtotime($booking_details['booking_date'])) : '-';?>
                                    </div>

                                    <div class="col-md-5"><span class="fw-bold">Booking By: </span></div>
                                    <div class="col-md-7">
                                      <?php echo isset($booking_details['booking_by_name']) && !empty($booking_details['booking_by_name']) ? $booking_details['booking_by_name'] : '-';?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Customer Details -->
                            <div class="col-lg-4 col-md-4 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Customer Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <div class="col-md-5"><span class="fw-bold">Customer Name: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_details['customer']) && !empty($booking_details['customer']) ? $booking_details['customer'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Contact Person: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_details['contact_person']) && !empty($booking_details['contact_person']) ? $booking_details['contact_person'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Customer City: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_details['cb_city']) && !empty($booking_details['cb_city']) ? $booking_details['cb_city'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Contact Phone No.: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_details['primary_phone']) && !empty($booking_details['primary_phone']) ? $booking_details['primary_phone'] : '-';?>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Vehicle Details -->
                            <div class="col-lg-4 col-md-4 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Vehicle Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <div class="col-md-5"><span class="fw-bold">Vehicle RC: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_details['rc_number']) && !empty($booking_details['rc_number']) ? $booking_details['rc_number'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Driver Name: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($driver['driver_name']) && !empty($driver['driver_name']) ? $driver['driver_name'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Driver Phone No.: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($driver['primary_phone']) && !empty($driver['primary_phone']) ? $driver['primary_phone'] : '-';?>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Pickup Details -->
                            <div class="col-lg-4 col-md-4 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Pickup Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <div class="col-md-5"><span class="fw-bold">Pickup Date: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_details['pickup_date']) && (strtotime($booking_details['pickup_date']) > 0) ? date('d-F-Y',strtotime($booking_details['pickup_date'])) : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Pickup City: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_pickups['city']) && !empty($booking_pickups['city']) ? $booking_pickups['city'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Pickup State: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_pickups_state['state_name']) && !empty($booking_pickups_state['state_name']) ? $booking_pickups_state['state_name'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Pickup Postcode: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_pickups['pincode']) && !empty($booking_pickups['pincode']) ? $booking_pickups['pincode'] : '-';?>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Drop Details -->
                            <div class="col-lg-4 col-md-4 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Drop Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <div class="col-md-5"><span class="fw-bold">Drop Date: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_details['drop_date']) && (strtotime($booking_details['drop_date']) > 0) ? date('d-F-Y',strtotime($booking_details['drop_date'])) : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Drop City: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_drops['city']) && !empty($booking_drops['city']) ? $booking_drops['city'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Drop State: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_drops_state['state_name']) && !empty($booking_drops_state['state_name']) ? $booking_drops_state['state_name'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Drop Postcode: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_drops['pincode']) && !empty($booking_drops['pincode']) ? $booking_drops['pincode'] : '-';?>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Weight & Payment Details -->
                            <div class="col-lg-4 col-md-4 d-flex ">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Weight & Payment Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <?php 
                                      $guranteed_wt = isset($booking_details['guranteed_wt']) && !empty($booking_details['guranteed_wt']) ? number_format($booking_details['guranteed_wt'],2).' kg' : '';
                                      if(!empty($guranteed_wt)){
                                      ?>
                                      <div class="col-md-7"><span class="fw-bold">Guaranteed / Charged Weight: </span></div>
                                      <div class="col-md-5"><?php echo $guranteed_wt;?></div>
                                      <?php } ?>

                                      <?php
                                      $freight = isset($booking_details['freight']) && !empty($booking_details['freight']) ? 'Rs '.number_format($booking_details['freight'],2) : '';
                                      if(!empty($freight)){
                                      ?>
                                      <div class="col-md-7"><span class="fw-bold">Total Freight: </span></div>
                                      <div class="col-md-5"><?php echo $freight;?></div>
                                      <?php } ?>

                                      <?php
                                      $advance = isset($booking_details['advance']) && !empty($booking_details['advance']) ? 'Rs '.number_format($booking_details['advance'],2) : '';
                                      if(!empty($advance)){
                                      ?>
                                      <div class="col-md-7"><span class="fw-bold">Advance: </span></div>
                                      <div class="col-md-5"><?php echo $advance;?></div>
                                      <?php } ?>

                                      <?php
                                      $discount = isset($booking_details['discount']) && !empty($booking_details['discount']) ? 'Rs '.number_format($booking_details['discount'],2) : '';
                                      if(!empty($discount)){
                                      ?>
                                      <div class="col-md-7"><span class="fw-bold">Discount: </span></div>
                                      <div class="col-md-5"><?php echo $discount;?></div>
                                      <?php } ?>

                                      <?php
                                      $balance = isset($booking_details['balance']) && !empty($booking_details['balance']) ? 'Rs '.number_format($booking_details['balance'],2) : '';
                                      if(!empty($balance)){
                                      ?>
                                      <div class="col-md-7"><span class="fw-bold">Balance: </span></div>
                                      <div class="col-md-5"><?php echo $balance;?></div>
                                      <?php } ?>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Remarks -->
                            <?php
                            $remarks = isset($booking_details['remarks']) ? $booking_details['remarks'] : '';
                            if(!empty($remarks)){
                            ?>
                            <div class="col-lg-12 col-md-12 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Remarks:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <div class="col-md-12"><?php echo $remarks;?></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?>

                            <!-- Expense Details -->
                            <?php if(isset($booking_expences) && !empty($booking_expences)){?>
                            <div class="col-lg-4 col-md-4 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Expense Details:</h4>
                                  </div><hr>

                                  <div class="row">
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
                                            <tr id="del_expense_<?php echo $i ?>">
                                              <td> 
                                              <?php echo isset($be['head_name']) && !empty($be['head_name']) ? $be['head_name'].' (Rs.)' : '-' ?>
                                              </td>  
                                              <td> 
                                              <?php echo isset($be['value']) && !empty($be['value']) ? $be['value'] : '-' ?>
                                              </td>
                                            </tr>
                                          <?php
                                            $i++;
                                          } ?> 
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?> 
                            <hr class="hrcl" style="display: none;">
                            <?php echo $this->include('partials/print-footer') ?>
                            <div class="pagebreak"></div>
                            <!-- PTL Booking Details -->
                             <?php if(isset($ptl_bookings['ptl_cnt']) && ($ptl_bookings['ptl_cnt'] > 0) ){ ?>
                            <div class="col-lg-12 col-md-12 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>PTL Booking Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                     <div class="col-md-5"><span class="fw-bold">No. Of Bookings Linked: </span></div>
                                      <div class="col-md-7">
                                      <?php echo isset($ptl_bookings['ptl_cnt']) && ($ptl_bookings['ptl_cnt'] > 0) ? $ptl_bookings['ptl_cnt'] : 0;?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Customer Name: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($ptl_bookings['ptl_customers']) && !empty($ptl_bookings['ptl_customers']) ? $ptl_bookings['ptl_customers'] : '-';?>
                                      </div> 
                                     
                                      <div class="col-md-5"><span class="fw-bold">Bookings Numbers: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($ptl_bookings['ptl_bokking_no']) && !empty($ptl_bookings['ptl_bokking_no']) ? $ptl_bookings['ptl_bokking_no'] : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Total Charged Weight: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_total['total_charged_weight']) && ($booking_total['total_charged_weight'] > 0) ? number_format($booking_total['total_charged_weight'],2).' kg' : 0;?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Total Freight: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($booking_total['total_freight']) && ($booking_total['total_freight'] > 0) ? 'Rs '.number_format($booking_total['total_freight'],2) : 0;?>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?> 

                          </div>
                        </div>

                        <div class="submit-button noprint">  
                          <button type="button" class="btn btn-danger" onclick="window.print();"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                          <a href="<?php echo base_url('booking'); ?>" class="btn btn-light">Back</a>
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

  <?php echo $this->include('partials/vendor-scripts') ?>
  <script> 
  </script>
</body>
</html>