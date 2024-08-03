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
            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <div class="settings-sub-header">
                  <h6>Add New Foreman</h6>
                </div>

                <?= $this->include('Foreman/form.php') ?>


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
    jQuery(document).ready(function($) {
      $("#party_id").on('change', function() {
        $("#target").empty();
        var level = $(this).val();
        if (level) {
          $.ajax({
            type: 'POST',
            url: 'populate_fields_data',
            data: {
              party_id: '' + level + ''
            },
            success: function(htmlresponse) {
              $('#target').append(htmlresponse);
            }
          });
        }
      });
      

      $("#dl_no").on('change', function() {
        var dl_no = $(this).val();

        $('#span_dl').html('');
        $('#submit-btn').removeAttr('disabled');

        if (dl_no) {
          $.ajax({
            type: 'POST',
            url: 'validate_dl',
            data: {
              dl_no: dl_no
            },
            success: function(response) {

              if (response == '1') {
                $('#span_dl').html('DL already exists !!');
                $('#submit-btn').attr('disabled', 'disabled');
              }
            }
          });
        }
      });
    });
  </script>
</body>

</html>