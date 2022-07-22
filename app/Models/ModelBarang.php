<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'brgkode';
    protected $allowedFields    = [
        'brgnama', 'brgkatid', 'brgsubkatid', 'brgsatid', 'brgharga', 'brggambar', 'brgstok'
    ];
}
