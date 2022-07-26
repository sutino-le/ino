<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailPembelian extends Model
{
    protected $table            = 'detail_barangmasuk';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'detfaktur', 'detbrgkode', 'dethargamasuk', 'dethargajual', 'detjml', 'detsubtotal'
    ];

    public function tampilDataDetail($nofaktur)
    {
        return $this->table('detail_barangmasuk')->join('barang', 'detbrgkode=brgkode')
            ->join('satuan', 'brgsatid=satid')
            ->where('detfaktur', $nofaktur)->get();
    }
}
