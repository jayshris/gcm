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
                              <select class="form-select select2" name="vehicle_id[]" aria-label="Default select example">
                                <option value="">Select Vehicle</option>
                                <?php foreach ($vehicles as $v) {
                                  echo '<option value="' . $v['id'] . '">' . $v['rc_number'] . '</option>';
                                } ?>
                              </select>
                            </div>
                          </div>
                          <br>
                          <div class="security-grid flex-fill certificate_div_block">
                            <div class="row g-3"> 
                              <div class="col-md-4">
                                <label class="col-form-label">Certificate Type</label>
                                <select class="form-select select2" name="certificate_id[]" aria-label="Default select example">
                                  <option value="">Select Certificate</option>
                                  <?php foreach ($cert_type as $c) {
                                    echo '<option value="' . $c['id'] . '" ' . (set_value('certificate_id') == $c['id'] ? 'selected' : '') . '>' . $c['name'] . '</option>';
                                  } ?>
                                </select>
                              </div>

                              <div class="col-md-4">
                                <label class="col-form-label">Vendor</label>
                                <select class="form-select select2" name="party_id[]" aria-label="Default select example">
                                  <option value="">Select Vendor</option>
                                  <?php foreach ($party as $p) {
                                    echo '<option value="' . $p['id'] . '" ' . (set_value('party_id') == $p['id'] ? 'selected' : '') . '>' . $p['party_name'] . '</option>';
                                  } ?>
                                </select>
                              </div>

                              <div class="col-md-4">
                                <label class="col-form-label">Document Number </label>
                                <input type="text" name="doc_no[]" class="form-control">
                              </div>

                              <div class="col-md-4">
                                <label class="col-form-label">Issue Date <span class="text-danger">*</span></label>
                                <input type="date" required name="issue_date[]" class="form-control">
                              </div>

                              <div class="col-md-4">
                                <label class="col-form-label">Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" required name="expiry_date[]" class="form-control">
                              </div>

                              <div class="col-md-4">
                                <label class="col-form-label">Authority Issued By <span class="text-danger">*</span></label>
                                <input type="text" required name="issue_by[]" class="form-control">
                              </div>

                              <div class="col-md-4">
                                <label class="col-form-label">Image 1<span class="text-danger">*</span></label>
                                <input type="file" required name="image1[]" accept="application/pdf, application/vnd.ms-excel, image/png, image/gif, image/jpeg" class="form-control">
                              </div>
                              <div class="col-md-4">
                                <label class="col-form-label">Image 2</label>
                                <input type="file" name="image2[]" accept="application/pdf,application/vnd.ms-excel,image/png, image/gif, image/jpeg" class="form-control">
                              </div>
                            </div>
                          </div>
                          
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary">Save</button>
                          <button type="button" class="btn btn-info" onclick="$.addCertificate()">Add More</button>
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
        success: function(data) {
          $('#certificate_div').append(data);
        }
      })
    }

    $.delete = function(index) {
      $('.del_cert_' + index).remove(); 
    }
  </script>

</body>

</html>