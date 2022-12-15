<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelHrBagian;

class HrStruktur extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Struktur Organisasi',
            'menu'          => 'struktur',
            'submenu'       => 'struktur',
        ];
        return view('hrstruktur/viewdata', $data);
    }

    function tampilData()
    {
        $modelBagian = new ModelHrBagian();
        $databagian = $modelBagian->findAll();

        $json = [
            'sukses' => $databagian
        ];

        echo json_encode($json);
    }
}