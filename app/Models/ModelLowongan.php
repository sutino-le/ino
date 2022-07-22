<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLowongan extends Model
{
    protected $table            = 'lowongan';
    protected $primaryKey       = 'lowonganid';
    protected $allowedFields    = [
        'lowonganid', 'lowonganjob', 'lowongandeskripsi', 'lowonganpersyaratan', 'lowongantanggal', 'lowonganstatus'
    ];
}
