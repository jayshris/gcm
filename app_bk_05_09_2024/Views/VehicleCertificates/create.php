<!DOCTYPE html>
<html lang="en">

<head>
  <?= $this->include('partials/title-meta') ?>
  <?= $this->include('partials/head-css') ?>
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

            <?= $this->include('partials/page-title') ?>

            <?php $validation = \Config\Services::validation();
            // print_r($category_details);
            // print_r($companies);

            // echo set_value('product_name');
            ?>

            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <!-- Settings Info -->
                <div class="card">
                  <div class="card-body">
                    <div class="settings-form">


                      <form method="post" enctype="multipart/form-data" action="<?php echo base_url('vehiclecertificates/create'); ?>">

                        <div class="settings-sub-header">
                          <h6>Add New Certificate</h6>
                        </div>
                        <div class="profile-details" id="certificate_div">
                          <div class="row g-3"> 
                            <div class="col-md-4">
                              <label class="col-form-label">Vehicle <span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="vehicle_id" aria-label="Default select example">
                                <option value="">Select Vehicle</option>
                                <?php foreach ($vehicles as $v) {
                                  echo '<option value="' . $v['id'] . '">' . $v['rc_number'] . '</option>';
                                } ?>
                              </select>
                            </div>
                          </div>
                          <br> 
                          
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary">Save</button>
                          <button type="button" class="btn btn-info" id="add_more" onclick="$.addCertificate()">Add More</button>
                          <a href="./create" class="btn btn-warning">Reset</a>
                          <a href="<?php echo base_url().$currentController; ?>" class="btn btn-light">Back</a>
                        </div>
                      </form>

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
    $(document).ready(function() {
      $.addCertificate();
    });

    $.getOffice = function() {

      var company_id = $('#company_id').val();
      console.log(company_id);

      $.ajax({
        method: "POST",
        url: '<?php echo base_url('warehouses/getOffice') ?>',
        data: {
          company_id: company_id
        },
        success: function(response) {

          console.log(response);
          $('#office_id').html(response);
        }
      });

    }

    $.addCertificate = function() {
      var index = $('#certificate_div .certificate_div_block').children('div').length; 
      $.ajax({
        type: "POST",
        url: "<?php echo base_url($currentController.'/addCertificate'); ?>",
        data: {
          index: index
        },
        beforeSend: function() {
            // setting a timeout
            $('#add_more').attr('disabled','disabled');
        },
        success: function(data) {
          $('#add_more').removeAttr('disabled');
          $('#certificate_div').append(data);
        }
      })
    }

    $.delete = function(index) {
      $('.del_cert_' + index).remove(); 
    }

    function checkUniqueCertificate(index){ 

      var certificates=[]; 
      var selectedVal = $('#certificate_'+index).val();
      // alert('selectedVal = '+selectedVal + ' / arra = ' +certificates + ' / isexist =' + certificates.indexOf(selectedVal));
      $('.certificates-err').html('');
     var added = true;
      $('select[name="certificate_id[]"] option:selected').each(function(i) {  
        console.log(index);
        if ($(this).val() > 0) { 
          // alert($(this).val() +'=='+ selectedVal + certificates.indexOf(selectedVal));
          if((certificates.indexOf(selectedVal) > -1) && ($(this).val() == selectedVal)){
            added = false;
          }
          if(certificates.indexOf(selectedVal) < 0){
            certificates.push($(this).val());   
          } 
         
        }
      });     
      if(added == false){
        $("#certificate_"+index).val("");//.trigger('change'); 
        var html = "<font color=red>Certificate type already selected. Please try another one.</font>"
        $("#certificates_sp_"+index).html(html);
      } 
    }
  </script>

</body>

</html>