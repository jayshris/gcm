<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $table            = 'accounts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['ac_name', 'ac_for', 'ac_type', 'ac_type_2', 'status', 'created_at', 'created_by', 'created_ip', 'updated_at', 'updated_by', 'updated_ip'];
}
