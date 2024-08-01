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

            <!-- Page Header -->
            <div class="page-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="page-title">Consignment Note For Office Use</h4>
                </div>
                <div class="col-4 text-end">
                  <div class="head-icons">
                    <a href="<?= base_url().$currentController ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Page Header -->

            <?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
              <div class="card main-card">
                <div class="card-body">
                  <h4>Search / Filter</h4>
                  <hr>
                  <div class="row mt-2"> 
                    <div class="col-md-3">
                      <label class="col-form-label">Booking No.</label>
                      <select class="form-select select2" name="party_id">
                        <option value="">Select </option>
                        <?php foreach ($parties as $party) {
                          echo '<option value="' . $party['id'] . '" ' . (set_value('party_id') == $party['id'] ? 'selected' : '') . '>' . $party['party_name'] . '</option>';
                        } ?>
                      </select>
                    </div>

                    <div class="col-md-2">
                      <div class="form-wrap">
                        <label class="col-form-label">Vehicle RC </label>
                        <select class="form-select" name="status" aria-label="Default select example">
                          <option value="">Select </option> 
                        </select>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                      <a href="<?= base_url().$currentController ?>" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                    </div>
 
                  </div>
                </div>
              </div>
            </form> 

          </div>

        </div>
      </div>
      <!-- /Page Wrapper -->


    </div>
    <!-- /Main Wrapper -->

    <!-- scripts link  -->
    <?= $this->include('partials/vendor-scripts') ?>
 
</body>

</html>