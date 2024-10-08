<body>
  <div class="main-wrapper">

    <div class="page-wrapper">
      <div class="content">

        <style>
          table,
          tr,
          td {
            border: 1px solid black;
            border-collapse: collapse;
          }
        </style>

        <table style="width: 100%;">
          <tr>
            <td colspan="6" style="text-align: center;height: 50px;">
              <h2>Booking Report</h2>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center; height: 30px;">
              <h4>Booking Details</h4>
            </td>
            <td colspan="2" style="text-align: center; height: 30px;">
              <h4>Customer Details</h4>
            </td>
            <td colspan="2" style="text-align: center; height: 30px;">
              <h4>Vehicle Details</h4>
            </td>
          </tr>
          <tr>
            <td style="width: 13%;">Booking Number:</td>
            <td style="width: 20%;"><?php echo isset($booking_details['booking_number']) && !empty($booking_details['booking_number']) ? $booking_details['booking_number'] : '-'; ?></td>
            <td style="width: 13%;">Customer Name: </td>
            <td style="width: 20%;"><?php echo isset($booking_details['customer']) && !empty($booking_details['customer']) ? $booking_details['customer'] : '-'; ?></td>
            <td style="width: 13%;">Vehicle RC: </td>
            <td style="width: 20%;"><?php echo isset($booking_details['rc_number']) && !empty($booking_details['rc_number']) ? $booking_details['rc_number'] : '-'; ?></td>
          </tr>
          <tr>
            <td>Booking Date:</td>
            <td><?php echo isset($booking_details['booking_date']) && !empty($booking_details['booking_date']) ? date('d-F-Y', strtotime($booking_details['booking_date'])) : '-'; ?></td>
            <td>Contact Person: </td>
            <td><?php echo isset($booking_details['contact_person']) && !empty($booking_details['contact_person']) ? $booking_details['contact_person'] : '-'; ?></td>
            <td>Driver Name: </td>
            <td><?php echo isset($driver['driver_name']) && !empty($driver['driver_name']) ? $driver['driver_name'] : '-'; ?></td>
          </tr>
          <tr>
            <td>Booking By: </td>
            <td> <?php echo isset($booking_details['booking_by_name']) && !empty($booking_details['booking_by_name']) ? $booking_details['booking_by_name'] : '-'; ?></td>
            <td>Customer City: </td>
            <td> <?php echo isset($booking_details['cb_city']) && !empty($booking_details['cb_city']) ? $booking_details['cb_city'] : '-'; ?></td>
            <td>Driver Phone No.: </td>
            <td><?php echo isset($driver['primary_phone']) && !empty($driver['primary_phone']) ? $driver['primary_phone'] : '-'; ?></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>Contact Phone No.: </td>
            <td><?php echo isset($booking_details['primary_phone']) && !empty($booking_details['primary_phone']) ? $booking_details['primary_phone'] : '-'; ?></td>
            <td></td>
            <td></td>
          </tr>
        </table>
        <br>

        <table style="width: 100%;">
          <tr>
            <td colspan="2" style="text-align: center; height: 30px;">
              <h4>Pickup Details</h4>
            </td>
            <td colspan="2" style="text-align: center; height: 30px;">
              <h4>Drop Details</h4>
            </td>
            <td colspan="2" style="text-align: center; height: 30px;">
              <h4>Weight & Payment Details</h4>
            </td>
          </tr>
          <tr>
            <td style="width: 13%;">Pickup Date: </td>
            <td style="width: 20%;"><?php echo isset($booking_details['pickup_date']) && (strtotime($booking_details['pickup_date']) > 0) ? date('d-F-Y', strtotime($booking_details['pickup_date'])) : '-'; ?></td>
            <td style="width: 13%;">Drop Date: </td>
            <td style="width: 20%;"><?php echo isset($booking_details['drop_date']) && (strtotime($booking_details['drop_date']) > 0) ? date('d-F-Y', strtotime($booking_details['drop_date'])) : '-'; ?></td>
            <td style="width: 20%;">Guaranteed / Charged Weight: </td>
            <td style="width: 13%;"><?php echo isset($booking_details['guranteed_wt']) && !empty($booking_details['guranteed_wt']) ? number_format($booking_details['guranteed_wt'], 2) . ' kg' : ''; ?></td>
          </tr>
          <tr>
            <td>Pickup City: </td>
            <td><?php echo isset($booking_pickups['city']) && !empty($booking_pickups['city']) ? $booking_pickups['city'] : '-'; ?></td>
            <td>Drop City: </td>
            <td><?php echo isset($booking_drops['city']) && !empty($booking_drops['city']) ? $booking_drops['city'] : '-'; ?></td>
            <td>Total Freight: </td>
            <td><?= isset($booking_details['freight']) && !empty($booking_details['freight']) ? 'Rs ' . number_format($booking_details['freight'], 2) : ''; ?></td>
          </tr>
          <tr>
            <td>Pickup State: </td>
            <td><?php echo isset($booking_pickups_state['state_name']) && !empty($booking_pickups_state['state_name']) ? $booking_pickups_state['state_name'] : '-'; ?></td>
            <td>Drop State: </td>
            <td><?php echo isset($booking_drops_state['state_name']) && !empty($booking_drops_state['state_name']) ? $booking_drops_state['state_name'] : '-'; ?></td>
            <td>Advance: </td>
            <td><?= isset($booking_details['advance']) && !empty($booking_details['advance']) ? 'Rs ' . number_format($booking_details['advance'], 2) : ''; ?></td>
          </tr>
          <tr>
            <td>Pickup Postcode: </td>
            <td><?php echo isset($booking_pickups['pincode']) && !empty($booking_pickups['pincode']) ? $booking_pickups['pincode'] : '-'; ?></td>
            <td>Drop Postcode: </td>
            <td><?php echo isset($booking_drops['pincode']) && !empty($booking_drops['pincode']) ? $booking_drops['pincode'] : '-'; ?></td>
            <td>Discount: </td>
            <td><?= isset($booking_details['discount']) && !empty($booking_details['discount']) ? 'Rs ' . number_format($booking_details['discount'], 2) : ''; ?></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Balance: </td>
            <td><?= isset($booking_details['balance']) && !empty($booking_details['balance']) ? 'Rs ' . number_format($booking_details['balance'], 2) : ''; ?></td>
          </tr>
          <tr>
            <td style=" height: 30px;">
              <h4>Remarks:</h4>
            </td>
            <td colspan="5"><?= isset($booking_details['remarks']) ? $booking_details['remarks'] : ''; ?></td>
          </tr>
        </table>
        <br>

        <?php
        if (isset($booking_expences) && !empty($booking_expences)) {
        ?>
          <table style="width: 100%;">
            <tr>
              <td colspan="2" style="text-align: center; height: 30px;">
                <h4>Expense Details</h4>
              </td>
            </tr>
            <tr>
              <td style="width: 20%;" align="center">Head</td>
              <td align="center">Value</td>
            </tr>
            <?php
            $i = 1;
            foreach ($booking_expences as $be) {
            ?>
              <tr>
                <td> <?php echo isset($be['head_name']) && !empty($be['head_name']) ? $be['head_name'] . ' (Rs.)' : '-' ?> </td>
                <td> <?php echo isset($be['value']) && !empty($be['value']) ? $be['value'] : '-' ?> </td>
              </tr>
            <?php
              $i++;
            } ?>
          </table>
        <?php
        }
        ?>
        <br>

        <?php
        if (isset($booking_expences) && !empty($booking_expences)) {
        ?>
          <table style="width: 100%;">
            <tr>
              <td colspan="2" style="text-align: center; height: 30px;">
                <h4>PTL Booking Details</h4>
              </td>
            </tr>
            <tr>
              <td style="width: 20%;">No. Of Bookings Linked: </td>
              <td><?php echo isset($ptl_bookings['ptl_cnt']) && ($ptl_bookings['ptl_cnt'] > 0) ? $ptl_bookings['ptl_cnt'] : 0; ?></td>
            </tr>
            <tr>
              <td>Customer Name: </td>
              <td><?php echo isset($ptl_bookings['ptl_customers']) && !empty($ptl_bookings['ptl_customers']) ? $ptl_bookings['ptl_customers'] : '-'; ?></td>
            </tr>
            <tr>
              <td>Bookings Numbers: </td>
              <td><?php echo isset($ptl_bookings['ptl_bokking_no']) && !empty($ptl_bookings['ptl_bokking_no']) ? $ptl_bookings['ptl_bokking_no'] : '-'; ?></td>
            </tr>
            <tr>
              <td>Total Charged Weight: </td>
              <td><?php echo isset($booking_total['total_charged_weight']) && ($booking_total['total_charged_weight'] > 0) ? number_format($booking_total['total_charged_weight'], 2) . ' kg' : 0; ?></td>
            </tr>
            <tr>
              <td>Total Freight: </td>
              <td><?php echo isset($booking_total['total_freight']) && ($booking_total['total_freight'] > 0) ? 'Rs ' . number_format($booking_total['total_freight'], 2) : 0; ?></td>
            </tr>
          </table>
        <?php
        }
        ?>
      </div>

    </div>

</body>