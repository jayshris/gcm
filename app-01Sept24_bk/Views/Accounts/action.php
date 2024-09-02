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
                        <?php $validation = \Config\Services::validation(); ?>
                        <?php
                        $session = \Config\Services::session();
                        if ($session->getFlashdata('success')) {
                            echo '
								<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
								';
                        }
                        ?>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <!-- Settings Info -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="settings-form">
                                            <?php echo form_open_multipart(base_url() . $currentController . '/' . $currentMethod . (($token > 0) ? '/' . $token : ''), ['name' => 'actionForm', 'id' => 'actionForm']); ?>
                                            <div class="settings-sub-header">
                                                <h4>Add Account</h4>
                                            </div>

                                            <?php
                                            $validation = \Config\Services::validation();
                                            ?>
                                            <div class="profile-details">
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="col-form-label">Account Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="ac_name" class="form-control" required value="<?= (isset($ac_details['ac_name'])) ?  $ac_details['ac_name'] : '' ?>">
                                                    </div>

                                                    <div class="form-wrap col-md-12">
                                                        <label class="col-form-label" style="padding-right: 10px;"> 1: <span class="text-danger">*</span> </label>
                                                        <input type="radio" name="ac_for" id="balance_sheet" value="1" required <?= isset($ac_details['ac_for']) && $ac_details['ac_for'] == '1' ? 'checked' : '' ?>>
                                                        <label for="balance_sheet" style="padding-right:15px">Balance Sheet</label>
                                                        <input type="radio" name="ac_for" id="profit_and_loss" value="2" required <?= isset($ac_details['ac_for']) && $ac_details['ac_for'] == '2' ? 'checked' : '' ?>>
                                                        <label for="profit_and_loss" style="padding-right:15px">Profit And Loss</label>
                                                    </div>

                                                    <div class="form-wrap col-md-12">
                                                        <label class="col-form-label" style="padding-right: 10px;"> 2: <span class="text-danger">*</span> </label>
                                                        <input type="radio" name="ac_type" onchange="$.validate();" id="asset" value="1" required <?= isset($ac_details['ac_type']) && $ac_details['ac_type'] == '1' ? 'checked' : '' ?>>
                                                        <label for="asset" style="padding-right:15px">Asset</label>
                                                        <input type="radio" name="ac_type" onchange="$.validate();" id="liability" value="2" required <?= isset($ac_details['ac_type']) && $ac_details['ac_type'] == '2' ? 'checked' : '' ?>>
                                                        <label for="liability">Liability</label>
                                                    </div>

                                                    <div class="form-wrap col-md-12 asset" style="display: none;">
                                                        <label class="col-form-label" style="padding-right: 10px;"> 3: <span class="text-danger">*</span> </label>
                                                        <input type="radio" class="asset_radio" name="ac_type_2" id="fixed" value="1" required <?= isset($ac_details['ac_type_2']) && $ac_details['ac_type_2'] == '1' ? 'checked' : '' ?>>
                                                        <label for="fixed" style="padding-right:15px">Current Asset</label>
                                                        <input type="radio" class="asset_radio" name="ac_type_2" id="variable" value="2" required <?= isset($ac_details['ac_type_2']) && $ac_details['ac_type_2'] == '2' ? 'checked' : '' ?>>
                                                        <label for="variable">Fixed Asset</label>
                                                    </div>

                                                    <div class="form-wrap col-md-12 liability" style="display: none;">
                                                        <label class="col-form-label" style="padding-right: 10px;"> 3: <span class="text-danger">*</span> </label>
                                                        <input type="radio" class="liability_radio" name="ac_type_2" id="cl" value="3" required <?= isset($ac_details['ac_type_2']) && $ac_details['ac_type_2'] == '3' ? 'checked' : '' ?>>
                                                        <label for="cl" style="padding-right:15px">Current Liability</label>
                                                        <input type="radio" class="liability_radio" name="ac_type_2" id="ll" value="4" required <?= isset($ac_details['ac_type_2']) && $ac_details['ac_type_2'] == '4' ? 'checked' : '' ?>>
                                                        <label for="ll">Long Term Liability</label>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="submit-button">
                                                <input type="submit" name="add_expensehead" class="btn btn-primary" value="Save">
                                                <a href="<?php echo base_url($currentController . '/' . $currentMethod); ?>" class="btn btn-warning">Reset</a>
                                                <a href="<?php echo base_url($currentController); ?>" class="btn btn-light">Cancel</a>
                                            </div>
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
        $(document).ready(function($) {
            $.validate();
        });

        $.validate = function() {
            var x = $('input[name=ac_type]:checked').val();
            console.log(x);

            if (x == '1') {
                $('.liability').css('display', 'none');
                $('.liability_radio').removeAttr('required');
                $('.asset_radio').attr('required', 'required');
                $('.asset').css('display', 'block');
            }
            if (x == '2') {
                $('.asset').css('display', 'none');
                $('.asset_radio').removeAttr('required');
                $('.liability_radio').attr('required', 'required');
                $('.liability').css('display', 'block');
            }
        }
    </script>
</body>

</html>