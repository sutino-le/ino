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

    // Dates
    // protected $useTimestamps = true;

    public function dataTest($nomorktp)
    {
        return $this->table('psikotest')->where('testktp', $nomorktp)->get();
    }



    public function cekPsikotest($nomorktp)
    {
        $query = $this->table('psikotest')->getWhere([
            'testktp' => $nomorktp
        ]);

        $jmlApply = 0;
        foreach ($query->getResultArray() as $r) :
            $jmlApply += $r['testid'];
        endforeach;
        return $jmlApply;
    }


    public function hasilPsikotest($nomorktp)
    {
        return $this->table('psikotest')->where('testktp', $nomorktp)->get();
    }



    public function detailPsikotes($nomorktp)
    {
        return $this->table('psikotest')->join('soal', 'testpertid=soalid', 'left')->where('testktp', $nomorktp)->get();
    }
}
