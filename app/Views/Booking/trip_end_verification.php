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
                                           <?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
                                                <div class="settings-sub-header">
                                                    <h6>Trip End Verification</h6>
                                                </div>
                                                <div class="profile-details">
                                                    <div class="row mb-3 g-3">
                                                        <div class="col-md-5">
                                                            <label class="col-form-label">Uploaded Doc<span class="text-danger">*</span></label>
                                                            <?php  
                                                            $doc = isset($pod_data['upload_doc']) && !empty($pod_data['upload_doc']) ?  $pod_data['upload_doc'] :  '';
                                                            $file_type = !empty($doc) && file_exists(getcwd().'/public/uploads/booking_pods/'.$doc) ?  mime_content_type(getcwd().'/public/uploads/booking_pods/'.$doc) : '';
                                                            if($file_type == 'application/pdf'){?>
                                                                <a href="<?= base_url('public/uploads/booking_pods/').$doc  ?>" class="btn btn-info" target="_blank" style="margin-left: 7px;width: 200px;">View Document</a>        
                                                            <?php }else{?>
                                                                <div style="float: right;margin-right: 15px;">
                                                                <a href="<?= base_url('public/uploads/booking_pods/').$doc ?>" title="View Doc" target="_blank"><img src="<?= ($doc) ? base_url('public/uploads/booking_pods/').$doc : base_url('public/assets/img/no-img.png') ?>" style="height:150px;width:240px;"></a>
                                                                </div>
                                                            <?php } ?>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Received By<span class="text-danger">*</span></label>
                                                            <input type="text" name="received_by" value="<?= isset($pod_data['received_by']) ? $pod_data['received_by'] : '' ?>" class="form-control" readonly>
                                                        </div>
                                                       
                                                        <div class="col-md-3">
                                                            <label class="col-form-label">POD Date<span class="text-danger">*</span></label>
                                                            <input type="date"  name="pod_date" value="<?= isset($pod_data['pod_date']) ? $pod_data['pod_date'] : '' ?>" class="form-control" readonly>                                                            
                                                        </div> 

                                                        <div class="col-md-12"></div>

                                                        <div class="col-md-3">
                                                            <input type="radio" id="approve" checked class="form-check-input" name="trip_end_approved" value="1" style="height: 20px; width:20px;">
                                                            <label for="approve" style="padding-top: 3px;"> Approve for trip end</label>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <input type="radio" id="revert_to_approve" class="form-check-input" name="trip_end_approved" value="0" style="height: 20px; width:20px;"> 
                                                            <label for="revert_to_approve"  style="padding-top: 3px;"> Not approve for trip end</label>
                                                        </div>

                                                        
                                                    </div>
                                                </div>
                                                <div class="submit-button mt-3">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    <button type="reset" class="btn btn-info">Reset</button>
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


</body>

</html>