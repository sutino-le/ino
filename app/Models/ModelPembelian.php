<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembelian extends Model
{
    protected $table            = 'barangmasuk';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur', 'tglfaktur', 'idsup', 'totalharga'
    ];



    public function noFaktur($tanggalSekarang)
    {
        return $this->table('barangmasuk')->select('max(faktur) as nofaktur')->where('tglfaktur', $tanggalSekarang)->get();
    }
}
