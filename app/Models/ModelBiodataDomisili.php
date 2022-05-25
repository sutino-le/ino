<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBiodataDomisili extends Model
{
    protected $table            = 'biodata_domisili';
    protected $primaryKey       = 'domisili_ktp';
    protected $allowedFields    = [
        'domisili_ktp', 'domisili_alamat', 'domisili_rt', 'domisili_rw', 'domisili_wilayah_id'
    ];
}
