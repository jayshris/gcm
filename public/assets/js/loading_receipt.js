$(document).ready(function() {
    $("#consignor_name").select2({
        tags: true
    }); 
     $("#consignee_name").select2({
        tags: true
    });  

    $('form').submit(function() { 
        $(":submit").attr("disabled", "disabled");
    });

    $("#consignor_city").select2({
        tags: true
    }); 
    $("#consignee_city").select2({
        tags: true
    });   

}); 

var base_url = $('#base_url').val(); 
  
$.getBookingDetails = function() {
    $("#transporter_bilti_no_div").attr('hidden','hidden');
    $("#e_way_bill_no_div").attr('hidden','hidden');
    $("#transporter_bilti_no").attr('readonly','readonly');
    $("#e_way_bill_no").attr('readonly','readonly');
    $("#transporter_bilti_no").val('');
    $("#e_way_bill_no").val('');
    $('#transporter_div').attr('hidden','hidden');
    $('#e_way_bill_number_div').removeAttr('hidden');
    $('#e_way_bill_number').removeAttr('disabled');
    $('#e_way_expiry_date_div').removeAttr('hidden');
    $('#payment_terms_div').attr('hidden','hidden');
    var booking_id = $('#booking_id').val();
    $(".tr-req").removeAttr('required');
    $(".tr-req").val('');

    if(booking_id){
        $.ajax({
            method: "POST",
            url: base_url+'loadingreceipt/getBookingDetails',
            data: {
                booking_id: booking_id
            },
            dataType: "json",
            success: function(res) { 
                $("#office_id").val(res.office_id).attr("selected","selected").trigger('change').attr('disabled','disabled');
                $("#booking_date").val(res.booking_date).attr('disabled','disabled');
                $("#vehicle_number").val(res.vehicle_id);
                $("#consignment_date").attr('min',res.booking_date);
                $("#loading_station").val(res.bp_city);
                $("#delivery_station").val(res.bd_city);
                $("#charge_weight").val(res.guranteed_wt);
                $("#customer_name").val(res.party_name);
                if(res.is_lr_third_party > 0){
                    $("#transporter_bilti_no_div").removeAttr('hidden'); 
                    $("#e_way_bill_no_div").removeAttr('hidden'); 
                    $("#transporter_bilti_no").removeAttr('readonly');
                    $("#e_way_bill_no").removeAttr('readonly');
                    $('#transporter_div').removeAttr('hidden');
                    $('#e_way_bill_number_div').attr('hidden','hidden');
                    $('#e_way_bill_number').attr('disabled','disabled');
                    $('#e_way_expiry_date_div').attr('hidden','hidden');
                    $(".tr-req").attr('required','required');
                } 
                
                if(res.is_lr_first_party > 0){
                    $('#payment_terms_div').removeAttr('hidden');

                    //If lr first party then pincode should be mandatory for ship to and disapatch - 07-10-2024
                    $('#place_of_delivery_pincode').attr('required','required');
                    $('#place_of_dispatch_pincode').attr('required','required');
                    $('.lr-pincode').removeAttr('hidden');
                }else{
                    $('#place_of_delivery_pincode').removeAttr('required');
                    $('#place_of_dispatch_pincode').removeAttr('required');
                    $('.lr-pincode').attr('hidden','hidden');
                }
            }
        });
    }else{
        $("#office_id").val('').trigger('change').attr('disabled','disabled');
        $("#booking_date").val('').attr('disabled','');
        $("#vehicle_number").val('');
        $("#consignment_date").attr('min','');
        $("#loading_station").val('');
        $("#delivery_station").val('');
        $("#charge_weight").val('');
        $("#customer_name").val('');
    }			
}

