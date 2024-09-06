<tr id="del_drop_<?= $index ?>">
    <td>
        <input type="number" name="drop_seq[]" value="<?= $index ?>" class="form-control">
    </td>
    <td>
        <select class="form-select" name="drop_state_id[]" aria-label="Default select example" required>
            <option value="">Select State</option>
            <?php foreach ($states as $s) {
                echo '<option value="' . $s['state_id'] . '">' . $s['state_name'] . '</option>';
            } ?>
        </select>
        </select>
    </td>
    <td>
        <input type="text" name="drop_city[]" class="form-control" required>
    </td>
    <td>
        <input type="text" name="drop_pin[]" class="form-control">
    </td>
    <td><button type="button" class="btn btn-sm btn-danger" onclick="$.delete(<?= $index ?>,'drop')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
</tr>