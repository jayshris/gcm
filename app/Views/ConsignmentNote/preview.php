<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/print_report.css"> 
    <style>
        @media print {
            .printableArea { 
                display: block;
            }   
            .tbl-center{
                margin-left:inherit !important;
                margin-right: inherit !important;
            }
        }
        table{
            margin-bottom: 9px;
        }
        .page-wrapper{
            margin: 0;
            padding: 0;
        }

        .tbl-center{
            margin-left: 234px;
            margin-right: auto;
        } 
        #debug-icon{
            display: none;
        }
    </style>
</head>
<body> 
<input type="hidden" id="consignment_no" value="<?= str_replace('/','-',$lr['consignment_no']) ?>" />
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div  id="printableArea" class="col-md-12">
                <div  >  
                    <?= $this->include('ConsignmentNote/consignee_note.php') ?> 
                    <?= $this->include('ConsignmentNote/terms_and_conditions.php') ?>
                    <?= $this->include('ConsignmentNote/consignor_note.php') ?>
                    <?= $this->include('ConsignmentNote/terms_and_conditions.php') ?>  
                    <?= $this->include('ConsignmentNote/truck_forwarding_note.php') ?>
                    <?= $this->include('ConsignmentNote/terms_and_conditions.php') ?>
                </div>
            </div>
            <div class="submit-button noprint"> 
                <button type="button" class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                <a href="<?php echo base_url('/loadingreceipt'); ?>" class="btn btn-light">Cancel</a>
                <!-- <a href="javascript:history.back()" class="btn btn-light">Cancel</a> -->
            </div> 
        </div>
    </div>
</div>
    
	<?= $this->include('partials/vendor-scripts') ?> 

    <script>
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.title = $('#consignment_no').val();
            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>

</html>