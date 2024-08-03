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
                <h6>Add Party type</h6>
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
    checkLR();
    $("input[name='sale']").click(function(){      
      checkLR();
    });
    function checkLR(){
      var sale = $('input[name="sale"]:checked').val() 
      $('input[name=LR]').attr("disabled",true).prop('checked', false); 
      $('.lr-span').text(''); 
      if(sale==1){ 
        $('input[name="LR"]').removeAttr('disabled');
        $('.lr-span').text('*');
      }
    }
  </script>
</body>

</html>