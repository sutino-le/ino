<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelDetailPembelian;
use App\Models\ModelPembelian;
use App\Models\ModelPembelianBarangPagination;
use App\Models\ModelPembelianPagination;
use App\Models\ModelPenerimaan;
use App\Models\ModelPenerimaanPagination;
use Config\Services;
use CodeIgniter\Database\BaseBuilder;

class Penerimaan extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

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
        $modelPembelian = new ModelPembelian();
        $data   = [
            'judul'     => 'Home',
            'subjudul'  => 'Input Penerimaan',
            'tampilfaktur'  => $modelPembelian->findAll(),
            'nottb'  => $this->buatTtb()
        ];
        return view('penerimaan/forminput', $data);
    }

    public function tampilDataPembelian()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modelDetailPembelian = new ModelDetailPembelian();
            $dataDetailPembelian = $modelDetailPembelian->tampilDataDetailPembelian($nofaktur);

            $modelPenerimaan = new ModelPenerimaan();

            $data = [
                'tampilpembelian' => $dataDetailPembelian,

            ];

            $json = [
                'data' => view('penerimaan/datapembelian', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }


    public function tampilTtb()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modelPenerimaan = new ModelPenerimaan();

            $data = [
                'tampilpenerimaan' => $modelPenerimaan->tampilDataPenerimaan($nofaktur),
            ];

            $json = [
                'data' => view('penerimaan/datattb', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }


    public function hapusItemTtb()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('ttbid');
            $modelPenerimaan = new ModelPenerimaan();
            $modelPenerimaan->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    public function modalCariBarangBeli()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data'  => view('penerimaan/modalcaribarang')
            ];

            echo json_encode($json);
        }
    }


    public function listDataBarangBeli()
    {
        $nofaktur = $this->request->getPost('faktur');

        $modelDetailPembelian = new ModelDetailPembelian();
        $cekData = $modelDetailPembelian->tampilDataDetail($nofaktur);

        // $request = Services::request();
        // $datamodel = new ModelPembelianBarangPagination($request);
        // if ($request->getMethod(true) == 'POST') {
        //     $lists = $datamodel->get_datatables();
        //     $data = [];
        //     $no = $request->getPost("start");
        //     foreach ($lists as $list) {
        //         $no++;
        //         $row = [];

        //         $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->iddetail . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";

        //         $row[] = $no;
        //         $row[] = $list->detfaktur;
        //         $row[] = $list->brgkode;
        //         $row[] = $list->brgnama;
        //         $row[] = $list->detjml;
        //         $row[] = $tombolPilih;
        //         $data[] = $row;
        //     }
        //     $output = [
        //         "draw" => $request->getPost('draw'),
        //         "recordsTotal" => $datamodel->count_all(),
        //         "recordsFiltered" => $datamodel->count_filtered(),
        //         "data" => $data
        //     ];
        //     echo json_encode($output);
        }
    }

    function ambilDataBarangBeli()
    {
        if ($this->request->isAJAX()) {
            $kodebeli = $this->request->getPost('kodebeli');

            $modelPembelian    = new ModelDetailPembelian();
            $cekData        = $modelPembelian->find($kodebeli);

            $modelBarang = new ModelBarang();
            $rowBarang = $modelBarang->find($cekData['detbrgkode']);

            if ($cekData == null) {
                $json = [
                    'error' => 'Maaf, Data barang tidak ditemukan'
                ];
            } else {
                $data = [
                    'kodebarang' => $rowBarang['brgkode'],
                    'namabarang' => $rowBarang['brgnama'],
                    'detjml' => $cekData['detjml'],
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


    function simpanItemTtb()
    {
        if ($this->request->isAJAX()) {
            $nottb = $this->request->getPost('nottb');
            $tglttb = $this->request->getPost('tglttb');
            $ttbfaktur = $this->request->getPost('ttbfaktur');
            $penerima = $this->request->getPost('penerima');
            $kodebeli = $this->request->getPost('kodebeli');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $detjml = $this->request->getPost('detjml');
            $jml = $this->request->getPost('jml');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ttbfaktur'    => [
                    'label'     => 'Faktur',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'penerima'    => [
                    'label'     => 'Penerima',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kodebeli'    => [
                    'label'     => 'Kode Beli',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'jml'    => [
                    'label'     => 'Jumlah',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errTtbFaktur'  => $validation->getError('ttbfaktur'),
                        'errPenerima'   => $validation->getError('penerima'),
                        'errKodeBeli'   => $validation->getError('kodebeli'),
                        'errJumlah'     => $validation->getError('jml'),
                    ]
                ];
            } else {


                $modelPenerimaan = new ModelPenerimaan();

                $modelPenerimaan->insert([
                    'ttbfaktur'         => $ttbfaktur,
                    'ttbpembelianid'    => $kodebeli,
                    'ttbtanggal'        => $tglttb,
                    'ttbbrgkode'        => $kodebarang,
                    'ttbjml'            => $jml,
                    'ttbpenerima'       => $penerima,
                    'ttbnomor'          => $nottb,
                ]);

                $json = [
                    'sukses' => 'Item berhasil ditambahkan'
                ];
            }

            echo json_encode($json);
        }
    }
}
