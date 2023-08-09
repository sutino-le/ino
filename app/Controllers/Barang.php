<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangPagination;
use App\Models\ModelDetailPembelian;
use App\Models\ModelKategori;
use App\Models\ModelPemakaianDet;
use App\Models\ModelPembelian;
use App\Models\ModelPenerimaan;
use App\Models\ModelPengembalianDet;
use App\Models\ModelSatuan;
use App\Models\ModelSubKategori;
use Config\Services;

class Barang extends BaseController
{


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Barang',
            'menu'          => 'masterbarang',
            'submenu'       => 'barang',
        ];
        return view('barang/viewdata', $data);
    }


    public function listData()
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

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->brgkode . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->brgkode . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolDetail = "<button type=\"button\" class=\"btn btn-sm btn-success\" onclick=\"detail('" . $list->brgkode . "')\" title=\"Detail\"><i class='fas fa-search'></i></button>";


                // if ($list->brgsatid == "") {
                //     $tomboleditsatuan = $tombolEdit;
                //     $tombolhapussatuan = $tombolHapus;
                // } else {
                //     $tomboleditsatuan = "";
                //     $tombolhapussatuan = "";
                // }

                $row[] = $no;
                $row[] = $list->brgnama;
                $row[] = $list->katnama;
                $row[] = $list->subkatnama;
                $row[] = $list->satinisial;
                $row[] = $list->brgharga;
                $row[] = $list->brgstok;
                $row[] = $tombolEdit . ' ' . $tombolHapus . ' ' . $tombolDetail;
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

        $modelKategori = new ModelKategori();
        $modelSubKategori = new ModelSubKategori();
        $modelSatuan = new ModelSatuan();

        $data = [
            'kategori'      => $modelKategori->findAll(),
            'subkategori'   => $modelSubKategori->findAll(),
            'satuan'        => $modelSatuan->findAll(),
        ];

        $json = [
            'data' => view('barang/modaltambah', $data)
        ];

        echo json_encode($json);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'brgnama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama Barang',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'brgkatid' => [
                    'rules'     => 'required',
                    'label'     => 'Kategori',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'brgsubkatid' => [
                    'rules'     => 'required',
                    'label'     => 'Sub Kategori',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'brgsatid' => [
                    'rules'     => 'required',
                    'label'     => 'Satuan',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'brgharga' => [
                    'rules'     => 'required',
                    'label'     => 'Harga',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errBrgNama'        => $validation->getError('brgnama'),
                        'errBrgKategori'    => $validation->getError('brgkatid'),
                        'errBrgSubKategori' => $validation->getError('brgsubkatid'),
                        'errBrgSatuan'      => $validation->getError('brgsatid'),
                        'errBrgHarga'       => $validation->getError('brgharga'),
                    ]
                ];
            } else {

                $modelBarang = new ModelBarang();
                $modelBarang->insert([
                    'brgnama'               => $this->request->getPost('brgnama'),
                    'brgkatid'              => $this->request->getPost('brgkatid'),
                    'brgsubkatid'           => $this->request->getPost('brgsubkatid'),
                    'brgsatid'              => $this->request->getPost('brgsatid'),
                    'brgkapasitas'          => $this->request->getPost('brgkapasitas'),
                    'brgpanjang'            => $this->request->getPost('brgpanjang'),
                    'brglebar'              => $this->request->getPost('brglebar'),
                    'brgtinggi'             => $this->request->getPost('brgtinggi'),
                    'brgharga'              => $this->request->getPost('brgharga'),
                    'brggambar'             => '',
                    'brgstok'               => '0',
                ]);

                $json = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }

    public function formedit($brgkode)
    {

        $modelBarang = new ModelBarang();
        $modelKategori = new ModelKategori();
        $modelSubKategori = new ModelSubKategori();
        $modelSatuan = new ModelSatuan();


        $cekBarang = $modelBarang->find($brgkode);
        $cekKategori = $modelKategori->find($cekBarang['brgkatid']);
        $cekSubKategori = $modelSubKategori->find($cekBarang['brgsubkatid']);
        $cekSatuan = $modelSatuan->find($cekBarang['brgsatid']);


        $data = [
            'brgkode'             => $cekBarang['brgkode'],
            'brgnama'           => $cekBarang['brgnama'],
            'brgkatid'          => $cekBarang['brgkatid'],
            'brgkatnama'        => $cekKategori['katnama'],
            'brgsubkatid'       => $cekBarang['brgsubkatid'],
            'brgsubkatnama'     => $cekSubKategori['subkatnama'],
            'brgsatid'          => $cekBarang['brgsatid'],
            'brgsatnama'        => $cekSatuan['satnama'],
            'brgkapasitas'      => $cekBarang['brgkapasitas'],
            'brgpanjang'        => $cekBarang['brgpanjang'],
            'brglebar'          => $cekBarang['brglebar'],
            'brgtinggi'         => $cekBarang['brgtinggi'],
            'brgharga'          => $cekBarang['brgharga'],
            'brggambar'         => $cekBarang['brggambar'],
            'brgstok'           => $cekBarang['brgstok'],
            'kategori'          => $modelKategori->findAll(),
            'subkategori'       => $modelSubKategori->findAll(),
            'satuan'            => $modelSatuan->findAll(),
        ];

        $json = [
            'data' => view('barang/modaledit', $data)
        ];

        echo json_encode($json);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $brgkode        = $this->request->getPost('brgkode');
            $brgnama        = $this->request->getPost('brgnama');
            $brgkatid       = $this->request->getPost('brgkatid');
            $brgsubkatid    = $this->request->getPost('brgsubkatid');
            $brgsatid       = $this->request->getPost('brgsatid');
            $brgkapasitas   = $this->request->getPost('brgkapasitas');
            $brgpanjang     = $this->request->getPost('brgpanjang');
            $brglebar       = $this->request->getPost('brglebar');
            $brgtinggi      = $this->request->getPost('brgtinggi');
            $brgharga       = $this->request->getPost('brgharga');


            $modelBarang = new ModelBarang();

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'brgnama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama Barang',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'brgkatid' => [
                    'rules'     => 'required',
                    'label'     => 'Kategori',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'brgsubkatid' => [
                    'rules'     => 'required',
                    'label'     => 'Sub Kategori',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'brgsatid' => [
                    'rules'     => 'required',
                    'label'     => 'Satuan',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'brgharga' => [
                    'rules'     => 'required',
                    'label'     => 'Harga',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errBrgNama'        => $validation->getError('brgnama'),
                        'errBrgKategori'    => $validation->getError('brgkatid'),
                        'errBrgSubKategori' => $validation->getError('brgsubkatid'),
                        'errBrgSatuan'      => $validation->getError('brgsatid'),
                        'errBrgHarga'       => $validation->getError('brgharga'),
                    ]
                ];
            } else {

                $modelBarang->update($brgkode, [
                    'brgnama'               => $brgnama,
                    'brgkatid'              => $brgkatid,
                    'brgsubkatid'           => $brgsubkatid,
                    'brgsatid'              => $brgsatid,
                    'brgkapasitas'          => $brgkapasitas,
                    'brgpanjang'            => $brgpanjang,
                    'brglebar'              => $brglebar,
                    'brgtinggi'             => $brgtinggi,
                    'brgharga'              => $brgharga
                ]);

                $json = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }

            echo json_encode($json);
        }
    }

    public function hapusdata($brgkode)
    {

        $modelBarang = new ModelBarang();

        $modelBarang->delete($brgkode);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }

    public function datadetail($brgkode)
    {

        $modelBarang = new ModelBarang();
        $modelKategori = new ModelKategori();
        $modelSubKategori = new ModelSubKategori();
        $modelSatuan = new ModelSatuan();

        // ngambil data penerimaan atau TTB
        $modelPenerimaan = new ModelPenerimaan();
        $cekPenerimaan = $modelPenerimaan->penerimaanBarang($brgkode);

        // ngambil data pemakaian
        $modelPemakaian = new ModelPemakaianDet();
        $cekPemakaian = $modelPemakaian->pemakaianBarang($brgkode);

        // ngambil data pengembalian
        $modelPengembalian = new ModelPengembalianDet();
        $cekPengembalian = $modelPengembalian->pengembalianBarang($brgkode);


        $cekBarang = $modelBarang->find($brgkode);
        $cekKategori = $modelKategori->find($cekBarang['brgkatid']);
        $cekSubKategori = $modelSubKategori->find($cekBarang['brgsubkatid']);
        $cekSatuan = $modelSatuan->find($cekBarang['brgsatid']);


        $data = [
            'brgkode'             => $cekBarang['brgkode'],
            'brgnama'           => $cekBarang['brgnama'],
            'brgkatid'          => $cekBarang['brgkatid'],
            'brgkatnama'        => $cekKategori['katnama'],
            'brgsubkatid'       => $cekBarang['brgsubkatid'],
            'brgsubkatnama'     => $cekSubKategori['subkatnama'],
            'brgsatid'          => $cekBarang['brgsatid'],
            'brgsatnama'        => $cekSatuan['satnama'],
            'brgkapasitas'      => $cekBarang['brgkapasitas'],
            'brgpanjang'        => $cekBarang['brgpanjang'],
            'brglebar'          => $cekBarang['brglebar'],
            'brgtinggi'         => $cekBarang['brgtinggi'],
            'brgharga'          => $cekBarang['brgharga'],
            'brggambar'         => $cekBarang['brggambar'],
            'brgstok'           => $cekBarang['brgstok'],
            'kategori'          => $modelKategori->findAll(),
            'subkategori'       => $modelSubKategori->findAll(),
            'satuan'            => $modelSatuan->findAll(),
            'datapenerimaan'    => $cekPenerimaan,
            'datapemakaian'     => $cekPemakaian,
            'datapengembalian'  => $cekPengembalian,
        ];

        $json = [
            'data' => view('barang/modaldetail', $data)
        ];

        echo json_encode($json);
    }
}
