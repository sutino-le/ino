<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLowonganApply;
use App\Models\ModelLowonganApplyPagination;
use Config\Services;

class HrPelamar extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Pelamar',
            'menu'          => 'seleksi',
            'submenu'       => 'pelamar',
        ];
        return view('hrpelamar/viewdata', $data);
    }



    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelLowonganApplyPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->applyid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->applyid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                // if ($list->brgsatid == "") {
                //     $tombolhapusJabatan = $tombolHapus;
                // } else {
                //     $tombolhapusJabatan = "";
                // }

                $row[] = $no;
                $row[] = $list->lowonganjob;
                $row[] = $list->ktp_nama;
                $row[] = date('d - M - Y', strtotime($list->applytanggal));
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



    public function hapusdata($applyid)
    {
        $modelLowonganApply = new ModelLowonganApply();
        $modelLowonganApply->delete($applyid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}
