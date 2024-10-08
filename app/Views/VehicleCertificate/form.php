<?php $validation = \Config\Services::validation();

use App\Models\UserTypePermissionModel;
?>
<!-- Settings Info -->
<div class="card">
  <div class="card-body">
    <div class="settings-form">
      <?php
      $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
      $last = array_pop($uriSegments);
      if ($last == 'create') {
        $action = 'Vehiclecertificate/create';
      } else {
        $action = 'Vehiclecertificate/edit';
      }
      $userPermissions = new UserTypePermissionModel();
      ?>
      <form method="post" action="<?php echo base_url() . $action; ?>" enctype="multipart/form-data">
        <div class="profile-details">
          <div class="row">
            <input type="hidden" name="id" value="<?php
                                                  if (isset($vc_data)) {
                                                    echo $vc_data['id'];
                                                  }
                                                  ?>">
            <div class="col-md-6">
              <div class="form-wrap">
                <label class="col-form-label">
                  Vehicle Certificate Name <span class="text-danger">*</span>
                </label>
                <input type="text" required name="name" class="form-control" value="<?php
                                                                                    if (isset($vc_data)) {
                                                                                      echo $vc_data['name'];
                                                                                    } else {
                                                                                      echo set_value('name');
                                                                                    }
                                                                                    ?>">
                <?php
                if ($validation->getError('name')) {
                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('name') . '</div>';
                }
                ?>
              </div>
            </div>

            <div class="col-md-6"></div>

            <div class="form-wrap col-md-6">
              <label class="col-form-label" style="padding-right: 10px;"> Issue Date<span class="text-danger">*</span> : </label>
              <input type="radio" name="issue_date" id="issue_yes" value="1" required <?= isset($vc_data['issue_date']) && $vc_data['issue_date'] == '1' ? 'checked' : '' ?>>
              <label for="issue_yes" style="padding-right:15px">Yes</label>
              <input type="radio" name="issue_date" id="issue_no" value="0" required <?= isset($vc_data['issue_date']) && $vc_data['issue_date'] == '0' ? 'checked' : '' ?>>
              <label for="issue_no" style="padding-right:15px">No</label>
            </div>

            <div class="form-wrap col-md-6">
              <label class="col-form-label" style="padding-right: 10px;"> Expiry Date<span class="text-danger">*</span> : </label>
              <input type="radio" name="expiry_date" id="expiry_yes" value="1" required <?= isset($vc_data['expiry_date']) && $vc_data['expiry_date'] == '1' ? 'checked' : '' ?>>
              <label for="expiry_yes" style="padding-right:15px">Yes</label>
              <input type="radio" name="expiry_date" id="expiry_no" value="0" required <?= isset($vc_data['expiry_date']) && $vc_data['expiry_date'] == '0' ? 'checked' : '' ?>>
              <label for="expiry_no" style="padding-right:15px">No</label>
            </div>

            <div class="form-wrap col-md-6">
              <label class="col-form-label" style="padding-right: 10px;"> Vendor<span class="text-danger">*</span> : </label>
              <input type="radio" name="vendor" id="vendor_yes" value="1" required <?= isset($vc_data['vendor']) && $vc_data['vendor'] == '1' ? 'checked' : '' ?>>
              <label for="vendor_yes" style="padding-right:15px">Yes</label>
              <input type="radio" name="vendor" id="vendor_no" value="0" required <?= isset($vc_data['vendor']) && $vc_data['vendor'] == '0' ? 'checked' : '' ?>>
              <label for="vendor_no" style="padding-right:15px">No</label>
            </div>

            <div class="form-wrap col-md-6">
              <label class="col-form-label" style="padding-right: 10px;"> Issue Authority<span class="text-danger">*</span> : </label>
              <input type="radio" name="issue_by" id="issueby_yes" value="1" required <?= isset($vc_data['issue_by']) && $vc_data['issue_by'] == '1' ? 'checked' : '' ?>>
              <label for="issueby_yes" style="padding-right:15px">Yes</label>
              <input type="radio" name="issue_by" id="issueby_no" value="0" required <?= isset($vc_data['issue_by']) && $vc_data['issue_by'] == '0' ? 'checked' : '' ?>>
              <label for="issueby_no" style="padding-right:15px">No</label>
            </div>

          </div>
        </div>
        <div class="submit-button">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="<?php echo base_url(); ?>vehiclecertificate" class="btn btn-light">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /Settings Info -->