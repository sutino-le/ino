<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelHrJabatan;
use App\Models\ModelHrJabatanPagination;
use Config\Services;

class HrJabatan extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Jabatan',
            'menu'          => 'masterhr',
            'submenu'       => 'jabatan',
        ];
        return view('hrjabatan/viewdata', $data);
    }


    public function listData()
    {


        $request = Services::request();
        $datamodel = new ModelHrJabatanPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->jabatanid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->jabatanid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                // if ($list->brgsatid == "") {
                //     $tombolhapusJabatan = $tombolHapus;
                // } else {
                //     $tombolhapusJabatan = "";
                // }

                $row[] = $no;
                $row[] = $list->jabatanid;
                $row[] = $list->jabatannama;
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
            'data' => view('hrjabatan/modaltambah')
        ];

        echo json_encode($json);
    }


    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $jabatannama      = $this->request->getPost('jabatannama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'jabatannama' => [
                    'rules'     => 'required',
                    'label'     => 'Jabatan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errJabatanNama'      => $validation->getError('jabatannama'),
                    ]
                ];
            } else {
                $modelJabatan = new ModelHrjabatan();

                $modelJabatan->insert([
                    'jabatanid'          => '',
                    'jabatannama'        => $jabatannama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }


    public function formedit($jabatanid)
    {
        $modelJabatan = new ModelHrjabatan();

        $cekDataSub        = $modelJabatan->find($jabatanid);


        if ($cekDataSub) {
            $data = [
                'jabatanid'          => $cekDataSub['jabatanid'],
                'jabatannama'        => $cekDataSub['jabatannama'],
            ];

            $json = [
                'data' => view('hrjabatan/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $jabatanid          = $this->request->getPost('jabatanid');
            $jabatannama        = $this->request->getPost('jabatannama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'jabatannama' => [
                    'rules'     => 'required',
                    'label'     => 'Jabatan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errJabatanNama'      => $validation->getError('jabatannama'),
                    ]
                ];
            } else {
                $modelJabatan = new ModelHrjabatan();

                $modelJabatan->update($jabatanid, [
                    'jabatannama'         => $jabatannama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapusdata($jabatanid)
    {
        $modelJabatan = new ModelHrjabatan();
        $modelJabatan->delete($jabatanid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}