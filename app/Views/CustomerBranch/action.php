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
            // print_r($branch_detail);


            // print_r($typeArr);

            // echo set_value('product_name');
            ?>

            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <!-- Settings Info -->
                <div class="card">
                  <div class="card-body">
                    <div class="settings-form">


                      <form method="post" enctype="multipart/form-data" action="<?= isset($branch_detail) ? base_url('customer-branch/edit/' . $branch_detail['id']) : base_url('customer-branch/create') ?>">

                        <div class="settings-sub-header">
                          <h6>Add Customer Branch</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row g-3">



                            <div class="col-md-6">
                              <label class="col-form-label">Customers<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="party_id">
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $c) {
                                  echo '<option value="' . $c['id'] . '" ' . (isset($branch_detail) && $branch_detail['customer_id'] == $c['id'] ? 'selected' : '') . '>' . $c['party_name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-12"> </div>

                            <div class="col-md-6">
                              <label class="col-form-label">Office Name</label>
                              <input type="text" class="form-control" name="office_name" value="<?= isset($branch_detail) ? $branch_detail['office_name'] : '' ?>">
                            </div>

                            <div class="col-md-6">
                              <label class="col-form-label">GST Number</label>
                              <input type="text" class="form-control" name="gst" value="<?= isset($branch_detail) ? $branch_detail['gst'] : '' ?>">
                            </div>



                            <?php if (isset($branch_detail)) {
                              $i = 1;
                              foreach ($branch_persons as $bp) {
                            ?>
                                <div class="col-md-4 count del<?= $i ?>">
                                  <label class="col-form-label">Contact Person Name</label>
                                  <input type="text" class="form-control" name="contact_person[]" value="<?= $bp['name'] ?>">
                                </div>
                                <div class="col-md-2 del<?= $i ?>">
                                  <label class="col-form-label">Designation</label>
                                  <input type="text" class="form-control" name="contact_designation[]" value="<?= $bp['designation'] ?>">
                                </div>
                                <div class="col-md-2 del<?= $i ?>">
                                  <label class="col-form-label">Phone No.</label>
                                  <input type="text" class="form-control" name="contact_phone[]" value="<?= $bp['phone'] ?>">
                                </div>
                                <div class="col-md-3 del<?= $i ?>">
                                  <label class="col-form-label">Email</label>
                                  <input type="text" class="form-control" name="contact_email[]" value="<?= $bp['email'] ?>">
                                </div>

                                <?php if ($i > 1) { ?>
                                  <div class="col-md-1 del<?= $i ?>"><button type="button" class="btn btn-danger" style="margin-top: 26px;" onclick="$.delete(<?= $i ?>);"><i class="fa fa-trash" aria-hidden="true"></i></button></div>
                                <?php } else { ?>
                                  <div class="col-md-1 fill"><button type="button" class="btn btn-info" style="margin-top: 26px;" onclick="$.addMore();"><i class="fa fa-plus" aria-hidden="true"></i></button></div>
                              <?php }

                                $i++;
                              }
                            } else {
                              ?>
                              <div class="col-md-4 count">
                                <label class="col-form-label">Contact Person Name<span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="contact_person[]">
                              </div>
                              <div class="col-md-2">
                                <label class="col-form-label">Designation<span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="contact_designation[]">
                              </div>
                              <div class="col-md-2">
                                <label class="col-form-label">Phone No.<span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="contact_phone[]">
                              </div>
                              <div class="col-md-3">
                                <label class="col-form-label">Email<span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="contact_email[]">
                              </div>
                              <div class="col-md-1 fill"><button type="button" class="btn btn-info" style="margin-top: 26px;" onclick="$.addMore();"><i class="fa fa-plus" aria-hidden="true"></i></button></div>

                            <?php } ?>



                            <div class="col-md-6">
                              <label class="col-form-label">Address</label>
                              <input type="text" class="form-control" name="address" value="<?= isset($branch_detail) ? $branch_detail['address'] : '' ?>">
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">City</label>
                              <input type="text" class="form-control" name="city" value="<?= isset($branch_detail) ? $branch_detail['city'] : '' ?>">
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">State</label>
                              <select class="form-select select2" name="state_id">
                                <option value="">Select State</option>
                                <?php foreach ($state as $row) { ?>
                                  <option value="<?php echo $row["state_id"]; ?>" <?= isset($branch_detail) && $branch_detail['state_id'] == $row["state_id"] ? 'selected' : '' ?>><?php echo ucwords($row["state_name"]); ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Country</label>
                              <input type="text" class="form-control" name="country" value="<?= isset($branch_detail) ? $branch_detail['phone'] : '' ?>">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Pin Code</label>
                              <input type="text" class="form-control" name="pin" value="<?= isset($branch_detail) ? $branch_detail['pincode'] : '' ?>">
                            </div>

                            <?php if (isset($branch_detail)) { ?>

                              <div class="col-12"></div>

                              <div class="col-md-2">
                                <label class="col-form-label">Status<span class="text-danger">*</span></label>
                                <select class="form-select" required name="status" aria-label="Default select example">
                                  <option value="1" <?= isset($branch_detail) && $branch_detail['status'] == '1' ? 'selected' : '' ?>>Active</option>
                                  <option value="0" <?= isset($branch_detail) && $branch_detail['status'] == '0' ? 'selected' : '' ?>>InActive</option>
                                </select>
                              </div>
                            <?php } ?>

                          </div>
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary">Save Changes</button>
                          <a href="./<?= isset($branch_detail) ? $branch_detail['id'] : 'create' ?>" class="btn btn-warning">Reset</a>
                          <a href="<?php echo base_url('customer-branch'); ?>" class="btn btn-light">Back</a>
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

      $.addMore = function() {
        var count = $('.count').length;

        $.ajax({
          url: "<?= base_url('customer-branch/addPerson/') ?>" + (count + 1),
          type: "GET",
          data: {
            count: count
          },
          success: function(data) {
            $('.fill').after(data);
          }
        })
      }

      $.delete = function(index) {
        $('.del' + index).remove();
      }
    });
  </script>

</body>

</html>