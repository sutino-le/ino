<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelHrJenisPkwt extends Model
{
    protected $table            = 'hr_jenispkwt';
    protected $primaryKey       = 'jpkwtid';
    protected $allowedFields    = ['jpkwtnama'];

    // Dates
    protected $useTimestamps = true;
}