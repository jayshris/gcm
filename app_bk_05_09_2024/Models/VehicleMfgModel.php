<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleMfgModel extends Model
{
    protected $table            = 'vehicle_mfg';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'status', 'created_at', 'created_by', 'created_ip', 'modified_at', 'modified_by', 'modified_ip', 'is_deleted'];
}
