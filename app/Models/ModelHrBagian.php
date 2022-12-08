<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelHrBagian extends Model
{
    protected $table            = 'hr_bagian';
    protected $primaryKey       = 'bagianid';
    protected $allowedFields    = ['bagiannama', 'bagianparent'];

    // Dates
    protected $useTimestamps = true;
}