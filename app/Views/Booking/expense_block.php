<tr id="del_expense_<?= $index ?>">
    <td>
        <select class="form-select" name="expense[]" aria-label="Default select example">
            <option value="">Select Expense</option>
            <option value="1">Loading</option>
            <option value="2">Unloading</option>
            <option value="3">Detention</option>
            <option value="4">Munshiana</option>
        </select>
    </td>
    <td><input type="number" name="expense_value[]" id="expense_<?= $index ?>" class="form-control"></td>
    <td><input class="form-check-input" type="checkbox" name="expense_flag_<?= $index ?>" id="expense_flag_<?= $index ?>" style="height:30px; width:30px; border-radius: 50%;" onchange="$.billToParty(<?= $index ?>);"></td>
    <td><button type="button" class="btn btn-sm btn-danger" onclick="$.delete(<?= $index ?>,'expense')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
</tr>