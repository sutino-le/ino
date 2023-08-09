<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelDetailPembelian;
use App\Models\ModelPembelian;
use App\Models\ModelPenerimaan;
use App\Models\ModelPenerimaanDetPagination;
use App\Models\ModelPenerimaanPagination;
use Config\Services;

class Penerimaan extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    // untuk menampilkan penerimaan barang
    public function index()
    {
        $modelPembelian = new ModelPembelian();
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Penerimaan',
            'menu'          => 'penerimaan',
            'submenu'       => 'penerimaan',
            'datapembelian' => $modelPembelian->findAll()
        ];
        return view('penerimaan/viewdata', $data);
    }

    // untuk menampilkan detail penerimaan barang
    public function detailttb()
    {
        $modelPembelian = new ModelPembelian();
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Penerimaan',
            'menu'          => 'penerimaan',
            'submenu'       => 'detailpenerimaan',
            'datapembelian' => $modelPembelian->findAll()
        ];
        return view('penerimaan/detailpenerimaan', $data);
    }

    // deta penerimaan
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

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->ttbnomor . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";

                $row[] = $no;
                $row[] = $list->ttbnomor;
                $row[] = $list->ttbtanggal;
                $row[] = $list->ttbpenerima;
                $row[] = $tombolCetak;
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

    // detail penerimaan
    public function listDataDetail()
    {

        $ttbfaktur = $this->request->getPost('nofaktur');
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelPenerimaanDetPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($ttbfaktur, $tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $row[] = $no;
                $row[] = $list->ttbnomor;
                $row[] = $list->ttbfaktur;
                $row[] = $list->ttbtanggal;
                $row[] = $list->brgnama;
                $row[] = $list->ttbjml;
                $row[] = $list->ttbpenerima;
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

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
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

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
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
            'judul'         => 'Home',
            'subjudul'      => 'Input Penerimaan',
            'menu'          => 'penerimaan',
            'submenu'       => 'penerimaan',
            'penerima'      => session()->namauser,
            'tampilfaktur'  => $modelPembelian->findAll(),
            'nottb'         => $this->buatTtb()
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
            $nofaktur = $this->request->getPost('faktur');


            $modelDetailPembelian = new ModelDetailPembelian();

            $data = [
                'tampilpembelian' => $modelDetailPembelian->tampilDataDetail($nofaktur),
            ];


            $json = [
                'data'  => view('penerimaan/modalcaribarang', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
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


    function editItemTtb()
    {
        if ($this->request->isAJAX()) {
            $ttbid = $this->request->getPost('ttbid');
            $jml = $this->request->getPost('jml');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
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
                        'errJumlah'     => $validation->getError('jml'),
                    ]
                ];
            } else {


                $modelPenerimaan = new ModelPenerimaan();

                $modelPenerimaan->update($ttbid, [
                    'ttbjml'            => $jml,
                ]);

                $json = [
                    'sukses' => 'Item berhasil dirubah'
                ];
            }

            echo json_encode($json);
        }
    }

    // untuk mencetak penerimaan barang
    public function cetakTtb($nottb)
    {
        $modelPenerimaan = new ModelPenerimaan();

        $cekData = $modelPenerimaan->dataTtb($nottb)->getRowArray();

        if ($cekData != null) {
            $data = [
                'nomor'             => $cekData['ttbnomor'],
                'ttbtanggal'        => $cekData['ttbtanggal'],
                'penerima'          => $cekData['ttbpenerima'],
                'supnama'           => $cekData['supnama'],
                'supalamat'         => $cekData['supalamat'],
                'faktur'            => $cekData['faktur'],
                'detailpenerimaan'  => $modelPenerimaan->tampilDataTtb($nottb)
            ];

            return view('penerimaan/cetakpenerimaan', $data);
        } else {
            return redirect()->to(site_url('penerimaan/index'));
        }
    }
}
