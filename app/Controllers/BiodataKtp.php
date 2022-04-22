<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBiodataKtp;
use App\Models\ModelBiodataKtpPagination;
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
                $row[] = $list->ktp_email . '<br>' . $list->ktp_hp;
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
            'subjudul'      => 'Biodata KTP - Input'
        ];

        return view('biodataktp/formtambah', $data);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $ktp_nomor      = $this->request->getPost('ktp_nomor');
            $ktp_nama      = $this->request->getPost('ktp_nama');
            $ktp_tempat_lahir      = $this->request->getPost('ktp_tempat_lahir');
            $ktp_tanggal_lahir      = $this->request->getPost('ktp_tanggal_lahir');
            $ktp_kelamin      = $this->request->getPost('ktp_kelamin');
            $ktp_alamat      = $this->request->getPost('ktp_alamat');
            $ktp_rt      = $this->request->getPost('ktp_rt');
            $ktp_rw      = $this->request->getPost('ktp_rw');
            $ktp_alamatid      = $this->request->getPost('ktp_alamatid');

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
                'ktp_alamatid' => [
                    'rules'     => 'required',
                    'label'     => 'Daerah',
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
                        'errKtpAlamatId'         => $validation->getError('ktp_alamatid'),
                    ]
                ];
            } else {
                $modelLevel = new Modelbiodataktp();

                $modelLevel->insert([
                    'ktp_nomor'         => $ktp_nomor,
                    'ktp_nama'          => $ktp_nama,
                    'ktp_tempat_lahir'  => $ktp_tempat_lahir,
                    'ktp_tanggal_lahir' => $ktp_tanggal_lahir,
                    'ktp_kelamin'       => $ktp_kelamin,
                    'ktp_alamat'        => $ktp_alamat,
                    'ktp_rt'            => $ktp_rt,
                    'ktp_rw'            => $ktp_rw,
                    'ktp_alamatid'      => $ktp_alamatid
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }
}
