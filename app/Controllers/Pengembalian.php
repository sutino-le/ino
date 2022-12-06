<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangPagination;
use App\Models\ModelBiodataKtp;
use App\Models\ModelPemakaianCariPagination;
use App\Models\ModelPemakaianDet;
use App\Models\ModelPengembalian;
use App\Models\ModelPengembalianDet;
use App\Models\ModelPengembalianDetPagination;
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

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->pgmnomor . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->pgmnomor . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->pgmnomor . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->pgmnomor;
                $row[] = $list->pgmtanggal;
                $row[] = $list->ktp_nama;
                $row[] = $list->pgmuser;;
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

    // untuk menyimpan item Pengembalian
    function simpanItem()
    {
        if ($this->request->isAJAX()) {
            $pgmnomor       = $this->request->getPost('pgmnomor');
            $pgmbrgkode     = $this->request->getPost('pgmbrgkode');
            $pgmjenis       = $this->request->getPost('pgmjenis');
            $pgmketerangan  = $this->request->getPost('pgmketerangan');
            $pgmjumlah      = $this->request->getPost('pgmjumlah');
            $detpgmpmkid      = $this->request->getPost('detpgmpmkid');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'pgmbrgkode'    => [
                    'label'     => 'Kode Barang',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgmjumlah'    => [
                    'label'     => 'Jumlah',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgmjenis'    => [
                    'label'     => 'Jenis',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgmketerangan'    => [
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
                        'errPgmBrgKode'     => $validation->getError('pgmbrgkode'),
                        'errPgmJumlah'      => $validation->getError('pgmjumlah'),
                        'errPgmJenis'       => $validation->getError('pgmjenis'),
                        'errPgmKeterangan'  => $validation->getError('pgmketerangan'),
                    ]
                ];
            } else {


                $modelPengembalianTemp = new ModelPengembalianTemp();

                $modelPengembalianTemp->insert([
                    'detpgmnomor'          => $pgmnomor,
                    'detpgmbrgkode'        => $pgmbrgkode,
                    'detpgmjumlah'         => $pgmjumlah,
                    'detpgmjenis'          => $pgmjenis,
                    'detpgmketerangan'     => $pgmketerangan,
                    'detpgmpmkid'          => $detpgmpmkid
                ]);

                $json = [
                    'sukses' => 'Item berhasil ditambahkan'
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
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

    // untuk menghaput item data temp
    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $detpgmid = $this->request->getPost('detpgmid');
            $modelPengembalianTemp = new ModelPengembalianTemp();
            $modelPengembalianTemp->delete($detpgmid);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
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
        $datamodel = new ModelPemakaianCariPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->brgkode . "', '" . $list->pmkid . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";

                $row[] = $no;
                $row[] = $list->brgkode;
                $row[] = $list->brgnama;
                $row[] = date('d-M-Y', strtotime($list->pmktanggal));
                $row[] = number_format($list->pmkjumlah, 0, ",", ".");
                $row[] = $list->ktp_nama;
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

    // menyelesaikan form input pengembalian
    function selesaiPengembalian()
    {
        if ($this->request->isAJAX()) {
            $pgmnomor   = $this->request->getPost('pgmnomor');
            $pgmtanggal = $this->request->getPost('pgmtanggal');
            $pgmoleh    = $this->request->getPost('pgmoleh');
            $pgmuser    = $this->request->getPost('pgmuser');

            $modelTemp  = new ModelPengembalianTemp();

            $dataTemp   = $modelTemp->tampilDataTemp($pgmnomor);

            if ($dataTemp->getNumRows() > 0) {
                // Simpan ke tabel Pengembalian
                $modelPengembalian = new ModelPengembalian();

                $modelPengembalian->insert([
                    'pgmnomor'      => $pgmnomor,
                    'pgmtanggal'    => $pgmtanggal,
                    'pgmoleh'       => $pgmoleh,
                    'pgmuser'       => $pgmuser,
                ]);



                // simpan ke detail Pengembalian
                $modelDetailPengembalian = new ModelPengembalianDet();
                foreach ($dataTemp->getResultArray() as $rowtemp) :
                    $modelDetailPengembalian->insert([
                        'detpgmnomor'      => $rowtemp['detpgmnomor'],
                        'detpgmbrgkode'    => $rowtemp['detpgmbrgkode'],
                        'detpgmjumlah'     => $rowtemp['detpgmjumlah'],
                        'detpgmjenis'      => $rowtemp['detpgmjenis'],
                        'detpgmketerangan' => $rowtemp['detpgmketerangan'],
                        'detpgmpmkid'      => $rowtemp['detpgmpmkid'],
                    ]);
                endforeach;

                // hapus temp Pengembalian berdasarkan nomor
                $modelTemp->where(['detpgmnomor' => $pgmnomor]);
                $modelTemp->delete();

                // $modelTemp->emptyTable();

                $json   = [
                    'sukses'  => 'Pengembalian berhasil disimpan'
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

    // untuk mencetak pengembalian
    public function cetakPengembalian($pgmnomor)
    {
        $modelPengembalian = new ModelPengembalian();
        $modelDetail = new ModelPengembalianDet();
        $modelBiodata = new ModelBiodataKtp();

        $cekData = $modelPengembalian->find($pgmnomor);
        $dataBiodata = $modelBiodata->find($cekData['pgmoleh']);

        $ktpnama = ($dataBiodata != null) ? $dataBiodata['ktp_nama'] : '-';
        if ($cekData != null) {
            $data = [
                'pgmnomor'              => $pgmnomor,
                'pgmtanggal'            => $cekData['pgmtanggal'],
                'ktpnama'               => $ktpnama,
                'detailpengembalian'    => $modelDetail->tampilDataDetail($pgmnomor)
            ];

            return view('pengembalian/cetakPengembalian', $data);
        } else {
            return redirect()->to(site_url('pengembalian/forminput'));
        }
    }

    // untuk menghapus data pengembalian
    function hapusPengembalian()
    {
        if ($this->request->isAJAX()) {
            $pgmnomor = $this->request->getPost('pgmnomor');

            $modelDetail = new ModelPengembalianDet();
            $modelPengembalian = new ModelPengembalian();

            // hapus detail
            $modelDetail->where(['detpgmnomor' => $pgmnomor]);
            $modelDetail->delete();
            $modelPengembalian->delete($pgmnomor);

            $json = [
                'sukses' => 'Pengembalian berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    // untuk menampilkan form edit pengembalian
    public function edit($pgmnomor)
    {
        $modelPengembalian = new ModelPengembalian();
        $rowData = $modelPengembalian->find($pgmnomor);


        $modelBiodata = new ModelBiodataKtp();
        $rowBiodata = $modelBiodata->find($rowData['pgmoleh']);

        if ($rowData['pgmoleh'] == 0) {
            $ktpnama = '';
        } else {
            $ktpnama = $rowBiodata['ktp_nama'];
        }

        $data = [
            'judul'                 => 'Home',
            'subjudul'              => 'Edit Pengembalian',
            'menu'                  => 'pengembalian',
            'submenu'               => 'pengembalian',
            'pgmnomor'              => $pgmnomor,
            'pgmtanggal'            => $rowData['pgmtanggal'],
            'pgmoleh'               => $rowData['pgmoleh'],
            'ktpnama'               => $ktpnama
        ];

        return view('pengembalian/formedit', $data);
    }

    // untuk tampil data detail
    public function tampilDataDetail()
    {
        if ($this->request->isAJAX()) {
            $pgmnomor = $this->request->getPost('pgmnomor');

            $modelDetailPengembalian = new ModelPengembalianDet();
            $dataDetail = $modelDetailPengembalian->tampilDataDetail($pgmnomor);

            $data = [
                'tampildata' => $dataDetail
            ];

            $json = [
                'data' => view('pengembalian/datadetail', $data)
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
            $detpgmid = $this->request->getPost('detpgmid');
            $ModelDetailPengembalian = new ModelPengembalianDet();

            $ModelDetailPengembalian->delete($detpgmid);


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
            $detpgmid           = $this->request->getPost('detpgmid');
            $pgmnomor           = $this->request->getPost('pgmnomor');
            $pgmbrgkode         = $this->request->getPost('pgmbrgkode');
            $pgmjenis           = $this->request->getPost('pgmjenis');
            $pgmketerangan      = $this->request->getPost('pgmketerangan');
            $pgmjumlah          = $this->request->getPost('pgmjumlah');
            $detpgmpmkid        = $this->request->getPost('detpgmpmkid');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'pgmbrgkode'    => [
                    'label'     => 'Kode Barang',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgmjenis'    => [
                    'label'     => 'Jenis Pemakaian',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgmketerangan'    => [
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
                        'errPgmBrgKode'     => $validation->getError('pgmbrgkode'),
                        'errPgmJenis'       => $validation->getError('pgmjenis'),
                        'errPgmKeterangan'  => $validation->getError('pgmketerangan'),
                    ]
                ];
            } else {

                $modelPengembalianDet = new ModelPengembalianDet();

                $modelPengembalianDet->update($detpgmid, [
                    'detpgmnomor'          => $pgmnomor,
                    'detpgmbrgkode'        => $pgmbrgkode,
                    'detpgmjumlah'         => $pgmjumlah,
                    'detpgmjenis'          => $pgmjenis,
                    'detpgmketerangan'     => $pgmketerangan,
                    'detpgmpmkid'          => $detpgmpmkid
                ]);

                $json = [
                    'sukses' => 'Item berhasil diupdate'
                ];
            }

            echo json_encode($json);
        }
    }


    // untuk simpan item detail
    function simpanDetail()
    {
        if ($this->request->isAJAX()) {
            $pgmnomor       = $this->request->getPost('pgmnomor');
            $pgmbrgkode     = $this->request->getPost('pgmbrgkode');
            $pgmjenis       = $this->request->getPost('pgmjenis');
            $pgmketerangan  = $this->request->getPost('pgmketerangan');
            $pgmjumlah      = $this->request->getPost('pgmjumlah');
            $detpgmpmkid    = $this->request->getPost('detpgmpmkid');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'pgmbrgkode'    => [
                    'label'     => 'Kode Barang',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgmjenis'    => [
                    'label'     => 'Jenis Pemakaian',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'pgmketerangan'    => [
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
                        'errPgmBrgKode'     => $validation->getError('pgmbrgkode'),
                        'errPgmJenis'       => $validation->getError('pgmjenis'),
                        'errPgmKeterangan'  => $validation->getError('pgmketerangan'),
                    ]
                ];
            } else {
                $modelPengembalianDet = new ModelPengembalianDet();

                $modelPengembalianDet->insert([
                    'detpgmnomor'          => $pgmnomor,
                    'detpgmbrgkode'        => $pgmbrgkode,
                    'detpgmjumlah'         => $pgmjumlah,
                    'detpgmjenis'          => $pgmjenis,
                    'detpgmketerangan'     => $pgmketerangan,
                    'detpgmpmkid'          => $detpgmpmkid
                ]);

                $json = [
                    'sukses' => 'Item berhasil ditambahkan'
                ];
            }

            echo json_encode($json);
        }
    }

    // menyelesaikan form input pengembalian
    function selesaiPengembalianEdit()
    {
        if ($this->request->isAJAX()) {
            $pgmnomor   = $this->request->getPost('pgmnomor');

            $modelDet  = new ModelPengembalianDet();

            $dataDet   = $modelDet->tampilDataDet($pgmnomor);

            if ($dataDet->getNumRows() > 0) {
                $json   = [
                    'sukses'  => 'Pengembalian berhasil disimpan'
                ];
            } else {
                $json = [
                    'error'  => 'Maaf, item belum ada'
                ];
            }

            echo json_encode($json);
        }
    }

    // menampilkan data pengembalian
    public function datapengembalian()
    {

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Pengembalian',
            'menu'          => 'pengembalian',
            'submenu'       => 'datapengembalian',
        ];
        return view('pengembalian/datapengembalian', $data);
    }

    // untuk menampilkan data pengembalian
    public function listDataPengembalian()
    {

        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelPengembalianDetPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $row[] = $no;
                $row[] = $list->brgnama;
                $row[] = $list->subkatnama;
                $row[] = $list->pgmtanggal;
                $row[] = $list->ktp_nama;
                $row[] = $list->pgmuser;
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