function changeIdIpt(branch_id,party_id,id,key = 'consignor'){
    // return true;
    var party_id = (party_id) > 0 ? party_id : 0; 
    var pre = 'place_of_delivery';
    if(key == 'consignor'){
        pre = 'place_of_dispatch';
    }  
    if(key == 'transporter'){
        branch_id = (branch_id == 'Select Office') ? '' : branch_id;
        pre = 'transporter';
    }
    if(key == 'supplier'){
        pre = 'consignor';
    }
    if(key == 'recipient'){
        pre = 'consignee';
    }
    // alert(party_id + ' /branch_id ' +branch_id );
    if((party_id>0) && (branch_id !='')){
        $.ajax({
        method: "POST",
        url: base_url+'loadingreceipt/getPartyDetails',
        data: {
            party_id: party_id,
            branch_id:branch_id
        },
        dataType: "json",
        success: function(res) {
                // $("#"+key+"_state").val(res.state_id).attr("selected","selected").trigger('change');  
                // $("#"+pre+"_state").val(res.state_id).attr("selected","selected").trigger('change');  
                // $("#"+key+"_address").val(res.address);
                $("#"+pre+"_address").val(res.address);

                // $("#"+key+"_city").val(res.city);
                $("#"+pre+"_city").val(res.city);

                // $("#"+key+"_pincode").val(res.pincode);
                $("#"+pre+"_pincode").val(res.pincode);

                //$("#"+key+"_GSTIN").val(res.gst); 
                $("#"+pre+"_GSTIN").val(res.gst);

                $("#selected_"+pre+"_state").val(res.state_id);  
                $("#selected_"+pre+"_city_id").val(res.city_id); 
                $("#selected_"+pre+"_pincode").val(res.pincode); 
                $("#"+pre+"_country_id").val(res.country_id).trigger('change'); 
 

            }
        }); 
        
    }else{
        // $("#"+key+"_state").val('').attr("selected","selected").trigger('change');  
        $("#"+pre+"_state").val('').attr("selected","selected").trigger('change');  
        // $("#"+key+"_address").val('');
        $("#"+pre+"_address").val('');

        // $("#"+key+"_city").val('');
        $("#"+pre+"_city").val('');

        // $("#"+key+"_pincode").val('');
        $("#"+pre+"_pincode").val('');
        $("#"+pre+"_GSTIN").val('');
    }
}

$.getVehicleBookings = function() {
    var vehicle_id = $('#vehicle_number').val();
    
    $.ajax({
        method: "POST",
        url: base_url+'loadingreceipt/getVehicleBookings',
        data: {
            vehicle_id: vehicle_id
        },
        dataType: "json",
        success: function(res) { 
            console.log(res);
            var html  ='<option value="">Select Booking</option>';
            if(res){
                $.each(res, function(i, item) { 
                    var selected = (i==0) ? 'selected' : '';
                    html += '<option value="'+item.id+'" "'+selected+'">'+item.booking_number+'</option>'; 
                }); 
            }
            $('#booking_id').html(html);
            $('#booking_id').val('').attr("selected","selected").trigger('change');   
        }
    });
}

