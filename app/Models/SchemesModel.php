<?php

namespace App\Models;

use CodeIgniter\Model;

class SchemesModel extends Model
{
    protected $table            = 'schemes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['scheme_name', 'rate'];
}
