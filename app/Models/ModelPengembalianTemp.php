<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengembalianTemp extends Model
{
    protected $table            = 'temp_pengembalian';
    protected $primaryKey       = 'detpgmid';
    protected $allowedFields    = [
        'detpgmnomor', 'detpgmbrgkode', 'detpgmjumlah', 'detpgmjenis', 'detpgmketerangan'
    ];


    // Dates
    protected $useTimestamps = true;



    public function tampilDataTemp($detpgmnomor)
    {
        return $this->table('temp_pengembalian')->join('barang', 'detpgmbrgkode=brgkode')->where('detpgmnomor', $detpgmnomor)->get();
    }
}
