<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenerimaan extends Model
{
    protected $table            = 'tanda_terimabarang';
    protected $primaryKey       = 'ttbid';
    protected $allowedFields    = [
        'ttbfaktur', 'ttbpembelianid', 'ttbtanggal', 'ttbbrgkode', 'ttbjml', 'ttbpenerima', 'ttbnomor'
    ];



    public function noTtb($tanggalSekarang)
    {
        return $this->table('tanda_terimabarang')->select('max(ttbnomor) as nottb')->where('ttbtanggal', $tanggalSekarang)->get();
    }


    public function tampilDataPenerimaan($nofaktur)
    {
        return $this->table('tanda_terimabarang')->join('barang', 'ttbbrgkode=brgkode')->where('ttbfaktur', $nofaktur)->get();
    }

    function ambilTotalTerima($brgkode, $nofaktur)
    {
        $query = $this->table('tanda_terimabarang')->getWhere(['ttbfaktur' => $nofaktur, 'ttbbrgkode' => $brgkode]);

        $totalterima = 0;
        foreach ($query->getResultArray() as $r) :
            $totalterima += $r['ttbjml'];
        endforeach;
        return $totalterima;
    }




    public function dataTtb($nottb)
    {
        return $this->table('tanda_terimabarang')
            ->join('barangmasuk', 'ttbfaktur=faktur')
            ->join('suplier', 'idsup=supid', 'left')
            ->join('barang', 'ttbbrgkode=brgkode')
            ->where('ttbnomor', $nottb)
            ->groupBy('ttbnomor', 'asc')
            ->get();
    }


    public function tampilDataTtb($nottb)
    {
        return $this->table('tanda_terimabarang')
            ->join('barang', 'ttbbrgkode=brgkode')
            ->join('satuan', 'brgsatid=satid')
            ->where('ttbnomor', $nottb)
            ->orderBy('brgnama', 'asc')
            ->get();
    }
}