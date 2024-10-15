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
           .print-tbl tr td th{
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
                          <h3>Booking Details</h3> 
                        </div>                        

                        <div class="profile-details">
                          <div class="row g-3">
                            <!-- Booking Details -->
                            <div class="col-lg-4 col-md-4 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Booking Information:</h4>
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

                            <!-- Trip Duration Details -->
                            <div class="col-lg-4 col-md-4 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Trip Duration:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <div class="col-md-5"><span class="fw-bold">Trip Start Date: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($trip_start_details[0]['status_date']) ? date('d.M.Y H:i A',strtotime($trip_start_details[0]['status_date'])) : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">Unload Date: </span></div>
                                      <div class="col-md-7">
                                        <?php echo isset($unloading_details[0]['status_date']) ? date('d.M.Y H:i A',strtotime($unloading_details[0]['status_date'])) : '-';?>
                                      </div>

                                      <div class="col-md-5"><span class="fw-bold">POD Upload Date: </span></div>
                                      <div class="col-md-7">
                                        <?php $countPOD = count($pod_details); 
                                          $lastPOD = ($countPOD > 0) ? ($countPOD-1) : 0;
                                        ?>
                                        <?php echo isset($pod_details[$lastPOD]['status_date']) ? date('d.M.Y H:i A',strtotime($pod_details[$lastPOD]['status_date'])) : '-';?>
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
                            <div class="col-lg-6 col-md-6 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Expense Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <table class="table table-bordered print-tbl">
                                        <tbody>
                                          <tr>
                                            <th>Head</th>
                                            <th>Value</th>
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

                            <!-- trip start Details -->
                            <?php if(isset($trip_start_details) && !empty($trip_start_details)){?>
                            <div class="col-lg-6 col-md-6 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Trip Start Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <table class="table table-bordered print-tbl">
                                        <tbody>
                                          <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Vehicle</th>
                                            <th>Driver</th>
                                          </tr>   
                                          <?php
                                          $i = 1;
                                          foreach ($trip_start_details as $val) {
                                          ?>
                                            <tr>
                                              <td><?= $i;$i++; ?>
                                              <td> <?= date('d-M-Y H:i A',strtotime($val['status_date'])) ?></td> 
                                              <td> <?= isset($val['rc_number']) && ($val['rc_number']) ? $val['rc_number'] : '-' ?></td>
                                              <td> <?= isset($val['driver']) && ($val['driver']) ? $val['driver'] : '-' ?></td>   
                                            </tr>
                                          <?php } ?> 
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?> 

                            <!-- Loading Details -->
                            <?php if(isset($loading_details) && !empty($loading_details)){?>
                            <div class="col-lg-6 col-md-6 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Loading Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <table class="table table-bordered print-tbl">
                                        <tbody>
                                          <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Vehicle</th>
                                            <th>Driver</th>
                                          </tr>   
                                          <?php
                                          $i = 1;
                                          foreach ($loading_details as $val) {
                                          ?>
                                            <tr>
                                              <td><?= $i;$i++; ?>
                                              <td> <?= date('d-M-Y H:i A',strtotime($val['status_date'])) ?></td> 
                                              <td> <?= isset($val['rc_number']) && ($val['rc_number']) ? $val['rc_number'] : '-' ?></td>
                                              <td> <?= isset($val['driver']) && ($val['driver']) ? $val['driver'] : '-' ?></td>   
                                            </tr>
                                          <?php } ?> 
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?> 

                             <!-- trip_running_details -->
                             <?php if(isset($trip_running_details) && !empty($trip_running_details)){?>
                            <div class="col-lg-6 col-md-6 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Trip Running Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <table class="table table-bordered print-tbl">
                                        <tbody>
                                          <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Vehicle</th>
                                            <th>Driver</th>
                                          </tr>   
                                          <?php
                                          $i = 1;
                                          foreach ($trip_running_details as $val) {
                                          ?>
                                            <tr>
                                              <td><?= $i;$i++; ?>
                                              <td> <?= date('d-M-Y H:i A',strtotime($val['status_date'])) ?></td> 
                                              <td> <?= isset($val['rc_number']) && ($val['rc_number']) ? $val['rc_number'] : '-' ?></td>
                                              <td> <?= isset($val['driver']) && ($val['driver']) ? $val['driver'] : '-' ?></td>   
                                            </tr>
                                          <?php } ?> 
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?> 
                                   
                            <!-- unloading_details -->
                            <?php if(isset($unloading_details) && !empty($unloading_details)){?>
                            <div class="col-lg-6 col-md-6 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Unloading Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <table class="table table-bordered print-tbl">
                                        <tbody>
                                          <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Vehicle</th>
                                            <th>Driver</th>
                                          </tr>   
                                          <?php
                                          $i = 1;
                                          foreach ($unloading_details as $val) {
                                          ?>
                                            <tr>
                                              <td><?= $i;$i++; ?>
                                              <td> <?= date('d-M-Y H:i A',strtotime($val['status_date'])) ?></td> 
                                              <td> <?= isset($val['rc_number']) && ($val['rc_number']) ? $val['rc_number'] : '-' ?></td>
                                              <td> <?= isset($val['driver']) && ($val['driver']) ? $val['driver'] : '-' ?></td>   
                                            </tr>
                                          <?php } ?> 
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?> 

                            <!-- pod_details -->
                            <?php if(isset($pod_details) && !empty($pod_details)){?>
                            <div class="col-lg-6 col-md-6 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>POD Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <table class="table table-bordered print-tbl">
                                        <tbody>
                                          <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Vehicle</th>
                                            <th>Driver</th>
                                          </tr>   
                                          <?php
                                          $i = 1;
                                          foreach ($pod_details as $val) {
                                          ?>
                                            <tr>
                                              <td><?= $i;$i++; ?>
                                              <td> <?= date('d-M-Y H:i A',strtotime($val['status_date'])) ?></td> 
                                              <td> <?= isset($val['rc_number']) && ($val['rc_number']) ? $val['rc_number'] : '-' ?></td>
                                              <td> <?= isset($val['driver']) && ($val['driver']) ? $val['driver'] : '-' ?></td>   
                                            </tr>
                                          <?php } ?> 
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?> 

                            <div class="col-md-12 col-lg-12"></div>
                            
                            <!-- Loading Images -->
                            <?php if($booking_details['loading_doc'] || $booking_details['loading_doc_2'] || $booking_details['loading_doc_2']){?>
                            <div class="col-lg-12 col-md-12 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Loading Images:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <table class="table table-bordered print-tbl">
                                        <tbody>
                                          <tr> 
                                            <th>Image 1</th>
                                            <th>Image 2</th>
                                            <th>Image 3</th>
                                          </tr>    
                                            <tr>
                                              <td> 
                                                  <?php $loading_doc = isset($booking_details['loading_doc']) && ($booking_details['loading_doc']) ? $booking_details['loading_doc'] : '' ?>                                                  
                                                  <?php if($loading_doc){ ?> 
                                                    <a href="<?= base_url('public/uploads/loading_docs/').$loading_doc  ?>"  target="_blank" style="margin-left: 7px;width: 200px;">
                                                    <img src="<?= base_url('public/uploads/loading_docs/').$loading_doc  ?>" class="img-fluid" alt="Logo" height="100" width="100" />
                                                    </a>     
                                                  <?php } ?>
                                              </td>
                                              <td> 
                                                  <?php $loading_doc = isset($booking_details['loading_doc_2']) && ($booking_details['loading_doc_2']) ? $booking_details['loading_doc_2'] : '' ?>                                                  
                                                  <?php if($loading_doc){ ?> 
                                                    <a href="<?= base_url('public/uploads/loading_docs/').$loading_doc  ?>"  target="_blank" style="margin-left: 7px;width: 200px;">
                                                    <img src="<?= base_url('public/uploads/loading_docs/').$loading_doc  ?>" class="img-fluid" alt="Logo" height="100" width="100" />
                                                    </a>     
                                                  <?php } ?>
                                              </td>
                                              <td> 
                                                  <?php $loading_doc = isset($booking_details['loading_doc_3']) && ($booking_details['loading_doc_3']) ? $booking_details['loading_doc_3'] : '' ?>                                                  
                                                  <?php if($loading_doc){ ?> 
                                                    <a href="<?= base_url('public/uploads/loading_docs/').$loading_doc  ?>"  target="_blank" style="margin-left: 7px;width: 200px;">
                                                    <img src="<?= base_url('public/uploads/loading_docs/').$loading_doc  ?>" class="img-fluid" alt="Logo" height="100" width="100" />
                                                    </a>     
                                                  <?php } ?>
                                              </td>
                                            </tr>  
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?> 

                            <!-- kanta_parchi_details -->
                            <?php if(isset($kanta_parchi_details) && !empty($kanta_parchi_details)){?>
                            <div class="col-lg-12 col-md-12 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Kanta Parchi Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <table class="table table-bordered print-tbl">
                                        <tbody>
                                          <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Kanta Parchi</th>
                                            <th>Actual Weight</th>  
                                          </tr>   
                                          <?php
                                          $i = 1;
                                          foreach ($kanta_parchi_details as $val) {
                                          ?>
                                            <tr>
                                              <td><?= $i;$i++; ?>
                                              <td> <?= date('d-M-Y H:i A',strtotime($val['kanta_parchi_datetime'])) ?></td>                                               
                                              <td> <?= isset($val['actual_weight']) && ($val['actual_weight']) ? number_format($val['actual_weight'],2) : '-' ?></td> 
                                              <td> <?php $kanta_parchi = isset($val['kanta_parchi']) && ($val['kanta_parchi']) ? $val['kanta_parchi'] : '' ?>                                                  
                                                  <a href="<?= base_url('public/uploads/kanta_parchies/').$kanta_parchi  ?>"  target="_blank" style="margin-left: 7px;width: 200px;">
                                                  <img src="<?= base_url('public/uploads/kanta_parchies/').$kanta_parchi  ?>" class="img-fluid" alt="Logo" height="100" width="100" />
                                                  </a>     
                                              </td>
                                            </tr>
                                          <?php } ?> 
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?>

                            <!-- uploaded_pods_details -->
                            <?php if(isset($uploaded_pods_details) && !empty($uploaded_pods_details)){?>
                            <div class="col-lg-12 col-md-12 d-flex">
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Uploaded POD Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                      <table class="table table-bordered print-tbl">
                                        <tbody>
                                          <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Received By</th>
                                            <th>Status</th> 
                                            <th>Document</th>  
                                          </tr>   
                                          <?php
                                          $i = 1;
                                          foreach ($uploaded_pods_details as $val) {
                                          ?>
                                            <tr>
                                              <td><?= $i;$i++; ?>
                                              <td> <?= date('d-M-Y H:i A',strtotime($val['pod_date'])) ?></td>
                                              <td> <?= isset($val['received_by']) && ($val['received_by']) ? $val['received_by'] : '-' ?></td>
                                              <td> <?= isset($val['status']) && ($val['status'] == 1 ) ? 'Active' : 'Not Active' ?></td> 
                                              <td> <?php $upload_doc = isset($val['upload_doc']) && ($val['upload_doc']) ? $val['upload_doc'] : '' ?>                                                  
                                                  <a href="<?= base_url('public/uploads/booking_pods/').$upload_doc  ?>"  target="_blank" style="margin-left: 7px;width: 200px;">
                                                  <img src="<?= base_url('public/uploads/booking_pods/').$upload_doc  ?>" class="img-fluid" alt="Logo" height="100" width="100" />
                                                  </a>     
                                              </td>
                                            </tr>
                                          <?php } ?> 
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
 
                            <!-- trip_update_details -->
                            <?php if(isset($trip_update_details) && !empty($trip_update_details)){?>
                            <div class="col-lg-12 col-md-12 d-flex"  >
                              <div class="security-grid flex-fill">
                                <div class="security-header">
                                  <div class="security-heading">
                                      <h4>Trip Update Details:</h4>
                                  </div><hr>

                                  <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered print-tbl" width="100%">
                                            <tbody>
                                              <tr>
                                                <th width="10%">#</th>
                                                <th width="10%">Date</th>
                                                <th width="10%">Location</th>
                                                <th width="30%">Remarks</th> 
                                                <th width="10%">Purpose Of Update</th>
                                                <th width="10%">Fuel</th>
                                                <th width="10%">Money</th> 
                                                <th width="10%">Created By</th>
                                              </tr>   
                                              <?php
                                              $i = 1;
                                              foreach ($trip_update_details as $val) {
                                              ?>
                                                <tr>
                                                  <td><?= $i;$i++; ?>
                                                  <td> <?= date('d-M-Y',strtotime($val['status_date'])) ?></td> 
                                                  <td> <?= isset($val['location']) && ($val['location']) ? ucfirst($val['location']) : '-' ?></td>
                                                  <td style="white-space: break-spaces !important;" > THE VEHICLE HAS UNLOADED BUT POD DID NOT SEND	<?= isset($val['remarks']) && ($val['remarks']) ? ucfirst($val['remarks']) : '-' ?></td>
                                                  <td><?= isset($val['purpose_of_update_name']) && ($val['purpose_of_update_name']) ? $val['purpose_of_update_name'] : '-' ?></td>   
                                                  <td> <?= isset($val['fuel']) && ($val['fuel']) ? number_format($val['fuel'],2) : '-' ?></td>
                                                  <td> <?= isset($val['money']) && ($val['money']) ? number_format($val['money'],2) : '-' ?></td> 
                                                  <td> <?= ($val['created_by_name']) ? ucwords($val['created_by_name']) : '-' ?></td>
                                                </tr>
                                              <?php } ?> 
                                            </tbody>
                                          </table>
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