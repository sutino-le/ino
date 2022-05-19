<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUsersUpdate extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'userktp';
    protected $allowedFields    = [
        'userid', 'usernama', 'userktp', 'useremail', 'userpassword', 'userlevelid'
    ];
}
