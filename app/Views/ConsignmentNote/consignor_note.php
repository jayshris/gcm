<table cellspacing="0" class="print-table">
    <tbody> 
        <tr style="height:77pt"> 
            <td colspan="6" class="td-head">
                <table border="0" cellspacing="0" cellpadding="0" class="tbl-center">
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
                    <span>PAN NO - AAICG9037G</span>  &nbsp;
                    <span>GSTIN - 07AAICG9037G1ZF</span> <br/>
                    <span>CIN - U63030DL2021PTC378353</span>  &nbsp;
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
                    <span class="s7 prtds10">FOR CONSIGNOR</span>
                </p>
            </td>
        </tr>
        <tr style="height:21pt">
            <td class="td1" colspan="3">
                <p class="s9 tdp1">Consignment No. <span class="s10"><?= $lr['consignment_no'] ?></span></p>
                <p class="s9 tdp2">Consignment Date <span class="s10"><?= date('d M Y', strtotime($lr['consignment_date'])) ?></span></p>
            </td>
            <td class="td2" colspan="3">
                <p class="s9 tdp1">Booking Branch <span class="s10"><?= isset($lr['branch_name']) && (!empty($lr['branch_name'])) ? $lr['branch_name'] : '-' ?></span></p>
                <p class="s9 tdp2">Seal No. <span class="s10"><?= isset($lr['seal_no']) && (!empty($lr['seal_no'])) ? $lr['seal_no'] : '-' ?></span></p>
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
        <tr style="height:21pt">
            <td  class="td14" colspan="3">
                <p class="s9 p14 txt-center" >Work Order No.: <?= isset($lr['booking_number']) && (!empty($lr['booking_number'])) ? $lr['booking_number'] : '-' ?></p>
            </td> 
            <td class="td16" colspan="3">
                <p class="s9 p14 txt-center" >Work Order Date: <?= isset($lr['booking_date']) && ($lr['booking_date'] != '0000-00-00') ? date('d M Y',strtotime($lr['booking_date'])) : '-' ?></p>
            </td> 
        </tr>
        <tr style="height:auto">
            <td class="td18 bor-r-none bobn">
                <p class="s9 p14" >ConsignorName:</p>
            </td>
            <td class="td19 bn" colspan="2">
                <p class="s10 p14" ><?= isset($lr['consignor_name']) && (!empty($lr['consignor_name'])) ? strtoupper($lr['consignor_name']) : '-' ?></p>
            </td>
            <td class="td20 bor-r-none bobn">
                <p class="s9 p14" >Consignee Name:</p>
            </td>
            <td class="td21 bor-l-none  bobn" colspan="2">
                <p class="s10 p14" ><?= isset($lr['consignee_name']) && (!empty($lr['consignee_name'])) ? strtoupper($lr['consignee_name']) : '-' ?></p>
            </td>
        </tr>
        <tr style="height:auto">
            <td class="td22 bor-r-none botn bobn">
                <p class="s9 p14" >Consignor Address:</p>
            </td>
            <td class="td23 bn " colspan="2">
                <p class="s10 p15" style="text-indent: 0pt;line-height: 12pt;text-align: left;"><?= isset($lr['consignor_address_f']) && (!empty($lr['consignor_address_f'])) ? strtoupper($lr['consignor_address_f']) : '-' ?></p>
            </td>
            <td class="td24 botn  bor-r-none bobn">
                <p class="s9 p14" >Consignee Address:</p>
            </td>
            <td class="td25 botn bor-l-none bobn" colspan="2">
                <p class="s10 bn" style="text-indent: 0pt;line-height: 12pt;text-align: left;"><?= isset($lr['consignee_address_f']) && (!empty($lr['consignee_address_f'])) ? strtoupper($lr['consignee_address_f']) : '-' ?></p> 
            </td>
        </tr>
        <tr style="height:auto">
            <td class="td26 bor-r-none botn">
                <p class="s9 p14" >GSTIN:</p>
            </td>
            <td class="td27  bor-l-none botn" colspan="2">
                <p class="s10 p14" ><?= isset($lr['consignor_GSTIN']) && (!empty($lr['consignor_GSTIN'])) ? strtoupper($lr['consignor_GSTIN']) : '-' ?></p>
            </td>
            <td class="td28  bor-r-none botn">
                <p class="s9 p14" >GSTIN:</p>
            </td>
            <td class="td29  bor-l-none botn" colspan="2">
                <p class="s10 p14" ><?= isset($lr['consignee_GSTIN']) && (!empty($lr['consignee_GSTIN'])) ? strtoupper($lr['consignee_GSTIN']) : '-' ?></p>
            </td>
        </tr>
        <tr style="height:64pt">
            <td class="td30 bor-r-none">
                <p class="s9 p14" >Place of Dispatch:</p>
            </td>
            <td  class="td31 bor-l-none" colspan="2">
                <p class="s10 p15" ><?= isset($lr['place_of_dispatch_address_f']) && (!empty($lr['place_of_dispatch_address_f'])) ? strtoupper($lr['place_of_dispatch_address_f']) : '-' ?></p>
            </td>
            <td  class="td32 bor-r-none">
                <p class="s9 p14" >Place of Delivery:</p>
            </td>
            <td  class="td33 bor-l-none" colspan="2">
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
                <p class="s9 p17">PartyDocumentDetails</p>
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
        <tr style="height:21pt">
            <td class="s6td" colspan="6">
                <p class="s10"> 
                    The company shall not be held responsible for any penalties or consequences arising from the absence or omission of essential information on the invoice. The following
