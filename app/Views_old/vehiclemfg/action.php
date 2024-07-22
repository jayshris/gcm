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
            ?>

            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <!-- Settings Info -->
                <div class="card">
                  <div class="card-body">
                    <div class="settings-form">


                      <form method="post" enctype="multipart/form-data" action="<?php echo isset($mfg_details) ?  base_url('vehicle-mfg/edit/' . $mfg_details['id']) : base_url('vehicle-mfg/create'); ?>">

                        <div class="settings-sub-header">
                          <h6><?= isset($mfg_details) ? 'Edit' : 'Add' ?> Vehicle Manufacturer</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row g-3">

                            <div class="col-md-6">
                              <label class="col-form-label">Manufacturer Name <span class="text-danger">*</span></label>
                              <?php
                              if ($validation->getError('mfg_name')) {
                                echo '<br><span class="text-danger mt-2">' . $validation->getError('mfg_name') . '</span>';
                              }
                              ?>
                              <input type="text" required name="mfg_name" value="<?= isset($mfg_details) ?  $mfg_details['name'] : set_value('mfg_name') ?>" class="form-control">
                            </div>

                            <?php if (isset($mfg_details)) { ?>
                              <div class="col-md-2">
                                <div class="form-wrap">
                                  <label class="col-form-label">Status <span class="text-danger">*</span></label>
                                  <select class="form-select" name="status" aria-label="Default select example">
                                    <option value="1" <?= isset($mfg_details) && $mfg_details['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= isset($mfg_details) && $mfg_details['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                  </select>
                                </div>
                              </div>
                            <?php } ?>

                          </div>
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary">Save Changes</button>
                          <a href="./<?= isset($mfg_details) ? $mfg_details['id'] : 'create' ?>" class="btn btn-warning">Reset</a>
                          <a href="<?php echo base_url('vehicle-mfg'); ?>" class="btn btn-light">Back</a>
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