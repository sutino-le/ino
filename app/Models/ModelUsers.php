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

    public function cariUser($idlevel)
    {
        return $this->table('users')->like('userlevelid', $idlevel);
    }
}
