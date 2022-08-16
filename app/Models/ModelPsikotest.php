<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPsikotest extends Model
{
    protected $table            = 'psikotest';
    protected $primaryKey       = 'testid';
    protected $allowedFields    = [
        'testktp', 'testtanggal', 'testpertid', 'testkuncijawaban', 'testjawab', 'teststatus'
    ];

    public function dataTest($nomorktp)
    {
        return $this->table('psikotest')->where('testktp', $nomorktp)->get();
    }
}
