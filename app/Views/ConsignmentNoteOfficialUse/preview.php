<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/print_report.css"> 
    <style>
        @media print {
            .printableArea { 
                display: block;
            } 
        }
    </style>
</head>
<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<?= $this->include('partials/menu') ?> 
        <hr>
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				<div class="row">
					<div class="col-md-12"> 
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<!-- Settings Info -->
								<div class="card">
									<div class="card-body">
										<div class="settings-form"> 
                                            <div class="settings-sub-header">
                                                <h4>Preview Consignment Note For Office Use</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Consignment No: </label>
                                                        <label class="col-form-label"><?= $lr['consignment_no'] ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Booking Number: </label>
                                                        <label class="col-form-label"><?= $lr['booking_number'] ?></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Customer Name: </label>
                                                        <label class="col-form-label"><?= $lr['customer'] ?></label>  
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Booking Date: </label>
                                                        <label class="col-form-label"><?= date('d M Y',strtotime($lr['booking_date'])) ?></label> 
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Pick Location: </label> 
                                                        <label class="col-form-label"><?= $lr['bp_city'] ?></label>    
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Drop Location: </label>
                                                        <label class="col-form-label"><?= $lr['bd_city'] ?></label> 
                                                    </div>
 
                                                </div>
                                                <br>
                                            </div> 
                                            <div class="submit-button noprint"> 
                                                <button type="button" class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                                <a href="<?php echo base_url().$currentController; ?>" class="btn btn-light">Cancel</a>
                                            </div>  
										</div>
									</div>
								</div>
								<!-- /Settings Info -->
                                
                                <div class="card" id="printableArea" style="display: none;">
                                    <div class="card-body">
                                    <table cellspacing="0" id="printTable" class="print-table">
                                        <tbody> 
                                            <tr style="height:77pt"> 
                                                <td colspan="6" class="td-head">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <img width="105" height="47" src="<?php echo base_url(); ?>public/assets/img/logo.png">
                                                                </td>
                                                                <td>
                                                                    <p class="s1 txt-center mh"> 
                                                                        GAE CARGO MOVERS PRIVATE LIMITED 
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table> 
                                                    <p class="sub-headerpr">
                                                        A-131/2, 2nd Floor, Wazirpur Industrial Area, Delhi- 110052
                                                    </p>
                                                    <p class="sub-headerpr">
                                                        <a href="mailto:gaecargo21@yahoo.com" class="s4" target="_blank">
                                                            Mobile : 7669027900, EMail :booking@gaegroup.in
                                                        </a>
                                                    </p> 
                                                    <p class="sub-headerpr">
                                                        <span>PAN NO - AAICG9037G</span> &nbsp;
                                                        <span>GSTIN - 07AAICG9037G1ZF</span> <br/>
                                                        <span>CIN - U63030DL2021PTC378353</span> &nbsp;
                                                        <span>MSME - UDYAM-DL-06-0016237</span>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr style="height:21pt">
                                                <td class="s6td" colspan="6">
                                                    <p class="s6 p13">
                                                        <span class="s6 td-sub">
                                                        Subject to Delhi Jurisdiction         
                                                        </span>
                                                        <span class="s7">CONSIGNMENT NOTE</span> Official Use Only
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr style="height:21pt">
                                                <td class="td1" colspan="3">
                                                    <p class="s9 tdp1">ConsignmentNo   <span class="s10"><?= $lr['consignment_no'] ?></span></p>
                                                    <p class="s9 tdp2">ConsignmentDate   <span class="s10"><?= date('d M Y', strtotime($lr['consignment_date'])) ?></span></p>
                                                </td>
                                                <td class="td2" colspan="3">
                                                    <p class="s9 tdp1">BookingBranch   <span class="s10"><?= isset($lr['branch_name']) && (!empty($lr['branch_name'])) ? $lr['branch_name'] : '-' ?></span></p>
                                                    <p class="s9 tdp2">SealNo</p>
                                                </td>
                                            </tr>
                                            <tr style="height:27pt">
                                                <td class="td3" colspan="2">
                                                    <p class="s9 tdp1" style="padding-left: 61pt;">LoadingStation</p>
                                                    <p class="s10" style="padding-left: 60pt;"><?= isset($lr['loading_station']) && (!empty($lr['loading_station'])) ? $lr['loading_station'] : '-' ?></p>
                                                </td>
                                                <td class="td4" colspan="2">
                                                    <p class="s9 s9txt">DeliveryStation</p>
                                                    <p class="s10 s9txt"><?= isset($lr['delivery_station']) && (!empty($lr['delivery_station'])) ? $lr['delivery_station'] : '-' ?></p>
                                                </td>
                                                <td class="td5" colspan="2">
                                                    <p class="s9 s9txt">Vehicle Number</p>
                                                    <p class="s10 s9txt"><?= isset($lr['rc_number']) && (!empty($lr['rc_number'])) ? $lr['rc_number'] : '-' ?></p>
                                                </td>
                                            </tr>
                                            <tr style="height:20pt">
                                                <td class="td6">
                                                    <p class="s9 p14" >Billing Party Name</p>
                                                </td>
                                                <td class="td7" colspan="2">
                                                    <p class="s10 p14" ><?= isset($lr['bill_to_party_nm']) && (!empty($lr['bill_to_party_nm'])) ? strtoupper($lr['bill_to_party_nm']) : '-' ?></p>
                                                </td>
                                                <td class="td8">
                                                    <p class="s9 p14" style="padding-left: 3pt;">Billing Party Add</p>
                                                </td>
                                                <td class="td9" colspan="2">
                                                    <p class="p14"><?= isset($lr['bill_to_address']) && (!empty($lr['bill_to_address'])) ? strtoupper($lr['bill_to_address']) : '-' ?></p>
                                                </td>
                                            </tr>
                                            <tr style="height:21pt">
                                                <td class="td10">
                                                    <p class="s9 p14" >Billing Party Email</p>
                                                </td>
                                                <td class="td11" colspan="2">
                                                    <p class="p14"  ><br></p>
                                                </td>
                                                <td  class="td12">
                                                    <p class="s9 p14" style="padding-left: 3pt;">Billing Party Phone</p>
                                                </td>
                                                <td  class="td13" colspan="2">
                                                    <p class=" p14" ><?= isset($lr['bill_to_phone']) && (!empty($lr['bill_to_phone'])) ? strtoupper($lr['bill_to_phone']) : '-' ?></p>
                                                </td>
                                            </tr>
                                            <tr style="height:21pt">
                                                <td  class="td14">
                                                    <p class="s9 p14" >Billing Party GSTIN</p>
                                                </td>
                                                <td class="td15" colspan="2">
                                                    <p class=" p14" ><br></p>
                                                </td>
                                                <td class="td16">
                                                    <p class="s9 p14" >Billing Party Pan</p>
                                                </td>
                                                <td class="td17" colspan="2">
                                                    <p class=" p14" ><br></p>
                                                </td>
                                            </tr>
                                            <tr style="height:20pt">
                                                <td class="td18">
                                                    <p class="s9 p14" >ConsignorName</p>
                                                </td>
                                                <td class="td19" colspan="2">
                                                    <p class="s10 p14" ><?= isset($lr['consignor_name']) && (!empty($lr['consignor_name'])) ? strtoupper($lr['consignor_name']) : '-' ?></p>
                                                </td>
                                                <td class="td20">
                                                    <p class="s9 p14" >Consignee Name</p>
                                                </td>
                                                <td class="td21" colspan="2">
                                                    <p class="s10 p14" ><?= isset($lr['consignee_name']) && (!empty($lr['consignee_name'])) ? strtoupper($lr['consignee_name']) : '-' ?></p>
                                                </td>
                                            </tr>
                                            <tr style="height:61pt">
                                                <td class="td22">
                                                    <p class="s9 p14" >Consignor Address</p>
                                                </td>
                                                <td class="td23" colspan="2">
                                                    <p class="s10 p15" ><?= isset($lr['consignor_address_f']) && (!empty($lr['consignor_address_f'])) ? strtoupper($lr['consignor_address_f']) : '-' ?></p>
                                                </td>
                                                <td class="td24">
                                                    <p class="s9 p14" >Consignee Address</p>
                                                </td>
                                                <td class="td25" colspan="2">
                                                    <p class="s10" style="text-indent: 0pt;line-height: 21pt;text-align: left;"><?= isset($lr['consignee_address_f']) && (!empty($lr['consignee_address_f'])) ? strtoupper($lr['consignee_address_f']) : '-' ?></p> 
                                                </td>
                                            </tr>
                                            <tr style="height:21pt">
                                                <td class="td26">
                                                    <p class="s9 p14" >GSTIN</p>
                                                </td>
                                                <td class="td27" colspan="2">
                                                    <p class="s10 p14" ><?= isset($lr['consignor_GSTIN']) && (!empty($lr['consignor_GSTIN'])) ? strtoupper($lr['consignor_GSTIN']) : '-' ?></p>
                                                </td>
                                                <td class="td28">
                                                    <p class="s9 p14" >GSTIN</p>
                                                </td>
                                                <td class="td29" colspan="2">
                                                    <p class="s10 p14" ><?= isset($lr['consignee_GSTIN']) && (!empty($lr['consignee_GSTIN'])) ? strtoupper($lr['consignee_GSTIN']) : '-' ?></p>
                                                </td>
                                            </tr>
                                            <tr style="height:64pt">
                                                <td class="td30">
                                                    <p class="s9 p14" >Place of Dispatch</p>
                                                </td>
                                                <td  class="td31" colspan="2">
                                                    <p class="s10 p15" ><?= isset($lr['place_of_dispatch_address_f']) && (!empty($lr['place_of_dispatch_address_f'])) ? strtoupper($lr['place_of_dispatch_address_f']) : '-' ?></p>
                                                </td>
                                                <td  class="td32">
                                                    <p class="s9 p14" >Place of Delivery</p>
                                                </td>
                                                <td  class="td33" colspan="2">
                                                    <p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;"><?= isset($lr['place_of_delivery_pincode_f']) && (!empty($lr['place_of_delivery_pincode_f'])) ? strtoupper($lr['place_of_delivery_pincode_f']) : '-' ?></p> 
                                                </td>
                                            </tr>
                                            <tr style="height:11pt">
                                                <td  class="td34" >
                                                    <p class="s9 p12" style="padding-left: 24pt;">Particulars</p>
                                                </td>
                                                <td  class="td35">
                                                    <p class="s9 p16" >HSNCode</p>
                                                </td>
                                                <td  class="td36" >
                                                    <p class="s9 p16" >No.ofPackages</p>
                                                </td>
                                                <td  class="td37" >
                                                    <p class="s9 p12" style="padding-left: 19pt;">ActualWeight</p>
                                                </td>
                                                <td  class="td38" >
                                                    <p class="s9 p16" >Charge Weight</p>
                                                </td>
                                                <td  class="td39" >
                                                    <p class="s9 p16" >PaymentTerms</p>
                                                </td>
                                            </tr>
                                            <tr style="height:21pt">
                                                <td  class="td40" >
                                                    <p class="s10" style="padding-left: 22pt;padding-right: 2pt;text-indent: -19pt;line-height: 10pt;text-align: left;"><?= isset($lr['particulars']) && (!empty($lr['particulars'])) ? strtoupper($lr['particulars']) : '-' ?></p>
                                                </td>
                                                <td class="td41" >
                                                    <p class="s10 p11" ><?= isset($lr['hsn_code']) && (!empty($lr['hsn_code'])) ? strtoupper($lr['hsn_code']) : '-' ?></p>
                                                </td>
                                                <td class="td42" >
                                                    <p class="s10 p11" ><?= isset($lr['no_of_packages']) && (!empty($lr['no_of_packages'])) ? strtoupper($lr['no_of_packages']) : '-' ?></p>
                                                </td>
                                                <td class="td43" >
                                                    <p class="s10 p11" ><?= isset($lr['actual_weight']) && (!empty($lr['actual_weight'])) ? strtoupper($lr['actual_weight']) : '-' ?></p>
                                                </td>
                                                <td class="td44" >
                                                    <p class="s10 p11" ><?= isset($lr['charge_weight']) && (!empty($lr['charge_weight'])) ? strtoupper($lr['charge_weight']) : '-' ?></p>
                                                </td>
                                                <td class="td45" >
                                                    <p class="s10 p11" ><?= isset($lr['payment_terms']) && (!empty($lr['payment_terms'])) ? strtoupper($lr['payment_terms']) : '-' ?></p>
                                                </td>
                                            </tr>
                                            <tr style="height:11pt">
                                                <td class="td46" colspan="2">
                                                    <p class="s10 p12" style="padding-left: 54pt;">EWAYBill Number</p>
                                                </td>
                                                <td class="td47" colspan="2">
                                                    <p class="s10 p12" style="padding-left: 52pt;">EWAYBillExpiryDate</p>
                                                </td>
                                                <td class="td48" colspan="2">
                                                    <p class="s11 p12" style="padding-left: 44pt;">FreightChargesAmount</p>
                                                </td>
                                            </tr>
                                            <tr style="height:13pt">
                                                <td class="td49" colspan="2">
                                                    <p class="s10 p11" ><?= isset($lr['e_way_bill_number']) && (!empty($lr['e_way_bill_number'])) ? strtoupper($lr['e_way_bill_number']) : '-' ?></p>
                                                </td>
                                                <td class="td50" colspan="2">
                                                    <p class="s10 p11" ><?= isset($lr['e_way_expiry_date']) && (strtotime($lr['e_way_expiry_date'])>0) ? date('d/m/Y',strtotime($lr['e_way_expiry_date'])) : '-' ?></p>
                                                </td>
                                                <td class="td51" colspan="2">
                                                    <p class="s11 p11" ><?= isset($lr['freight_charges_amount']) && (!empty($lr['freight_charges_amount'])) ? strtoupper($lr['freight_charges_amount']) : '-' ?></p>
                                                </td>
                                            </tr>
                                            <tr style="height:11pt">
                                                <td class="td52" colspan="6">
                                                    <p class="s9" style="padding-left: 29pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;text-align: center;">PartyDocumentDetails</p>
                                                </td>
                                            </tr>
                                            <tr style="height:11pt">
                                                <td class="td53" colspan="2">
                                                    <p class="s9 p12" style="padding-left: 59pt;">Invoice/BOENo.</p>
                                                </td>
                                                <td class="td54" colspan="2">
                                                    <p class="s9 p12" style="text-align: center;">Invoice/BOEDate</p>
                                                </td>
                                                <td class="td55" colspan="2">
                                                    <p class="s9 p12 p16" >Invoice Value</p>
                                                </td>
                                            </tr>
                                            <tr style="height:11pt">
                                                <td class="td56" colspan="2">
                                                    <p class="s10 p12" style="padding-left: 60pt;"><?= isset($lr['invoice_boe_no']) && (!empty($lr['invoice_boe_no'])) ? strtoupper($lr['invoice_boe_no']) : '-' ?></p>
                                                </td>
                                                <td class="td57" colspan="2">
                                                    <p class="s10 p12" style="text-align: center;"><?= isset($lr['invoice_boe_date']) && (strtotime($lr['invoice_boe_date'])>0) ? date('d M y',strtotime($lr['invoice_boe_date'])) : '-' ?></p>
                                                </td>
                                                <td class="td58" colspan="2">
                                                    <p class="s10 p16" ><?= isset($lr['invoice_value']) && (!empty($lr['invoice_value'])) ? strtoupper($lr['invoice_value']) : '-' ?></p>
                                                </td>
                                            </tr>
                                            <tr style="height:16pt">
                                                <td class="td59" colspan="3">
                                                    <p class="s12" style="text-indent: 0pt;text-align: center;">Reporting Date/Time:<?= isset($lr['reporting_datetime']) && (strtotime($lr['reporting_datetime'])>0) ? date('d M y, h:i A',strtotime($lr['reporting_datetime'])) : '-' ?></p>
                                                </td>
                                                <td class="td60" colspan="3">
                                                    <p class="s12" style="text-indent: 0pt;text-align: center;">Releasing Date/Time:<?= isset($lr['releasing_datetime']) && (strtotime($lr['releasing_datetime'])>0) ? date('d M y, h:i A',strtotime($lr['releasing_datetime'])) : '-' ?></p>
                                                </td>
                                            </tr>
                                            <tr style="height:96pt">
                                                <td class="td61" colspan="3">
                                                    <p class="s12 p14" style="padding-top: 3pt;padding-left: 7pt;">Remarks:</p>
                                                </td>
                                                <td class="td62" colspan="3">
                                                    <p class="s12" style="padding-right: 29pt;text-indent: 0pt;text-align: center;">ForGAECARGOMOVERSPRIVATELIMITED</p>
                                                    <p class=" p14" style="padding-left: 75pt;"><span></span></p>
                                                    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="text-align: center;">
                                                                    <img width="105" height="70" src="<?php echo base_url(); ?>public/assets/img/print-consignment-sign.png">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <p></p>
                                                    <p class="s12" style="padding-right: 29pt;text-indent: 0pt;line-height: 8pt;text-align: center;">
                                                        SIGNATURE OF THE ISSUING OFFICE
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                    </div>
                                </div>
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
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>

</html>