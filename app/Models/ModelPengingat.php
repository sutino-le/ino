<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengingat extends Model
{
    protected $table            = 'pengingat';
    protected $primaryKey       = 'ingatnomor';
    protected $allowedFields    = [
        'ingatnomor', 'ingattanggal', 'ingatuser'
    ];

    // Dates
    protected $useTimestamps = true;



    public function nomorIngat($tanggalSekarang)
    {
        return $this->table('pengingat')->select('max(ingatnomor) as nomoringat')->where('ingattanggal', $tanggalSekarang)->get();
    }
}