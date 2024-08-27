<?php 
    $validation = \Config\Services::validation();
?>
<div class="profile-details">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="col-form-label">Reason Name<span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required value="<?= (isset($booking_cancellation_reasons['name'])) ?  $booking_cancellation_reasons['name'] : ''?>">
            <?php
            if ($validation->getError('name')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('name') . '</div>';
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