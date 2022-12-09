<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelHrJenisPkwt;
use App\Models\ModelHrJenisPkwtPagination;
use Config\Services;

class HrJenisPkwt extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Jenis PKWT',
            'menu'          => 'masterhr',
            'submenu'       => 'jenispkwt',
        ];
        return view('hrjenispkwt/viewdata', $data);
    }


    public function listData()
    {


        $request = Services::request();
        $datamodel = new ModelHrJenisPkwtPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->jpkwtid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->jpkwtid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                // if ($list->brgsatid == "") {
                //     $tombolhapusJabatan = $tombolHapus;
                // } else {
                //     $tombolhapusJabatan = "";
                // }

                $row[] = $no;
                $row[] = $list->jpkwtid;
                $row[] = $list->jpkwtnama;
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
            'data' => view('hrjenispkwt/modaltambah')
        ];

        echo json_encode($json);
    }


    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $jpkwtnama      = $this->request->getPost('jpkwtnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'jpkwtnama' => [
                    'rules'     => 'required',
                    'label'     => 'Jenis PKWT',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errorJenisPkwtNama'      => $validation->getError('jpkwtnama'),
                    ]
                ];
            } else {
                $modelJabatan = new ModelHrJenisPkwt();

                $modelJabatan->insert([
                    'jpkwtid'          => '',
                    'jpkwtnama'        => $jpkwtnama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }


    public function formedit($jpkwtid)
    {
        $modelJabatan = new ModelHrJenisPkwt();

        $cekDataSub        = $modelJabatan->find($jpkwtid);


        if ($cekDataSub) {
            $data = [
                'jpkwtid'          => $cekDataSub['jpkwtid'],
                'jpkwtnama'        => $cekDataSub['jpkwtnama'],
            ];

            $json = [
                'data' => view('hrjenispkwt/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $jpkwtid          = $this->request->getPost('jpkwtid');
            $jpkwtnama        = $this->request->getPost('jpkwtnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'jpkwtnama' => [
                    'rules'     => 'required',
                    'label'     => 'Jenis PKWT',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errorJenisPkwtNama'      => $validation->getError('jpkwtnama'),
                    ]
                ];
            } else {
                $modelJabatan = new ModelHrJenisPkwt();

                $modelJabatan->update($jpkwtid, [
                    'jpkwtnama'         => $jpkwtnama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapusdata($jpkwtid)
    {
        $modelJabatan = new ModelHrJenisPkwt();
        $modelJabatan->delete($jpkwtid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}