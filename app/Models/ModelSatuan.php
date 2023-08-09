<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSatuan extends Model
{
    protected $table            = 'satuan';
    protected $primaryKey       = 'satid';
    protected $allowedFields    = ['satnama', 'satinisial'];

    // Dates
    // protected $useTimestamps = true;
}
