<?php

namespace App\Models;

use CodeIgniter\Model;

class KycLinksModel extends Model
{
    protected $table            = 'kyc_links';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['token', 'gen_date', 'gen_by', 'gen_ip', 'link_used'];
}
