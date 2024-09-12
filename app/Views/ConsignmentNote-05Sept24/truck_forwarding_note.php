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
                    <span class="s7 prtds10">TRUCK FORWARDING NOTE</span>
                    <span class="s6" style="float: right;">Transporter Copy</span>
                </p>
            </td>
        </tr>
        <tr style="height:21pt" class="flr">
            <td class="td1">
                <p class="s9 tdp1 rl">ConsignmentNo:</p> 
            </td>
            <td class="td2" colspan="2">
                <p class="s9 tdp1 pdl6"><?= $lr['consignment_no'] ?></p> 
            </td>
            <td class="td1" colspan="2">
                <p class="s9 tdp1 rl">ConsignmentDate:</p> 
            </td>
            <td class="td2">
                <p class="s9 tdp1  pdl6"><span class="s10"><?= date('d M Y', strtotime($lr['consignment_date'])) ?></span></p>
            </td>
        </tr>
        <tr style="height:21pt" class="flr">
            <td class="td1 "> 
                <p class="s9 tdp2 rl">Actual Weight:</p>
            </td>
            <td class="td2" colspan="2">
                <p class="s9 tdp1 pdl6"><?= isset($lr['actual_weight']) && (!empty($lr['actual_weight'])) ? $lr['actual_weight'] : '-' ?></p> 
            </td>
            <td class="td1" colspan="2">
                <p class="s9 tdp2 rl">Charged Weight:</p>
            </td>
            <td class="td2">
                <p class="s9 tdp2 pdl6"><?= isset($lr['charge_weight']) && (!empty($lr['charge_weight'])) ? $lr['charge_weight'] : '-' ?></p>
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
            <td  class="td14" colspan="1">
                <p class="s9 p14" >Party Name:</p>
            </td> 
            <td class="td16" colspan="5">
                <p class="s10 p14" ><?= isset($lr['bill_to_party_nm']) && !empty($lr['bill_to_party_nm']) ? $lr['bill_to_party_nm'] : '-' ?></p>
            </td> 
        </tr>
        <tr style="height:21pt">
            <td  class="td14" colspan="1">
                <p class="s9 p14" >Party Address:</p>
            </td> 
            <td class="td16" colspan="5">
                <p class="s10 p14" ><?= isset($lr['bill_to_address']) && !empty($lr['bill_to_address']) ? $lr['bill_to_address'] : '-' ?></p>
            </td> 
        </tr>
        <tr style="height:21pt">
            <td  class="td14" colspan="1">
                <p class="s9 p14" >GST No.:</p>
            </td> 
            <td class="td16" colspan="5">
                <p class="s10 p14" >07AFOPG6202K1ZE</p>
            </td> 
        </tr>
            
        <tr style="height:16pt">
            <td class="td59" colspan="3">
                <p class="s9">Reporting Date/Time:&nbsp;<?= isset($lr['reporting_datetime']) && (strtotime($lr['reporting_datetime'])>0) ? date('d M y, h:i A',strtotime($lr['reporting_datetime'])) : '-' ?></p>
                <p class="s9">Releasing Date/Time:&nbsp;<?= isset($lr['releasing_datetime']) && (strtotime($lr['releasing_datetime'])>0) ? date('d M y, h:i A',strtotime($lr['releasing_datetime'])) : '-' ?></p>
            </td>
            <td class="td60" colspan="3">
                <p class="s9">Freight Amount:&nbsp;<?= isset($lr['freight_charges_amount']) && (!empty($lr['freight_charges_amount'])) ? $lr['freight_charges_amount'] : '-' ?></p>
                <p class="s9">Freight  Rate (PMT):&nbsp;<?= isset($lr['rate']) && !empty($lr['rate']) ? $lr['rate'] : '-' ?></p>
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