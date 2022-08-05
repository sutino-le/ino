<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenerimaan extends Model
{
    protected $table            = 'tanda_terimabarang';
    protected $primaryKey       = 'ttbid';
    protected $allowedFields    = [
        'ttbfaktur', 'ttbtanggal', 'ttbbrgkode', 'ttbjml', 'ttbpenerima', 'ttbnomor'
    ];



    public function noTtb($tanggalSekarang)
    {
        return $this->table('tanda_terimabarang')->select('max(ttbnomor) as nottb')->where('ttbtanggal', $tanggalSekarang)->get();
    }
}
