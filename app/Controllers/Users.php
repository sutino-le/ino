<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBiodataKtp;
use App\Models\ModelLevels;
use App\Models\ModelLowongan;
use App\Models\ModelLowonganApply;
use App\Models\ModelPemakaian;
use App\Models\ModelPengembalian;
use App\Models\ModelPsikotest;
use App\Models\ModelUsers;
use App\Models\ModelUsersPagination;
use Config\Services;

class Users extends BaseController
{
    public function __construct()
    {
        $this->levels   = new ModelLevels();
        $this->users    = new ModelUsers();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'users',
            'menu'          => 'setting',
            'submenu'       => 'user',
        ];
        return view('users/viewdata', $data);
    }


    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelUsersPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->userid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->userid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                $row[] = $no;
                $row[] = $list->userid;
                $row[] = $list->usernama;
                $row[] = $list->useremail;
                $row[] = $list->userpassword;
                $row[] = $list->levelnama;
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
            'datalevel' => $this->levels->findAll()
        ];

        $json = [
            'data' => view('users/modaltambah', $data)
        ];

        echo json_encode($json);
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
                ],
                'userlevelid' => [
                    'rules'     => 'required',
                    'label'     => 'User Level',
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
                        'errUserLevelId'    => $validation->getError('userlevelid'),
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
                    $cekEmail = $modelUser->cariEmail($useremail)->getRowArray();

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
                                'userlevelid'       => $userlevelid
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
                                    'ktp_foto'          => 'user.png'
                                ]);

                                $json = [
                                    'sukses'        => 'Anda telah berhasil disimpan...'
                                ];
                            }
                        }
                    }
                }
            }


            echo json_encode($json);
        }
    }


    public function formedit($userid)
    {

        $cekData        = $this->users->find($userid);
        if ($cekData) {

            $modellevel = new ModelLevels();

            $data = [
                'userid'        => $cekData['userid'],
                'userktp'       => $cekData['userktp'],
                'usernama'      => $cekData['usernama'],
                'useremail'     => $cekData['useremail'],
                'userpassword'  => $cekData['userpassword'],
                'userlevelid'   => $cekData['userlevelid'],
                'datalevel'     => $modellevel->findAll(),
            ];

            $json = [
                'data' => view('users/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $useridlama     = $this->request->getPost('useridlama');
            $userktplama     = $this->request->getPost('userktplama');
            $useremaillama     = $this->request->getPost('useremaillama');
            $userid         = $this->request->getPost('userid');
            $userktp         = $this->request->getPost('userktp');
            $usernama       = $this->request->getPost('usernama');
            $useremail      = $this->request->getPost('useremail');
            $userpassword   = $this->request->getPost('userpassword');
            $userlevelid    = $this->request->getPost('userlevelid');

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
                ],
                'userlevelid' => [
                    'rules'     => 'required',
                    'label'     => 'User Level',
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
                        'errUserLevelId'    => $validation->getError('userlevelid'),
                    ]
                ];
            } else {
                $modelUser = new Modelusers();

                // Cek userid
                $cekUser = $modelUser->find($userid);


                if ($useridlama != $cekUser['userid'] and $cekUser > 0) {
                    $json = [
                        'error' => [
                            'errUserID'         => 'ID User suda ada...',
                        ]
                    ];
                } else {

                    $modelUser = new Modelusers();

                    $cekKtp = $modelUser->cariKtp($userktp)->getRowArray();

                    if ($userktplama != $cekKtp['userktp'] and $cekKtp > 0) {
                        $json = [
                            'error' => [
                                'errUserKtp'       => 'Nomor KTP sudah ada...',
                            ]
                        ];
                    } else {

                        $modelUser = new Modelusers();
                        $cekEmail = $modelUser->cariEmail($useremail)->getRowArray();


                        if ($useremaillama != $cekEmail['useremail'] and $cekEmail > 0) {
                            $json = [
                                'error' => [
                                    'errUserEmail'      => 'Email sudah ada...',
                                ]
                            ];
                        } else {
                            $modelUser->update($useridlama, [
                                'userid'            => $userid,
                                'usernama'          => $usernama,
                                'userktp'           => $userktp,
                                'useremail'         => $useremail,
                                'userpassword'      => password_hash($userpassword, PASSWORD_BCRYPT),
                                'userlevelid'       => $userlevelid
                            ]);

                            $modelBiodata = new ModelBiodataKtp();
                            $modelPemakai = new ModelPemakaian();
                            $modelPengembalian = new ModelPengembalian();
                            $modelLowongan = new ModelLowonganApply();
                            $modelPsikotest = new ModelPsikotest();

                            if ($modelUser) {
                                $modelBiodata->update($userktplama, [
                                    'ktp_nomor'         => $userktp,
                                ]);

                                $modelPemakai->update($userktplama, [
                                    'pemakai'   => $userktp
                                ]);

                                $modelPengembalian->update($userktplama, [
                                    'pgmoleh'   => $userktp
                                ]);

                                $modelLowongan->update($userktplama, [
                                    'applyktp'   => $userktp
                                ]);

                                $modelPsikotest->update($userktplama, [
                                    'testktp'   => $userktp
                                ]);

                                $json = [
                                    'sukses'        => 'Anda telah berhasil disimpan...'
                                ];
                            }
                        }
                    }
                }
            }


            echo json_encode($json);
        }
    }

    public function hapus($userid)
    {
        $modelUser = new ModelUsers();
        $cekData = $modelUser->find($userid);

        $modelBiodata = new ModelBiodataKtp();

        $this->users->delete($userid);

        $modelBiodata->delete($cekData['userktp']);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}