<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangPagination;
use App\Models\ModelPembelian;
use App\Models\ModelPembelianPagination;
use App\Models\ModelTempPembelian;
use Config\Services;

class Pembelian extends BaseController
{

    public function __construct()
    {
        $this->barang = new ModelBarang();
        $this->pembelian = new ModelPembelian();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Pembelian',
        ];
        return view('pembelian/viewdata', $data);
    }

    public function listData()
    {

        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelPembelianPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->faktur . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->faktur . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->faktur . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->faktur;
                $row[] = $list->tglfaktur;
                $row[] = $list->supnama;
                $row[] = number_format($list->totalharga, 0, ",", ".");
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

    private function buatFaktur()
    {
        $tanggalSekarang = date("Y-m-d");
        $pembelian = new ModelPembelian();

        $hasil = $pembelian->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noFaktur;
    }

    public function buatNoFaktur()
    {
        $tanggalSekarang = $this->request->getPost('tanggal');
        $pembelian = new ModelPembelian();

        $hasil = $pembelian->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);


        $json = [
            'nofaktur' => $noFaktur
        ];

        echo json_encode($json);
    }

    public function input()
    {
        $data   = [
            'judul'     => 'Home',
            'subjudul'  => 'Input Faktur Pembelian',
            'nofaktur'  => $this->buatFaktur()
        ];
        return view('pembelian/forminput', $data);
    }

    public function tampilDataTemp()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modalTempPembelian = new ModelTempPembelian();
            $dataTemp = $modalTempPembelian->tampilDataTemp($nofaktur);

            $data = [
                'tampildata' => $dataTemp
            ];

            $json = [
                'data' => view('pembelian/datatemp', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $kodebarang = $this->request->getPost('kodebarang');

            $modelBarang    = new Modelbarang();
            $cekData        = $modelBarang->find($kodebarang);

            if ($cekData == null) {
                $json = [
                    'error' => 'Maaf, Data barang tidak ditemukan'
                ];
            } else {
                $data = [
                    'namabarang' => $cekData['brgnama'],
                    'hargajual'  => $cekData['brgharga']
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

    function simpanItem()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargabeli = $this->request->getPost('hargabeli');
            $hargajual = $this->request->getPost('hargajual');
            $jml = $this->request->getPost('jml');

            $modalTempPembelian = new ModelTempPembelian();

            $modalTempPembelian->insert([
                'detfaktur'     => $nofaktur,
                'detbrgkode'    => $kodebarang,
                'dethargamasuk' => $hargabeli,
                'dethargajual'  => $hargajual,
                'detjml'        => $jml,
                'detsubtotal'   => intval($jml) * intval($hargabeli)
            ]);

            $json = [
                'sukses' => 'Item berhasil ditambahkan'
            ];

            echo json_encode($json);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $ModelTempPembelian = new ModelTempPembelian();
            $ModelTempPembelian->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }


    public function modalCariBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data'  => view('pembelian/modalcaribarang')
            ];

            echo json_encode($json);
        }
    }

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
}
