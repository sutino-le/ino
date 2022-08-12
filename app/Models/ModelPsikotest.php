<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPsikotest extends Model
{
    protected $table            = 'psikotest';
    protected $primaryKey       = 'testid';
    protected $allowedFields    = [
        'testktp', 'testtanggal', 'testpertid', 'testjawab', 'teststatus'
    ];
}
