<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailPembelian extends Model
{
    protected $table            = 'detail_barangmasuk';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = [
        'detfaktur', 'detbrgkode', 'dethargamasuk', 'dethargajual', 'detjml', 'detsubtotal'
    ];

    public function tampilDataDetail($nofaktur)
    {
        return $this->table('detail_barangmasuk')->join('barang', 'detbrgkode=brgkode')
            ->join('satuan', 'brgsatid=satid')
            ->where('detfaktur', $nofaktur)->get();
    }

    function ambilTotalHarga($nofaktur)
    {
        $query = $this->table('detail_barangkeluar')->getWhere([
            'detfaktur' => $nofaktur
        ]);

        $totalHarga = 0;
        foreach ($query->getResultArray() as $r) :
            $totalHarga += $r['detsubtotal'];
        endforeach;
        return $totalHarga;
    }

    public function tampilDataDetailPembelian($nofaktur)
    {
        return $this->table('detail_barangmasuk')->join('barang', 'detbrgkode=brgkode')->join('tanda_terimabarang', 'detbrgkode=ttbbrgkode', 'left')
            ->join('satuan', 'brgsatid=satid')
            ->where('detfaktur', $nofaktur)->get();
    }
}
