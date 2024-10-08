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
        $action = 'partytype/create';
      } else {
        $action = 'partytype/edit';
      }
      $userPermissions = new UserTypePermissionModel();
      ?>
      <form method="post" action="<?php echo base_url() . $action; ?>" enctype="multipart/form-data">
        <div class="profile-details">
          <div class="row">
            <input type="hidden" name="id" value="<?php
                                                  if (isset($partytype_data)) {
                                                    echo $partytype_data['id'];
                                                  }
                                                  ?>">
            <div class="col-md-6">
              <div class="form-wrap">
                <label class="col-form-label">
                  Party Type Name <span class="text-danger">*</span>
                </label>
                <input type="text" required name="name" class="form-control" value="<?php
                                                                                    if (isset($partytype_data)) {
                                                                                      echo $partytype_data['name'];
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

            <div class="col-md-6">
              <label class="col-form-label mt-2"> Sale <span class="text-danger">*</span> </label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sale" required <?= isset($partytype_data) && $partytype_data['sale'] == '1' ? 'checked' : '' ?> id="inlineRadio1" value="1">
                <label class="form-check-label" for="inlineRadio1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sale" required <?= isset($partytype_data) && $partytype_data['sale'] == '0' ? 'checked' : '' ?> id="inlineRadio2" value="0">
                <label class="form-check-label" for="inlineRadio2">No</label>
              </div>
            </div>

            <div class="col-md-4">
              <label class="col-form-label mt-2"> LR First Party<span class="text-danger lr-span"><?= isset($partytype_data) && $partytype_data['sale'] == 0 ? '' : '*' ?></span> </label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" onchange="unselectYesParty('lr_third_party')" name="lr_first_party" required <?= isset($partytype_data) && $partytype_data['lr_first_party'] == '1' ? 'checked' : '' ?> id="inlineRadioLR1" value="1" <?= isset($partytype_data) && $partytype_data['sale'] == '0' ? 'disabled' : '' ?>>
                <label class="form-check-label" for="inlineRadioLR1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="lr_first_party" required <?= isset($partytype_data) && ($partytype_data['lr_first_party'] == '0' && $partytype_data['sale'] == '1') ? 'checked' : '' ?> id="inlineRadioLR2" value="0" <?= isset($partytype_data) && $partytype_data['sale'] == '0' ? 'disabled' : '' ?> >
                <label class="form-check-label" for="inlineRadioLR2">No</label>
              </div>
            </div>

            <div class="col-md-4">
              <label class="col-form-label mt-2"> LR Third Party<span class="text-danger lr-third-span"><?= isset($partytype_data) && $partytype_data['sale'] == 0 ? '' : '*' ?></span> </label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" onchange="unselectYesParty('lr_first_party')" name="lr_third_party" required <?= isset($partytype_data) && $partytype_data['lr_third_party'] == '1' ? 'checked' : '' ?> id="inlineRadioLR1" value="1" <?= isset($partytype_data) && $partytype_data['sale'] == '0' ? 'disabled' : '' ?>>
                <label class="form-check-label" for="inlineRadioLR1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="lr_third_party" required <?= isset($partytype_data) && ($partytype_data['lr_third_party'] == '0' && $partytype_data['sale'] == '1') ? 'checked' : '' ?> id="inlineRadioLR2" value="0" <?= isset($partytype_data) && $partytype_data['sale'] == '0' ? 'disabled' : '' ?> >
                <label class="form-check-label" for="inlineRadioLR2">No</label>
              </div>
            </div>

            <div class="col-md-4">
              <label class="col-form-label mt-2">Tax Applicable<span class="text-danger tax_applicable-span"><?= isset($partytype_data) && $partytype_data['sale'] == 0 ? '' : '*' ?></span> </label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tax_applicable" required <?= isset($partytype_data['tax_applicable']) && $partytype_data['tax_applicable'] == '1' ? 'checked' : '' ?> id="tax_tpplicable_yes" value="1" <?= isset($partytype_data) && $partytype_data['sale'] == '0' ? 'disabled' : '' ?>>
                <label class="form-check-label" for="tax_tpplicable_yes">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tax_applicable" required <?= isset($partytype_data['tax_applicable']) && ($partytype_data['tax_applicable'] == '0' && $partytype_data['sale'] == '1') ? 'checked' : '' ?> id="tax_applicable_no" value="0" <?= isset($partytype_data) && $partytype_data['sale'] == '0' ? 'disabled' : '' ?> >
                <label class="form-check-label" for="tax_applicable_no">No</label>
              </div>
            </div>

          </div>
        </div>
        <div class="submit-button">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="<?php echo base_url(); ?>partytype" class="btn btn-light">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /Settings Info -->