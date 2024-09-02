<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficeMasterModel extends Model
{
    protected $table            = 'offices_master';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'name', 'status', 'added_date', 'added_by', 'updated_at', 'updated_by'];
}
