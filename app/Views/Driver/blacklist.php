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
                                                    <h6>Baclkist Driver</h6>
                                                </div>
                                                <div class="profile-details">
                                                    <div class="row mb-3 g-3"> 
                                                       
                                                        <div class="col-md-6">
                                                            <label class="col-form-label">Date<span class="text-danger">*</span></label>
                                                            <input type="datetime-local"  name="status_date"   value="<?= date('Y-m-d H:i');?>" max="<?= date('Y-m-d H:i');?>"  class="form-control" required/>                                                            
                                                            <?php
                                                            if ($validation->getError('status_date')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('status_date') . '</div>';
                                                            }   
                                                            ?>  
                                                        </div>  
                                                         
                                                        <div class="col-md-6">
                                                            <label class="col-form-label">Remarks</label>
                                                            <input type="text" name="remarks" class="form-control" />
                                                            <?php
                                                            if ($validation->getError('remarks')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('remarks') . '</div>';
                                                            }   
                                                            ?> 
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