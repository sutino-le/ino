<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelHrJenisKaryawan extends Model
{
    protected $table            = 'hr_jenis_karyawan';
    protected $primaryKey       = 'jkid';
    protected $allowedFields    = ['jknama'];

    // Dates
    protected $useTimestamps = true;
}