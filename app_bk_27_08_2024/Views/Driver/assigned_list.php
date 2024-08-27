<div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sl.No.</th>
                <th>Vehicle RC Number</th>
                <th>Driver's Name</th>
                <th>Assigned On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            if ($assigned_list) {
                foreach ($assigned_list as $item) {
            ?>
                    <tr>
                        <td><?= $i++ ?>.</td>
                        <td><?= $item['rc_number'] ?></td>
                        <td><?= $item['party_name'] ?></td>
                        <td><?= date('d-m-Y', strtotime($item['assign_date']))  ?></td>
                    </tr>
            <?php
                }
            } else {
                echo '<tr align="center"><td colspan="4">No Assignments Found</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>