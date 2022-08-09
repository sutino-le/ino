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
        return $this->table('detail_barangmasuk')
            ->join('barang', 'detbrgkode=brgkode')
            ->join('tanda_terimabarang', 'iddetail=ttbpembelianid', 'left')
            ->groupby('detail_barangmasuk.detbrgkode')
            ->where('detail_barangmasuk.detfaktur', $nofaktur)
            ->select('barang.brgnama')
            ->select('detail_barangmasuk.detjml')
            ->selectSum('tanda_terimabarang.ttbjml')
            ->get();
    }



    public function ambilData($kodebarang)
    {
        return $this->table('detail_barangmasuk')->join('barang', 'detbrgkode=brgkode')
            ->where('detbrgkode', $kodebarang)->get();
    }
}
