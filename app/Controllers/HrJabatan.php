<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HrJabatan extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Jabatan',
            'menu'          => 'masterhr',
            'submenu'       => 'jabatan',
        ];
        return view('hrjabatan/viewdata', $data);
    }
}
