<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPemakaianDet extends Model
{
    protected $table            = 'detail_pemakaian';
    protected $primaryKey       = 'pmkid';
    protected $allowedFields    = [
        'pmknomor', 'pmkbrgkode', 'pmkjumlah', 'pmkjenis', 'pmkketerangan'
    ];


    // Dates
    protected $useTimestamps = true;

    public function tampilDataDetail($nomor)
    {
        return $this->table('detail_pemakaian')->join('barang', 'pmkbrgkode=brgkode')
            ->join('satuan', 'brgsatid=satid')
            ->where('pmknomor', $nomor)
            ->orderBy('brgnama', 'asc')
            ->get();
    }


    public function pemakaianBarang($brgkode)
    {
        return $this->table('detail_pemakaian')->join('pemakaian', 'pmknomor=nomor', 'left')->join('biodata_ktp', 'pemakai=ktp_nomor', 'left')->join('barang', 'pmkbrgkode=brgkode')
            ->where('pmkbrgkode', $brgkode)->get();
    }
}
