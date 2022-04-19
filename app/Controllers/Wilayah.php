<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelWilayahPagination;
use Config\Services;

class Wilayah extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Wilayah',
        ];
        return view('wilayah/viewdata', $data);
    }


    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelWilayahPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->id_wilayah . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->id_wilayah . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                $row[] = $no;
                $row[] = $list->kelurahan;
                $row[] = $list->kecamatan;
                $row[] = $list->kota_kabupaten;
                $row[] = $list->propinsi;
                $row[] = $list->kodepos;
                $row[] = $tombolEdit . ' ' . $tombolHapus;
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

    
    public function formtambah()
    {
        $json = [
            'data' => view('wilayah/modaltambah')
        ];

        echo json_encode($json);
    }


}
