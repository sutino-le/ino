<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBiodataKtp;
use App\Models\ModelPembelian;
use App\Models\ModelPengingat;
use App\Models\ModelPengingatDet;
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


                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->ingatnomor . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->ingatnomor . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->ingatnomor . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->ingatnomor;
                $row[] = $list->ingattanggal;
                $row[] = $list->ingatuser;
                $row[] = $tombolCetak . ' ' . $tombolHapus . ' ' . $tombolEdit;
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
            $pgtbrgkode = $this->request->getPost('pgtbrgkode');

            $modelBarang    = new ModelBarang();
            $cekData        = $modelBarang->find($pgtbrgkode);

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
            $ingatnomor         = $this->request->getPost('ingatnomor');
            $pgtbrgkode         = $this->request->getPost('pgtbrgkode');
            $pgtlocation        = $this->request->getPost('pgtlocation');
            $pgtawal            = $this->request->getPost('pgtawal');
            $pgtakhir           = $this->request->getPost('pgtakhir');
            $pgtuser            = $this->request->getPost('pgtuser');
            $pgtketerangan      = $this->request->getPost('pgtketerangan');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ingatnomor'    => [
                    'label'     => 'Nomor',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
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
                        'errIngatNomor'     => $validation->getError('ingatnomor'),
                        'errPgtBrgKode'     => $validation->getError('pgtbrgkode'),
                        'errPgtLocation'    => $validation->getError('pgtlocation'),
                        'errPgtAwal'        => $validation->getError('pgtawal'),
                        'errPgtAkhir'       => $validation->getError('pgtakhir'),
                        'errPgtUser'        => $validation->getError('pgtuser'),
                    ]
                ];
            } else {

                $modelPengingatTemp = new ModelPengingatTemp();

                $modelPengingatTemp->insert([
                    'pgtid'           => '',
                    'pgtnomor'        => $ingatnomor,
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
            $id = $this->request->getPost('pgtid');
            $modelPengingatTemp = new ModelPengingatTemp();
            $modelPengingatTemp->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    // menyelesaikan form input pengingat
    function selesaiPengingat()
    {
        if ($this->request->isAJAX()) {
            $ingatnomor   = $this->request->getPost('ingatnomor');
            $ingattanggal = $this->request->getPost('ingattanggal');
            $ingatuser    = $this->request->getPost('ingatuser');

            $modelTemp  = new ModelPengingatTemp();

            $dataTemp   = $modelTemp->tampilDataTemp($ingatnomor);

            if ($dataTemp->getNumRows() > 0) {
                // Simpan ke tabel pengingat
                $modelPengingat = new ModelPengingat();

                $modelPengingat->insert([
                    'ingatnomor'         => $ingatnomor,
                    'ingattanggal'    => $ingattanggal,
                    'ingatuser'       => $ingatuser,
                ]);



                // simpan ke detail pengingat
                $modelDetailPengingat = new ModelPengingatDet();
                foreach ($dataTemp->getResultArray() as $rowtemp) :
                    $modelDetailPengingat->insert([
                        'pgtnomor'          => $rowtemp['pgtnomor'],
                        'pgtbrgkode'        => $rowtemp['pgtbrgkode'],
                        'pgtlocation'       => $rowtemp['pgtlocation'],
                        'pgtawal'           => $rowtemp['pgtawal'],
                        'pgtakhir'          => $rowtemp['pgtakhir'],
                        'pgtuser'           => $rowtemp['pgtuser'],
                        'pgtstatus'         => $rowtemp['pgtstatus'],
                        'pgtketerangan'     => $rowtemp['pgtketerangan'],
                    ]);
                endforeach;

                // hapus temp pengingat berdasarkan nomor
                $modelTemp->where(['pgtnomor' => $ingatnomor]);
                $modelTemp->delete();

                // $modelTemp->emptyTable();

                $json   = [
                    'sukses'  => 'Pengingat berhasil disimpan'
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

    // hapus data pengingat
    function hapusTransaksi()
    {
        if ($this->request->isAJAX()) {
            $ingatnomor = $this->request->getPost('ingatnomor');

            $modelDetail = new ModelPengingatDet();
            $modelPengingat = new ModelPengingat();

            // hapus detail
            $modelDetail->where(['pgtnomor' => $ingatnomor]);
            $modelDetail->delete();
            $modelPengingat->delete($ingatnomor);

            $json = [
                'sukses' => 'Barang keluar berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    // untuk edit pengingat
    public function edit($ingatnomor)
    {
        $modelPengingat = new ModelPengingat();
        $rowData = $modelPengingat->find($ingatnomor);

        $data = [
            'judul'                 => 'Home',
            'subjudul'              => 'Edit Pengingat',
            'menu'                  => 'pengingat',
            'submenu'               => 'pengingat',
            'ingatnomor'            => $ingatnomor,
            'tanggal'               => $rowData['ingattanggal'],
            'ingatuser'             => $rowData['ingatuser'],
        ];

        return view('pengingat/formedit', $data);
    }

    // untuk menampilkan data pengingat detail
    public function tampilDataPengingatDet()
    {
        if ($this->request->isAJAX()) {
            $ingatnomor = $this->request->getPost('ingatnomor');

            $modelPengingat = new ModelPengingatDet();
            $dataIngat = $modelPengingat->tampilDataIngat($ingatnomor);

            $data = [
                'tampildata' => $dataIngat
            ];

            $json = [
                'data' => view('pengingat/datadetail', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // hapus item pengingat detail
    public function hapusItemIngatDetail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('pgtid');
            $modelPengingatTemp = new ModelPengingatDet();
            $modelPengingatTemp->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    // update item detail
    function editItem()
    {
        if ($this->request->isAJAX()) {
            $pgtid = $this->request->getPost('pgtid');
            $pgtbrgkode = $this->request->getPost('pgtbrgkode');
            $pgtlocation = $this->request->getPost('pgtlocation');
            $pgtawal = $this->request->getPost('pgtawal');
            $pgtakhir = $this->request->getPost('pgtakhir');
            $pgtuser = $this->request->getPost('pgtuser');
            $pgtketerangan = $this->request->getPost('pgtketerangan');

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

                $modelDetail = new ModelPengingatDet();

                //lakukan update pada detail
                $modelDetail->update($pgtid, [
                    'pgtbrgkode'    => $pgtbrgkode,
                    'pgtlocation'   => $pgtlocation,
                    'pgtawal'       => $pgtawal,
                    'pgtakhir'      => $pgtakhir,
                    'pgtuser'       => $pgtuser,
                    'pgtketerangan' => $pgtketerangan,
                ]);

                $json = [
                    'sukses' => 'Item berhasil di update'
                ];
            }

            echo json_encode($json);
        }
    }

    // untuk menyimpan Detail pengingat
    function simpanDetail()
    {
        if ($this->request->isAJAX()) {
            $ingatnomor         = $this->request->getPost('ingatnomor');
            $pgtbrgkode         = $this->request->getPost('pgtbrgkode');
            $pgtlocation        = $this->request->getPost('pgtlocation');
            $pgtawal            = $this->request->getPost('pgtawal');
            $pgtakhir           = $this->request->getPost('pgtakhir');
            $pgtuser            = $this->request->getPost('pgtuser');
            $pgtketerangan      = $this->request->getPost('pgtketerangan');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ingatnomor'    => [
                    'label'     => 'Nomor',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
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
                        'errIngatNomor'     => $validation->getError('ingatnomor'),
                        'errPgtBrgKode'     => $validation->getError('pgtbrgkode'),
                        'errPgtLocation'    => $validation->getError('pgtlocation'),
                        'errPgtAwal'        => $validation->getError('pgtawal'),
                        'errPgtAkhir'       => $validation->getError('pgtakhir'),
                        'errPgtUser'        => $validation->getError('pgtuser'),
                    ]
                ];
            } else {

                $modelPengingatDet = new ModelPengingatDet();

                $modelPengingatDet->insert([
                    'pgtid'           => '',
                    'pgtnomor'        => $ingatnomor,
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
}