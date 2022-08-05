<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\Modelbarangmasuk;
use App\Models\ModelBarangPagination;
use App\Models\ModelDetailPembelian;
use App\Models\ModelPembelian;
use App\Models\ModelPembelianPagination;
use App\Models\ModelSuplier;
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

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'kodebarang'    => [
                    'label'     => 'Kode Barang',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'hargabeli'    => [
                    'label'     => 'Harga Beli',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKodeBarang'      => $validation->getError('kodebarang'),
                        'errHargaBeli'      => $validation->getError('hargabeli'),
                    ]
                ];
            } else {


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
            }

            echo json_encode($json);
        }
    }


    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('iddetail');
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


    function modalPembayaran()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $idsuplier = $this->request->getPost('idsuplier');
            $totalharga = $this->request->getPost('totalharga');

            $modelTemp = new ModelTempPembelian();

            $cekdata = $modelTemp->tampilDataTemp($nofaktur);

            if ($cekdata->getNumRows() > 0) {
                $data = [
                    'nofaktur'      => $nofaktur,
                    'tglfaktur'     => $tglfaktur,
                    'idsuplier'     => $idsuplier,
                    'totalharga'    => $totalharga
                ];

                $json = [
                    'data'  => view('pembelian/modalpembayaran', $data)
                ];
            } else {
                $json = [
                    'error'  => 'Maaf, item belum ada'
                ];
            }

            echo json_encode($json);
        }
    }

    function simpanPembayaran()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $idsuplier = $this->request->getPost('idsuplier');
            $totalbayar = str_replace(".", "", $this->request->getPost('totalbayar'));
            $jumlahuang = str_replace(".", "", $this->request->getPost('jumlahuang'));
            $sisauang = str_replace(".", "", $this->request->getPost('sisauang'));

            $ModelPembelian = new ModelPembelian();

            //simpan ke table barang keluar
            $ModelPembelian->insert([
                'faktur'        => $nofaktur,
                'tglfaktur'     => $tglfaktur,
                'idsup'         => $idsuplier,
                'totalharga'    => $totalbayar,
                'jumlahuang'    => $jumlahuang,
                'sisauang'      => $sisauang
            ]);

            $modelTemp      = new ModelTempPembelian();
            $dataTemp       = $modelTemp->getWhere(['detfaktur' => $nofaktur]);

            $fieldDetail = [];
            foreach ($dataTemp->getResultArray() as $row) {
                $fieldDetail[] = [
                    'detfaktur'     => $row['detfaktur'],
                    'detbrgkode'    => $row['detbrgkode'],
                    'dethargamasuk' => $row['dethargamasuk'],
                    'dethargajual'  => $row['dethargajual'],
                    'detjml'        => $row['detjml'],
                    'detsubtotal'   => $row['detsubtotal']
                ];
            }

            $modelDetail = new ModelDetailPembelian();
            $modelDetail->insertBatch($fieldDetail);


            // hapus temp barang masuk berdasarkan faktur
            $modelTemp->where(['detfaktur' => $nofaktur]);
            $modelTemp->delete();

            $json = [
                'sukses'        => 'Transaksi berhasil disimpan',
                'cetakfaktur'   => site_url('pembelian/cetakfaktur/' . $nofaktur)
            ];

            echo json_encode($json);
        }
    }

    public function cetakFaktur($faktur)
    {
        $ModelPembelian = new ModelPembelian();
        $modelDetail = new ModelDetailPembelian();
        $ModelSuplier = new ModelSuplier();

        $cekData = $ModelPembelian->find($faktur);
        $dataSuplier = $ModelSuplier->find($cekData['idsup']);

        $namaSuplier = ($dataSuplier != null) ? $dataSuplier['supnama'] : '-';
        if ($cekData != null) {
            $data = [
                'faktur'            => $faktur,
                'tanggal'           => $cekData['tglfaktur'],
                'namasuplier'       => $namaSuplier,
                'jumlahuang'        => $cekData['jumlahuang'],
                'sisauang'          => $cekData['sisauang'],
                'detailbarang'      => $modelDetail->tampilDataDetail($faktur)
            ];

            return view('pembelian/cetakfaktur', $data);
        } else {
            return redirect()->to(site_url('pembelian/input'));
        }
    }


    function hapusTransaksi()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');

            $modelDetail = new ModelDetailPembelian();
            $ModelPembelian = new ModelPembelian();

            // hapus detail
            $modelDetail->where(['detfaktur' => $faktur]);
            $modelDetail->delete();
            $ModelPembelian->delete($faktur);

            $json = [
                'sukses' => 'Barang keluar berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    public function edit($faktur)
    {
        $ModelPembelian = new ModelPembelian();
        $rowData = $ModelPembelian->find($faktur);


        $modelSuplier = new ModelSuplier();
        $rowSuplier = $modelSuplier->find($rowData['idsup']);

        if ($rowData['idsup'] == 0) {
            $suplier = '';
        } else {
            $suplier = $rowSuplier['supnama'];
        }

        $data = [
            'judul'                 => 'Home',
            'subjudul'              => 'Edit Faktur Pembelian',
            'nofaktur'              => $faktur,
            'tanggal'               => $rowData['tglfaktur'],
            'namasuplier'           => $suplier
        ];

        return view('pembelian/formedit', $data);
    }

    function ambilTotalHarga()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modelDetail = new ModelDetailPembelian();

            $totalHarga = $modelDetail->ambilTotalHarga($nofaktur);

            $json = [
                'totalharga' => "Rp. " . number_format($totalHarga, 0, ",", ".")
            ];

            echo json_encode($json);
        }
    }

    public function tampilDataDetail()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modelDetailPembelian = new ModelDetailPembelian();
            $dataDetail = $modelDetailPembelian->tampilDataDetail($nofaktur);

            $data = [
                'tampildata' => $dataDetail
            ];

            $json = [
                'data' => view('pembelian/datadetail', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    function hapusItemDetail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('iddetail');
            $ModelDetailPembelian = new ModelDetailPembelian();
            $ModelPembelian = new ModelPembelian();

            $rowData = $ModelDetailPembelian->find($id);
            $noFaktur = $rowData['detfaktur'];

            $ModelDetailPembelian->delete($id);

            $totalHarga = $ModelDetailPembelian->ambilTotalHarga($noFaktur);

            //Lakukan update total di tabel pembelian
            $ModelPembelian->update($noFaktur, [
                'totalharga' => $totalHarga
            ]);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    function editItem()
    {
        if ($this->request->isAJAX()) {
            $iddetail = $this->request->getPost('iddetail');
            $jml = $this->request->getPost('jml');
            $hargabeli = $this->request->getPost('hargabeli');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'iddetail'    => [
                    'label'     => 'Kode Barang',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'hargabeli'    => [
                    'label'     => 'Harga Beli',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errIdDetail'      => $validation->getError('iddetail'),
                        'errHargaBeli'      => $validation->getError('hargabeli'),
                    ]
                ];
            } else {

                $modelDetail = new ModelDetailPembelian();
                $modelPembelian = new ModelPembelian();

                $rowData = $modelDetail->find($iddetail);
                $noFaktur = $rowData['detfaktur'];

                //lakukan update pada detail
                $modelDetail->update($iddetail, [
                    'dethargamasuk' => $hargabeli,
                    'detjml' => $jml,
                    'detsubtotal' => $hargabeli * $jml
                ]);

                //ambil total harga
                $totalHarga = $modelDetail->ambilTotalHarga($noFaktur);
                //update pembelian
                $modelPembelian->update($noFaktur, [
                    'totalharga' => $totalHarga
                ]);

                $json = [
                    'sukses' => 'Item berhasil di update'
                ];
            }

            echo json_encode($json);
        }
    }

    function simpanDetail()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargabeli = $this->request->getPost('hargabeli');
            $hargajual = $this->request->getPost('hargajual');
            $jml = $this->request->getPost('jml');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'kodebarang'    => [
                    'label'     => 'Kode Barang',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'hargabeli'    => [
                    'label'     => 'Harga Beli',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKodeBarang'      => $validation->getError('kodebarang'),
                        'errHargaBeli'      => $validation->getError('hargabeli'),
                    ]
                ];
            } else {

                $modelPembelian = new ModelPembelian();
                $modalDetailPembelian = new ModelDetailPembelian();

                $modalDetailPembelian->insert([
                    'detfaktur'     => $nofaktur,
                    'detbrgkode'    => $kodebarang,
                    'dethargamasuk' => $hargabeli,
                    'dethargajual'  => $hargajual,
                    'detjml'        => $jml,
                    'detsubtotal'   => $jml * $hargabeli
                ]);

                //ambil total harga
                $totalHarga = $modalDetailPembelian->ambilTotalHarga($nofaktur);
                //update pembelian
                $modelPembelian->update($nofaktur, [
                    'totalharga' => $totalHarga
                ]);

                $json = [
                    'sukses' => 'Item berhasil ditambahkan'
                ];
            }

            echo json_encode($json);
        }
    }
}
