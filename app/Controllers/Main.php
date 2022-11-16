<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBiodataKtp;
use App\Models\ModelUsers;

class Main extends BaseController
{
    public function index()
    {
        $modelusers = new ModelUsers();
        $cekUser = $modelusers->find(session()->iduser);

        $modelBiodata = new ModelBiodataKtp();
        $cekBiodata = $modelBiodata->find($cekUser['userktp']);

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Awal',
            'menu'          => '',
            'submenu'       => '',
            'ktp_foto'          => $cekBiodata['ktp_foto'],
        ];
        return view('main/layout', $data);
    }
}