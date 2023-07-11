<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengingatDet extends Model
{
    protected $table            = 'pengingatdet';
    protected $primaryKey       = 'pgtid';
    protected $allowedFields    = [
        'pgtnomor', 'pgtbrgkode', 'pgtlocation', 'pgtawal', 'pgtakhir', 'pgtuser', 'pgtstatus', 'pgtketerangan'
    ];


    public function tampilDataIngat($ingatnomor)
    {
        return $this->table('pengingatdet')
            ->join('barang', 'pgtbrgkode=brgkode')
            ->join('satuan', 'brgsatid=satid')
            ->join('biodata_ktp', 'pgtuser=ktp_nomor')
            ->where('pgtnomor', $ingatnomor)
            ->orderBy('pgtid', 'desc')
            ->get();
    }
}