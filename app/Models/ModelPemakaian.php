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
            ->join('kategori', 'brgkatid=katid')
            ->join('subkategori', 'brgsubkatid=subkatid')
            ->join('satuan', 'brgsatid=satid')
            ->join('detail_pengembalian', 'pmkid=detpgmpmkid', 'left')
            ->where('pemakai', $ktpnomor)
            ->orderBy('subkatid', 'asc')
            ->orderBy('pmkid', 'asc')
            ->get();
    }
}