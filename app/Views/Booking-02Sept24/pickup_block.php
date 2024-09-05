<tr id="del_pickup_<?= $index ?>">
    <td>
        <input type="number" name="pickup_seq[]" value="<?= $index ?>" class="form-control">
    </td>
    <td>
        <select class="form-select" name="pickup_state_id[]" aria-label="Default select example" required>
            <option value="">Select State</option>
            <?php foreach ($states as $s) {
                echo '<option value="' . $s['state_id'] . '">' . $s['state_name'] . '</option>';
            } ?>
        </select>
    </td>
    <td>
        <input type="text" name="pickup_city[]" class="form-control" required>
    </td>
    <td>
        <input type="text" name="pickup_pin[]" class="form-control">
    </td>
    <td><button type="button" class="btn btn-sm btn-danger" onclick="$.delete(<?= $index ?>,'pickup')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
</tr>