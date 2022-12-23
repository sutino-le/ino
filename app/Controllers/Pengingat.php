<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pengingat extends BaseController
{
    public function index()
    {

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Pengingat',
            'menu'          => 'pengingat',
            'submenu'       => 'pengingat',
        ];
        return view('pengingat/viewdata', $data);
    }
}