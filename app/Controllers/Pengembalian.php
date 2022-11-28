<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pengembalian extends BaseController
{
    public function index()
    {

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Pengembalian',
            'menu'          => 'pengembalian',
            'submenu'       => 'pengembalian',
        ];
        return view('pengembalian/viewdata', $data);
    }

    public function listData()
    {

        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelPemakaianPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->nomor . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->nomor . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->nomor . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->nomor;
                $row[] = $list->pmktanggal;
                $row[] = $list->ktp_nama;
                $row[] = $list->pmkuser;;
                $row[] = $tombolCetak . ' ' . $tombolHapus . ' ' . $tombolEdit;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($tglawal, $tglakhir),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}