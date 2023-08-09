<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLowonganApply extends Model
{
    protected $table            = 'lowongan_apply';
    protected $primaryKey       = 'applyid';
    protected $allowedFields    = [
        'applyktp', 'applylowid', 'applytanggal', 'applystatus'
    ];

    // Dates
    // protected $useTimestamps = true;

    function cariData($userktp)
    {
        $query = $this->table('lowongan_apply')->getWhere([
            'applyktp' => $userktp
        ]);

        $jmlApply = 0;
        foreach ($query->getResultArray() as $r) :
            $jmlApply += $r['applyid'];
        endforeach;
        return $jmlApply;
    }

    function cekApply($userktp, $lowonganid)
    {
        $query = $this->table('lowongan_apply')
            ->getWhere(['applyktp' => $userktp])
            ->getWhere(['applylowid' => $lowonganid]);
    }
}
