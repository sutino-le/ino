<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPemakaian extends Model
{
    protected $table            = 'pemakaian';
    protected $primaryKey       = 'nomor';
    protected $allowedFields    = [
        'nomor', 'pmktanggal', 'pemakai', 'pmkuser'
    ];


    // Dates
    protected $useTimestamps = true;


    public function noPakai($tanggalSekarang)
    {
        return $this->table('pemakaian')->select('max(nomor) as pmknomor')->where('pmktanggal', $tanggalSekarang)->get();
    }


    public function tampilDataPemakaian($ktpnomor)
    {
        return $this->table('pemakaian')
            ->join('detail_pemakaian', 'nomor=pmknomor')
            ->join('barang', 'pmkbrgkode=brgkode')
            ->join('satuan', 'brgsatid=satid')
            ->where('pemakai', $ktpnomor)
            ->orderBy('pmktanggal', 'desc')
            ->orderBy('brgnama', 'asc')
            ->get();
    }
}