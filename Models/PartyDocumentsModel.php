<?php

namespace App\Models;

use CodeIgniter\Model;

class PartyDocumentsModel extends Model
{
    protected $table            = 'party_documents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['party_id', 'flag_id', 'number', 'img1', 'img2'];
}
