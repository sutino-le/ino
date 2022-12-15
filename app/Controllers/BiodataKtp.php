<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBiodataKtp;
use App\Models\ModelBiodataKtpNamaPagination;
use App\Models\ModelBiodataKtpPagination;
use App\Models\ModelLowongan;
use App\Models\ModelLowonganApply;
use App\Models\ModelPemakaian;
use App\Models\ModelPengembalian;
use App\Models\ModelPsikotest;
use App\Models\ModelUsers;
use App\Models\ModelUsersUpdate;
use App\Models\ModelWilayah;
use Config\Services;

class BiodataKtp extends BaseController
{
    public function __construct()
    {
        $this->biodataktp    = new ModelBiodataKtp();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Biodata KTP',
            'menu'          => 'biodata',
            'submenu'       => 'ktp',
        ];
        return view('biodataktp/viewdata', $data);
    }


    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelBiodataKtpPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->ktp_nomor . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->ktp_nomor . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                $row[] = $no;
                $row[] = $list->ktp_nama . '<br>' . $list->ktp_nomor;
                $row[] = $list->ktp_tempat_lahir . '<br>' . $list->ktp_tanggal_lahir;
                $row[] = $list->ktp_kelamin;
                $row[] = $list->ktp_alamat . ' RT/RW ' . $list->ktp_rt . '/' . $list->ktp_rw . ', Kel. ' . $list->kelurahan . ', Kec. ' . $list->kecamatan . ' - ' . $list->kota_kabupaten . ' - ' . $list->propinsi;
                $row[] = $list->ktp_hp;
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
            'judul'         => 'Home',
            'subjudul'      => 'Biodata KTP - Input',
            'menu'          => 'biodata',
            'submenu'       => 'ktp',
        ];

        return view('biodataktp/formtambah', $data);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $ktp_nomor          = $this->request->getPost('ktp_nomor');
            $ktp_nama           = $this->request->getPost('ktp_nama');
            $ktp_tempat_lahir   = $this->request->getPost('ktp_tempat_lahir');
            $ktp_tanggal_lahir  = $this->request->getPost('ktp_tanggal_lahir');
            $ktp_kelamin        = $this->request->getPost('ktp_kelamin');
            $ktp_alamat         = $this->request->getPost('ktp_alamat');
            $ktp_rt             = $this->request->getPost('ktp_rt');
            $ktp_rw             = $this->request->getPost('ktp_rw');
            $ktp_alamatid       = $this->request->getPost('ktp_alamatid');
            $ktp_hp             = $this->request->getPost('ktp_hp');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ktp_nomor' => [
                    'rules'     => 'required',
                    'label'     => 'Nomor KTP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_nama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama Lengkap',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_tempat_lahir' => [
                    'rules'     => 'required',
                    'label'     => 'Tempat Lahir',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_tanggal_lahir' => [
                    'rules'     => 'required',
                    'label'     => 'Tanggal Lahir',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_kelamin' => [
                    'rules'     => 'required',
                    'label'     => 'Jenis Kelamin',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_alamat' => [
                    'rules'     => 'required',
                    'label'     => 'Alamat',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_rt' => [
                    'rules'     => 'required',
                    'label'     => 'RT',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_rw' => [
                    'rules'     => 'required',
                    'label'     => 'RW',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kelurahan' => [
                    'rules'     => 'required',
                    'label'     => 'Kelurahan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kecamatan' => [
                    'rules'     => 'required',
                    'label'     => 'Daerah',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kota_kabupaten' => [
                    'rules'     => 'required',
                    'label'     => 'Kota / Kabupaten',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'propinsi' => [
                    'rules'     => 'required',
                    'label'     => 'Propinsi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_alamatid' => [
                    'rules'     => 'required',
                    'label'     => 'Daerah',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_hp' => [
                    'rules'     => 'required',
                    'label'     => 'Nomor HP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKtpNomor'           => $validation->getError('ktp_nomor'),
                        'errKtpNama'            => $validation->getError('ktp_nama'),
                        'errKtpTempatLahir'     => $validation->getError('ktp_tempat_lahir'),
                        'errKtpTanggalLahir'    => $validation->getError('ktp_tanggal_lahir'),
                        'errKtpKelamin'         => $validation->getError('ktp_kelamin'),
                        'errKtpAlamat'          => $validation->getError('ktp_alamat'),
                        'errKtpRt'              => $validation->getError('ktp_rt'),
                        'errKtpRw'              => $validation->getError('ktp_rw'),
                        'errKelurahan'        => $validation->getError('kelurahan'),
                        'errKecamatan'        => $validation->getError('kecamatan'),
                        'errKotaKabupaten'        => $validation->getError('kota_kabupaten'),
                        'errPropinsi'        => $validation->getError('propinsi'),
                        'errKtpAlamatId'        => $validation->getError('ktp_alamatid'),
                        'errKtpHp'              => $validation->getError('ktp_hp'),
                    ]
                ];
            } else {

                $modelBiodata = new Modelbiodataktp();

                $modelBiodata->insert([
                    'ktp_nomor'         => $ktp_nomor,
                    'ktp_nama'          => $ktp_nama,
                    'ktp_tempat_lahir'  => $ktp_tempat_lahir,
                    'ktp_tanggal_lahir' => $ktp_tanggal_lahir,
                    'ktp_kelamin'       => $ktp_kelamin,
                    'ktp_alamat'        => $ktp_alamat,
                    'ktp_rt'            => $ktp_rt,
                    'ktp_rw'            => $ktp_rw,
                    'ktp_alamatid'      => $ktp_alamatid,
                    'ktp_hp'            => $ktp_hp,
                    'ktp_foto'          => ''
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }

    public function edit($ktp_nomor)
    {
        $modelBiodata = new ModelBiodataKtp();
        $cekData        = $modelBiodata->find($ktp_nomor);

        $modelWilayah = new ModelWilayah();
        $rowWilayah = $modelWilayah->find($cekData['ktp_alamatid']);

        if ($rowWilayah > 0) {

            $data = [
                'judul'                 => 'Home',
                'subjudul'              => 'Edit Biodata KTP',
                'menu'                  => 'biodata',
                'submenu'               => 'ktp',
                'ktp_nomor'             => $cekData['ktp_nomor'],
                'ktp_nama'              => $cekData['ktp_nama'],
                'ktp_tempat_lahir'      => $cekData['ktp_tempat_lahir'],
                'ktp_tanggal_lahir'     => $cekData['ktp_tanggal_lahir'],
                'ktp_kelamin'           => $cekData['ktp_kelamin'],
                'ktp_alamat'            => $cekData['ktp_alamat'],
                'ktp_rt'                => $cekData['ktp_rt'],
                'ktp_rw'                => $cekData['ktp_rw'],
                'ktp_alamatid'          => $cekData['ktp_alamatid'],
                'ktp_hp'                => $cekData['ktp_hp'],
                'kelurahan'             => $rowWilayah['kelurahan'],
                'kecamatan'             => $rowWilayah['kecamatan'],
                'kota_kabupaten'        => $rowWilayah['kota_kabupaten'],
                'propinsi'              => $rowWilayah['propinsi']
            ];
        } else {
            $data = [
                'judul'                 => 'Home',
                'subjudul'              => 'Edit Biodata KTP',
                'menu'                  => 'biodata',
                'submenu'               => 'ktp',
                'ktp_nomor'             => $cekData['ktp_nomor'],
                'ktp_nama'              => $cekData['ktp_nama'],
                'ktp_tempat_lahir'      => $cekData['ktp_tempat_lahir'],
                'ktp_tanggal_lahir'     => $cekData['ktp_tanggal_lahir'],
                'ktp_kelamin'           => $cekData['ktp_kelamin'],
                'ktp_alamat'            => $cekData['ktp_alamat'],
                'ktp_rt'                => $cekData['ktp_rt'],
                'ktp_rw'                => $cekData['ktp_rw'],
                'ktp_alamatid'          => $cekData['ktp_alamatid'],
                'ktp_hp'                => $cekData['ktp_hp'],
                'kelurahan'             => '',
                'kecamatan'             => '',
                'kota_kabupaten'        => '',
                'propinsi'              => ''
            ];
        }

        return view('biodataktp/formedit', $data);
    }



    public function update()
    {
        if ($this->request->isAJAX()) {
            $ktp_nomor_lama     = $this->request->getPost('ktp_nomor_lama');
            $ktp_nomor          = $this->request->getPost('ktp_nomor');
            $ktp_nama           = $this->request->getPost('ktp_nama');
            $ktp_tempat_lahir   = $this->request->getPost('ktp_tempat_lahir');
            $ktp_tanggal_lahir  = $this->request->getPost('ktp_tanggal_lahir');
            $ktp_kelamin        = $this->request->getPost('ktp_kelamin');
            $ktp_alamat         = $this->request->getPost('ktp_alamat');
            $ktp_rt             = $this->request->getPost('ktp_rt');
            $ktp_rw             = $this->request->getPost('ktp_rw');
            $ktp_alamatid       = $this->request->getPost('ktp_alamatid');
            $ktp_hp             = $this->request->getPost('ktp_hp');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ktp_nomor' => [
                    'rules'     => 'required',
                    'label'     => 'Nomor KTP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_nama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama Lengkap',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_tempat_lahir' => [
                    'rules'     => 'required',
                    'label'     => 'Tempat Lahir',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_tanggal_lahir' => [
                    'rules'     => 'required',
                    'label'     => 'Tanggal Lahir',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_kelamin' => [
                    'rules'     => 'required',
                    'label'     => 'Jenis Kelamin',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_alamat' => [
                    'rules'     => 'required',
                    'label'     => 'Alamat',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_rt' => [
                    'rules'     => 'required',
                    'label'     => 'RT',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_rw' => [
                    'rules'     => 'required',
                    'label'     => 'RW',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kelurahan' => [
                    'rules'     => 'required',
                    'label'     => 'Kelurahan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kecamatan' => [
                    'rules'     => 'required',
                    'label'     => 'Daerah',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kota_kabupaten' => [
                    'rules'     => 'required',
                    'label'     => 'Kota / Kabupaten',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'propinsi' => [
                    'rules'     => 'required',
                    'label'     => 'Propinsi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_alamatid' => [
                    'rules'     => 'required',
                    'label'     => 'Daerah',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'ktp_hp' => [
                    'rules'     => 'required',
                    'label'     => 'Nomor HP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKtpNomor'           => $validation->getError('ktp_nomor'),
                        'errKtpNama'            => $validation->getError('ktp_nama'),
                        'errKtpTempatLahir'     => $validation->getError('ktp_tempat_lahir'),
                        'errKtpTanggalLahir'    => $validation->getError('ktp_tanggal_lahir'),
                        'errKtpKelamin'         => $validation->getError('ktp_kelamin'),
                        'errKtpAlamat'          => $validation->getError('ktp_alamat'),
                        'errKtpRt'              => $validation->getError('ktp_rt'),
                        'errKtpRw'              => $validation->getError('ktp_rw'),
                        'errKelurahan'        => $validation->getError('kelurahan'),
                        'errKecamatan'        => $validation->getError('kecamatan'),
                        'errKotaKabupaten'        => $validation->getError('kota_kabupaten'),
                        'errPropinsi'        => $validation->getError('propinsi'),
                        'errKtpAlamatId'        => $validation->getError('ktp_alamatid'),
                        'errKtpHp'              => $validation->getError('ktp_hp'),
                    ]
                ];
            } else {

                $modelBiodata = new Modelbiodataktp();

                $modelBiodata->update($ktp_nomor_lama, [
                    'ktp_nomor'         => $ktp_nomor,
                    'ktp_nama'          => $ktp_nama,
                    'ktp_tempat_lahir'  => $ktp_tempat_lahir,
                    'ktp_tanggal_lahir' => $ktp_tanggal_lahir,
                    'ktp_kelamin'       => $ktp_kelamin,
                    'ktp_alamat'        => $ktp_alamat,
                    'ktp_rt'            => $ktp_rt,
                    'ktp_rw'            => $ktp_rw,
                    'ktp_alamatid'      => $ktp_alamatid,
                    'ktp_hp'            => $ktp_hp,
                ]);

                if ($modelBiodata) {
                    $modelUser = new ModelUsersUpdate();
                    $modelPemakaian = new ModelPemakaian();
                    $modelPengembalian = new ModelPengembalian();
                    $modelLowongan = new ModelLowonganApply();
                    $modelPsikotest = new ModelPsikotest();


                    $modelUser->update($ktp_nomor_lama, [
                        'userktp'   => $ktp_nomor
                    ]);


                    $modelPemakaian->update($ktp_nomor_lama, [
                        'pemakai'   => $ktp_nomor
                    ]);

                    $modelPengembalian->update($ktp_nomor_lama, [
                        'pgmoleh'   => $ktp_nomor
                    ]);

                    $modelLowongan->update($ktp_nomor_lama, [
                        'applyktp'   => $ktp_nomor
                    ]);

                    $modelPsikotest->update($ktp_nomor_lama, [
                        'testktp'   => $ktp_nomor
                    ]);


                    $json = [
                        'sukses'        => 'Data berhasil disimpan'
                    ];
                }
            }


            echo json_encode($json);
        }
    }

    function hapusBiodata()
    {
        if ($this->request->isAJAX()) {
            $ktp_nomor = $this->request->getPost('ktp_nomor');

            $modelBiodata = new ModelBiodataKtp();

            $modelBiodata->delete($ktp_nomor);

            if ($modelBiodata) {
                $modelUser = new ModelUsers();

                $modelUser->where(['userktp' => $ktp_nomor]);
                $modelUser->delete();
            }

            $json = [
                'sukses' => 'Barang keluar berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    // modal data untuk menampilkan data ktp untuk pemakaian barang
    public function modalData()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('biodataktp/modaldata')
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // menampilkan data dimodal data pencarian untuk pemakaian barang
    public function listDataKtp()
    {
        $request = Services::request();
        $datamodel = new ModelBiodataKtpNamaPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->ktp_nomor . "', '" . $list->ktp_nama . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";

                $row[] = $no;
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
}