<?php

namespace App\Models;

use CodeIgniter\Model;

class DriverSchemeMapModel extends Model
{
    protected $table            = 'driver_scheme_map';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['driver_id', 'scheme_id', 'added_date', 'removal_date'];
}
