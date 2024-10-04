<?php

namespace App\Models;

use CodeIgniter\Model;

class TyreSizeModel extends Model
{
    protected $table            = 'tyre_size';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['size', 'status', 'added_date', 'added_by', 'added_ip', 'updated_date', 'updated_by', 'updated_ip'];
}
