<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerBranchPersonModel extends Model
{
    protected $table            = 'customer_branch_persons';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['branch_id', 'name', 'designation', 'phone', 'email'];
}
