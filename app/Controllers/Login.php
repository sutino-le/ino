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
                    'required'  => 'User/Password tidak boleh kosong'
                ]
            ],
            'pass'    => [
                'label'     => 'Password',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'User/Password tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $sessError = [
                'errIdUser'     => $validation->getError('iduser'),
                'errIdUser'   => $validation->getError('pass')
            ];

            session()->setFlashdata($sessError);
            return redirect()->to(site_url('login/index'));
        } else {
            $modelLogin  = new ModelLogin();

            $cekUserLogin = $modelLogin->find($iduser);
            if ($cekUserLogin == null) {
                $sessError = [
                    'errIdUser'     => 'Maaf user/password salah',
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

                    if ($cekKtpFoto > 0) {
                        $simpan_session = [
                            'iduser'    => $iduser,
                            'namauser'  => $cekUserLogin['usernama'],
                            'levelnama'  => $cekLevel['levelnama'],
                            'idlevel'   => $idlevel,
                            'ktp_foto'  => $cekKtpFoto['ktp_foto'],
                            'userktp'  => $cekUserLogin['userktp']
                        ];
                    } else {
                        $simpan_session = [
                            'iduser'    => $iduser,
                            'namauser'  => $cekUserLogin['usernama'],
                            'levelnama'  => $cekLevel['levelnama'],
                            'idlevel'   => $idlevel,
                            'ktp_foto'  => 'user.png',
                            'userktp'  => $cekUserLogin['userktp']
                        ];
                    }
                    session()->set($simpan_session);

                    return redirect()->to('/main/index')->withInput()->with('validation', $validation);
                } else {
                    $sessError = [
                        'errIdUser'     => 'Maaf user/password salah',
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
            $usernama      = $this->request->getPost('usernama');
            $userktp      = $this->request->getPost('userktp');
            $useremail      = $this->request->getPost('useremail');
            $userpassword      = $this->request->getPost('userpassword');

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
                $modelUser = new Modelusers();

                // Cek userid
                $cekUser = $modelUser->find($userid);


                if ($cekUser > 0) {
                    $json = [
                        'error' => [
                            'errUserID'         => 'ID User suda ada...',
                        ]
                    ];
                } else {

                    $modelUser = new Modelusers();

                    $cekKtp = $modelUser->cariKtp($userktp)->getRowArray();

                    if ($cekKtp > 0) {
                        $json = [
                            'error' => [
                                'errUserKtp'       => 'Nomor KTP sudah ada...',
                            ]
                        ];
                    } else {

                        $modelUser = new Modelusers();
                        $cekEmail = $modelUser->cariEmail($useremail)->getRowArray();


                        if ($cekEmail > 0) {
                            $json = [
                                'error' => [
                                    'errUserEmail'      => 'Email sudah ada...',
                                ]
                            ];
                        } else {
                            $modelUser->insert([
                                'userid'            => $userid,
                                'usernama'          => $usernama,
                                'userktp'           => $userktp,
                                'useremail'         => $useremail,
                                'userpassword'      => password_hash($userpassword, PASSWORD_BCRYPT),
                                'userlevelid'       => '2'
                            ]);

                            $modelBiodata = new ModelBiodataKtp();

                            if ($modelUser) {
                                $modelBiodata->insert([
                                    'ktp_nomor'         => $userktp,
                                    'ktp_nama'          => $usernama,
                                    'ktp_tempat_lahir'  => '',
                                    'ktp_tanggal_lahir' => '',
                                    'ktp_kelamin'       => '',
                                    'ktp_alamat'        => '',
                                    'ktp_rt'            => '',
                                    'ktp_rw'            => '',
                                    'ktp_alamatid'      => 82521,
                                    'ktp_hp'            => '',
                                    'ktp_email'         => $useremail,
                                    'ktp_foto'          => 'user.png'
                                ]);

                                $json = [
                                    'sukses'        => 'Anda telah berhasil mendaftar...'
                                ];
                            }
                        }
                    }
                }
            }


            echo json_encode($json);
        }
    }
}