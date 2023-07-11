<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengingatTemp extends Model
{
    protected $table            = 'pengingattemp';
    protected $primaryKey       = 'pgtid';
    protected $allowedFields    = [
        'pgtnomor', 'pgtbrgkode', 'pgtlocation', 'pgtawal', 'pgtakhir', 'pgtuser', 'pgtstatus', 'pgtketerangan'
    ];





    public function tampilDataIngat($ingatnomor)
    {
        return $this->table('pengingattemp')
            ->join('barang', 'pgtbrgkode=brgkode')
            ->join('satuan', 'brgsatid=satid')
            ->join('biodata_ktp', 'pgtuser=ktp_nomor')
            ->where('pgtnomor', $ingatnomor)
            ->orderBy('pgtid', 'desc')
            ->get();
    }




    public function tampilDataTemp($ingatnomor)
    {
        return $this->table('pengingattemp')->join('barang', 'pgtbrgkode=brgkode')->where('pgtnomor', $ingatnomor)->get();
    }
}