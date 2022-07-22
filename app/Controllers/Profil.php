<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBiodataDomisili;
use App\Models\ModelBiodataKtp;
use App\Models\ModelLevels;
use App\Models\ModelUsers;
use App\Models\ModelUsersUpdate;
use App\Models\ModelWilayah;
use Config\Services;

class Profil extends BaseController
{

    public function __construct()
    {
        $this->users    = new ModelUsers();
        $this->biodataKtp   = new ModelBiodataKtp();
        $this->wilayah    = new ModelWilayah();
        helper('form');
    }



    public function index($admin)
    {
        //ambil tabel user
        $modelUser = new ModelUsers();
        $rowUser = $modelUser->find($admin);

        //ambil tabel biodata ktp
        $modelKtp = new ModelBiodataKtp();
        $rowKtp = $modelKtp->find($rowUser['userktp']);

        //ambil tabel wilayah
        $modelWilayah = new ModelWilayah();
        $rowWilayah = $modelWilayah->find($rowKtp['ktp_alamatid']);
        if ($rowWilayah > 0) {
            $data_wilayah = [
                'kelurahan'         => $rowWilayah['kelurahan'],
                'kecamatan'         => $rowWilayah['kecamatan'],
                'kota_kabupaten'    => $rowWilayah['kota_kabupaten'],
                'propinsi'          => $rowWilayah['propinsi'],
            ];
        } else {
            $data_wilayah = [
                'kelurahan'         => '',
                'kecamatan'         => '',
                'kota_kabupaten'    => '',
                'propinsi'          => '',
            ];
        }

        //ambil tabel domisili
        $modelBiodataDomisili = new ModelBiodataDomisili();
        $rowKtpDomisili = $modelBiodataDomisili->find($rowUser['userktp']);
        if ($rowKtpDomisili > 0) {
            $data_domisili = [
                'domisili_alamat'           => $rowKtpDomisili['domisili_alamat'],
                'domisili_rt'               => $rowKtpDomisili['domisili_rt'],
                'domisili_rw'               => $rowKtpDomisili['domisili_rw'],
                'domisili_wilayah_id'       => $rowKtpDomisili['domisili_wilayah_id'],
            ];

            //ambil tabel domisili wilayah
            $modelWilayahDomisili = new ModelWilayah();
            $rowWilDomisili = $modelWilayahDomisili->find($rowKtpDomisili['domisili_wilayah_id']);
            if ($rowWilDomisili > 0) {


                $data_domisili_wilayah = [
                    'domisili_kelurahan'        => $rowWilDomisili['kelurahan'],
                    'domisili_kecamatan'        => $rowWilDomisili['kecamatan'],
                    'domisili_kota_kabupaten'   => $rowWilDomisili['kota_kabupaten'],
                    'domisili_propinsi'         => $rowWilDomisili['propinsi'],
                ];
            } else {
                $data_domisili_wilayah = [
                    'domisili_kelurahan'        => '',
                    'domisili_kecamatan'        => '',
                    'domisili_kota_kabupaten'   => '',
                    'domisili_propinsi'         => '',
                ];
            }
        } else {
            $data_domisili = [
                'domisili_alamat'           => '',
                'domisili_rt'               => '',
                'domisili_rw'               => '',
                'domisili_wilayah_id'       => '',
            ];


            $data_domisili_wilayah = [
                'domisili_kelurahan'        => '',
                'domisili_kecamatan'        => '',
                'domisili_kota_kabupaten'   => '',
                'domisili_propinsi'         => '',
            ];
        }


        if ($rowKtp > 0) {
            $data = [
                'judul'                 => 'Home',
                'subjudul'              => 'Profil',
                'validation'            => \Config\Services::validation(),
                'userid'                => $rowUser['userid'],
                'usernama'              => $rowUser['usernama'],
                'ktp_nomor'             => $rowKtp['ktp_nomor'],
                'ktp_nama'              => $rowKtp['ktp_nama'],
                'ktp_tempat_lahir'      => $rowKtp['ktp_tempat_lahir'],
                'ktp_tanggal_lahir'     => $rowKtp['ktp_tanggal_lahir'],
                'ktp_kelamin'           => $rowKtp['ktp_kelamin'],
                'ktp_alamat'            => $rowKtp['ktp_alamat'],
                'ktp_rt'                => $rowKtp['ktp_rt'],
                'ktp_rw'                => $rowKtp['ktp_rw'],
                'ktp_alamatid'          => $rowKtp['ktp_alamatid'],
                'ktp_hp'                => $rowKtp['ktp_hp'],
                'ktp_email'             => $rowKtp['ktp_email'],
                'ktp_foto'              => $rowKtp['ktp_foto'],
                'kelurahan'             => $data_wilayah['kelurahan'],
                'kecamatan'             => $data_wilayah['kecamatan'],
                'kota_kabupaten'        => $data_wilayah['kota_kabupaten'],
                'propinsi'              => $data_wilayah['propinsi'],
                'domisili_alamat'       => $data_domisili['domisili_alamat'],
                'domisili_rt'           => $data_domisili['domisili_rt'],
                'domisili_rw'           => $data_domisili['domisili_rw'],
                'domisili_wilayah_id'   => $data_domisili['domisili_wilayah_id'],
                'domisili_kelurahan'             => $data_domisili_wilayah['domisili_kelurahan'],
                'domisili_kecamatan'             => $data_domisili_wilayah['domisili_kecamatan'],
                'domisili_kota_kabupaten'        => $data_domisili_wilayah['domisili_kota_kabupaten'],
                'domisili_propinsi'              => $data_domisili_wilayah['domisili_propinsi'],
            ];
        } else {
            $data = [
                'judul'                 => 'Home',
                'subjudul'              => 'Profil',
                'validation'            => \Config\Services::validation(),
                'userid'                => $rowUser['userid'],
                'usernama'              => $rowUser['usernama'],
                'ktp_nomor'             => '',
                'ktp_nama'              => '',
                'ktp_tempat_lahir'      => '',
                'ktp_tanggal_lahir'     => '',
                'ktp_kelamin'           => '',
                'ktp_alamat'            => '',
                'ktp_rt'                => '',
                'ktp_rw'                => '',
                'ktp_alamatid'          => '',
                'ktp_hp'                => '',
                'ktp_email'             => '',
                'ktp_foto'              => '',
                'kelurahan'             => $data_wilayah['kelurahan'],
                'kecamatan'             => $data_wilayah['kecamatan'],
                'kota_kabupaten'        => $data_wilayah['kota_kabupaten'],
                'propinsi'              => $data_wilayah['propinsi'],
                'domisili_alamat'       => $data_domisili['domisili_alamat'],
                'domisili_rt'           => $data_domisili['domisili_rt'],
                'domisili_rw'           => $data_domisili['domisili_rw'],
                'domisili_wilayah_id'   => $data_domisili['domisili_wilayah_id'],
                'domisili_kelurahan'             => $data_domisili_wilayah['domisili_kelurahan'],
                'domisili_kecamatan'             => $data_domisili_wilayah['domisili_kecamatan'],
                'domisili_kota_kabupaten'        => $data_domisili_wilayah['domisili_kota_kabupaten'],
                'domisili_propinsi'              => $data_domisili_wilayah['domisili_propinsi'],
            ];
        }
        return view('profil/viewdata', $data);
    }


