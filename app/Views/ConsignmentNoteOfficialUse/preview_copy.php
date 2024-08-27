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
        <hr>
		<!-- Page Wrapper -->
		<div class="page-wrapper" style="margin:0;padding:0;">
			<div class="content">
				<div class="row">
					<div class="col-md-12"> 
						<div class="row">
							<div class="col-xl-12 col-lg-12">
                                
                                <div class="card" id="printableArea" style="display: block;">
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
                                                        <span class="s7">PROFORMA INVOICE</span>
                                                    </p>
                                                </td>
                                            </tr>
                                            
                                            <tr style="height:21pt"> 
                                                <td class="td27" colspan="3" rowspan="5">
                                                    <p class="s10 p14" >Address</p>
                                                </td> 
                                                <td class="td29" colspan="4">
                                                    <p class="s10 p14" >NO - </p>
                                                </td>
                                                
                                            </tr>
                                            <tr style="height:21pt">  
                                                <td  class="td33" colspan="4">
                                                    <p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">Date - </p> 
                                                </td>
                                            </tr>
                                            <tr style="height:21pt">  
                                                <td  class="td33" colspan="4">
                                                    <p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">BOOKING NUMBER - </p> 
                                                </td>
                                            </tr>
                                            <tr style="height:21pt">  
                                                <td  class="td33" colspan="4">
                                                    <p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">BOOKING DATE - </p> 
                                                </td>
                                            </tr>
                                            <tr style="height:21pt">  
                                                <td  class="td33" colspan="4">
                                                    <p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">VEHICLE NO - </p> 
                                                </td>
                                            </tr>

                                            <tr style="height:21pt"> 
                                                <td class="td27" colspan="3">
                                                    <p class="s10 p14" >EMAIL:-</p>
                                                </td> 
                                                <td class="td29" colspan="4">
                                                    <p class="s10 p14" >PLACE OF DEPARTURE - </p>
                                                </td>
                                            </tr>

                                            <tr style="height:21pt"> 
                                                <td class="td27" colspan="3">
                                                    <p class="s10 p14" >MOBILE:-</p>
                                                </td> 
                                                <td class="td29" colspan="4">
                                                    <p class="s10 p14" >PLACE OF DESTINATION - </p>
                                                </td>                                                
                                            </tr>

                                            <tr style="height:21pt"> 
                                                <td class="td27" colspan="3">
                                                    <p class="s10 p14" >CONTACT PERSON:-</p>
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
                                                    <p class="s10 p14" >WEIGHT- </p>
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
                                                    <p class="s10" style="padding-left: 22pt;padding-right: 2pt;text-indent: -19pt;line-height: 10pt;text-align: left;"><?= isset($lr['particulars']) && (!empty($lr['particulars'])) ? strtoupper($lr['particulars']) : '-' ?></p>
                                                </td>
                                                <td class="td41" >
                                                    <p class="s10 p11" ><?= isset($lr['hsn_code']) && (!empty($lr['hsn_code'])) ? strtoupper($lr['hsn_code']) : '-' ?></p>
                                                </td>
                                                <td class="td42" >
                                                    <p class="s10 p11" ><?= isset($lr['no_of_packages']) && (!empty($lr['no_of_packages'])) ? strtoupper($lr['no_of_packages']) : '-' ?></p>
                                                </td>
                                                <td class="td41" >
                                                    <p class="s10 p11" ><?= isset($lr['hsn_code']) && (!empty($lr['hsn_code'])) ? strtoupper($lr['hsn_code']) : '-' ?></p>
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
                                                <td class="td46" colspan="5">
                                                    <p class="s10 p12 prtds10">Detention</p>
                                                </td> 
                                                <td class="td48" colspan="2">
                                                    <p class="s11 p12 fntb" style="padding-left: 44pt;">0</p>
                                                </td>
                                            </tr> 
                                            <tr style="height:11pt">
                                                <td class="td46" colspan="5">
                                                    <p class="s10 p12 prtds10">Loading Charges</p>
                                                </td> 
                                                <td class="td48" colspan="2">
                                                    <p class="s11 p12 fntb" style="padding-left: 44pt;">0</p>
                                                </td>
                                            </tr> 
                                            <tr style="height:11pt">
                                                <td class="td46" colspan="5">
                                                    <p class="s10 p12 prtds10">Unloading Charges</p>
                                                </td> 
                                                <td class="td48" colspan="2">
                                                    <p class="s11 p12 fntb" style="padding-left: 44pt;">0</p>
                                                </td>
                                            </tr> 
                                            <tr style="height:11pt">
                                                <td class="td46" colspan="5">
                                                    <p class="s10 p12 prtds10">Other Charges</p>
                                                </td> 
                                                <td class="td48" colspan="2">
                                                    <p class="s11 p12 fntb" style="padding-left: 44pt;">0</p>
                                                </td>
                                            </tr> 
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
                                                    <p class="s11 p12 fntb" style="padding-left: 44pt;">60500</p>
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
                                                            <td class="profotd34">60500</td>
                                                            <td class="profotd34">0</td>
                                                            <td class="profotd34">0</td>
                                                            <td class="profotd34">0</td>
                                                            <td class="profotd34">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="profotd34">Amount (in words)</td>
                                                            <td colspan="5" class="profotd34">Rs. Zero Rupees Only</td>
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
                                                    Bank Name:ICICI
                                                    </p>
                                                    <p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
                                                    Branch Name: Ravet
                                                    </p>
                                                    <p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
                                                    A/C NO: 333
                                                    </p>
                                                    <p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
                                                    IFSC: 1234
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