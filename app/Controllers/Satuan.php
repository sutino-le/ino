<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSatuan;
use App\Models\ModelSatuanPagination;
use Config\Services;

class Satuan extends BaseController
{

    public function __construct()
    {
        $this->satuan = new ModelSatuan();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Satuan',
        ];
        return view('satuan/viewdata', $data);
    }


    public function listData()
    {


        $request = Services::request();
        $datamodel = new ModelSatuanPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->satid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->satid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                if ($list->brgsatid == "") {
                    $tombolhapussatuan = $tombolHapus;
                } else {
                    $tombolhapussatuan = "";
                }

                $row[] = $no;
                $row[] = $list->satnama;
                $row[] = $tombolEdit . ' ' . $tombolhapussatuan;
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
            'data' => view('satuan/modaltambah')
        ];

        echo json_encode($json);
    }


    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $satnama      = $this->request->getPost('satnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'satnama' => [
                    'rules'     => 'required',
                    'label'     => 'Satuan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errSatNama'      => $validation->getError('satnama'),
                    ]
                ];
            } else {
                $modelsatuan = new ModelSatuan();

                $modelsatuan->insert([
                    'satid'         => '',
                    'satnama'         => $satnama
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }


    public function formedit($satid)
    {
        $modelsub = new ModelSatuan();

        $cekDataSub        = $modelsub->find($satid);
        if ($cekDataSub) {
            $data = [
                'satid'        => $cekDataSub['satid'],
                'satnama'         => $cekDataSub['satnama']
            ];

            $json = [
                'data' => view('satuan/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $satid     = $this->request->getPost('satid');
            $satnama      = $this->request->getPost('satnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'satnama' => [
                    'rules'     => 'required',
                    'label'     => 'Satuan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errSatNama'      => $validation->getError('satnama')
                    ]
                ];
            } else {
                $modelsatuan = new ModelSatuan();

                $modelsatuan->update($satid, [
                    'satnama'         => $satnama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapusdata($satid)
    {
        $this->satuan->delete($satid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}
