<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelFinger extends Model
{
    protected $table            = 'finger';
    protected $primaryKey       = 'pin';
    protected $allowedFields    = ['pin', 'waktu', 'status'];

    // Dates
    // protected $useTimestamps = true;

    public function cekFinger($pin, $datetime)
    {
        return $this->table('finger')->Where('pin', $pin)->Where('waktu', $datetime)->get();
    }
}
