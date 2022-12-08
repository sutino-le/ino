<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HrJenisPkwt extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Jenis PKWT',
            'menu'          => 'masterhr',
            'submenu'       => 'jenispkwt',
        ];
        return view('hrjenispkwt/viewdata', $data);
    }
}
