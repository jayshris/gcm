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
                                                <h4>Preview Tax Invoice</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>Tax Invoice No.: </b></label>
                                                        <label class="col-form-label"><?= $invoice['invoices_no'] ?></label>
                                                    </div>

													<div class="col-md-6">
                                                        <label class="col-form-label"><b>Booking No.: </b></label>
                                                        <label class="col-form-label"><?= $invoice['booking_number'] ?></label>
                                                    </div>

													<div class="col-md-6">
                                                        <label class="col-form-label"><b>Customer Name: </b></label>
                                                        <label class="col-form-label"><?= $invoice['party_name'] ?></label>
                                                    </div>

													<div class="col-md-6">
                                                        <label class="col-form-label"><b>Total Freight: </b></label>
                                                        <label class="col-form-label"><?= 'Rs.'.$invoice['total_freight'] ?></label>
                                                    </div>


                                                </div>
                                                <br>
                                            </div> 
                                            <div class="submit-button"> 
											<button type="button" class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                                <a href="<?php echo base_url().$currentController; ?>" class="btn btn-light">Cancel</a>
                                            </div>  

											<div class="card" id="printableArea" style="display: none;">
											<div class="card-body">
											<table cellspacing="0" id="printTable" class="print-table">
												<tbody> 
													<tr style="height:77pt"> 
														<td colspan="7" class="td-head">
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
																	Mobile : 7669027902, EMail :booking@gaegroup.in
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
														<td class="s6td" colspan="7">
															<p class="s6 p13 txt-center">
																<span class="s7">TAX &nbsp;INVOICE</span>
															</p>
														</td>
													</tr>
													
													<tr style="height:21pt"> 
														<td class="td27" colspan="3" rowspan="5">
															<p class="s10 p14"><?= $invoice['party_name'] ?></p>
															<p class="s10 p14"><?= $invoice['business_address'] ?></p>
															<p class="s10 p14"><?= $invoice['city'] .', '.$invoice['state_name'] .'-'.$invoice['postcode'] ?></p>
														</td> 
														<td class="td29" colspan="4">
															<p class="s10 p14" >NO - <?= $invoice['invoices_no'] ?> </p>
														</td>
														
													</tr>
													<tr style="height:21pt">  
														<td  class="td33" colspan="4">
															<p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">Date - <?= date('d M Y'); ?></p> 
														</td>
													</tr>
													<tr style="height:21pt">  
														<td  class="td33" colspan="4">
															<p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">BOOKING NUMBER - <?= $invoice['booking_number'] ?></p> 
														</td>
													</tr>
													<tr style="height:21pt">  
														<td  class="td33" colspan="4">
															<p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">BOOKING DATE - <?= date('d M Y',strtotime($invoice['booking_date'])) ?></p> 
														</td>
													</tr>
													<tr style="height:21pt">  
														<td  class="td33" colspan="4">
															<p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">VEHICLE NO - <?= $invoice['rc_number'] ?></p> 
														</td>
													</tr>

													<tr style="height:21pt"> 
														<td class="td27" colspan="3">
															<p class="s10 p14" >EMAIL:- <?= $invoice['email'] ?></p>
														</td> 
														<td class="td29" colspan="4">
															<p class="s10 p14" >PLACE OF DEPARTURE - <?= $invoice['pickup_state'] ?></p>
														</td>
													</tr>

													<tr style="height:21pt"> 
														<td class="td27" colspan="3">
															<p class="s10 p14" >MOBILE:- <?= $invoice['primary_phone'] ?></p>
														</td> 
														<td class="td29" colspan="4">
															<p class="s10 p14" >PLACE OF DESTINATION - <?= $invoice['drop_state'] ?></p>
														</td>                                                
													</tr>

													<tr style="height:21pt"> 
														<td class="td27" colspan="3">
															<p class="s10 p14" >CONTACT PERSON:- <?= $invoice['contact_person'] ?></p>
														</td> 
														<td class="td29" colspan="4">
															<p class="s10 p14" ></p>
														</td>
													</tr>

													<tr style="height:21pt"> 
														<td class="td27" colspan="3">
															<p class="s10 p14" ></p>
														</td> 
														<td class="td29" colspan="4">
															<p class="s10 p14" >WEIGHT- <?= ($invoice['guranteed_wt'] >0) ? $invoice['guranteed_wt'] : 0 .' KG' ?></p>
														</td>
													</tr>

													<tr style="height:21pt"> 
														<td class="td27" colspan="3">
															<p class="s10 p14" ></p>
														</td> 
														<td class="td29" colspan="4">
															<p class="s10 p14" >PAYMENT TERMS -</p>
														</td>
													</tr>

													<tr style="height:11pt">
														<td  class="td34" >
															<p class="s9 p12" style="padding-left: 24pt;">S.N</p>
														</td>
														<td  class="td35">
															<p class="s9 p16" >Particulars</p>
														</td>
														<td  class="td36" >
															<p class="s9 p16" ></p>
														</td>
														<td  class="td36" >
															<p class="s9 p16" >Qty.</p>
														</td>
														<td  class="td37" >
															<p class="s9 p12" style="padding-left: 19pt;">Unit</p>
														</td>
														<td  class="td38" >
															<p class="s9 p16" >Price</p>
														</td>
														<td  class="td39" >
															<p class="s9 p16" >Amount</p>
														</td>
													</tr>
													<tr style="height:21pt">
														<td  class="td40" >
															<p class="s10" style="padding-left: 22pt;padding-right: 2pt;text-indent: -19pt;line-height: 10pt;text-align: left;">1.</p>
														</td>
														<td class="td41" >
															<p class="s10 p11" >Frieght Charges</p>
														</td>
														<td class="td42" >
															<p class="s10 p11" ></p>
														</td>
														<td class="td41" >
															<p class="s10 p11" ><?= ($invoice['guranteed_wt'] >0) ? $invoice['guranteed_wt'] : 0 ?></p>
														</td>
														<td class="td43" >
															<p class="s10 p11" >KG</p>
														</td>
														<td class="td44" >
															<p class="s10 p11" ><?= $invoice['total_freight'] ?></p>
														</td>
														<td class="td45" >
															<p class="s10 p11" ><?= $invoice['total_freight'] ?></p>
														</td>
													</tr>
													<?php 
													if(!empty($booking_expences)){
														foreach($booking_expences as $booking_expence){ ?>
															<tr style="height:11pt">
																<td class="td46" colspan="5">
																	<p class="s10 p12 prtds10"><?= ($booking_expence['head_name']) ? ucfirst($booking_expence['head_name']) : '' ?></p>
																</td> 
																<td class="td48" colspan="2">
																	<p class="s11 p12 fntb" style="padding-left: 44pt;"><?= $booking_expence['value'] ?></p>
																</td>
															</tr> 
														<?php }
													}
													?>
													<tr style="height:11pt">
														<td class="td46" colspan="5">
															<p class="s10 p12 prtds10">SGST @ 6%</p>
														</td> 
														<td class="td48" colspan="2">
															<p class="s11 p12 fntb" style="padding-left: 44pt;">0</p>
														</td>
													</tr> 
													<tr style="height:11pt">
														<td class="td46" colspan="5">
															<p class="s10 p12 prtds10">CGST @ 6%</p>
														</td> 
														<td class="td48" colspan="2">
															<p class="s11 p12 fntb" style="padding-left: 44pt;">0</p>
														</td>
													</tr> 
													<tr style="height:11pt">
														<td class="td46" colspan="5">
															<p class="s10 p12 prtds10">IGST @ 6%</p>
														</td> 
														<td class="td48" colspan="2">
															<p class="s11 p12 fntb" style="padding-left: 44pt;">0</p>
														</td>
													</tr> 
													<tr style="height:11pt">
														<td class="td46" colspan="5">
															<p class="s10 p12 prtds10">Total Invoice Value</p>
														</td> 
														<td class="td48" colspan="2">
															<p class="s11 p12 fntb" style="padding-left: 44pt;"><?= $invoice['total_freight'] ?></p>
														</td>
													</tr>  
													<tr style="height:11pt">
														<td class="td34" colspan="7">
															<table border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td class="profotd34">Tax Rate</td>
																	<td class="profotd34">Taxable Amt.</td>
																	<td class="profotd34">SGST</td>
																	<td class="profotd34">IGST</td>
																	<td class="profotd34">CGST</td>
																	<td class="profotd34">Total Tax</td>
																</tr>
																<tr>
																	<td class="profotd34"></td>
																	<td class="profotd34"><?= $invoice['total_freight'] ?></td>
																	<td class="profotd34">0</td>
																	<td class="profotd34">0</td>
																	<td class="profotd34">0</td>
																	<td class="profotd34">0</td>
																</tr>
																<tr>
																	<td class="profotd34">Amount (in words)</td>
																	<?php $amount = ($invoice['total_freight'] > 0) ? $invoice['total_freight'] : 0; ?>
																	<td colspan="5" class="profotd34">Rs. <?= convert_number_to_words($amount) ?> Only</td>
																</tr>
															</table>
														</td>
													</tr>
													<tr style="height:11pt"> 
														<td class="td34">
															<p class="s9 p12" style="padding-left: 24pt;">Bank Detail:</p>
														</td>
														<td class="td52" colspan="6">
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
															Bank Name:ICICI Bank
															</p>
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
															Branch Name: BG-221, SNJAY GANDHI TRANSPORT NAGAR, DELHI - 110042
															</p>
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
															A/C NO: 723505000126
															</p>
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
															IFSC: ICIC0007235
															</p>
														</td>
													</tr>
		
													<tr style="height:59pt">                                                
														<td colspan="4" rowspan="2"  class="td63">
															<p class="s9 pdl12 pdl8">
															Terms & Conditions:  
															</p> 
															<p class="s9 pdl12 pdl8">
															E. & OE.<br/>
															1.Description of service : Transport of Goods by Road <br/>
															2.Interest @ 18% p.a will be charged if the payment for GAE CARGO MOVERS PVT LTD is not made within the stipulated time.<br/>
															3. Subject to 'Delhi'Jurisdiction only.<br/>
															</p> 
														</td>
														<td colspan="4" class="td63">
															<p class="s9 pdl12 pdl8">
															Receiver's Signature:  
															</p> 
														</td>
													
													</tr>
													<tr style="height:45pt">
														<td colspan="4" class="td64">
															<p class="s9 p17 mrg-tp5">
																For GAE CARGO MOVERS PRIVATE LIMITED</p>
															<p class="p18"><span></span></p>
															<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
																<tbody>
																	<tr>
																		<td style="text-align: center;">
																			<img width="105" height="70" src="http://localhost/gcm/public/assets/img/print-consignment-sign.png">
																		</td>
																	</tr>
																</tbody>
															</table>
															<p></p>
															<p class="s9 p17">
																SIGNATURE OF THE ISSUING OFFICE
															</p>
														</td>
													</tr>
													<tr style="height:11pt">
														<td class="td52" colspan="7">
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
																Remarks:
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