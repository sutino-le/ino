<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangPagination;
use App\Models\ModelBiodataKtp;
use App\Models\ModelPemakaian;
use App\Models\ModelPemakaianDet;
use App\Models\ModelPemakaianDetPagination;
use App\Models\ModelPemakaianPagination;
use App\Models\ModelPemakaianTemp;
use Config\Services;

class Pemakaian extends BaseController
{
    public function index()
    {

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Pemakaian',
            'menu'          => 'pemakaian',
            'submenu'       => 'pemakaian',
        ];
        return view('pemakaian/viewdata', $data);
    }

    public function listData()
    {

        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelPemakaianPagination($request);
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

    // mebuat nomor pemakaian
    private function buatNomor()
    {
        $tanggalSekarang = date("Y-m-d");
        $pembelian = new ModelPemakaian();

        $hasil = $pembelian->noPakai($tanggalSekarang)->getRowArray();
        $data = $hasil['pmknomor'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noPakai = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noPakai;
    }

    // mebuat nomor pemakaian jika merubah tanggal
    public function buatNoPakai()
    {
        $tanggalSekarang = $this->request->getPost('tanggal');
        $pembelian = new ModelPemakaian();

        $hasil = $pembelian->noPakai($tanggalSekarang)->getRowArray();
        $data = $hasil['pmknomor'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noPakai = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);


        $json = [
            'pmknomor' => $noPakai
        ];

        echo json_encode($json);
    }

    // form input pemakaian
    public function forminput()
    {
        $data   = [
            'judul'     => 'Home',
            'subjudul'  => 'Input Pemakaian',
            'menu'      => 'pemakaian',
            'submenu'   => 'pemakaian',
            'pmknomor'  => $this->buatNomor()
        ];
        return view('pemakaian/forminput', $data);
    }

    // untuk menyimpan item pemakaian
    function simpanItem()
    {
        if ($this->request->isAJAX()) {
            $pmknomor       = $this->request->getPost('pmknomor');
            $pmkbrgkode     = $this->request->getPost('pmkbrgkode');
            $namabarang     = $this->request->getPost('namabarang');
            $brgstok        = $this->request->getPost('brgstok');
            $pmkjenis       = $this->request->getPost('pmkjenis');
            $pmkketerangan  = $this->request->getPost('pmkketerangan');
            $pmkjumlah      = $this->request->getPost('pmkjumlah');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'pmkbrgkode'    => [
                    'label'     => 'Kode Barang',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pmkjenis'    => [
                    'label'     => 'Jenis Pemakaian',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pmkketerangan'    => [
                    'label'     => 'Keterangan',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errPmkBrgKode'     => $validation->getError('pmkbrgkode'),
                        'errPmkJenis'       => $validation->getError('pmkjenis'),
                        'errPmkKeterangan'  => $validation->getError('pmkketerangan'),
                    ]
                ];
            } else {

                if ($brgstok == 0) {
                    $json = [
                        'error' => [
                            'errBrgStok'        => 'Stok Kosong',
                        ]
                    ];
                } else {
                    if ($brgstok < $pmkjumlah) {
                        $json = [
                            'error' => [
                                'errPmkJumlah'        => 'Stok terbatas',
                            ]
                        ];
                    } else {
                        $modelPemakaianTemp = new ModelPemakaianTemp();

                        $modelPemakaianTemp->insert([
                            'pmknomor'          => $pmknomor,
                            'pmkbrgkode'        => $pmkbrgkode,
                            'pmkjumlah'         => $pmkjumlah,
                            'pmkjenis'          => $pmkjenis,
                            'pmkketerangan'     => $pmkketerangan
                        ]);

                        $json = [
                            'sukses' => 'Item berhasil ditambahkan'
                        ];
                    }
                }
            }

            echo json_encode($json);
        }
    }

    // untuk menampilkan modal cari barang
    public function modalCariBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data'  => view('pemakaian/modalcaribarang')
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
            $pmkbrgkode = $this->request->getPost('pmkbrgkode');

            $modelBarang    = new ModelBarang();
            $cekData        = $modelBarang->find($pmkbrgkode);

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

    // untuk menampilkan data temp_pemakaian
    public function tampilDataTemp()
    {
        if ($this->request->isAJAX()) {
            $pmknomor = $this->request->getPost('pmknomor');

            $modelPemakaianTemp = new ModelPemakaianTemp();
            $dataTemp = $modelPemakaianTemp->tampilDataTemp($pmknomor);

            $data = [
                'tampildata' => $dataTemp
            ];

            $json = [
                'data' => view('pemakaian/datatemp', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // untuk menghaput item data temp
    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('pmkid');
            $ModelTempPemakaian = new ModelPemakaianTemp();
            $ModelTempPemakaian->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    // menyelesaikan form input pemakaian
    function selesaiPemakaian()
    {
        if ($this->request->isAJAX()) {
            $pmknomor   = $this->request->getPost('pmknomor');
            $pmktanggal = $this->request->getPost('pmktanggal');
            $pemakai    = $this->request->getPost('pemakai');
            $pmkuser    = $this->request->getPost('pmkuser');

            $modelTemp  = new ModelPemakaianTemp();

            $dataTemp   = $modelTemp->tampilDataTemp($pmknomor);

            if ($dataTemp->getNumRows() > 0) {
                // Simpan ke tabel pemakaian
                $modelPemakaian = new ModelPemakaian();

                $modelPemakaian->insert([
                    'nomor'         => $pmknomor,
                    'pmktanggal'    => $pmktanggal,
                    'pemakai'       => $pemakai,
                    'pmkuser'       => $pmkuser,
                ]);



                // simpan ke detail pemakaian
                $modelDetailPemakaian = new ModelPemakaianDet();
                foreach ($dataTemp->getResultArray() as $rowtemp) :
                    $modelDetailPemakaian->insert([
                        'pmknomor'      => $rowtemp['pmknomor'],
                        'pmkbrgkode'    => $rowtemp['pmkbrgkode'],
                        'pmkjumlah'     => $rowtemp['pmkjumlah'],
                        'pmkjenis'      => $rowtemp['pmkjenis'],
                        'pmkketerangan' => $rowtemp['pmkketerangan'],
                    ]);
                endforeach;

                // hapus temp pemakaian berdasarkan nomor
                $modelTemp->where(['pmknomor' => $pmknomor]);
                $modelTemp->delete();

                // $modelTemp->emptyTable();

                $json   = [
                    'sukses'  => 'Pemakaian berhasil disimpan'
                ];
            } else {
                $json = [
                    'error'  => 'Maaf, item belum ada'
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menghapus data');
        }
    }

    // untuk mencetak pemakaian
    public function cetakPemakaian($nomor)
    {
        $modelPemakaian = new ModelPemakaian();
        $modelDetail = new ModelPemakaianDet();
        $modelBiodata = new ModelBiodataKtp();

        $cekData = $modelPemakaian->find($nomor);
        $dataBiodata = $modelBiodata->find($cekData['pemakai']);

        $ktpnama = ($dataBiodata != null) ? $dataBiodata['ktp_nama'] : '-';
        if ($cekData != null) {
            $data = [
                'nomor'             => $nomor,
                'pmktanggal'        => $cekData['pmktanggal'],
                'ktpnama'           => $ktpnama,
                'detailpemakaian'      => $modelDetail->tampilDataDetail($nomor)
            ];

            return view('pemakaian/cetakPemakaian', $data);
        } else {
            return redirect()->to(site_url('pemakaian/forminput'));
        }
    }

    // untuk menghapus data pemakaian
    function hapusPemakaian()
    {
        if ($this->request->isAJAX()) {
            $nomor = $this->request->getPost('nomor');

            $modelDetail = new ModelPemakaianDet();
            $modelPemakaian = new ModelPemakaian();

            // hapus detail
            $modelDetail->where(['pmknomor' => $nomor]);
            $modelDetail->delete();
            $modelPemakaian->delete($nomor);

            $json = [
                'sukses' => 'Pemakaian berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    // untuk menampilkan form edit pemakaian
    public function edit($nomor)
    {
        $modelPemakaian = new ModelPemakaian();
        $rowData = $modelPemakaian->find($nomor);


        $modelBiodata = new ModelBiodataKtp();
        $rowBiodata = $modelBiodata->find($rowData['pemakai']);

        if ($rowData['pemakai'] == 0) {
            $ktpnama = '';
        } else {
            $ktpnama = $rowBiodata['ktp_nama'];
        }

        $data = [
            'judul'                 => 'Home',
            'subjudul'              => 'Edit Pemakaian',
            'menu'                  => 'pemakaian',
            'submenu'               => 'pemakaian',
            'nomor'                 => $nomor,
            'pmktanggal'            => $rowData['pmktanggal'],
            'pemakai'               => $rowData['pemakai'],
            'ktpnama'               => $ktpnama
        ];

        return view('pemakaian/formedit', $data);
    }

    // untuk tampil data detail
    public function tampilDataDetail()
    {
        if ($this->request->isAJAX()) {
            $nomor = $this->request->getPost('pmknomor');

            $modelDetailPemakaian = new ModelPemakaianDet();
            $dataDetail = $modelDetailPemakaian->tampilDataDetail($nomor);

            $data = [
                'tampildata' => $dataDetail
            ];

            $json = [
                'data' => view('pemakaian/datadetail', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // untuk menghapus detail
    function hapusItemDetail()
    {
        if ($this->request->isAJAX()) {
            $pmkid = $this->request->getPost('pmkid');
            $ModelDetailPemakaian = new ModelPemakaianDet();

            $ModelDetailPemakaian->delete($pmkid);


            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    // untuk mengedit item
    function editItem()
    {
        if ($this->request->isAJAX()) {
            $pmkid          = $this->request->getPost('pmkid');
            $pmknomor       = $this->request->getPost('pmknomor');
            $pmkbrgkode     = $this->request->getPost('pmkbrgkode');
            $namabarang     = $this->request->getPost('namabarang');
            $brgstok        = $this->request->getPost('brgstok');
            $pmkjenis       = $this->request->getPost('pmkjenis');
            $pmkketerangan  = $this->request->getPost('pmkketerangan');
            $pmkjumlah      = $this->request->getPost('pmkjumlah');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'pmkbrgkode'    => [
                    'label'     => 'Kode Barang',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pmkjenis'    => [
                    'label'     => 'Jenis Pemakaian',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pmkketerangan'    => [
                    'label'     => 'Keterangan',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errPmkBrgKode'     => $validation->getError('pmkbrgkode'),
                        'errPmkJenis'       => $validation->getError('pmkjenis'),
                        'errPmkKeterangan'  => $validation->getError('pmkketerangan'),
                    ]
                ];
            } else {

                if ($brgstok == 0) {
                    $json = [
                        'error' => [
                            'errBrgStok'        => 'Stok Kosong',
                        ]
                    ];
                } else {
                    if ($brgstok < $pmkjumlah) {
                        $json = [
                            'error' => [
                                'errPmkJumlah'        => 'Stok terbatas',
                            ]
                        ];
                    } else {
                        $modelPemakaianDet = new ModelPemakaianDet();

                        $modelPemakaianDet->update($pmkid, [
                            'pmknomor'          => $pmknomor,
                            'pmkbrgkode'        => $pmkbrgkode,
                            'pmkjumlah'         => $pmkjumlah,
                            'pmkjenis'          => $pmkjenis,
                            'pmkketerangan'     => $pmkketerangan
                        ]);

                        $json = [
                            'sukses' => 'Item berhasil diupdate'
                        ];
                    }
                }
            }

            echo json_encode($json);
        }
    }


    // untuk simpan item detail
    function simpanDetail()
    {
        if ($this->request->isAJAX()) {
            $pmknomor       = $this->request->getPost('pmknomor');
            $pmkbrgkode     = $this->request->getPost('pmkbrgkode');
            $namabarang     = $this->request->getPost('namabarang');
            $brgstok        = $this->request->getPost('brgstok');
            $pmkjenis       = $this->request->getPost('pmkjenis');
            $pmkketerangan  = $this->request->getPost('pmkketerangan');
            $pmkjumlah      = $this->request->getPost('pmkjumlah');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'pmkbrgkode'    => [
                    'label'     => 'Kode Barang',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pmkjenis'    => [
                    'label'     => 'Jenis Pemakaian',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pmkketerangan'    => [
                    'label'     => 'Keterangan',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errPmkBrgKode'     => $validation->getError('pmkbrgkode'),
                        'errPmkJenis'       => $validation->getError('pmkjenis'),
                        'errPmkKeterangan'  => $validation->getError('pmkketerangan'),
                    ]
                ];
            } else {

                if ($brgstok == 0) {
                    $json = [
                        'error' => [
                            'errBrgStok'        => 'Stok Kosong',
                        ]
                    ];
                } else {
                    if ($brgstok < $pmkjumlah) {
                        $json = [
                            'error' => [
                                'errPmkJumlah'        => 'Stok terbatas',
                            ]
                        ];
                    } else {
                        $modelPemakaianDet = new ModelPemakaianDet();

                        $modelPemakaianDet->insert([
                            'pmknomor'          => $pmknomor,
                            'pmkbrgkode'        => $pmkbrgkode,
                            'pmkjumlah'         => $pmkjumlah,
                            'pmkjenis'          => $pmkjenis,
                            'pmkketerangan'     => $pmkketerangan
                        ]);

                        $json = [
                            'sukses' => 'Item berhasil ditambahkan'
                        ];
                    }
                }
            }

            echo json_encode($json);
        }
    }

    // menampilkan data pemakaian
    public function datapemakaian()
    {

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Pemakaian',
            'menu'          => 'pemakaian',
            'submenu'       => 'datapemakaian',
        ];
        return view('pemakaian/datapemakaian', $data);
    }

    // untuk menampilkan data pemakaian
    public function listDataPemakai()
    {

        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelPemakaianDetPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                if (empty($list->detpgmjenis)) {
                    $status = "Belum";
                } else {
                    $status = "Sudah dan Kondisi : " . $list->detpgmjenis;
                }

                $row[] = $no;
                $row[] = $list->brgnama;
                $row[] = $list->subkatnama;
                $row[] = $list->pmktanggal;
                $row[] = $list->ktp_nama;
                $row[] = $list->pmkketerangan;
                $row[] = $status;
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
}