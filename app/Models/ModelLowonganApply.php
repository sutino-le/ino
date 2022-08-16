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
}