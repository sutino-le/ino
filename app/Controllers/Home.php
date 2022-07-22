<?php

namespace App\Controllers;

use App\Models\ModelLowongan;

class Home extends BaseController
{
    public function index()
    {
        $modelLowongan = new ModelLowongan();

        $data = [
            'tampildata' => $modelLowongan->findAll()
        ];

        return view('home/viewdata', $data);
    }
}
