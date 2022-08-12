<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBiodataKtp;
use App\Models\ModelLevels;
use App\Models\ModelLogin;
use App\Models\ModelUsers;
use Config\Services;

class Login extends BaseController
{
    public function index()
    {
        return view('login/index');
    }

    public function cekUser()
    {
        $iduser = $this->request->getPost('iduser');
        $pass = $this->request->getPost('pass');

        $validation = \Config\Services::validation();



        $valid = $this->validate([
            'iduser'    => [
                'label'     => 'ID User',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ],
            'pass'    => [
                'label'     => 'Password',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $sessError = [
                'errIdUser'     => $validation->getError('iduser'),
                'errPassword'   => $validation->getError('pass')
            ];

            session()->setFlashdata($sessError);
            return redirect()->to(site_url('login/index'));
        } else {
            $modelLogin  = new ModelLogin();

            $cekUserLogin = $modelLogin->find($iduser);
            if ($cekUserLogin == null) {
                $sessError = [
                    'errIdUser'     => 'Maaf user tidak terdaftar',
                ];

                session()->setFlashdata($sessError);
                return redirect()->to(site_url('login/index'));
            } else {
                $passwordUser = $cekUserLogin['userpassword'];

                if (password_verify($pass, $passwordUser)) {
                    //lanjutkan
                    $idlevel = $cekUserLogin['userlevelid'];

                    $modelLevel = new ModelLevels();
                    $cekLevel = $modelLevel->find($idlevel);

                    $modelFotoKtp = new ModelBiodataKtp();
                    $cekKtpFoto = $modelFotoKtp->find($cekUserLogin['userktp']);

                    $simpan_session = [
                        'iduser'    => $iduser,
                        'namauser'  => $cekUserLogin['usernama'],
                        'levelnama'  => $cekLevel['levelnama'],
                        'idlevel'   => $idlevel,
                        'ktp_foto'  => $cekKtpFoto['ktp_foto'],
                        'userktp'  => $cekUserLogin['userktp']
                    ];
                    session()->set($simpan_session);

                    return redirect()->to('/main/index')->withInput()->with('validation', $validation);
                } else {
                    $sessError = [
                        'errPassword'     => 'Maaf password anda salah !!',
                    ];

                    session()->setFlashdata($sessError);
                    return redirect()->to(site_url('login/index'));
                }
            }
        }
    }

    public function keluar()
    {
        session()->destroy();
        return redirect()->to('/login/index');
    }


    public function daftar()
    {
        return view('login/daftar');
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $userid      = $this->request->getPost('userid');
            $userktp      = $this->request->getPost('userktp');
            $usernama      = $this->request->getPost('usernama');
            $useremail      = $this->request->getPost('useremail');
            $userpassword      = $this->request->getPost('userpassword');
            $userlevelid      = $this->request->getPost('userlevelid');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'userid' => [
                    'rules'     => 'required',
                    'label'     => 'User ID',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userktp' => [
                    'rules'     => 'required',
                    'label'     => 'Nomor KTP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'usernama' => [
                    'rules'     => 'required',
                    'label'     => 'User Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'useremail' => [
                    'rules'     => 'required',
                    'label'     => 'User Email',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userpassword' => [
                    'rules'     => 'required',
                    'label'     => 'User Password',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errUserID'         => $validation->getError('userid'),
                        'errUserKtp'       => $validation->getError('userktp'),
                        'errUserNama'       => $validation->getError('usernama'),
                        'errUserEmail'      => $validation->getError('useremail'),
                        'errUserPassword'   => $validation->getError('userpassword'),
                    ]
                ];
            } else {
                $modelLevel = new Modelusers();

                $modelLevel->insert([
                    'userid'            => $userid,
                    'usernama'          => $usernama,
                    'userktp'           => $userktp,
                    'useremail'         => $useremail,
                    'userpassword'      => password_hash($userpassword, PASSWORD_BCRYPT),
                    'userlevelid'       => $userlevelid
                ]);

                $modelBiodata = new ModelBiodataKtp();

                if ($modelLevel) {
                    $modelBiodata->insert([
                        'ktp_nomor'         => $userktp,
                        'ktp_nama'          => $usernama,
                        'ktp_tempat_lahir'  => '',
                        'ktp_tanggal_lahir' => '',
                        'ktp_kelamin'       => '',
                        'ktp_alamat'        => '',
                        'ktp_rt'            => '',
                        'ktp_rw'            => '',
                        'ktp_alamatid'      => '',
                        'ktp_hp'            => '',
                        'ktp_email'         => $useremail,
                        'ktp_foto'          => ''
                    ]);

                    $json = [
                        'sukses'        => 'Data berhasil disimpan'
                    ];
                }
            }


            echo json_encode($json);
        }
    }
}
