<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelPemakaian;
use App\Models\ModelPemakaianBBPagination;
use Config\Services;

class Pemakaian extends BaseController
{
    public function index()
    {
        $ModelPemakaian = new ModelPemakaian();

        $modelBarang = new ModelBarang();

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Pemakaian',
            'datapembelian' => $ModelPemakaian->findAll(),
            'datakategori'  => $modelBarang->dataBarang(),
        ];
        return view('pemakaian/viewdata', $data);
    }

    public function listDataPemakaian()
    {

        $kategori = $this->request->getPost('kategori');
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelPemakaianBBPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($kategori, $tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->pmkid . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->pmkid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->pmkid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->pmknomor;
                $row[] = $list->brgnama;
                $row[] = $list->pmktanggal;
                $row[] = $list->pmkjumlah;
                $row[] = $tombolCetak . ' ' . $tombolHapus . ' ' . $tombolEdit;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($kategori, $tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($kategori, $tglawal, $tglakhir),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
