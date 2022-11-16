<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPemakaianTemp extends Model
{
    protected $table            = 'temp_pemakaian';
    protected $primaryKey       = 'pmkid';
    protected $allowedFields    = [
        'pmknomor', 'pmkbrgkode', 'pmkjumlah', 'pmkjenis', 'pmkketerangan'
    ];


    // Dates
    protected $useTimestamps = true;



    public function tampilDataTemp($pmknomor)
    {
        return $this->table('temp_pemakaian')->join('barang', 'pmkbrgkode=brgkode')->where('pmknomor', $pmknomor)->get();
    }
}