<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTempPembelian extends Model
{
    protected $table            = 'temp_barangmasuk';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = [
        'detfaktur', 'detbrgkode', 'dethargamasuk', 'dethargajual', 'detjml', 'detsubtotal', 'detketerangan'
    ];

    // Dates
    // protected $useTimestamps = true;

    public function tampilDataTemp($nofaktur)
    {
        return $this->table('temp_barangmasuk')->join('barang', 'detbrgkode=brgkode')->where('detfaktur', $nofaktur)->get();
    }

    public function ambilDetailBerdasarkanID($iddetail)
    {
        return $this->table('temp_barangmasuk')->join('barang', 'detbrgkode=brgkode')->where('iddetail', $iddetail)->get();
    }
}
