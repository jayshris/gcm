<?php 
    $validation = \Config\Services::validation();
?>
<div class="profile-details">
    <div class="row g-3">
        <div class="col-md-12">
            <label class="col-form-label">Head Name<span class="text-danger">*</span></label>
            <input type="text" name="head_name" id="head_name" class="form-control" required value="<?= (isset($expense_heads['head_name'])) ?  $expense_heads['head_name'] : ''?>">
            <?php
            if ($validation->getError('head_name')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('head_name') . '</div>';
            }
            ?>
        </div>
        <div class="form-wrap col-md-12">
            <label class="col-form-label" style="padding-right: 10px;">
             1: <span class="text-danger">*</span>
            </label>
            <input type="radio" name="type_1" id="balance_sheet" value="balance_sheet" required  <?= isset($expense_heads['type_1']) && $expense_heads['type_1'] === 'balance_sheet' ? 'checked' : '' ?>>
            <label for="balance_sheet" style="padding-right:15px">Balance Sheet</label>
            <input type="radio" name="type_1" id="profit_and_loss" value="profit_and_loss"  required  <?= isset($expense_heads['type_1']) && $expense_heads['type_1'] === 'profit_and_loss' ? 'checked' : '' ?>>
            <label for="profit_and_loss">Profit and Loss</label>

            <?php
            if ($validation->getError('type_1')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('type_1') . '</div>';
            }   
            ?>
        </div>

        <div class="form-wrap col-md-12"> 
            <label class="col-form-label" style="padding-right: 10px;">
             2: <span class="text-danger">*</span>
            </label>
            <input type="radio" name="type_2" id="operating_expense" value="operating_expense" required <?= isset($expense_heads['type_2']) && $expense_heads['type_2'] === 'operating_expense' ? 'checked' : '' ?>>
            <label for="operating_expense" style="padding-right:15px">Operating Expense</label>
            <input type="radio" name="type_2" id="non_operating_expense" value="non_operating_expense"  required <?= isset($expense_heads['type_2']) && $expense_heads['type_2'] === 'non_operating_expense' ? 'checked' : '' ?>>
            <label for="non_operating_expense">Non-Operating Expense</label> 

            <?php
            if ($validation->getError('type_2')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('type_2') . '</div>';
            }   
            ?>
        </div>

        <div class="form-wrap col-md-12"> 
            <label class="col-form-label" style="padding-right: 10px;">
             3: <span class="text-danger">*</span>
            </label>
            <input type="radio" name="type_3" id="fixed" value="fixed" required <?= isset($expense_heads['type_3']) && $expense_heads['type_3'] === 'fixed' ? 'checked' : '' ?>>
            <label for="fixed" style="padding-right:15px">Fixed</label>
            <input type="radio" name="type_3" id="variable" value="variable"  required <?= isset($expense_heads['type_3']) && $expense_heads['type_3'] === 'variable' ? 'checked' : '' ?>>
            <label for="variable">Variable</label> 

            <?php
            if ($validation->getError('type_3')) {
                echo '<div class="alert alert-danger mt-2">' . $validation->getError('type_3') . '</div>';
            }   
            ?>
        </div>
    </div>
    <br>
</div> 
<div class="submit-button">
    <input type="submit" name="add_expensehead" class="btn btn-primary" value="Save">
    <input type="reset" name="reset" class="btn btn-warning" value="Reset">
    <a href="<?php echo base_url(); ?>expensehead" class="btn btn-light">Cancel</a>
</div>