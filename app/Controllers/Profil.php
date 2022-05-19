<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBiodataKtp;
use App\Models\ModelUsers;

class Profil extends BaseController
{
    public function index($admin)
    {
        //ambil tabel user
        $modelUser = new ModelUsers();
        $rowUser = $modelUser->find($admin);

        //ambil tabel biodata ktp
        $modelKtp = new ModelBiodataKtp();
        $rowKtp = $modelKtp->find($rowUser['userktp']);

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Profil',
            'userid'        => $rowUser['userid'],
            'usernama'      => $rowUser['usernama'],
            'ktp_nama'      => $rowKtp['ktp_nama'],
        ];
        return view('profil/viewdata', $data);
    }
}
