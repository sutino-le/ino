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
        return $this->table('tanda_terimabarang')->join('barang', 'ttbbrgkode=brgkode')
            ->where('ttbfaktur', $nofaktur)->get();
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
}
