<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HrJenisKaryawan extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Jenis Karyawan',
            'menu'          => 'masterhr',
            'submenu'       => 'jeniskaryawan',
        ];
        return view('hrjeniskaryawan/viewdata', $data);
    }
}
