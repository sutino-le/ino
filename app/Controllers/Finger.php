<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelFinger;
use App\Models\ModelFingerPagination;
use Config\Services;

class Finger extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Finger',
            'menu'          => 'finger',
            'submenu'       => 'finger',
        ];
        return view('finger/viewdata', $data);
    }


    public function listData()
    {


        $request = Services::request();
        $datamodel = new ModelFingerPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];



                $row[] = $no;
                $row[] = $list->pin;
                $row[] = $list->waktu;
                $row[] = $list->status;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function download()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Finger',
            'menu'          => 'finger',
            'submenu'       => 'finger',
        ];
        return view('finger/download202', $data);
    }

    public function download203()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Finger',
            'menu'          => 'finger',
            'submenu'       => 'finger',
        ];
        return view('finger/download203', $data);
    }

    public function download204()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Finger',
            'menu'          => 'finger',
            'submenu'       => 'finger',
        ];
        return view('finger/download204', $data);
    }
}