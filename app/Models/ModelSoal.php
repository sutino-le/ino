<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSoal extends Model
{
    protected $table            = 'soal';
    protected $primaryKey       = 'soalid';
    protected $allowedFields    = [
        'soalper', 'soalkat', 'soalpila', 'soalpilb', 'soalpilc', 'soalpild', 'soalpile', 'soaljaw', 'soalket'
    ];

    // Dates
    // protected $useTimestamps = true;
}