function customerBranches(customer_id,customer_type,supplier_or_recipient){
    $("#"+customer_type+"_office_id").attr('disabled','disabled');
    $("#"+customer_type+"_office_id").removeAttr('required');
    $('#'+customer_type+'_office_id').val('').attr("selected","selected").trigger('change');
    $("#"+customer_type+"_branch_span").attr('hidden','hidden');

    $('#'+supplier_or_recipient+'_office_id').val('').attr("selected","selected").trigger('change');
    $('#'+supplier_or_recipient+'_office_id').attr('disabled','disabled');

    if(customer_id > 0 ){
        $('#'+customer_type+'_id').val(customer_id); 
        $.ajax({
            method: "POST",
            url: base_url+'loadingreceipt/getCustomerBranches',
            data: {
                customer_id: customer_id  
            },
            dataType: "json",
            success: function(res) { 
                var html  ='<option value="">Select Branch</option>';
                if(res){
                    $.each(res, function(i, item) { 
                        var selected = (i==0) ? 'selected' : '';
                        html += '<option value="'+item.office_name+'" "'+selected+'">'+item.office_name+'</option>'
                    }); 
                    $("#"+customer_type+"_office_id").removeAttr('disabled');
                    $("#"+customer_type+"_office_id").attr('required','required');
                } 
                $('#'+customer_type+'_office_id').html(html);
                $('#'+customer_type+'_office_id').val('').attr("selected","selected").trigger('change');   
                $("#"+customer_type+"_branch_span").removeAttr('hidden');//alert('customer_type');return false;

                if(customer_type=='consignor'){
                    $("#supplier_office_id").attr('disabled','disabled');
                    $("#supplier_office_id").removeAttr('required');
                    $('#supplier_office_id').val('').attr("selected","selected").trigger('change');

                    var htmlS  ='<option value="">Select Branch</option>';
                    if(res){
                        $.each(res, function(i, item) { 
                            var selected = (i==0) ? 'selected' : '';
                            htmlS += '<option value="'+item.office_name+'" "'+selected+'">'+item.office_name+'</option>'
                        }); 
                        $("#supplier_office_id").removeAttr('disabled');
                        $("#supplier_office_id").attr('required','required');
                    } 
                    $('#supplier_office_id').html(htmlS);
                    $('#supplier_office_id').val('').attr("selected","selected").trigger('change');   
                    $("#supplier_office_id").removeAttr('hidden');
                    $('#place_of_dispatch_name').val($('#'+customer_type+'_name').val());
                }

                if(customer_type=='consignee'){
                    $("#recipient_office_id").attr('disabled','disabled');
                    $("#recipient_office_id").removeAttr('required');
                    $('#recipient_office_id').val('').attr("selected","selected").trigger('change');

                    var htmlS  ='<option value="">Select Branch</option>';
                    if(res){
                        $.each(res, function(i, item) { 
                            var selected = (i==0) ? 'selected' : '';
                            htmlS += '<option value="'+item.office_name+'" "'+selected+'">'+item.office_name+'</option>'
                        }); 
                        $("#recipient_office_id").removeAttr('disabled');
                        $("#recipient_office_id").attr('required','required');
                    } 
                    $('#recipient_office_id').html(htmlS);
                    $('#recipient_office_id').val('').attr("selected","selected").trigger('change');   
                    $("#recipient_office_id").removeAttr('hidden');
                    $('#place_of_delivery_name').val($('#'+customer_type+'_name').val());
                }
            }
        });	
         //27-09-2024 If consignee or cosignor added manually, then remove city and state mandatory validation 
        $('#'+customer_type+'_city_spn').removeAttr('hidden');
        $('#'+customer_type+'_state_spn').removeAttr('hidden');
        $('#'+customer_type+'_city').attr('required','required');
        $('#'+customer_type+'_state').attr('required','required');

    }else{ 

        //If consignee or cosignor added manually, then remove city and state mandatory validation 
        $('#'+customer_type+'_city_spn').attr('hidden','hidden');
        $('#'+customer_type+'_state_spn').attr('hidden','hidden');
        $('#'+customer_type+'_city').removeAttr('required');
        $('#'+customer_type+'_state').removeAttr('required');
    } 
//    partyInfo(customer_id, customer_type); 
    
}

function partyInfo(party_id=0, key = 'consignor'){   
    var pre = 'place_of_dispatch';
    if(key == 'consignee'){
        pre = 'place_of_delivery';
    } 
    
    $("#"+key+"_state").val('').attr("selected","selected").trigger('change');  
    $("#"+key+"_address").val('');
    $("#"+key+"_city").val('');
    $("#"+key+"_pincode").val('');
    $("#"+key+"_GSTIN").val('');
    $("#"+pre+"_name").val('');

    if(party_id>0){
        $.ajax({
        method: "POST",
        url: base_url+'loadingreceipt/getPartyInfo',
        data: {
            party_id: party_id
        },
        dataType: "json",
        success: function(res) {console.log(res);
                $("#"+key+"_state").val(res.state_id).attr("selected","selected").trigger('change');   
                $("#"+key+"_address").val(res.business_address);
                $("#"+key+"_city").val(res.city);
                $("#"+key+"_pincode").val(res.postcode);
                $("#"+key+"_GSTIN").val(res.gst);
                $("#"+pre+"_name").val(res.party_name); 
            }
        });
    }
}

function transportedBranches(customer_id,customer_type){  
    $("#"+customer_type+"_office_id").attr('disabled','disabled');
    $("#"+customer_type+"_office_id").removeAttr('required');
    $('#'+customer_type+'_office_id').val('').attr("selected","selected").trigger('change'); 
    if(customer_id > 0 ){
        $('#'+customer_type+'_id').val(customer_id); 
        $.ajax({
            method: "POST",
            url: base_url+'loadingreceipt/getTransporterBranchesById',
            data: {
                customer_id: customer_id  
            },
            dataType: "json",
            success: function(res) { 
                console.log(res);
                var html  ='<option value="">Select Branch</option>';
                if(res){
                    $.each(res, function(i, item) { 
                        var selected = (i==0) ? 'selected' : '';
                        html += '<option value="'+item.id+'" "'+selected+'">'+item.office_name+'</option>'
                    }); 
                    $("#"+customer_type+"_office_id").removeAttr('disabled');
                    $("#"+customer_type+"_office_id").attr('required','required');
                } 
                $('#'+customer_type+'_office_id').html(html);
                $('#'+customer_type+'_office_id').val('').attr("selected","selected").trigger('change');   
                $("#"+customer_type+"_branch_span").removeAttr('hidden');
            }
        });				
    } 
//    partyInfo(customer_id, customer_type);     
}

