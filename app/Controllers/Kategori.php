<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKategori;
use App\Models\ModelKategoriPagination;
use Config\Services;

class Kategori extends BaseController
{

    public function __construct()
    {
        $this->kategori = new ModelKategori();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Kategori',
            'menu'          => 'masterbarang',
            'submenu'       => 'kategori',
        ];
        return view('kategori/viewdata', $data);
    }


    public function listData()
    {


        $request = Services::request();
        $datamodel = new ModelKategoriPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->katid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->katid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                if ($list->brgkatid == "") {
                    $tombolhapuskategori = $tombolHapus;
                } else {
                    $tombolhapuskategori = "";
                }

                $row[] = $no;
                $row[] = $list->katnama;
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
            'data' => view('kategori/modaltambah')
        ];

        echo json_encode($json);
    }


    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $katnama      = $this->request->getPost('katnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'katnama' => [
                    'rules'     => 'required',
                    'label'     => 'Kategori',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKatNama'      => $validation->getError('katnama'),
                    ]
                ];
            } else {
                $modelKategori = new ModelKategori();

                $modelKategori->insert([
                    'katid'         => '',
                    'katnama'         => $katnama
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }



    public function formedit($katid)
    {
        $modelKategori = new ModelKategori();

        $cekData        = $modelKategori->find($katid);
        if ($cekData) {
            $data = [
                'katid'        => $cekData['katid'],
                'katnama'         => $cekData['katnama']
            ];

            $json = [
                'data' => view('kategori/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $katid     = $this->request->getPost('katid');
            $katnama      = $this->request->getPost('katnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'katnama' => [
                    'rules'     => 'required',
                    'label'     => 'Kategori',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errkatNama'      => $validation->getError('katnama')
                    ]
                ];
            } else {
                $modelKategori = new ModelKategori();

                $modelKategori->update($katid, [
                    'katnama'         => $katnama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapusdata($katid)
    {
        $this->kategori->delete($katid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}