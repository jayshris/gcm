<?php

namespace App\Models;

use CodeIgniter\Model;

class ForemanModel extends Model
{
    protected $table            = 'foreman';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['party_id', 'mobile', 'email', 'bank_account_number', 'bank_ifsc_code', 'dl_no', 'dl_authority', 'dl_expiry', 'dl_image_front', 'dl_image_back', 'upi_text', 'upi_id', 'profile_image1', 'profile_image2', 'status', 'created_at', 'updated_at', 'deleted_at'];
}
