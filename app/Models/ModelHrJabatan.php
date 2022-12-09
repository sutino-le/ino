<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelHrJabatan extends Model
{
    protected $table            = 'hr_jabatan';
    protected $primaryKey       = 'jabatanid';
    protected $allowedFields    = ['jabatannama'];

    // Dates
    protected $useTimestamps = true;
}