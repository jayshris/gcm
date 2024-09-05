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
            // print_r($status_details);

            // echo set_value('product_name');
            ?>

            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <!-- Settings Info -->
                <div class="card">
                  <div class="card-body">
                    <div class="settings-form">

                      <form method="post" enctype="multipart/form-data" action="<?php echo isset($status_details) ? base_url('status/edit/' . $status_details['id']) : base_url('status/create')  ?>">

                        <div class="settings-sub-header">
                          <h6><?= isset($status_details) ? 'Edit' : 'Add' ?> Status</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row g-3">

                            <div class="col-md-4">
                              <label class="col-form-label">Status Label <span class="text-danger">*</span></label>
                              <input type="text" required name="status" value="<?= isset($status_details) ? $status_details['status_name'] : set_value('status')   ?>" class="form-control">
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Status Label <span class="text-danger">*</span></label>
                              <select class="form-select" name="status_bg" aria-label="Default select example" required>
                                <option value="">Select Label Background</option>
                                <option value="bg-success" <?= isset($status_details) && $status_details['status_bg'] == 'bg-success' ? 'selected' : '' ?>>Green</option>
                                <option value="bg-danger" <?= isset($status_details) && $status_details['status_bg'] == 'bg-danger' ? 'selected' : '' ?>>Red</option>
                                <option value="bg-info" <?= isset($status_details) && $status_details['status_bg'] == 'bg-info' ? 'selected' : '' ?>>Blue</option>
                                <option value="bg-warning" <?= isset($status_details) && $status_details['status_bg'] == 'bg-warning' ? 'selected' : '' ?>>Yellow</option>
                              </select>
                            </div>

                          </div>
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary">Save Changes</button>
                          <a href="./<?= isset($status_details) ? $status_details['id'] : 'create' ?>" class="btn btn-warning">Reset</a>
                          <a href="<?php echo base_url('status'); ?>" class="btn btn-light">Back</a>
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


</body>

</html>