<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangPagination;
use App\Models\ModelPengembalian;
use App\Models\ModelPengembalianPagination;
use App\Models\ModelPengembalianTemp;
use Config\Services;

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
        $datamodel = new ModelPengembalianPagination($request);
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


    // mebuat nomor pengembalian
    private function buatNomor()
    {
        $tanggalSekarang = date("Y-m-d");
        $pengembalian = new ModelPengembalian();

        $hasil = $pengembalian->noKembali($tanggalSekarang)->getRowArray();
        $data = $hasil['pgmnomor'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noKembali = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noKembali;
    }

    // mebuat nomor pengembalian jika merubah tanggal
    public function buatNoKembali()
    {
        $tanggalSekarang = $this->request->getPost('tanggal');
        $pengembalian = new ModelPengembalian();

        $hasil = $pengembalian->noKembali($tanggalSekarang)->getRowArray();
        $data = $hasil['pgmnomor'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noKembali = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);


        $json = [
            'pgmnomor' => $noKembali
        ];

        echo json_encode($json);
    }

    // form input pengembalian
    public function forminput()
    {
        $data   = [
            'judul'     => 'Home',
            'subjudul'  => 'Input Pengembalian',
            'menu'      => 'pengembalian',
            'submenu'   => 'pengembalian',
            'pgmnomor'  => $this->buatNomor()
        ];
        return view('pengembalian/forminput', $data);
    }


    // untuk menampilkan data temp_pengembalian
    public function tampilDataTemp()
    {
        if ($this->request->isAJAX()) {
            $pgmnomor = $this->request->getPost('pgmnomor');

            $modelPengembalianTemp = new ModelPengembalianTemp();
            $dataTemp = $modelPengembalianTemp->tampilDataTemp($pgmnomor);

            $data = [
                'tampildata' => $dataTemp
            ];

            $json = [
                'data' => view('pengembalian/datatemp', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }


    // untuk menampilkan modal cari barang
    public function modalCariBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data'  => view('pengembalian/modalcaribarang')
            ];

            echo json_encode($json);
        }
    }

    // untuk menampilkan list data barang
    public function listDataBarang()
    {
        $request = Services::request();
        $datamodel = new ModelBarangPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->brgkode . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";

                $row[] = $no;
                $row[] = $list->brgkode;
                $row[] = $list->brgnama;
                $row[] = number_format($list->brgharga, 0, ",", ".");
                $row[] = number_format($list->brgstok, 0, ",", ".");
                $row[] = $tombolPilih;
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

    // untuk mengambil data barang
    function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $pgmbrgkode = $this->request->getPost('pgmbrgkode');

            $modelBarang    = new ModelBarang();
            $cekData        = $modelBarang->find($pgmbrgkode);

            if ($cekData == null) {
                $json = [
                    'error' => 'Maaf, Data barang tidak ditemukan'
                ];
            } else {
                $data = [
                    'namabarang'    => $cekData['brgnama'],
                    'brgstok'       => $cekData['brgstok'],
                ];

                $json = [
                    'sukses' => $data
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }
}
