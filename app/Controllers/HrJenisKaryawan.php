<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelHrJenisKaryawan;
use App\Models\ModelHrJenisKaryawanPagination;
use Config\Services;

class HrJenisKaryawan extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Jenis Karyawan',
            'menu'          => 'masterhr',
            'submenu'       => 'jeniskaryawan',
        ];
        return view('hrjeniskaryawan/viewdata', $data);
    }


    public function listData()
    {


        $request = Services::request();
        $datamodel = new ModelHrJenisKaryawanPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->jkid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->jkid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                // if ($list->brgsatid == "") {
                //     $tombolhapusJabatan = $tombolHapus;
                // } else {
                //     $tombolhapusJabatan = "";
                // }

                $row[] = $no;
                $row[] = $list->jkid;
                $row[] = $list->jknama;
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

        $json = [
            'data' => view('hrjeniskaryawan/modaltambah')
        ];

        echo json_encode($json);
    }


    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $jknama      = $this->request->getPost('jknama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'jknama' => [
                    'rules'     => 'required',
                    'label'     => 'Jenis Karyawan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errJkNama'      => $validation->getError('jknama'),
                    ]
                ];
            } else {
                $modelJenisKaryawan = new ModelHrJenisKaryawan();

                $modelJenisKaryawan->insert([
                    'jkid'          => '',
                    'jknama'        => $jknama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }


    public function formedit($jkid)
    {
        $modelJenisKaryawan = new ModelHrJenisKaryawan();

        $cekDataSub        = $modelJenisKaryawan->find($jkid);


        if ($cekDataSub) {
            $data = [
                'jkid'          => $cekDataSub['jkid'],
                'jknama'        => $cekDataSub['jknama'],
            ];

            $json = [
                'data' => view('hrjeniskaryawan/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $jkid          = $this->request->getPost('jkid');
            $jknama        = $this->request->getPost('jknama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'jknama' => [
                    'rules'     => 'required',
                    'label'     => 'Jenis Karyawan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errJkNama'      => $validation->getError('jknama'),
                    ]
                ];
            } else {
                $modelJenisKaryawan = new ModelHrJenisKaryawan();

                $modelJenisKaryawan->update($jkid, [
                    'jknama'         => $jknama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapusdata($jkid)
    {
        $modelJenisKaryawan = new ModelHrJenisKaryawan();
        $modelJenisKaryawan->delete($jkid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}