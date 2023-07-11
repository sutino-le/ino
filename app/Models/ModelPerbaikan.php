<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPerbaikan extends Model
{
    protected $table            = 'perbaikan';
    protected $primaryKey       = 'pbknid';
    protected $allowedFields    = [
        'pbknuser', 'pbkntanggal', 'pbknproblem', 'pbknsolusi', 'pbknstatus'
    ];

    // Dates
    protected $useTimestamps = true;
}