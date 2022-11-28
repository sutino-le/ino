<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengembalian extends Model
{
    protected $table            = 'pengembalian';
    protected $primaryKey       = 'pgmnomor';
    protected $allowedFields    = [
        'pgmnomor', 'pgmtanggal', 'pgmoleh', 'pgmuser'
    ];


    // Dates
    protected $useTimestamps = true;


    public function noKembali($tanggalSekarang)
    {
        return $this->table('pengembalian')->select('max(pgmnomor) as pgmnomor')->where('pgmtanggal', $tanggalSekarang)->get();
    }


    public function tampilDataPengembalian($ktpnomor)
    {
        return $this->table('pengembalian')
            ->join('detail_pengembalian', 'pgmnomor=detpgmnomor')
            ->join('barang', 'pmkbrgkode=brgkode')
            ->join('satuan', 'brgsatid=satid')
            ->where('pgmoleh', $ktpnomor)
            ->orderBy('pgmtanggal', 'desc')
            ->orderBy('brgnama', 'asc')
            ->get();
    }
}
