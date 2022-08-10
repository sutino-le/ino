<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPemakaian extends Model
{
    protected $table            = 'pemakaian';
    protected $primaryKey       = 'pmkid';
    protected $allowedFields    = [
        'pmknomor', 'pmkbrgkode', 'pmktanggal', 'pmkjumlah', 'pmknama', 'pmkketerangan'
    ];
}
