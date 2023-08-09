<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBiodataKtp extends Model
{
    protected $table            = 'biodata_ktp';
    protected $primaryKey       = 'ktp_nomor';
    protected $allowedFields    = [
        'ktp_nomor', 'ktp_nama', 'ktp_tempat_lahir', 'ktp_tanggal_lahir', 'ktp_kelamin', 'ktp_alamat', 'ktp_rt', 'ktp_rw', 'ktp_alamatid', 'ktp_hp', 'ktp_foto'
    ];

    // Dates
    // protected $useTimestamps = true;
}
