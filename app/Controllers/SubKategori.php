<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSubKategori;
use App\Models\ModelSubKategoriPagination;
use Config\Services;

class SubKategori extends BaseController
{

    public function __construct()
    {
        $this->subkategori = new ModelSubKategori();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Sub Kategori',
            'menu'          => 'masterbarang',
            'submenu'       => 'subkategori',
        ];
        return view('subkategori/viewdata', $data);
    }


    public function listData()
    {


        $request = Services::request();
        $datamodel = new ModelSubKategoriPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->subkatid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->subkatid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                if ($list->brgsubkatid == "") {
                    $tombolhapuskategori = $tombolHapus;
                } else {
                    $tombolhapuskategori = "";
                }

                $row[] = $no;
                $row[] = $list->subkatnama;
                $row[] = $tombolEdit . ' ' . $tombolhapuskategori;
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
            'data' => view('subkategori/modaltambah')
        ];

        echo json_encode($json);
    }


    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $subkatnama      = $this->request->getPost('subkatnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'subkatnama' => [
                    'rules'     => 'required',
                    'label'     => 'Sub Kategori',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errSubKatNama'      => $validation->getError('subkatnama'),
                    ]
                ];
            } else {
                $modelSubKategori = new ModelSubKategori();

                $modelSubKategori->insert([
                    'subkatid'         => '',
                    'subkatnama'         => $subkatnama
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }


    public function formedit($subkatid)
    {
        $modelsub = new ModelSubKategori();

        $cekDataSub        = $modelsub->find($subkatid);
        if ($cekDataSub) {
            $data = [
                'subkatid'        => $cekDataSub['subkatid'],
                'subkatnama'         => $cekDataSub['subkatnama']
            ];

            $json = [
                'data' => view('subkategori/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $subkatid     = $this->request->getPost('subkatid');
            $subkatnama      = $this->request->getPost('subkatnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'subkatnama' => [
                    'rules'     => 'required',
                    'label'     => 'Sub Kategori',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errSubkatNama'      => $validation->getError('subkatnama')
                    ]
                ];
            } else {
                $modelSubKategori = new ModelSubKategori();

                $modelSubKategori->update($subkatid, [
                    'subkatnama'         => $subkatnama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapusdata($subkatid)
    {
        $this->subkategori->delete($subkatid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}