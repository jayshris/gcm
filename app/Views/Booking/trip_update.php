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
                                                    <h6>Trip Update</h6>
                                                </div>
                                                <div class="profile-details">
                                                    <div class="row mb-3 g-3"> 
                                                       
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Date<span class="text-danger">*</span></label>
                                                            <input type="datetime-local"  name="status_date" value="<?= (set_value('status_date')) ? set_value('status_date') : date('Y-m-d H:i');?>" max="<?= date('Y-m-d H:i');?>"  class="form-control" required />                                                            
                                                            <?php
                                                            if ($validation->getError('status_date')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('status_date') . '</div>';
                                                            }   
                                                            ?>  
                                                        </div>  

                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Purpose Of Update<span class="text-danger">*</span></label>
                                                            <select name="purpose_of_update" id="purpose_of_update" class="form-select" required onchange="validateFuelMoney()">
                                                                <option value="">Select Purpose Of Update</option> 
                                                                <?php if(!empty($purpose_of_updates)) {foreach($purpose_of_updates as $key => $purpose_ofupdate){ ?>
                                                                <option value="<?= $purpose_ofupdate['id']?>" <?= (set_value('purpose_of_update')) && (set_value('purpose_of_update') == $purpose_ofupdate['id']) ? 'selected' : '' ?> is_money_mandatory="<?= $purpose_ofupdate['is_money_mandatory'] ?>"  is_fuel_mandatory="<?= $purpose_ofupdate['is_fuel_mandatory'] ?>"><?= ucfirst($purpose_ofupdate['name']) ?></option>
                                                                <?php }}?>
                                                            </select>
                                                            <?php
                                                            if ($validation->getError('purpose_of_update')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('purpose_of_update') . '</div>';
                                                            }   
                                                            ?> 
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Location</label>
                                                            <input type="text" name="location" class="form-control" value="<?= set_value('location') ?>" />
                                                            <?php
                                                            if ($validation->getError('location')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('location') . '</div>';
                                                            }   
                                                            ?> 
                                                        </div> 

                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Authorised By</label>
                                                            <select class="form-select" name="updated_by">
                                                                <option value="">Select Employee</option>
                                                                <?php foreach ($employees as $e) { ?>
                                                                <option value="<?= $e['id'] ?>" <?= (set_value('updated_by') ==  $e['id']) ? 'selected' : '' ?>><?= $e['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <?php
                                                            if ($validation->getError('updated_by')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('updated_by') . '</div>';
                                                            }   
                                                            ?> 
                                                        </div> 

                                                        <div class="col-md-8">
                                                            <label class="col-form-label">Remarks</label>
                                                            <input type="text" name="remarks" class="form-control" value="<?= set_value('remarks') ?>"/>
                                                            <?php
                                                            if ($validation->getError('remarks')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('remarks') . '</div>';
                                                            }   
                                                            ?> 
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Money<span class="text-danger" id="money_span" hidden>*</span></label>
                                                            <input type="number" name="money" step="0.01" id="money_txt" class="form-control" value="<?= set_value('money') ?>" />
                                                            <?php
                                                            if ($validation->getError('money')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('money') . '</div>';
                                                            }   
                                                            ?> 
                                                        </div> 

                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Fuel<span class="text-danger" id="fuel_span" hidden>*</span></label>
                                                            <input type="number" name="fuel" step="0.01" id="fuel_txt" class="form-control"  value="<?= set_value('fuel') ?>" />
                                                            <?php
                                                            if ($validation->getError('fuel')) {
                                                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('fuel') . '</div>';
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

                        <div class="card main-card">
                            <div class="card-body">
                                <div class="table-responsive custom-table">
                                    <table class="table" id="datatable">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Location</th>
                                            <th>Authorised By</th>
                                            <th>Remarks</th>
                                            <th>Purpose Of Update</th>
                                            <th>Fuel</th>
                                            <th>Money</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;$total_fuel = 0;$total_money = 0;
                                            foreach ($data as $val) {  
                                                $total_fuel += $val['fuel'];
                                                $total_money += $val['money'];
                                            ?>
                                            <tr>
                                            <td><?= $i++; ?>.</td>
                                            <td><?= date('d M Y',strtotime($val['status_date'])) ?></td>
                                            <td><?= $val['location']; ?></td>
                                            <td><?= $val['e_name']; ?></td>
                                            <td><?= $val['remarks']; ?></td>
                                            <td><?= isset($val['pou_name']) ? $val['pou_name'] : '-'; ?></td>
                                            <td><?= number_format($val['fuel'],2); ?></td>
                                            <td><?= number_format($val['money'],2); ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <?php if(!empty($data)){ ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><b>Total:</b></td>
                                                <td><?= number_format($total_fuel,2); ?></td>
                                                <td><?= number_format($total_money,2); ?></td>
                                            </tr>
                                            <?php }?>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="datatable-length"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="datatable-paginate"></div>
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
    // datatable init
    if ($('#datatable').length > 0) {
      $('#datatable').DataTable({
        "bFilter": false,
        "bInfo": false,
        "autoWidth": true,
        "language": {
          search: ' ',
          sLengthMenu: '_MENU_',
          searchPlaceholder: "Search",
          info: "_START_ - _END_ of _TOTAL_ items",
          "lengthMenu": "Show _MENU_ entries",
          paginate: {
            next: 'Next <i class=" fa fa-angle-right"></i> ',
            previous: '<i class="fa fa-angle-left"></i> Prev '
          },
        },
        initComplete: (settings, json) => {
          $('.dataTables_paginate').appendTo('.datatable-paginate');
          $('.dataTables_length').appendTo('.datatable-length');
        },
        columnDefs: [{ 
            target: 1,  
            render: DataTable.render.datetime( "DD MMM YYYY" )
        }, 
        ]
      });
    }

    // 1. Status - Money & Fuel Non-Mandatory
    // 2. Fuel - Fuel Mandatory
    // 3. Money - Money Mandatory
    // 4. Urea - Money Mandatory
    // 5. Repair - Money Mandatory
    // 6. Tyre - Money Mandatory
    // 7. Other - Money Mandatory
    function validateFuelMoney(){
        var purpose_of_update = $('#purpose_of_update').val(); 
        var is_money_mandatory = $('#purpose_of_update option:selected').attr('is_money_mandatory');
        var is_fuel_mandatory = $('#purpose_of_update option:selected').attr('is_fuel_mandatory');
        $('#fuel_txt').removeAttr('required');
        $('#money_txt').removeAttr('required');
        $('#fuel_span').attr('hidden','hidden');
        $('#money_span').attr('hidden','hidden');
        if(is_fuel_mandatory == 1){
            $('#fuel_txt').attr('required','required'); 
            $('#fuel_span').removeAttr('hidden');
        } 
        if(is_money_mandatory == 1){
            $('#money_txt').attr('required','required'); 
            $('#money_span').removeAttr('hidden');
        }
    }
    </script>
</body>

</html>