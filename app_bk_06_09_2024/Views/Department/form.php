<?php 
    $validation = \Config\Services::validation();
?>
<div class="profile-details">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="col-form-label">Department Name<span class="text-danger">*</span></label>
            <input type="text" name="dept_name" id="name" class="form-control" required value="<?= (isset($department['dept_name'])) ?  $department['dept_name'] : ''?>">
            <?php
            if ($validation->getError('dept_name')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('dept_name') . '</div>';
            }
            ?>
        </div> 
        <div class="col-md-6"></div>
        <div class="col-md-6" style="margin-top: 30px;"> 
            <input type="checkbox" name="booking" id="booking" class="form-check-input" required value="1"  <?= (isset($department['booking']) && ($department['booking'] == 1)) ? 'checked'  : ''?> style="height: 25px; width:25px;">
            <label for="booking" style="margin-top: 5px;"> Booking</label>
       
            <?php
            if ($validation->getError('booking')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('booking') . '</div>';
            }
            ?>
        </div> 
    </div>
    <br>
</div> 
<div class="submit-button">
    <input type="submit" class="btn btn-primary" value="Save">
    <input type="reset" name="reset" class="btn btn-warning" value="Reset">
    <a href="<?php echo base_url().$currentController; ?>" class="btn btn-light">Cancel</a>
</div>