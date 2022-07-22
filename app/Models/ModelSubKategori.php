<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSubKategori extends Model
{
    protected $table            = 'subkategori';
    protected $primaryKey       = 'subkatid';
    protected $allowedFields    = ['subkatnama'];
}
