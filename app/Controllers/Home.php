<?php

namespace App\Controllers;

use App\Models\ModelLowongan;

class Home extends BaseController
{
    public function index()
    {

        $status = "Aktif";
        $modelLowongan = new ModelLowongan();

        $cekdata = $modelLowongan->cariData($status);

        if ($cekdata->getNumRows() > 0) {
            $jumlahdata = 1;
        } else {
            $jumlahdata = 0;
        }


        $data = [
            'tampildata'    => $cekdata,
            'jumlahdata'    => $jumlahdata,
        ];

        return view('home/viewdata', $data);
    }
}