details are considered essential and must be provided: Invoice copy, E-WAY Bill number, GSTIN, E-Invoice Number (if applicable), and the full address of the consignor
and consignee.        
                </p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td class="td52" colspan="6">
                <p class="s9 p17">Transit Insurance</p>
            </td>
        </tr>
        <tr style="height:16pt">
            <td class="td59" colspan="3">
                <p class="s9 p17">Dispatch Details</p>
            </td>
            <td class="td60" colspan="3">
                <p class="s9 p17">Insurance Co.</p>
            </td>
        </tr>
        <tr style="height:16pt">
            <td class="td59" colspan="3">
                <p class="s9">Reporting Date/Time:<?= isset($lr['reporting_datetime']) && (strtotime($lr['reporting_datetime'])>0) ? date('d M y, h:i A',strtotime($lr['reporting_datetime'])) : '-' ?></p>
                <p class="s9">Releasing Date/Time:<?= isset($lr['releasing_datetime']) && (strtotime($lr['releasing_datetime'])>0) ? date('d M y, h:i A',strtotime($lr['releasing_datetime'])) : '-' ?></p>
            </td>
            <td class="td60" colspan="3">
                <p class="s9">Policy Date:<?= isset($lr['policy_date']) && (strtotime($lr['policy_date'])>0) ? date('d M y, h:i A',strtotime($lr['policy_date'])) : '-' ?></p>
                <p class="s9">Policy Number:<?= isset($lr['policy_no']) && !empty($lr['policy_no']) ? $lr['policy_no'] : '-' ?></p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td class="td52" colspan="6">
                <p class="s9 p17 mrg-tp5">AT OWNER'S RISK</p>
                <p class="s10"> 
                Goods are carried at the owner’s risk. The customer (Consignor/Consignee) must make sure that the goods are insured by an Insurance Company. GAE Cargo
Movers Pvt. Ltd. Is not held responsible for any kind of loss, damage, hold, leakage, etc. due to any reason. It is further made that the GAE Cargo Movers Private
Limited is not held responsible for any Damage or loss due to natural disaster or any act of God, which is beyond the control of the company
                </p>
            </td>
        </tr> 
        
        <tr style="height:45pt">
            <td colspan="3" class="td63">
                <p class="s9 pdl12 pdl8">
                Receiver Name:  
                </p>
                <p class="s9 pdl12 pdl8"> 
                Signature & Stamp:
                </p>
            </td>
            <td colspan="3" rowspan="2" class="td64">
                <p class="s9 p17 mrg-tp5">
                    For GAE CARGO MOVERS PRIVATE LIMITED</p>
                <p class="p18"><span></span></p>
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
                <p class="s9 p17">
                    SIGNATURE OF THE ISSUING OFFICE
                </p>
            </td>
        </tr>
        <tr style="height:59pt">
            <td colspan="3" class="td65">
                <p class="s9  pdl12 pdl8">Remarks:</p>
            </td>
        </tr>

    </tbody>
</table>