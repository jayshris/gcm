<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/print_report.css">
<style>
    .printableArea {
        display: block;
    }

    .tbl-center {
        margin-left: inherit !important;
        margin-right: inherit !important;
    }


    table {
        margin-bottom: 9px;
    }

    .page-wrapper {
        margin: 0;
        padding: 0;
    }

    .tbl-center {
        margin-left: 234px;
        margin-right: auto;
    }

    #debug-icon {
        display: none;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="">
            <div id="printableArea" class="">

            <?php $lr_third_party_cnt = isset($lr_party_type['lr_third_party']['cnt']) && ($lr_party_type['lr_third_party']['cnt'] > 0) ? $lr_party_type['lr_third_party']['cnt'] : 0; ?>
            <?php if($lr_third_party_cnt == 0){ ?>  
                <!-- Consignee Note  -->
                <table cellspacing="0" class="print-table" style="width: 100%;">
                    <tbody>
                        <tr>
                            <td colspan="6" class="td-head">
                                <table border="0" cellspacing="0" cellpadding="0" class="">
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;">
                                                <img width="105" height="47" src="<?php echo base_url(); ?>public/assets/img/logo.png">
                                            </td>
                                            <td style="width: 80%;">
                                                <p style="text-align: center; font-size: 24px; text-decoration: underline;">
                                                    <b>GAE CARGO MOVERS PRIVATE LIMITED</b>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center;">
                                                <b>
                                                    A-131/2, 2nd Floor, Wazirpur Industrial Area, Delhi- 110052<br>
                                                    Mobile : 7669027900, EMail :booking@gaegroup.in<br>
                                                    PAN NO - AAICG9037G | GSTIN - 07AAICG9037G1ZF <br>
                                                    CIN - U63030DL2021PTC378353 | MSME - UDYAM-DL-06-0016237
                                                </b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style="height:25pt">
                            <td class="s6td" colspan="3">
                                <p class="s6 p13">
                                    <span class="s6 td-sub">
                                        Subject to Delhi Jurisdiction
                                    </span>
                                </p>
                            </td>
                            <td class="s6td" colspan="3" align="right">
                                <p class="s6 p13"><b>FOR CONSIGNEE</b></p>
                            </td>
                        </tr>
                        <tr style=" height:21pt">
                            <td class="td1" colspan="3">
                                <p class="s9 tdp1">ConsignmentNo <span class="s10"><?= $lr['consignment_no'] ?></span></p>
                                <p class="s9 tdp2">ConsignmentDate <span class="s10"><?= date('d M Y', strtotime($lr['consignment_date'])) ?></span></p>
                            </td>
                            <td class="td2" colspan="3">
                                <p class="s9 tdp1">BookingBranch <span class="s10"><?= isset($lr['branch_name']) && (!empty($lr['branch_name'])) ? $lr['branch_name'] : '-' ?></span></p>
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
                            <td class="td14" colspan="3">
                                <p class="s9 p14 txt-center">Work Order No.: <?= isset($lr['booking_number']) && (!empty($lr['booking_number'])) ? $lr['booking_number'] : '-' ?></p>
                                <p class="s9 p14 txt-center" >Work Order Date: <?= isset($lr['booking_date']) && ($lr['booking_date'] != '0000-00-00') ? date('d M Y',strtotime($lr['booking_date'])) : '-' ?></p>
                            </td>  
                            <td class="td16" colspan="3">
                                <p class="s9 p14 txt-center" >Driver Name : <?= isset($driver['driver_name']) && ($driver['driver_name']) ? ucwords(strtolower($driver['driver_name'])) : '-' ?></p>
                                <p class="s9 p14 txt-center" >Driver Phone No : <?= isset($driver['primary_phone']) && ($driver['primary_phone']) ? $driver['primary_phone'] : '-' ?></p>
                            </td> 
                        </tr>
                        <tr style="height:auto">
                            <td class="td18 bor-r-none bobn">
                                <p class="s9 p14">ConsignorName:</p>
                            </td>
                            <td class="td19 bn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignor_name']) && (!empty($lr['consignor_name'])) ? strtoupper($lr['consignor_name']) : '-' ?></p>
                            </td>
                            <td class="td20 bor-r-none bobn">
                                <p class="s9 p14">Consignee Name:</p>
                            </td>
                            <td class="td21 bor-l-none  bobn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignee_name']) && (!empty($lr['consignee_name'])) ? strtoupper($lr['consignee_name']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:auto">
                            <td class="td22 bor-r-none botn bobn">
                                <p class="s9 p14">Consignor Address:</p>
                            </td>
                            <td class="td23 bn " colspan="2">
                                <p class="s10 p15" style="text-indent: 0pt;line-height: 12pt;text-align: left;"><?= isset($lr['consignor_address_f']) && (!empty($lr['consignor_address_f'])) ? strtoupper($lr['consignor_address_f']) : '-' ?></p>
                            </td>
                            <td class="td24 botn  bor-r-none bobn">
                                <p class="s9 p14">Consignee Address:</p>
                            </td>
                            <td class="td25 botn bor-l-none bobn" colspan="2">
                                <p class="s10 bn" style="text-indent: 0pt;line-height: 12pt;text-align: left;"><?= isset($lr['consignee_address_f']) && (!empty($lr['consignee_address_f'])) ? strtoupper($lr['consignee_address_f']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:auto">
                            <td class="td26 bor-r-none botn">
                                <p class="s9 p14">GSTIN:</p>
                            </td>
                            <td class="td27  bor-l-none botn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignor_GSTIN']) && (!empty($lr['consignor_GSTIN'])) ? strtoupper($lr['consignor_GSTIN']) : '-' ?></p>
                            </td>
                            <td class="td28  bor-r-none botn">
                                <p class="s9 p14">GSTIN:</p>
                            </td>
                            <td class="td29  bor-l-none botn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignee_GSTIN']) && (!empty($lr['consignee_GSTIN'])) ? strtoupper($lr['consignee_GSTIN']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:64pt">
                            <td class="td30 bor-r-none">
                                <p class="s9 p14">Place of Dispatch:</p>
                            </td>
                            <td class="td31 bor-l-none" colspan="2">
                                <p class="s10 p15"><?= isset($lr['place_of_dispatch_address_f']) && (!empty($lr['place_of_dispatch_address_f'])) ? strtoupper($lr['place_of_dispatch_address_f']) : '-' ?></p>
                            </td>
                            <td class="td32 bor-r-none">
                                <p class="s9 p14">Place of Delivery:</p>
                            </td>
                            <td class="td33 bor-l-none" colspan="2">
                                <p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;"><?= isset($lr['place_of_delivery_pincode_f']) && (!empty($lr['place_of_delivery_pincode_f'])) ? strtoupper($lr['place_of_delivery_pincode_f']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:11pt">
                            <td class="td34">
                                <p class="s9 p12" style="padding-left: 24pt;">Particulars</p>
                            </td>
                            <td class="td35">
                                <p class="s9 p16">HSNCode</p>
                            </td>
                            <td class="td36">
                                <p class="s9 p16">No.ofPackages</p>
                            </td>
                            <td class="td37">
                                <p class="s9 p12" style="padding-left: 19pt;">ActualWeight</p>
                            </td>
                            <td class="td38">
                                <p class="s9 p16">Charge Weight</p>
                            </td>
                            <td class="td39">
                                <p class="s9 p16">PaymentTerms</p>
                            </td>
                        </tr>
                        <tr style="height:21pt">
                            <td class="td40">
                                <p class="s10" style="padding-left: 22pt;padding-right: 2pt;text-indent: -19pt;line-height: 10pt;text-align: left;"><?= isset($lr['particulars']) && (!empty($lr['particulars'])) ? strtoupper($lr['particulars']) : '-' ?></p>
                            </td>
                            <td class="td41">
                                <p class="s10 p11"><?= isset($lr['hsn_code']) && (!empty($lr['hsn_code'])) ? strtoupper($lr['hsn_code']) : '-' ?></p>
                            </td>
                            <td class="td42">
                                <p class="s10 p11"><?= isset($lr['no_of_packages']) && (!empty($lr['no_of_packages'])) ? strtoupper($lr['no_of_packages']) : '-' ?></p>
                            </td>
                            <td class="td43">
                                <p class="s10 p11"><?= isset($lr['actual_weight']) && (!empty($lr['actual_weight'])) ? strtoupper($lr['actual_weight']) : '-' ?></p>
                            </td>
                            <td class="td44">
                                <p class="s10 p11"><?= isset($lr['charge_weight']) && (!empty($lr['charge_weight'])) ? strtoupper($lr['charge_weight']) : '-' ?></p>
                            </td>
                            <td class="td45">
                                <p class="s10 p11"><?= isset($lr['payment_terms']) && (!empty($lr['payment_terms'])) ? strtoupper($lr['payment_terms']) : '-' ?></p>
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
                                <p class="s10 p11"><?= isset($lr['e_way_bill_number']) && (!empty($lr['e_way_bill_number'])) ? strtoupper($lr['e_way_bill_number']) : '-' ?></p>
                            </td>
                            <td class="td50" colspan="2">
                                <p class="s10 p11"><?= isset($lr['e_way_expiry_date']) && (strtotime($lr['e_way_expiry_date']) > 0) ? date('d/m/Y', strtotime($lr['e_way_expiry_date'])) : '-' ?></p>
                            </td>
                            <td class="td51" colspan="2">
                                <p class="s11 p11"><?= isset($lr['freight_charges_amount']) && (!empty($lr['freight_charges_amount'])) ? strtoupper($lr['freight_charges_amount']) : '-' ?></p>
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
                                <p class="s9 p12" style="padding-left: 60pt;">Invoice/BOEDate</p>
                            </td>
                            <td class="td55" colspan="2">
                                <p class="s9 p12 p16">Invoice Value</p>
                            </td>
                        </tr>
                        <tr style="height:11pt">
                            <td class="td56" colspan="2">
                                <p class="s10 p12" style="padding-left: 60pt;"><?= isset($lr['invoice_boe_no']) && (!empty($lr['invoice_boe_no'])) ? strtoupper($lr['invoice_boe_no']) : '-' ?></p>
                            </td>
                            <td class="td57" colspan="2">
                                <p class="s10 p12" style="padding-left: 56pt;"><?= isset($lr['invoice_boe_date']) && (strtotime($lr['invoice_boe_date']) > 0) ? date('d M y, h:i A', strtotime($lr['invoice_boe_date'])) : '-' ?></p>
                            </td>
                            <td class="td58" colspan="2">
                                <p class="s10 p16"><?= isset($lr['invoice_value']) && (!empty($lr['invoice_value'])) ? strtoupper($lr['invoice_value']) : '-' ?></p>
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
                                <p class="s9">Reporting Date/Time:<?= isset($lr['reporting_datetime']) && (strtotime($lr['reporting_datetime']) > 0) ? date('d M y, h:i A', strtotime($lr['reporting_datetime'])) : '-' ?></p>
                                <p class="s9">Releasing Date/Time:<?= isset($lr['releasing_datetime']) && (strtotime($lr['releasing_datetime']) > 0) ? date('d M y, h:i A', strtotime($lr['releasing_datetime'])) : '-' ?></p>
                            </td>
                            <td class="td60" colspan="3">
                                <p class="s9">Policy Date:<?= isset($lr['policy_date']) && (strtotime($lr['policy_date']) > 0) ? date('d M y, h:i A', strtotime($lr['policy_date'])) : '-' ?></p>
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
                <br>
                <br>
                <br>
                <br>

                <!-- terms and conditions  -->
                <table cellspacing="0" class="print-table" style="width: 100%;">
                    <tbody>
                        <tr style="font-size: 10px;">
                            <td colspan="6" class="td-head">
                                <table border="0" cellspacing="0" cellpadding="0" class="">
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;">
                                                <img width="105" height="47" src="<?php echo base_url(); ?>public/assets/img/logo.png">
                                            </td>
                                            <td style="width: 80%;">
                                                <p style="text-align: center; font-size: 24px; text-decoration: underline;">
                                                    <b>GAE CARGO MOVERS PRIVATE LIMITED</b>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center;">
                                                <b>
                                                    A-131/2, 2nd Floor, Wazirpur Industrial Area, Delhi- 110052<br>
                                                    Mobile : 7669027900, EMail :booking@gaegroup.in<br>
                                                    PAN NO - AAICG9037G | GSTIN - 07AAICG9037G1ZF <br>
                                                    CIN - U63030DL2021PTC378353 | MSME - UDYAM-DL-06-0016237
                                                </b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style="height:18pt">
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F; text-align: center;" colspan="3">
                                <p class="s19" style="padding-top: 4pt;padding-left: 1pt;padding-right: 11pt;text-indent: 0pt;line-height: 12pt;">TERMS AND CONDITIONS</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">1. Our logistics firm shall make reasonable efforts to transport the goods within the agreed-upon delivery schedule. However, delivery times are estimated and may be subject to delays beyond our control, such as traffic, weather conditions, or unforeseen circumstances. The Customer shall provide appropriate instructions regarding the delivery location, including access restrictions or specific delivery requirements. Any additional costs incurred due to the Customer's failure to provide accurate information shall be the Customer's responsibility.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">2. In cases where a Bank has agreed to accept this Lorry Receipt as a Consignee/endorsee or holder thereof in any other capacity, for the purpose of providing advances, collection, or discounting bills of any of its customers, whether before or after the goods are entrusted to the Transport Operator for carriage, the Transport Operator hereby agrees to hold itself liable. The Transport Operator shall be deemed to have held itself liable at all material times directly to the Bank concerned, as if the Bank were a party to the contract contained herein, with the right of recourse against the Transport Operator to the extent of the full value of the goods handed over to the Transport.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">3. The Transport Operator undertakes to transport and deliver the goods in the same order and condition as received, subject to any deterioration in the condition of the goods resulting from natural causes such as the effects of temperature, weather conditions, etc. The delivery will be made to the Consignee Bank or to its order or its assigns upon surrender of this Lorry Receipt, which must be duly discharged by the Bank or the holder of the receipt, along with a letter from the Bank authorizing the delivery of the goods. Only the Bank and the holder of the receipt, entitled to delivery as mentioned above, shall have the right of recourse against the Transport Operator for any claims arising from the transportation of the goods.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">4. The Transport Operator shall have the right to entrust the goods to any other lorry or service for transport. If the Transport Operator entrusts the goods to another Carrier, it shall be deemed that the other carrier acts as the agent of the Transport Operator. Therefore, notwithstanding the delivery of the goods to the other carrier, the Transport Operator shall continue to be responsible for the safety and security of the goods until their final delivery to the Consignee Bank or its designated recipient. The Transport Operator shall exercise due care in selecting and entrusting the goods to reliable and competent carriers to ensure the proper handling and delivery of the goods.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">5. The Consignor shall be primarily liable to pay the transport charges and any other incidental charges, if applicable, to the Transport Operator. The payment of such charges shall be made at the Head Office of the Transport Operator or at any other mutually agreed-upon location. The Consignor agrees to fulfil its payment obligations promptly and in accordance with the terms agreed upon between the Consignor and the Transport Operator. Failure to make timely payment may result in additional charges, interest, or other remedies as specified by the Transport Operator's billing policies.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">6. The Transport Operator shall have the right to dispose of perishable goods that remain undelivered after 48 hours of arrival, without providing any prior notice. This action is necessary to prevent further deterioration or spoilage of the perishable goods.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">7. In cases where the Transport Operator needs to dispose of the goods, whether perishable or otherwise, the Consignor, Consignee Bank, and any other interested parties shall be given a minimum of 15 days’ notice regarding the intended disposal of the goods. This notice period allows the concerned parties to take appropriate action or make alternative arrangements if necessary.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">8. In situations falling under Clause 6 or 7 above, where the Transport Operator disposes of the goods, the Bank or the claimant with the Bank's authority shall be entitled to the proceeds from the disposal, after deducting freight and demurrage charges. The Transport Operator shall promptly provide a full account of the proceeds and deductions to the Bank or the authorized claimant upon request, ensuring transparency and accountability in the process.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">9. The Consignee Bank, accepting the Lorry Receipt under Clause 2, shall not be held liable for the payment of any charges resulting from any liens that the Transport Operator may have against the consignor or the buyer. If it becomes necessary for a Bank to obtain delivery of the consignment from the Transport Operator, as per the IBA (International Bankers Association) scheme for Recommending Transport Operators to Member Banks, the Transport Operator shall unconditionally deliver the goods to the Bank. The Bank shall make payment for the normal freight and storage charges associated with the specific consignment in question, without the Transport Operator claiming any lien on the goods for any outstanding amounts due from the consignor or the buyer.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">10. Notwithstanding any statement made in this Lorry Receipt or any circumstances surrounding its issuance, the Transport Operator shall always uphold its obligation to the Consignee Bank named in this Lorry Receipt. The Transport Operator shall be responsible for the safe and timely delivery of the goods or consignment and shall bear liability for any loss or damage that occurs as a result of the Transport Operator's negligence, default, failure to exercise reasonable precautions, mala fides (bad faith), or any criminal or fraudulent actions committed by the Transport Operator, its managers, agents, employees, partners, directors, business associates, branches, or any other party associated with the Transport Operator's operations. The Transport Operator shall be held accountable for any such actions that directly result in the loss or damage to the goods or consignment covered by this Lorry Receipt.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">11. The Consignor shall bear full responsibility for any consequences arising from incorrect or false declarations made regarding the goods. It is the Consignor's duty to provide accurate and truthful information regarding the nature, value, condition, and any other relevant details of the goods being transported. Any inaccuracies or misrepresentations in the declaration may result in legal, financial, or other consequences, and the Consignor shall be solely liable for any such repercussions. The Transport Operator shall not be held responsible for any damages, losses, penalties, or liabilities arising from incorrect or false declarations made by the Consignor.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">12. If the goods covered by this Lorry Receipt are lost, destroyed, damaged, or have deteriorated, the compensation payable by the Transport Operator shall be limited to the value declared by the Consignor. The declared value represents the maximum amount that the Transport Operator will be held liable for in such cases. It is the responsibility of the Consignor to accurately declare the value of the goods prior to their transportation. The Transport Operator's liability for loss, destruction, damage, or deterioration of the goods shall be limited to the declared value and shall not exceed this amount.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">13. The Customer is responsible for adequately insuring the goods against loss, damage, or theft during transportation. Our logistics firm shall not be held liable for any loss or damage to uninsured goods.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">14. Any disputes arising from this agreement shall be resolved through negotiation in good faith. If the parties are unable to reach a mutually satisfactory resolution, either party may initiate mediation or other alternative dispute resolution methods agreed upon by both parties.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">15. Either party may terminate this agreement with written notice to the other party. Termination shall not relieve the Customer of its obligation to pay for services rendered up to the termination date. Both parties agree to treat any confidential information shared during the course of this agreement as confidential and not to disclose it to any third party without prior written consent unless required by law.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">16. This agreement shall be governed by and construed in accordance with the laws of Delhi jurisdiction. Any legal action or proceeding arising out of or relating to this agreement shall be exclusively settled in the courts.</p>
                            </td>
                        </tr>
                        <tr style="height:24pt">
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p class="txt-center"><span class="s20" style=" background-color: #F6F6F7;">ALL THE ABOVE TERMS &amp; CONDITIONS HAVE BEEN READ OVER/EXPLAINED TO AND ACCEPTED BY THE CONSIGNOR(S) AND/OR HIS AGENT(S).</span></p>
                            </td>
                        </tr>
                        <tr style="height:49pt">
                            <td style="width:179pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                                <p class="s10 txt-center">DELHI (NCR) BRANCH</p>
                                <p class="s10 txt-center">CONTACT PERSON-DEVANSH GOYAL</p>
                                <p class="s10 txt-center">CONTACT NUMBER-+91-7669027909</p>
                            </td>
                            <td style="width:179pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s10 txt-center">CHENNAI BRANCH</p>
                                <p class="s10 txt-center">CONTACT PERSON–MANJEET THAKAN</p>
                                <p class="s10 txt-center">CONTACT NUMBER-+91-7669027904</p>
                            </td>
                            <td style="width:179pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                                <p class="s10 txt-center">ACCOUNTS QUERY</p>
                                <p class="s10 txt-center"></p>
                                <p class="s10 txt-center">CONTACT NUMBER-+91-7669027906</p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Consigner note  -->
                <table cellspacing="0" class="print-table">
                    <tbody>
                        <tr style="font-size: 10px;">
                            <td colspan="6" class="td-head">
                                <table border="0" cellspacing="0" cellpadding="0" class="">
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;">
                                                <img width="105" height="47" src="<?php echo base_url(); ?>public/assets/img/logo.png">
                                            </td>
                                            <td style="width: 80%;">
                                                <p style="text-align: center; font-size: 24px; text-decoration: underline;">
                                                    <b>GAE CARGO MOVERS PRIVATE LIMITED</b>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center;">
                                                <b>
                                                    A-131/2, 2nd Floor, Wazirpur Industrial Area, Delhi- 110052<br>
                                                    Mobile : 7669027900, EMail :booking@gaegroup.in<br>
                                                    PAN NO - AAICG9037G | GSTIN - 07AAICG9037G1ZF <br>
                                                    CIN - U63030DL2021PTC378353 | MSME - UDYAM-DL-06-0016237
                                                </b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style="height:21pt">
                            <td class="s6td" colspan="3">
                                <p class="s6 p13">
                                    <span class="s6 td-sub">
                                        Subject to Delhi Jurisdiction
                                    </span>
                                </p>
                            </td>
                            <td class="s6td" colspan="3" align="right">
                                <p class="s6 p13"><b>FOR CONSIGNOR</b></p>
                            </td>
                        </tr>
                        <tr style="height:21pt">
                            <td class="td1" colspan="3">
                                <p class="s9 tdp1">ConsignmentNo <span class="s10"><?= $lr['consignment_no'] ?></span></p>
                                <p class="s9 tdp2">ConsignmentDate <span class="s10"><?= date('d M Y', strtotime($lr['consignment_date'])) ?></span></p>
                            </td>
                            <td class="td2" colspan="3">
                                <p class="s9 tdp1">BookingBranch <span class="s10"><?= isset($lr['branch_name']) && (!empty($lr['branch_name'])) ? $lr['branch_name'] : '-' ?></span></p>
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
                            <td class="td14" colspan="3">
                                <p class="s9 p14 txt-center">Work Order No.: <?= isset($lr['booking_number']) && (!empty($lr['booking_number'])) ? $lr['booking_number'] : '-' ?></p>
                                <p class="s9 p14 txt-center" >Work Order Date: <?= isset($lr['booking_date']) && ($lr['booking_date'] != '0000-00-00') ? date('d M Y',strtotime($lr['booking_date'])) : '-' ?></p>
                            </td>  
                            <td class="td16" colspan="3">
                                <p class="s9 p14 txt-center" >Driver Name : <?= isset($driver['driver_name']) && ($driver['driver_name']) ? ucwords(strtolower($driver['driver_name'])) : '-' ?></p>
                                <p class="s9 p14 txt-center" >Driver Phone No : <?= isset($driver['primary_phone']) && ($driver['primary_phone']) ? $driver['primary_phone'] : '-' ?></p>
                            </td> 
                        </tr>
                        <tr style="height:auto">
                            <td class="td18 bor-r-none bobn">
                                <p class="s9 p14">ConsignorName:</p>
                            </td>
                            <td class="td19 bn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignor_name']) && (!empty($lr['consignor_name'])) ? strtoupper($lr['consignor_name']) : '-' ?></p>
                            </td>
                            <td class="td20 bor-r-none bobn">
                                <p class="s9 p14">Consignee Name:</p>
                            </td>
                            <td class="td21 bor-l-none  bobn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignee_name']) && (!empty($lr['consignee_name'])) ? strtoupper($lr['consignee_name']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:auto">
                            <td class="td22 bor-r-none botn bobn">
                                <p class="s9 p14">Consignor Address:</p>
                            </td>
                            <td class="td23 bn " colspan="2">
                                <p class="s10 p15" style="text-indent: 0pt;line-height: 12pt;text-align: left;"><?= isset($lr['consignor_address_f']) && (!empty($lr['consignor_address_f'])) ? strtoupper($lr['consignor_address_f']) : '-' ?></p>
                            </td>
                            <td class="td24 botn  bor-r-none bobn">
                                <p class="s9 p14">Consignee Address:</p>
                            </td>
                            <td class="td25 botn bor-l-none bobn" colspan="2">
                                <p class="s10 bn" style="text-indent: 0pt;line-height: 12pt;text-align: left;"><?= isset($lr['consignee_address_f']) && (!empty($lr['consignee_address_f'])) ? strtoupper($lr['consignee_address_f']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:auto">
                            <td class="td26 bor-r-none botn">
                                <p class="s9 p14">GSTIN:</p>
                            </td>
                            <td class="td27  bor-l-none botn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignor_GSTIN']) && (!empty($lr['consignor_GSTIN'])) ? strtoupper($lr['consignor_GSTIN']) : '-' ?></p>
                            </td>
                            <td class="td28  bor-r-none botn">
                                <p class="s9 p14">GSTIN:</p>
                            </td>
                            <td class="td29  bor-l-none botn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignee_GSTIN']) && (!empty($lr['consignee_GSTIN'])) ? strtoupper($lr['consignee_GSTIN']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:64pt">
                            <td class="td30 bor-r-none">
                                <p class="s9 p14">Place of Dispatch:</p>
                            </td>
                            <td class="td31 bor-l-none" colspan="2">
                                <p class="s10 p15"><?= isset($lr['place_of_dispatch_address_f']) && (!empty($lr['place_of_dispatch_address_f'])) ? strtoupper($lr['place_of_dispatch_address_f']) : '-' ?></p>
                            </td>
                            <td class="td32 bor-r-none">
                                <p class="s9 p14">Place of Delivery:</p>
                            </td>
                            <td class="td33 bor-l-none" colspan="2">
                                <p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;"><?= isset($lr['place_of_delivery_pincode_f']) && (!empty($lr['place_of_delivery_pincode_f'])) ? strtoupper($lr['place_of_delivery_pincode_f']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:11pt">
                            <td class="td34">
                                <p class="s9 p12" style="padding-left: 24pt;">Particulars</p>
                            </td>
                            <td class="td35">
                                <p class="s9 p16">HSNCode</p>
                            </td>
                            <td class="td36">
                                <p class="s9 p16">No.ofPackages</p>
                            </td>
                            <td class="td37">
                                <p class="s9 p12" style="padding-left: 19pt;">ActualWeight</p>
                            </td>
                            <td class="td38">
                                <p class="s9 p16">Charge Weight</p>
                            </td>
                            <td class="td39">
                                <p class="s9 p16">PaymentTerms</p>
                            </td>
                        </tr>
                        <tr style="height:21pt">
                            <td class="td40">
                                <p class="s10" style="padding-left: 22pt;padding-right: 2pt;text-indent: -19pt;line-height: 10pt;text-align: left;"><?= isset($lr['particulars']) && (!empty($lr['particulars'])) ? strtoupper($lr['particulars']) : '-' ?></p>
                            </td>
                            <td class="td41">
                                <p class="s10 p11"><?= isset($lr['hsn_code']) && (!empty($lr['hsn_code'])) ? strtoupper($lr['hsn_code']) : '-' ?></p>
                            </td>
                            <td class="td42">
                                <p class="s10 p11"><?= isset($lr['no_of_packages']) && (!empty($lr['no_of_packages'])) ? strtoupper($lr['no_of_packages']) : '-' ?></p>
                            </td>
                            <td class="td43">
                                <p class="s10 p11"><?= isset($lr['actual_weight']) && (!empty($lr['actual_weight'])) ? strtoupper($lr['actual_weight']) : '-' ?></p>
                            </td>
                            <td class="td44">
                                <p class="s10 p11"><?= isset($lr['charge_weight']) && (!empty($lr['charge_weight'])) ? strtoupper($lr['charge_weight']) : '-' ?></p>
                            </td>
                            <td class="td45">
                                <p class="s10 p11"><?= isset($lr['payment_terms']) && (!empty($lr['payment_terms'])) ? strtoupper($lr['payment_terms']) : '-' ?></p>
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
                                <p class="s10 p11"><?= isset($lr['e_way_bill_number']) && (!empty($lr['e_way_bill_number'])) ? strtoupper($lr['e_way_bill_number']) : '-' ?></p>
                            </td>
                            <td class="td50" colspan="2">
                                <p class="s10 p11"><?= isset($lr['e_way_expiry_date']) && (strtotime($lr['e_way_expiry_date']) > 0) ? date('d/m/Y', strtotime($lr['e_way_expiry_date'])) : '-' ?></p>
                            </td>
                            <td class="td51" colspan="2">
                                <p class="s11 p11"><?= isset($lr['freight_charges_amount']) && (!empty($lr['freight_charges_amount'])) ? strtoupper($lr['freight_charges_amount']) : '-' ?></p>
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
                                <p class="s9 p12" style="padding-left: 60pt;">Invoice/BOEDate</p>
                            </td>
                            <td class="td55" colspan="2">
                                <p class="s9 p12 p16">Invoice Value</p>
                            </td>
                        </tr>
                        <tr style="height:11pt">
                            <td class="td56" colspan="2">
                                <p class="s10 p12" style="padding-left: 60pt;"><?= isset($lr['invoice_boe_no']) && (!empty($lr['invoice_boe_no'])) ? strtoupper($lr['invoice_boe_no']) : '-' ?></p>
                            </td>
                            <td class="td57" colspan="2">
                                <p class="s10 p12" style="padding-left: 56pt;"><?= isset($lr['invoice_boe_date']) && (strtotime($lr['invoice_boe_date']) > 0) ? date('d M y, h:i A', strtotime($lr['invoice_boe_date'])) : '-' ?></p>
                            </td>
                            <td class="td58" colspan="2">
                                <p class="s10 p16"><?= isset($lr['invoice_value']) && (!empty($lr['invoice_value'])) ? strtoupper($lr['invoice_value']) : '-' ?></p>
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
                                <p class="s9">Reporting Date/Time:<?= isset($lr['reporting_datetime']) && (strtotime($lr['reporting_datetime']) > 0) ? date('d M y, h:i A', strtotime($lr['reporting_datetime'])) : '-' ?></p>
                                <p class="s9">Releasing Date/Time:<?= isset($lr['releasing_datetime']) && (strtotime($lr['releasing_datetime']) > 0) ? date('d M y, h:i A', strtotime($lr['releasing_datetime'])) : '-' ?></p>
                            </td>
                            <td class="td60" colspan="3">
                                <p class="s9">Policy Date:<?= isset($lr['policy_date']) && (strtotime($lr['policy_date']) > 0) ? date('d M y, h:i A', strtotime($lr['policy_date'])) : '-' ?></p>
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
                <br>
                <br>
                <br>

                <!-- terms and conditions  -->
                <table cellspacing="0" class="print-table" style="width: 100%;">
                    <tbody>
                        <tr style="font-size: 10px;">
                            <td colspan="6" class="td-head">
                                <table border="0" cellspacing="0" cellpadding="0" class="">
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;">
                                                <img width="105" height="47" src="<?php echo base_url(); ?>public/assets/img/logo.png">
                                            </td>
                                            <td style="width: 80%;">
                                                <p style="text-align: center; font-size: 24px; text-decoration: underline;">
                                                    <b>GAE CARGO MOVERS PRIVATE LIMITED</b>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center;">
                                                <b>
                                                    A-131/2, 2nd Floor, Wazirpur Industrial Area, Delhi- 110052<br>
                                                    Mobile : 7669027900, EMail :booking@gaegroup.in<br>
                                                    PAN NO - AAICG9037G | GSTIN - 07AAICG9037G1ZF <br>
                                                    CIN - U63030DL2021PTC378353 | MSME - UDYAM-DL-06-0016237
                                                </b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style="height:18pt">
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F; text-align: center;" colspan="3">
                                <p class="s19" style="padding-top: 4pt;padding-left: 1pt;padding-right: 11pt;text-indent: 0pt;line-height: 12pt;">TERMS AND CONDITIONS</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">1. Our logistics firm shall make reasonable efforts to transport the goods within the agreed-upon delivery schedule. However, delivery times are estimated and may be subject to delays beyond our control, such as traffic, weather conditions, or unforeseen circumstances. The Customer shall provide appropriate instructions regarding the delivery location, including access restrictions or specific delivery requirements. Any additional costs incurred due to the Customer's failure to provide accurate information shall be the Customer's responsibility.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">2. In cases where a Bank has agreed to accept this Lorry Receipt as a Consignee/endorsee or holder thereof in any other capacity, for the purpose of providing advances, collection, or discounting bills of any of its customers, whether before or after the goods are entrusted to the Transport Operator for carriage, the Transport Operator hereby agrees to hold itself liable. The Transport Operator shall be deemed to have held itself liable at all material times directly to the Bank concerned, as if the Bank were a party to the contract contained herein, with the right of recourse against the Transport Operator to the extent of the full value of the goods handed over to the Transport.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">3. The Transport Operator undertakes to transport and deliver the goods in the same order and condition as received, subject to any deterioration in the condition of the goods resulting from natural causes such as the effects of temperature, weather conditions, etc. The delivery will be made to the Consignee Bank or to its order or its assigns upon surrender of this Lorry Receipt, which must be duly discharged by the Bank or the holder of the receipt, along with a letter from the Bank authorizing the delivery of the goods. Only the Bank and the holder of the receipt, entitled to delivery as mentioned above, shall have the right of recourse against the Transport Operator for any claims arising from the transportation of the goods.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">4. The Transport Operator shall have the right to entrust the goods to any other lorry or service for transport. If the Transport Operator entrusts the goods to another Carrier, it shall be deemed that the other carrier acts as the agent of the Transport Operator. Therefore, notwithstanding the delivery of the goods to the other carrier, the Transport Operator shall continue to be responsible for the safety and security of the goods until their final delivery to the Consignee Bank or its designated recipient. The Transport Operator shall exercise due care in selecting and entrusting the goods to reliable and competent carriers to ensure the proper handling and delivery of the goods.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">5. The Consignor shall be primarily liable to pay the transport charges and any other incidental charges, if applicable, to the Transport Operator. The payment of such charges shall be made at the Head Office of the Transport Operator or at any other mutually agreed-upon location. The Consignor agrees to fulfil its payment obligations promptly and in accordance with the terms agreed upon between the Consignor and the Transport Operator. Failure to make timely payment may result in additional charges, interest, or other remedies as specified by the Transport Operator's billing policies.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">6. The Transport Operator shall have the right to dispose of perishable goods that remain undelivered after 48 hours of arrival, without providing any prior notice. This action is necessary to prevent further deterioration or spoilage of the perishable goods.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">7. In cases where the Transport Operator needs to dispose of the goods, whether perishable or otherwise, the Consignor, Consignee Bank, and any other interested parties shall be given a minimum of 15 days’ notice regarding the intended disposal of the goods. This notice period allows the concerned parties to take appropriate action or make alternative arrangements if necessary.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">8. In situations falling under Clause 6 or 7 above, where the Transport Operator disposes of the goods, the Bank or the claimant with the Bank's authority shall be entitled to the proceeds from the disposal, after deducting freight and demurrage charges. The Transport Operator shall promptly provide a full account of the proceeds and deductions to the Bank or the authorized claimant upon request, ensuring transparency and accountability in the process.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">9. The Consignee Bank, accepting the Lorry Receipt under Clause 2, shall not be held liable for the payment of any charges resulting from any liens that the Transport Operator may have against the consignor or the buyer. If it becomes necessary for a Bank to obtain delivery of the consignment from the Transport Operator, as per the IBA (International Bankers Association) scheme for Recommending Transport Operators to Member Banks, the Transport Operator shall unconditionally deliver the goods to the Bank. The Bank shall make payment for the normal freight and storage charges associated with the specific consignment in question, without the Transport Operator claiming any lien on the goods for any outstanding amounts due from the consignor or the buyer.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">10. Notwithstanding any statement made in this Lorry Receipt or any circumstances surrounding its issuance, the Transport Operator shall always uphold its obligation to the Consignee Bank named in this Lorry Receipt. The Transport Operator shall be responsible for the safe and timely delivery of the goods or consignment and shall bear liability for any loss or damage that occurs as a result of the Transport Operator's negligence, default, failure to exercise reasonable precautions, mala fides (bad faith), or any criminal or fraudulent actions committed by the Transport Operator, its managers, agents, employees, partners, directors, business associates, branches, or any other party associated with the Transport Operator's operations. The Transport Operator shall be held accountable for any such actions that directly result in the loss or damage to the goods or consignment covered by this Lorry Receipt.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">11. The Consignor shall bear full responsibility for any consequences arising from incorrect or false declarations made regarding the goods. It is the Consignor's duty to provide accurate and truthful information regarding the nature, value, condition, and any other relevant details of the goods being transported. Any inaccuracies or misrepresentations in the declaration may result in legal, financial, or other consequences, and the Consignor shall be solely liable for any such repercussions. The Transport Operator shall not be held responsible for any damages, losses, penalties, or liabilities arising from incorrect or false declarations made by the Consignor.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">12. If the goods covered by this Lorry Receipt are lost, destroyed, damaged, or have deteriorated, the compensation payable by the Transport Operator shall be limited to the value declared by the Consignor. The declared value represents the maximum amount that the Transport Operator will be held liable for in such cases. It is the responsibility of the Consignor to accurately declare the value of the goods prior to their transportation. The Transport Operator's liability for loss, destruction, damage, or deterioration of the goods shall be limited to the declared value and shall not exceed this amount.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">13. The Customer is responsible for adequately insuring the goods against loss, damage, or theft during transportation. Our logistics firm shall not be held liable for any loss or damage to uninsured goods.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">14. Any disputes arising from this agreement shall be resolved through negotiation in good faith. If the parties are unable to reach a mutually satisfactory resolution, either party may initiate mediation or other alternative dispute resolution methods agreed upon by both parties.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">15. Either party may terminate this agreement with written notice to the other party. Termination shall not relieve the Customer of its obligation to pay for services rendered up to the termination date. Both parties agree to treat any confidential information shared during the course of this agreement as confidential and not to disclose it to any third party without prior written consent unless required by law.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#221E1F;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p style="font-size:9px">16. This agreement shall be governed by and construed in accordance with the laws of Delhi jurisdiction. Any legal action or proceeding arising out of or relating to this agreement shall be exclusively settled in the courts.</p>
                            </td>
                        </tr>
                        <tr style="height:24pt">
                            <td style="width:537pt;border-top-style:solid;border-top-width:1pt;border-top-color:#221E1F;border-left-style:solid;border-left-width:1pt;border-left-color:#221E1F;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#221E1F" colspan="3">
                                <p class="txt-center"><span class="s20" style=" background-color: #F6F6F7;">ALL THE ABOVE TERMS &amp; CONDITIONS HAVE BEEN READ OVER/EXPLAINED TO AND ACCEPTED BY THE CONSIGNOR(S) AND/OR HIS AGENT(S).</span></p>
                            </td>
                        </tr>
                        <tr style="height:49pt">
                            <td style="width:179pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                                <p class="s10 txt-center">DELHI (NCR) BRANCH</p>
                                <p class="s10 txt-center">CONTACT PERSON-DEVANSH GOYAL</p>
                                <p class="s10 txt-center">CONTACT NUMBER-+91-7669027909</p>
                            </td>
                            <td style="width:179pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                                <p class="s10 txt-center">CHENNAI BRANCH</p>
                                <p class="s10 txt-center">CONTACT PERSON–MANJEET THAKAN</p>
                                <p class="s10 txt-center">CONTACT NUMBER-+91-7669027904</p>
                            </td>
                            <td style="width:179pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                                <p class="s10 txt-center">ACCOUNTS QUERY</p>
                                <p class="s10 txt-center"></p>
                                <p class="s10 txt-center">CONTACT NUMBER-+91-7669027906</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php } ?> 
                <!-- transporter copy -->
                <table cellspacing="0" class="print-table">
                    <tbody>
                        <tr style="font-size: 10px;">
                            <td colspan="6" class="td-head">
                                <table border="0" cellspacing="0" cellpadding="0" class="">
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;">
                                                <img width="105" height="47" src="<?php echo base_url(); ?>public/assets/img/logo.png">
                                            </td>
                                            <td style="width: 80%;">
                                                <p style="text-align: center; font-size: 24px; text-decoration: underline;">
                                                    <b>GAE CARGO MOVERS PRIVATE LIMITED</b>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center;">
                                                <b>
                                                    A-131/2, 2nd Floor, Wazirpur Industrial Area, Delhi- 110052<br>
                                                    Mobile : 7669027900, EMail :booking@gaegroup.in<br>
                                                    PAN NO - AAICG9037G | GSTIN - 07AAICG9037G1ZF <br>
                                                    CIN - U63030DL2021PTC378353 | MSME - UDYAM-DL-06-0016237
                                                </b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style="height:25pt">
                            <td class="s6td" colspan="3">
                                <p class="s6 p13">
                                    <span class="s6 td-sub">
                                        Subject to Delhi Jurisdiction
                                    </span>
                                </p>
                            </td>
                            <td class="s6td" colspan="3" align="right">
                                <p class="s6 p13"><b>Transporter Copy</b></p>
                            </td>
                        </tr>
                        <tr style="height:21pt">
                            <td class="td1" colspan="3">
                                <p class="s9 tdp1">ConsignmentNo <span class="s10"><?= $lr['consignment_no'] ?></span></p>
                                <p class="s9 tdp2">ConsignmentDate <span class="s10"><?= date('d M Y', strtotime($lr['consignment_date'])) ?></span></p>
                            </td>
                            <td class="td2" colspan="3">
                                <p class="s9 tdp1">BookingBranch <span class="s10"><?= isset($lr['branch_name']) && (!empty($lr['branch_name'])) ? $lr['branch_name'] : '-' ?></span></p>
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
                            <td class="td14" colspan="3">
                                <p class="s9 p14 txt-center">Work Order No.: <?= isset($lr['booking_number']) && (!empty($lr['booking_number'])) ? $lr['booking_number'] : '-' ?></p>
                                <p class="s9 p14 txt-center" >Work Order Date: <?= isset($lr['booking_date']) && ($lr['booking_date'] != '0000-00-00') ? date('d M Y',strtotime($lr['booking_date'])) : '-' ?></p>
                            </td>  
                            <td class="td16" colspan="3">
                                <p class="s9 p14 txt-center" >Driver Name : <?= isset($driver['driver_name']) && ($driver['driver_name']) ? ucwords(strtolower($driver['driver_name'])) : '-' ?></p>
                                <p class="s9 p14 txt-center" >Driver Phone No : <?= isset($driver['primary_phone']) && ($driver['primary_phone']) ? $driver['primary_phone'] : '-' ?></p>
                            </td> 
                        </tr>
                        <tr style="height:auto">
                            <td class="td18 bor-r-none bobn">
                                <p class="s9 p14">ConsignorName:</p>
                            </td>
                            <td class="td19 bn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignor_name']) && (!empty($lr['consignor_name'])) ? strtoupper($lr['consignor_name']) : '-' ?></p>
                            </td>
                            <td class="td20 bor-r-none bobn">
                                <p class="s9 p14">Consignee Name:</p>
                            </td>
                            <td class="td21 bor-l-none  bobn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignee_name']) && (!empty($lr['consignee_name'])) ? strtoupper($lr['consignee_name']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:auto">
                            <td class="td22 bor-r-none botn bobn">
                                <p class="s9 p14">Consignor Address:</p>
                            </td>
                            <td class="td23 bn " colspan="2">
                                <p class="s10 p15" style="text-indent: 0pt;line-height: 12pt;text-align: left;"><?= isset($lr['consignor_address_f']) && (!empty($lr['consignor_address_f'])) ? strtoupper($lr['consignor_address_f']) : '-' ?></p>
                            </td>
                            <td class="td24 botn  bor-r-none bobn">
                                <p class="s9 p14">Consignee Address:</p>
                            </td>
                            <td class="td25 botn bor-l-none bobn" colspan="2">
                                <p class="s10 bn" style="text-indent: 0pt;line-height: 12pt;text-align: left;"><?= isset($lr['consignee_address_f']) && (!empty($lr['consignee_address_f'])) ? strtoupper($lr['consignee_address_f']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:auto">
                            <td class="td26 bor-r-none botn">
                                <p class="s9 p14">GSTIN:</p>
                            </td>
                            <td class="td27  bor-l-none botn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignor_GSTIN']) && (!empty($lr['consignor_GSTIN'])) ? strtoupper($lr['consignor_GSTIN']) : '-' ?></p>
                            </td>
                            <td class="td28  bor-r-none botn">
                                <p class="s9 p14">GSTIN:</p>
                            </td>
                            <td class="td29  bor-l-none botn" colspan="2">
                                <p class="s10 p14"><?= isset($lr['consignee_GSTIN']) && (!empty($lr['consignee_GSTIN'])) ? strtoupper($lr['consignee_GSTIN']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:64pt">
                            <td class="td30 bor-r-none">
                                <p class="s9 p14">Place of Dispatch:</p>
                            </td>
                            <td class="td31 bor-l-none" colspan="2">
                                <p class="s10 p15"><?= isset($lr['place_of_dispatch_address_f']) && (!empty($lr['place_of_dispatch_address_f'])) ? strtoupper($lr['place_of_dispatch_address_f']) : '-' ?></p>
                            </td>
                            <td class="td32 bor-r-none">
                                <p class="s9 p14">Place of Delivery:</p>
                            </td>
                            <td class="td33 bor-l-none" colspan="2">
                                <p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;"><?= isset($lr['place_of_delivery_pincode_f']) && (!empty($lr['place_of_delivery_pincode_f'])) ? strtoupper($lr['place_of_delivery_pincode_f']) : '-' ?></p>
                            </td>
                        </tr>
                        <tr style="height:11pt">
                            <td class="td34">
                                <p class="s9 p12" style="padding-left: 24pt;">Particulars</p>
                            </td>
                            <td class="td35">
                                <p class="s9 p16">HSNCode</p>
                            </td>
                            <td class="td36">
                                <p class="s9 p16">No.ofPackages</p>
                            </td>
                            <td class="td37">
                                <p class="s9 p12" style="padding-left: 19pt;">ActualWeight</p>
                            </td>
                            <td class="td38">
                                <p class="s9 p16">Charge Weight</p>
                            </td>
                            <td class="td39">
                                <p class="s9 p16">PaymentTerms</p>
                            </td>
                        </tr>
                        <tr style="height:21pt">
                            <td class="td40">
                                <p class="s10" style="padding-left: 22pt;padding-right: 2pt;text-indent: -19pt;line-height: 10pt;text-align: left;"><?= isset($lr['particulars']) && (!empty($lr['particulars'])) ? strtoupper($lr['particulars']) : '-' ?></p>
                            </td>
                            <td class="td41">
                                <p class="s10 p11"><?= isset($lr['hsn_code']) && (!empty($lr['hsn_code'])) ? strtoupper($lr['hsn_code']) : '-' ?></p>
                            </td>
                            <td class="td42">
                                <p class="s10 p11"><?= isset($lr['no_of_packages']) && (!empty($lr['no_of_packages'])) ? strtoupper($lr['no_of_packages']) : '-' ?></p>
                            </td>
                            <td class="td43">
                                <p class="s10 p11"><?= isset($lr['actual_weight']) && (!empty($lr['actual_weight'])) ? strtoupper($lr['actual_weight']) : '-' ?></p>
                            </td>
                            <td class="td44">
                                <p class="s10 p11"><?= isset($lr['charge_weight']) && (!empty($lr['charge_weight'])) ? strtoupper($lr['charge_weight']) : '-' ?></p>
                            </td>
                            <td class="td45">
                                <p class="s10 p11"><?= isset($lr['payment_terms']) && (!empty($lr['payment_terms'])) ? strtoupper($lr['payment_terms']) : '-' ?></p>
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
                                <p class="s10 p11"><?= isset($lr['e_way_bill_number']) && (!empty($lr['e_way_bill_number'])) ? strtoupper($lr['e_way_bill_number']) : '-' ?></p>
                            </td>
                            <td class="td50" colspan="2">
                                <p class="s10 p11"><?= isset($lr['e_way_expiry_date']) && (strtotime($lr['e_way_expiry_date']) > 0) ? date('d/m/Y', strtotime($lr['e_way_expiry_date'])) : '-' ?></p>
                            </td>
                            <td class="td51" colspan="2">
                                <p class="s11 p11"><?= isset($lr['freight_charges_amount']) && (!empty($lr['freight_charges_amount'])) ? strtoupper($lr['freight_charges_amount']) : '-' ?></p>
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
                                <p class="s9 p12" style="padding-left: 60pt;">Invoice/BOEDate</p>
                            </td>
                            <td class="td55" colspan="2">
                                <p class="s9 p12 p16">Invoice Value</p>
                            </td>
                        </tr>
                        <tr style="height:11pt">
                            <td class="td56" colspan="2">
                                <p class="s10 p12" style="padding-left: 60pt;"><?= isset($lr['invoice_boe_no']) && (!empty($lr['invoice_boe_no'])) ? strtoupper($lr['invoice_boe_no']) : '-' ?></p>
                            </td>
                            <td class="td57" colspan="2">
                                <p class="s10 p12" style="padding-left: 56pt;"><?= isset($lr['invoice_boe_date']) && (strtotime($lr['invoice_boe_date']) > 0) ? date('d M y, h:i A', strtotime($lr['invoice_boe_date'])) : '-' ?></p>
                            </td>
                            <td class="td58" colspan="2">
                                <p class="s10 p16"><?= isset($lr['invoice_value']) && (!empty($lr['invoice_value'])) ? strtoupper($lr['invoice_value']) : '-' ?></p>
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
                                <p class="s9">Reporting Date/Time:<?= isset($lr['reporting_datetime']) && (strtotime($lr['reporting_datetime']) > 0) ? date('d M y, h:i A', strtotime($lr['reporting_datetime'])) : '-' ?></p>
                                <p class="s9">Releasing Date/Time:<?= isset($lr['releasing_datetime']) && (strtotime($lr['releasing_datetime']) > 0) ? date('d M y, h:i A', strtotime($lr['releasing_datetime'])) : '-' ?></p>
                            </td>
                            <td class="td60" colspan="3">
                                <p class="s9">Policy Date:<?= isset($lr['policy_date']) && (strtotime($lr['policy_date']) > 0) ? date('d M y, h:i A', strtotime($lr['policy_date'])) : '-' ?></p>
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

            </div>

        </div>
    </div>
</div>