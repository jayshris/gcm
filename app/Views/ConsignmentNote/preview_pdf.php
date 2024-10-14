<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/print_report.css">
<style>
    .printableArea {
        display: block;
    }

    .tbl-center {
        margin-left: inherit !important;
        margin-right: inherit !important;
    }


    table {
        margin-bottom: 9px;
    }

    .page-wrapper {
        margin: 0;
        padding: 0;
    }

    .tbl-center {
        margin-left: 234px;
        margin-right: auto;
    }

    #debug-icon {
        display: none;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="">
            <div id="printableArea" class="">

            <?php $lr_third_party_cnt = isset($lr['lr_party_type']['lr_third_party']['cnt']) && ($lr['lr_party_type']['lr_third_party']['cnt'] > 0) ? $lr['lr_party_type']['lr_third_party']['cnt'] : 0; ?>
                <?php if($lr_third_party_cnt == 0){ ?>  
                    <!-- Consignee Note  -->
                    <?= $this->include('ConsignmentNote/consignee_note.php') ?> 
                    <?= $this->include('ConsignmentNote/terms_and_conditions.php') ?>
                    <?= $this->include('ConsignmentNote/consignor_note.php') ?>
                    <?= $this->include('ConsignmentNote/terms_and_conditions.php') ?>  
                <?php } ?>  
                <?= $this->include('ConsignmentNote/transporter_copy.php') ?> 
            </div>

        </div>
    </div>
</div>