<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembelian extends Model
{
    protected $table            = 'barangmasuk';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur', 'tglfaktur', 'jenis', 'idsup', 'totalharga', 'jumlahuang', 'sisauang'
    ];

    // Dates
    // protected $useTimestamps = true;



    public function noFaktur($tanggalSekarang)
    {
        return $this->table('barangmasuk')->select('max(faktur) as nofaktur')->where('tglfaktur', $tanggalSekarang)->get();
    }
}