    // untuk menampilkan form edit foto
    public function formeditfoto($userid)
    {

        $cekData        = $this->users->find($userid);
        $cekDataKtp        = $this->biodataKtp->find($cekData['userktp']);
        if ($cekData) {


            $data = [
                'userid'        => $cekData['userid'],
                'ktp_nomor'     => $cekDataKtp['ktp_nomor'],
                'ktp_foto'      => $cekDataKtp['ktp_foto'],
            ];

            $json = [
                'data' => view('profil/formeditfoto', $data)
            ];
        }
        echo json_encode($json);
    }

    // untuk update foto
    public function updatefoto()
    {

        $userid          = $this->request->getVar('userid');
        $ktp_nomor       = $this->request->getVar('ktp_nomor');
        $gambar        = $this->request->getVar('gambar');



        $cekData            = $this->biodataKtp->find($ktp_nomor);
        if ($cekData['ktp_foto'] == '') {
            $pathGambarLama     = '';
        } else {
            $pathGambarLama     = $cekData['ktp_foto'];
        }

        $gambar = $_FILES['gambar']['name'];

        if ($gambar != NULL) {
            ($pathGambarLama == '' || $pathGambarLama == null) ? '' : unlink('upload/' . $pathGambarLama);

            $namaFileGambar     = $ktp_nomor;
            $fileGambar         = $this->request->getFile('gambar');
            $fileGambar->move('upload/', $namaFileGambar . '.' . $fileGambar->getExtension());

            $pathGambar         = $fileGambar->getName();
        } else {
            $pathGambar         = $pathGambarLama;
        }

        $this->biodataKtp->update($ktp_nomor, [
            'ktp_foto'           => $pathGambar,
        ]);


        return redirect()->to('profil/index/' . $userid);
    }




