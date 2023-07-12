<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelHrBagian;
use App\Models\ModelHrBagianPagination;
use Config\Services;

class HrBagian extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Bagian',
            'menu'          => 'masterhr',
            'submenu'       => 'bagian',
        ];
        return view('hrbagian/viewdata', $data);
    }


    public function listData()
    {


        $request = Services::request();
        $datamodel = new ModelHrBagianPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->bagianid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->bagianid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                // if ($list->brgsatid == "") {
                //     $tombolhapusBagian = $tombolHapus;
                // } else {
                //     $tombolhapusBagian = "";
                // }

                $row[] = $no;
                $row[] = $list->bagianid;
                $row[] = $list->bagiannama;
                $row[] = $list->bagianparent;
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
        $modelBagian = new ModelHrBagian();
        $data = [
            'databagian' => $modelBagian->findAll()
        ];

        $json = [
            'data' => view('hrbagian/modaltambah', $data)
        ];

        echo json_encode($json);
    }


    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $bagiannama      = $this->request->getPost('bagiannama');
            $bagianparent      = $this->request->getPost('bagianparent');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'bagiannama' => [
                    'rules'     => 'required',
                    'label'     => 'Bagian',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'bagianparent' => [
                    'rules'     => 'required',
                    'label'     => 'Parent',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errBagianNama'      => $validation->getError('bagiannama'),
                        'errBagianParent'      => $validation->getError('bagianparent'),
                    ]
                ];
            } else {
                $modelBagian = new ModelHrBagian();

                $modelBagian->insert([
                    'bagianid'          => '',
                    'bagiannama'        => $bagiannama,
                    'bagianparent'      => $bagianparent,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }


    public function formedit($bagianid)
    {
        $modelBagian = new ModelHrBagian();

        $cekDataSub        = $modelBagian->find($bagianid);


        if ($cekDataSub) {
            $data = [
                'bagianid'          => $cekDataSub['bagianid'],
                'bagiannama'        => $cekDataSub['bagiannama'],
                'bagianparent'      => $cekDataSub['bagianparent'],
                'databagian'        => $modelBagian->findAll()
            ];

            $json = [
                'data' => view('hrbagian/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $bagianid          = $this->request->getPost('bagianid');
            $bagiannama        = $this->request->getPost('bagiannama');
            $bagianparent     = $this->request->getPost('bagianparent');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'bagiannama' => [
                    'rules'     => 'required',
                    'label'     => 'Bagian',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'bagianparent' => [
                    'rules'     => 'required',
                    'label'     => 'Parent',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errBagianNama'      => $validation->getError('bagiannama'),
                        'errBagianParent'      => $validation->getError('bagianparent')
                    ]
                ];
            } else {
                $modelbagian = new ModelHrBagian();

                $modelbagian->update($bagianid, [
                    'bagiannama'         => $bagiannama,
                    'bagianparent'         => $bagianparent,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapusdata($bagianid)
    {
        $modelbagian = new ModelHrBagian();
        $modelbagian->delete($bagianid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}
