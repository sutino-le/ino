<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBiodataKtp;
use App\Models\ModelPengingat;
use App\Models\ModelPengingatPagination;
use App\Models\ModelPengingatTemp;
use Config\Services;

class Pengingat extends BaseController
{
    public function index()
    {

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Pengingat',
            'menu'          => 'pengingat',
            'submenu'       => 'pengingat',
        ];
        return view('pengingat/viewdata', $data);
    }



    // deta pengingat
    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelPengingatPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->ingatid . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";

                $row[] = $no;
                $row[] = $list->brgnama;
                $row[] = $list->pgtlocation;
                $row[] = $list->pgtawal;
                $row[] = $list->pgtakhir;
                $row[] = $list->ktp_nama;
                $row[] = $tombolCetak;
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


    // untuk nomor ingat default
    private function nomorIngat()
    {
        $tanggalSekarang = date("Y-m-d");
        $pengingat = new ModelPengingat();

        $hasil = $pengingat->nomorIngat($tanggalSekarang)->getRowArray();
        $data = $hasil['nomoringat'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $ingatnomor = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $ingatnomor;
    }

    // untuk nomor ingat perubahan tanggal
    public function buatNoIngat()
    {
        $tanggalSekarang = $this->request->getPost('tanggal');
        $pengingat = new ModelPengingat();

        $hasil = $pengingat->nomorIngat($tanggalSekarang)->getRowArray();
        $data = $hasil['nomoringat'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $ingatnomor = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);


        $json = [
            'ingatnomor' => $ingatnomor
        ];

        echo json_encode($json);
    }


    // form input
    public function input()
    {
        $data   = [
            'judul'         => 'Home',
            'subjudul'      => 'Input Pengingat',
            'menu'          => 'pengingat',
            'submenu'       => 'pengingat',
            'ingatnomor'  => $this->nomorIngat()
        ];
        return view('pengingat/forminput', $data);
    }

    // untuk menampilkan modal cari barang
    public function modalCariBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data'  => view('pengingat/modalcaribarang')
            ];

            echo json_encode($json);
        }
    }

    // untuk mengambil data barang
    function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $ingatkode = $this->request->getPost('ingatkode');

            $modelBarang    = new ModelBarang();
            $cekData        = $modelBarang->find($ingatkode);

            if ($cekData == null) {
                $json = [
                    'error' => 'Maaf, Data barang tidak ditemukan'
                ];
            } else {
                $data = [
                    'namabarang'    => $cekData['brgnama'],
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

    // untuk menyimpan item pengingat
    function simpanItem()
    {
        if ($this->request->isAJAX()) {
            $pgtnomor           = $this->request->getPost('pgtnomor');
            $pgtbrgkode         = $this->request->getPost('pgtbrgkode');
            $pgtlocation        = $this->request->getPost('pgtlocation');
            $pgtawal            = $this->request->getPost('pgtawal');
            $pgtakhir           = $this->request->getPost('pgtakhir');
            $pgtuser            = $this->request->getPost('pgtuser');
            $pgtstatus          = $this->request->getPost('pgtstatus');
            $pgtketerangan      = $this->request->getPost('pgtketerangan');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'pgtbrgkode'    => [
                    'label'     => 'Kode',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgtlocation'    => [
                    'label'     => 'Lokasi',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgtawal'    => [
                    'label'     => 'Tanggal Awal',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgtakhir'    => [
                    'label'     => 'Tanggal Akhir',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgtuser'    => [
                    'label'     => 'User',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errPgtBrgKode'     => $validation->getError('pgtbrgkode'),
                        'errPgtLocation'    => $validation->getError('pgtlocation'),
                        'errPgtAwal'        => $validation->getError('pgtawal'),
                        'errPgtAkhir'       => $validation->getError('pgtakhir'),
                        'errPgtUser'        => $validation->getError('pgtuser'),
                    ]
                ];
            } else {

                $modelPengingat = new ModelPengingatTemp();

                $modelPengingat->insert([
                    'pgtid'           => '',
                    'pgtnomor'        => $pgtnomor,
                    'pgtbrgkode'      => $pgtbrgkode,
                    'pgtlocation'     => $pgtlocation,
                    'pgtawal'         => $pgtawal,
                    'pgtakhir'        => $pgtakhir,
                    'pgtuser'         => $pgtuser,
                    'pgtstatus'       => 'Aktif',
                    'pgtketerangan'   => $pgtketerangan
                ]);

                $json = [
                    'sukses' => 'Item berhasil ditambahkan'
                ];
            }

            echo json_encode($json);
        }
    }

    // untuk menampilkan data pengingat
    public function tampilDataPengingat()
    {
        if ($this->request->isAJAX()) {
            $ingatnomor = $this->request->getPost('ingatnomor');

            $modelPengingat = new ModelPengingatTemp();
            $dataIngat = $modelPengingat->tampilDataIngat($ingatnomor);

            $data = [
                'tampildata' => $dataIngat
            ];

            $json = [
                'data' => view('pengingat/dataIngat', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // hapus item inget
    public function hapusItemIngat()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('ingatid');
            $modelPengingat = new ModelPengingat();
            $modelPengingat->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }


    // ambil data pengingat
    function ambilDataPengingat()
    {
        if ($this->request->isAJAX()) {
            $ingatid = $this->request->getPost('ingatid');

            $modelPengingat    = new ModelPengingat();
            $cekData        = $modelPengingat->find($ingatid);

            $modelBarang = new ModelBarang();
            $rowBarang = $modelBarang->find($cekData['ingatkode']);

            $modelBiodataKtp = new ModelBiodataKtp();
            $rowKtp = $modelBiodataKtp->find($cekData['ingatuser']);

            if ($cekData == null) {
                $json = [
                    'error' => 'Maaf, Data barang tidak ditemukan'
                ];
            } else {
                $data = [
                    'ingatkode'         => $rowBarang['brgkode'],
                    'namabarang'        => $rowBarang['brgnama'],
                    'ingatnomor'        => $cekData['ingatnomor'],
                    'ingatlocation'     => $cekData['ingatlocation'],
                    'ingatawal'         => $cekData['ingatawal'],
                    'ingatakhir'        => $cekData['ingatakhir'],
                    'ingatuser'         => $cekData['ingatuser'],
                    'ingatnama'         => $rowKtp['ktp_nama'],
                    'ingatketerangan'   => $cekData['ingatketerangan'],
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

    // edit data pengingat
    function editItemPengingat()
    {
        if ($this->request->isAJAX()) {
            $ingatid            = $this->request->getPost('ingatid');
            $ingatnomor         = $this->request->getPost('ingatnomor');
            $ingatawal          = $this->request->getPost('ingatawal');
            $ingatakhir         = $this->request->getPost('ingatakhir');
            $ingatuser          = $this->request->getPost('ingatuser');
            $ingatkode          = $this->request->getPost('ingatkode');
            $ingatlocation      = $this->request->getPost('ingatlocation');
            $ingatketerangan    = $this->request->getPost('ingatketerangan');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ingatawal'    => [
                    'label'     => 'Tanggal Awal',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ingatakhir'    => [
                    'label'     => 'Tanggal Akhir',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ingatuser'    => [
                    'label'     => 'User',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ingatkode'    => [
                    'label'     => 'Kode',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ingatlocation'    => [
                    'label'     => 'Lokasi',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errIngatAwal'      => $validation->getError('ingatawal'),
                        'errIngatAkhir'     => $validation->getError('ingatakhir'),
                        'errIngatUser'      => $validation->getError('ingatuser'),
                        'errIngatKode'      => $validation->getError('ingatkode'),
                        'errIngatLocation'  => $validation->getError('ingatlocation'),
                    ]
                ];
            } else {

                $modelPengingat = new ModelPengingat();

                $modelPengingat->update($ingatid, [
                    'ingatnomor'        => $ingatnomor,
                    'ingatkode'         => $ingatkode,
                    'ingatlocation'     => $ingatlocation,
                    'ingatawal'         => $ingatawal,
                    'ingatakhir'        => $ingatakhir,
                    'ingatuser'         => $ingatuser,
                    'ingatketerangan'   => $ingatketerangan
                ]);

                $json = [
                    'sukses' => 'Item berhasil dirubah'
                ];
            }

            echo json_encode($json);
        }
    }
}