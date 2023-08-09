<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUsers extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'userid ';
    protected $allowedFields    = [
        'userid', 'usernama', 'userktp', 'useremail', 'userpassword', 'userlevelid'
    ];

    // Dates
    // protected $useTimestamps = true;

    public function cariUser($idlevel)
    {
        return $this->table('users')->like('userlevelid', $idlevel);
    }

    public function cariKtp($userktp)
    {
        return $this->table('users')->Where('userktp', $userktp)->get();
    }

    public function cariEmail($useremail)
    {
        return $this->table('users')->Where('useremail', $useremail)->get();
    }
}
