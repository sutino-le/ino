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
}