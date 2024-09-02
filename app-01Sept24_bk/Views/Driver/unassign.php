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
                                            <?php
                                            // print_r($assignment_details);
                                            ?>

                                            <!-- <form method="post" action="<?php //echo base_url('driver/unassign_vehicle/' . $token); ?>"> -->
                                            <?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>    
                                                <div class="settings-sub-header">
                                                    <h6>Unassign Vehicle To Driver</h6>
                                                </div>
                                                <div class="profile-details">
                                                    <div class="row mb-3 g-3">
                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Driver Name <span class="text-danger">*</span></label>
                                                            <input type="text" value="<?= $driver_detail['party_name'] ?>" class="form-control" disabled>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Vehicle<span class="text-danger">*</span></label>
                                                            <select class="form-control select2" name="vehicle_id" disabled>
                                                                <option value="">Select Vehicle</option>
                                                                <?php
                                                                foreach ($driverAllowedVehicleTypes as $v) {
                                                                ?>
                                                                    <option value="<?= $v["id"]; ?>" <?= isset($assignment_details) && $assignment_details['vehicle_id'] == $v['id'] ? 'selected' : '' ?>> <?php echo ucwords($v["rc_number"]); ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Unassigned Date<span class="text-danger">*</span></label>
                                                            <input type="datetime-local" required name="unassigned_date" min="<?= (isset($assignment_details["assign_date"]) && strtotime($assignment_details["assign_date"])>0)  ? date('Y-m-d H:i',strtotime($assignment_details["assign_date"]. ' +1 day')) : '' ?>" value="<?= isset($assignment_details["assign_date"]) && (strtotime($assignment_details["assign_date"]) > 0)  ? date('Y-m-d H:i',strtotime($assignment_details["assign_date"]. ' +1 day')) : ''; ?>" class="form-control">
                                                            <?php
                                                            if ($validation->getError('assigned_date')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('assigned_date') . '</div>';
                                                            }   
                                                            ?>
                                                        </div>
 
                                                        <div class="col-md-12"></div>

                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Vehicle Location <span class="text-danger">*</span></label>
                                                            <input type="text" name="location" class="form-control" value="" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Vehicle Fuel Status</label>
                                                            <input type="text" name="fuel" class="form-control" value="">
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Vehicle KM Reading</label>
                                                            <input type="text" name="km" class="form-control"  value="">
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="submit-button mt-3">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    <?php if (!isset($type_detail)) {
                                                        echo '<a href="./' . $token . '" class="btn btn-warning">Reset</a>';
                                                    } ?>
                                                    <a href="<?php echo base_url('driver'); ?>" class="btn btn-light">Back</a>
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