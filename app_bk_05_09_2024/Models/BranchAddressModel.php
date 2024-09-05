<?php

namespace App\Models;

use CodeIgniter\Model;

class BranchAddressModel extends Model
{
    protected $table            = 'branch_address';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['branch_id', 'address', 'city', 'state', 'country', 'zip', 'effective_from', 'created_on', 'created_by'];
}