    // untuk menampilkan form edit ktp
    public function formeditktp($userid)
    {

        $cekData        = $this->users->find($userid);
        $cekDataKtp        = $this->biodataKtp->find($cekData['userktp']);
        if ($cekData) {

            $modelWilayah = new ModelWilayah();
            $rowWilayah = $modelWilayah->find($cekDataKtp['ktp_alamatid']);

            if ($rowWilayah > 0) {

                $data = [
                    'judul'                 => 'Home',
                    'subjudul'              => 'Edit Biodata KTP',
                    'userid'                => $cekData['userid'],
                    'ktp_nomor'             => $cekDataKtp['ktp_nomor'],
                    'ktp_nama'              => $cekDataKtp['ktp_nama'],
                    'ktp_tempat_lahir'      => $cekDataKtp['ktp_tempat_lahir'],
                    'ktp_tanggal_lahir'     => $cekDataKtp['ktp_tanggal_lahir'],
                    'ktp_kelamin'           => $cekDataKtp['ktp_kelamin'],
                    'ktp_alamat'            => $cekDataKtp['ktp_alamat'],
                    'ktp_rt'                => $cekDataKtp['ktp_rt'],
                    'ktp_rw'                => $cekDataKtp['ktp_rw'],
                    'ktp_alamatid'          => $cekDataKtp['ktp_alamatid'],
                    'ktp_hp'                => $cekDataKtp['ktp_hp'],
                    'ktp_email'             => $cekDataKtp['ktp_email'],
                    'kelurahan'             => $rowWilayah['kelurahan'],
                    'kecamatan'             => $rowWilayah['kecamatan'],
                    'kota_kabupaten'        => $rowWilayah['kota_kabupaten'],
                    'propinsi'              => $rowWilayah['propinsi'],
                    'wilayah'               => $modelWilayah->findAll()
                ];
            } else {
                $data = [
                    'judul'                 => 'Home',
                    'subjudul'              => 'Edit Biodata KTP',
                    'userid'                => $cekData['userid'],
                    'ktp_nomor'             => $cekDataKtp['ktp_nomor'],
                    'ktp_nama'              => $cekDataKtp['ktp_nama'],
                    'ktp_tempat_lahir'      => $cekDataKtp['ktp_tempat_lahir'],
                    'ktp_tanggal_lahir'     => $cekDataKtp['ktp_tanggal_lahir'],
                    'ktp_kelamin'           => $cekDataKtp['ktp_kelamin'],
                    'ktp_alamat'            => $cekDataKtp['ktp_alamat'],
                    'ktp_rt'                => $cekDataKtp['ktp_rt'],
                    'ktp_rw'                => $cekDataKtp['ktp_rw'],
                    'ktp_alamatid'          => $cekDataKtp['ktp_alamatid'],
                    'ktp_hp'                => $cekDataKtp['ktp_hp'],
                    'ktp_email'             => $cekDataKtp['ktp_email'],
                    'kelurahan'             => '',
                    'kecamatan'             => '',
                    'kota_kabupaten'        => '',
                    'propinsi'              => '',
                    'wilayah'               => $modelWilayah->findAll()
                ];
            }

            $json = [
                'data' => view('profil/formeditktp', $data)
            ];
        }
        echo json_encode($json);
    }

    //untuk update biodata ktp
    public function update()
    {
        if ($this->request->isAJAX()) {
            $userid          = $this->request->getVar('userid');
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
            $ktp_email          = $this->request->getPost('ktp_email');

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
                'ktp_email' => [
                    'rules'     => 'required',
                    'label'     => 'Email',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
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
                        'errKtpEmail'           => $validation->getError('ktp_email'),
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
                    'ktp_email'         => $ktp_email,
                ]);

                if ($modelBiodata) {
                    $modelUser = new ModelUsersUpdate();
                    // $rowUser = $modelUser->find($ktp_nomor_lama);

                    // $userid   = $rowUser['propinsi'];

                    // if ($rowUser > 0) {
                    $modelUser->update($ktp_nomor_lama, [
                        'userktp'   => $ktp_nomor
                    ]);
                    // }

                    // $modelUser->where(['userktp' => $ktp_nomor_lama]);
                    // $modelUser->update([
                    //     'userktp'   => $ktp_nomor
                    // ]);


                    $json = [
                        'sukses'        => 'Data berhasil disimpan'
                    ];
                }
            }


            echo json_encode($json);
        }
    }
}