function changeCity(thisv,city_id_val,id,changed_id){   
$('#'+id).val( (city_id_val) > 0 ? city_id_val : 0) ; 
}

$("#consignor_country_id").trigger('change');
$("#consignee_country_id").trigger('change');

$("#consignor_state").val($('#selected_consignor_state').val()).trigger('change');
$("#consignee_state").val($('#selected_consignee_state').val()).trigger('change');

function getState(val,changed_id){  
var html ='<option value="">Select</option>';  
var selectedchanged_id = $('#selected_'+changed_id).val();
// alert('st '+changed_id + ' // '+selectedchanged_id);
if(val == 0){
    var selected = (selectedchanged_id == 0) ? 'selected': '';
    html += '<option value="0" '+selected+'>Other State</option>';
    $('#'+changed_id).html(html);
    $('#'+changed_id).trigger('change');
}
if(val > 0){
        $.ajax({
        method: "POST",
        url: base_url+'booking/getStateByCountry',
        data: {
            country_id: val
        },
        dataType:'json',
        beforeSend: function() { 
                $("body").css({ opacity:0.5 });
                $('#save-btn').attr('disabled','disabled'); 
        },
        complete: function(){
            $("body").css({ opacity:1});
            $('#save-btn').removeAttr('disabled'); 
        },
        success: function(response) {  
            if(response){ 
            response.forEach(function(val) {
                var selected = (selectedchanged_id == val.state_id) ? 'selected': '';
                html += '<option value="'+val.state_id+'" '+selected+'>'+val.state_name+'</option>'
            });
            }
            $('#'+changed_id).html(html);
            $('#'+changed_id).trigger('change');
        }
        });
    }
} 

function getCitiesByState(val,changed_id){ 
var selectedchanged_id = $('#selected_'+changed_id+'_id').val();
// alert('getCitiesByState   '+selectedchanged_id);
var html ='<option value="">Select</option>'; 
// alert('getCitiesByState '+val+' / val ' +changed_id + ' / selected '+ $('#selected_'+changed_id).val());
if(val == 0){ 
var selected = (selectedchanged_id == 0) ? 'selected': '';
    html += '<option value="0" '+selected+'>Other City</option>';
    $('#'+changed_id).html(html);
    $('#'+changed_id).trigger('change'); 
}
if(val > 0){
        $.ajax({
        method: "POST",
        url: base_url+'booking/getCitiesByState',
        data: {
            state_id: val
        },
        dataType:'json',
        beforeSend: function() { 
                $("body").css({ opacity:0.5 });
                $('#save-btn').attr('disabled','disabled'); 
        },
        complete: function(){
            $("body").css({ opacity:1});
            $('#save-btn').removeAttr('disabled'); 
        },
        success: function(response) { 
            var html ='<option value="0">Select</option>';
            if(response){ 
            response.forEach(function(val) {
                var selected =(selectedchanged_id == val.id) ? 'selected': '';
                html += '<option value="'+val.city+'" '+changed_id+'_id="'+val.id+'" '+selected+' >'+val.city+'</option>'
            });
            }
            $('#'+changed_id).html(html);
            $('#'+changed_id).trigger('change');
        }
        });
    }
}

function getPincodeByCity(city_id_val,changed_id){  
var html ='<option value="">Select</option>';   
if(city_id_val > 0){
        $.ajax({
        method: "POST",
        url: base_url+'booking/getPincodeByCity/'+city_id_val, 
        dataType:'json',
        beforeSend: function() { 
                $("body").css({ opacity:0.5 });
                $('#save-btn').attr('disabled','disabled'); 
        },
        complete: function(){
            $("body").css({ opacity:1});
            $('#save-btn').removeAttr('disabled'); 
        },
        success: function(response) {   
            if(response){  
                var selectedchanged_id = $('#selected_'+changed_id).val();
                response.forEach(function(val) { 
                var selected =(selectedchanged_id == val) ? 'selected': '';
                    html += '<option value="'+val+'" '+selected+'>'+val +'</option>'
                });
            }
            $('#'+changed_id).html(html);  
        }
        });
    }else{
        $('#'+changed_id).html(html);
    } 
} 