<div class="security-grid flex-fill certificate_div_block del_cert_<?= $index ?>">
    <div class="row g-3"> 
        <div class="col-md-12" style="text-align: right;position: absolute;top: -16px;" <?= ($index == 0) ? 'hidden' : '' ?>>
        <button type="button" class="btn btn-sm btn-danger" onclick="$.delete(<?= $index ?>)"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </div> 

        <div class="col-md-4">
        <label class="col-form-label">Certificate Type<span class="text-danger">*</span></label>
        <select class="form-select select2 " required id="certificate_<?= $index ?>" index="<?= $index ?>" name="certificate_id[]" aria-label="Default select example" onchange="checkUniqueCertificate(<?= $index ?>);">
            <option value="">Select Certificate</option>
            <?php foreach ($cert_type as $c) {
            echo '<option value="' . $c['id'] . '" ' . (set_value('certificate_id') == $c['id'] ? 'selected' : '') . '>' . $c['name'] . '</option>';
            } ?>
        </select>
        <span id='certificates_sp_<?= $index ?>' class="certificates-err"></span>
        </div>

        <div class="col-md-4">
        <label class="col-form-label">Vendor</label>
        <select class="form-select select2" name="party_id[]" aria-label="Default select example">
            <option value="">Select Vendor</option>
            <?php foreach ($party as $p) {
            echo '<option value="' . $p['id'] . '" ' . (set_value('party_id') == $p['id'] ? 'selected' : '') . '>' . $p['party_name'] . '</option>';
            } ?>
        </select>
        </div>

        <div class="col-md-4">
        <label class="col-form-label">Document Number </label>
        <input type="text" name="doc_no[]" class="form-control">
        </div>

        <div class="col-md-4">
        <label class="col-form-label">Issue Date <span class="text-danger">*</span></label>
        <input type="date" required name="issue_date[]" class="form-control">
        </div>

        <div class="col-md-4">
        <label class="col-form-label">Expiry Date <span class="text-danger">*</span></label>
        <input type="date" required name="expiry_date[]" class="form-control">
        </div>

        <div class="col-md-4">
        <label class="col-form-label">Authority Issued By <span class="text-danger">*</span></label>
        <input type="text" required name="issue_by[]" class="form-control">
        </div>

        <div class="col-md-4">
        <label class="col-form-label">Image 1<span class="text-danger">*</span></label>
        <input type="file" required name="image1[]" accept="application/pdf, application/vnd.ms-excel, image/png, image/gif, image/jpeg" class="form-control">
        </div>
        <div class="col-md-4">
        <label class="col-form-label">Image 2</label>
        <input type="file" name="image2[]" accept="application/pdf,application/vnd.ms-excel,image/png, image/gif, image/jpeg" class="form-control">
        </div>

        
    </div>
</div>