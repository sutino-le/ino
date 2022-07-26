<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangPagination;
use App\Models\ModelKategori;
use App\Models\ModelPembelian;
use App\Models\ModelSatuan;
use App\Models\ModelSubKategori;
use Config\Services;

class Barang extends BaseController
{

    public function __construct()
    {
        $this->barang = new ModelBarang();
        $this->kategori = new ModelKategori();
        $this->subkategori = new ModelSubKategori();
        $this->satuan = new ModelSatuan();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Barang',
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
                $row[] = $list->satnama;
                $row[] = $list->brgharga;
                $row[] = $list->brgstok;
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


    public function formtambah()
    {
        $data = [
            'kategori'      => $this->kategori->findAll(),
            'subkategori'   => $this->subkategori->findAll(),
            'satuan'        => $this->satuan->findAll(),
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
                $this->barang->insert([
                    'brgnama'               => $this->request->getPost('brgnama'),
                    'brgkatid'              => $this->request->getPost('brgkatid'),
                    'brgsubkatid'           => $this->request->getPost('brgsubkatid'),
                    'brgsatid'              => $this->request->getPost('brgsatid'),
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
        $cekBarang = $this->barang->find($brgkode);
        $cekKategori = $this->kategori->find($cekBarang['brgkatid']);
        $cekSubKategori = $this->subkategori->find($cekBarang['brgsubkatid']);
        $cekSatuan = $this->satuan->find($cekBarang['brgsatid']);


        $data = [
            'brgkode'             => $cekBarang['brgkode'],
            'brgnama'           => $cekBarang['brgnama'],
            'brgkatid'          => $cekBarang['brgkatid'],
            'brgkatnama'        => $cekKategori['katnama'],
            'brgsubkatid'       => $cekBarang['brgsubkatid'],
            'brgsubkatnama'     => $cekSubKategori['subkatnama'],
            'brgsatid'          => $cekBarang['brgsatid'],
            'brgsatnama'        => $cekSatuan['satnama'],
            'brgharga'          => $cekBarang['brgharga'],
            'brggambar'         => $cekBarang['brggambar'],
            'brgstok'           => $cekBarang['brgstok'],
            'kategori'          => $this->kategori->findAll(),
            'subkategori'       => $this->subkategori->findAll(),
            'satuan'            => $this->satuan->findAll(),
        ];

        $json = [
            'data' => view('barang/modaledit', $data)
        ];

        echo json_encode($json);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $brgkode          = $this->request->getPost('brgkode');
            $brgnama        = $this->request->getPost('brgnama');
            $brgkatid       = $this->request->getPost('brgkatid');
            $brgsubkatid    = $this->request->getPost('brgsubkatid');
            $brgsatid       = $this->request->getPost('brgsatid');
            $brgharga       = $this->request->getPost('brgharga');

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

                $this->barang->update($brgkode, [
                    'brgnama'               => $brgnama,
                    'brgkatid'              => $brgkatid,
                    'brgsubkatid'           => $brgsubkatid,
                    'brgsatid'              => $brgsatid,
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
        $this->barang->delete($brgkode);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}
