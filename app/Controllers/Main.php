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

        if ($cekBiodata > 0) {
            $data = [
                'judul'         => 'Home',
                'subjudul'      => 'Awal',
                'menu'          => '',
                'submenu'       => '',
                'ktp_foto'      => $cekBiodata['ktp_foto'],
            ];
        } else {
            $data = [
                'judul'         => 'Home',
                'subjudul'      => 'Awal',
                'menu'          => '',
                'submenu'       => '',
                'ktp_foto'      => 'user.png',
            ];
        }
        return view('main/layout', $data);
    }
}