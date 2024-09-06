<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'company_id', 'branch_id','dept_id', 'name', 'mobile', 'adhaar_number', 'aadhar_img_front', 'aadhar_img_back', 'email', 'company_phone', 'company_email', 'emergency_person', 'emergency_contact_number', 'digital_sign', 'bank_account_number', 'bank_ifsc_code', 'profile_image1', 'profile_image2', 'joining_date', 'upi_id', 'upi_img', 'status', 'created_at', 'created_by', 'created_ip', 'updated_at', 'updated_by', 'approved', 'approval_by', 'approval_date', 'approval_ip',
        'it_pan_card',
        'image_front',
        'image_back',
        'current_address',
        'current_city',
        'current_state',
        'current_pincode',
        'permanent_address',
        'permanent_city',
        'permanent_state',
        'permanent_pincode',
        'permanent_phone',
        'relation',
        'alternate_mobile',
        'comp_mobile2',
        'releaveing_date'
    ];
}
