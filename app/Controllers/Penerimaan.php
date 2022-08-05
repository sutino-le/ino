<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPembelian;
use App\Models\ModelPenerimaan;
use App\Models\ModelPenerimaanPagination;
use Config\Services;

class Penerimaan extends BaseController
{
    public function index()
    {
        $modelPembelian = new ModelPembelian();
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Penerimaan',
            'datapembelian' => $modelPembelian->findAll()
        ];
        return view('penerimaan/viewdata', $data);
    }


    public function listData()
    {

        $ttbfaktur = $this->request->getPost('nofaktur');
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelPenerimaanPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($ttbfaktur, $tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->ttbid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->ttbid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->ttbnomor;
                $row[] = $list->ttbfaktur;
                $row[] = $list->ttbtanggal;
                $row[] = $list->brgnama;
                $row[] = $list->ttbjml;
                $row[] = $list->ttbpenerima;
                $row[] = $tombolHapus . ' ' . $tombolEdit;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($ttbfaktur, $tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($ttbfaktur, $tglawal, $tglakhir),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    private function buatTtb()
    {
        $tanggalSekarang = date("Y-m-d");
        $penerimaan = new ModelPenerimaan();

        $hasil = $penerimaan->noTtb($tanggalSekarang)->getRowArray();
        $data = $hasil['nottb'];

        $lastNoUrut = substr($data, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noTtb = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noTtb;
    }

    public function buatNoTtb()
    {
        $tanggalSekarang = $this->request->getPost('tanggal');
        $penerimaan = new ModelPenerimaan();

        $hasil = $penerimaan->noTtb($tanggalSekarang)->getRowArray();
        $data = $hasil['nottb'];

        $lastNoUrut = substr($data, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noTtb = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);


        $json = [
            'nottb' => $noTtb
        ];

        echo json_encode($json);
    }

    public function input()
    {
        $data   = [
            'judul'     => 'Home',
            'subjudul'  => 'Input Penerimaan',
            'nottb'  => $this->buatTtb()
        ];
        return view('penerimaan/forminput', $data);
    }
}
