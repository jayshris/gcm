<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerBranchModel extends Model
{
    protected $table            = 'customer_branches';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['customer_id', 'office_name', 'gst', 'address', 'city', 'state_id', 'country', 'pincode', 'status', 'added_date', 'added_by', 'added_ip', 'modify_date', 'modify_by', 'modify_ip'];
}
