<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPerbaikan;
use App\Models\ModelPerbaikanPagination;
use Config\Services;

class Perbaikan extends BaseController
{
    // tampilan view data perbaikan
    public function index()
    {

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Perbaikan',
            'menu'          => 'lowongan',
            'submenu'       => 'perbaikan',
        ];
        return view('perbaikan/viewdata', $data);
    }

    // menampilkan data perbaikan
    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelPerbaikanPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $row[] = $no;
                $row[] = $list->ktp_nama;
                $row[] = $list->pbkntanggal;
                $row[] = $list->pbknproblem;
                $row[] = $list->pbknstatus;
                $row[] = $list->pbknsolusi;
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

    // modal input perbaikan
    public function formtambah()
    {

        $data   = [
            'pbknuser'      => session()->userktp,
            'namauser'      => session()->namauser,
        ];
        $json = [
            'data' => view('perbaikan/modaltambah', $data)
        ];

        echo json_encode($json);
    }

    // simpan usulan perbaikan
    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'pbknproblem' => [
                    'rules'     => 'required',
                    'label'     => 'Permasalahan',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errPbknProblem'        => $validation->getError('pbknproblem'),
                    ]
                ];
            } else {
                $modelPerbaikan = new ModelPerbaikan();

                $modelPerbaikan->insert([
                    'pbknuser'        => $this->request->getPost('pbknuser'),
                    'pbkntanggal'     => $this->request->getPost('pbkntanggal'),
                    'pbknproblem'     => $this->request->getPost('pbknproblem'),
                    'pbknsolusi'      => "",
                    'pbknstatus'      => "Progress",
                ]);

                $json = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }
}