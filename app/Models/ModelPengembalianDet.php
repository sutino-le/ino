<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengembalianDet extends Model
{
    protected $table            = 'detail_pengembalian';
    protected $primaryKey       = 'detpgmid';
    protected $allowedFields    = [
        'detpgmnomor', 'detpgmbrgkode', 'detpgmjumlah', 'detpgmjenis', 'detpgmketerangan', 'detpgmpmkid'
    ];


    // Dates
    protected $useTimestamps = true;



    public function tampilDataDetail($pgmnomor)
    {
        return $this->table('detail_pengembalian')->join('barang', 'detpgmbrgkode=brgkode')
            ->join('satuan', 'brgsatid=satid')
            ->where('detpgmnomor', $pgmnomor)
            ->orderBy('brgnama', 'asc')
            ->get();
    }



    public function tampilDataDet($pgmnomor)
    {
        return $this->table('detail_pengembalian')
            ->join('barang', 'detpgmbrgkode=brgkode')
            ->where('detpgmnomor', $pgmnomor)->get();
    }


    public function pengembalianBarang($brgkode)
    {
        return $this->table('detail_pengembalian')->join('pengembalian', 'detpgmnomor=pgmnomor', 'left')->join('biodata_ktp', 'pgmoleh=ktp_nomor', 'left')->join('barang', 'detpgmbrgkode=brgkode')
            ->where('detpgmbrgkode', $brgkode)->get();
    }
}
