<!DOCTYPE html>
<html lang="en">

<head>
  <?= $this->include('partials/title-meta') ?>
  <?= $this->include('partials/head-css') ?>
  <!-- Feathericon CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/feather.css">


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
            <div class="row">
              <div class="col-xl-12 col-lg-12">


              <div class="settings-sub-header">
                <h6>Update Party type</h6>
              </div>
              <?= $this->include('Partytype/form.php') ?>

              
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

  <!-- Profile Upload JS -->
  <script src="<?php echo base_url(); ?>assets/js/profile-upload.js"></script>

  <!-- Sticky Sidebar JS -->
  <script src="<?php echo base_url(); ?>assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
  
  <script>   
    $("input[name='sale']").click(function(){      
      var sale = $('input[name="sale"]:checked').val() 
      $('input[name=lr_first_party]').attr("disabled",true).prop('checked', false); 
      $('.lr-span').text(''); 
      $('input[name=lr_third_party]').attr("disabled",true).prop('checked', false); 
      $('.lr-third-span').text(''); 
      if(sale==1){ 
        $('input[name="lr_first_party"]').removeAttr('disabled');
        $('.lr-span').text('*');
        $('input[name=lr_third_party]').removeAttr('disabled');
        $('.lr-third-span').text('*'); 
      }
    });
    function unselectYesParty(name){
      var nameVal = $('input[name="'+name+'"]:checked').val() 
      if(nameVal == 1){
        $('input[name="'+name+'"]').prop('checked', false); 
      }      
    }
  </script>
</body>

</html>