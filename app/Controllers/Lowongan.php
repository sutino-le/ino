<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLowongan;
use App\Models\ModelLowonganPagination;
use Config\Services;


class Lowongan extends BaseController
{
    public function __construct()
    {
        $this->lowongan = new ModelLowongan();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Lowongan',
        ];
        return view('lowongan/viewdata', $data);
    }


    public function listData()
    {


        $request = Services::request();
        $datamodel = new ModelLowonganPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->lowonganid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->lowonganid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolPrint = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"print('" . $list->lowonganid . "')\" title=\"Edit\"><i class='fas fa-print'></i></button>";

                if ($list->lowonganstatus == "Aktif") {
                    $status = "<button type=\"button\" class=\"btn btn-sm btn-success\" onclick=\"satatus('" . $list->lowonganid . "')\" title=\"Non Aktifkan\"><i class='fas fa-power-off'></i></button>";
                } else {
                    $status = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"satatus('" . $list->lowonganid . "')\" title=\"Aktifkan\"><i class='fas fa-power-off'></i></button>";
                }

                // if ($list->brgkatid == "") {
                //     $tomboleditkategori = $tombolEdit;
                //     $tombolhapuskategori = $tombolHapus;
                // } else {
                //     $tomboleditkategori = "";
                //     $tombolhapuskategori = "";
                // }

                $row[] = $no;
                $row[] = $list->lowonganjob;
                $row[] = date('d M Y', strtotime($list->lowongantanggal));
                $row[] = $list->lowonganstatus;
                $row[] = $tombolEdit . ' ' . $tombolHapus . ' ' . $tombolPrint . ' ' . $status;
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
            'subjudul'      => 'Lowongan - Input'
        ];

        return view('lowongan/formtambah', $data);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'lowonganjob' => [
                    'rules'     => 'required',
                    'label'     => 'Bagian',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'summernotedesk' => [
                    'rules'     => 'required',
                    'label'     => 'Deskripsi',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'summernotepers' => [
                    'rules'     => 'required',
                    'label'     => 'Peryaratan',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errLowonganJob'    => $validation->getError('lowonganjob'),
                        'errLowonganDesk'   => $validation->getError('summernotedesk'),
                        'errLowonganPers'   => $validation->getError('summernotepers'),
                    ]
                ];
            } else {
                $this->lowongan->insert([
                    'lowonganjob'               => $this->request->getPost('lowonganjob'),
                    'lowongandeskripsi'         => $this->request->getPost('summernotedesk'),
                    'lowonganpersyaratan'       => $this->request->getPost('summernotepers'),
                    'lowongantanggal'           => date('Y-m-d'),
                    'lowonganstatus'            => 'Aktif',
                ]);

                $json = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }


    public function formedit($lowonganid)
    {
        $cekLoker = $this->lowongan->find($lowonganid);
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Lowongan - Edit',
            'lowonganjob'           =>  $cekLoker['lowonganjob'],
            'lowongandeskripsi'     =>  $cekLoker['lowongandeskripsi'],
            'lowonganpersyaratan'   =>  $cekLoker['lowonganpersyaratan'],
        ];

        return view('lowongan/formedit', $data);
    }

    public function hapusdata($lowonganid)
    {
        $this->lowongan->delete($lowonganid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }

    public function cetaklowongan($lowonganid)
    {

        $cekLoker = $this->lowongan->find($lowonganid);
        $data = [
            'lowonganjob'           =>  $cekLoker['lowonganjob'],
            'lowongandeskripsi'     =>  $cekLoker['lowongandeskripsi'],
            'lowonganpersyaratan'   =>  $cekLoker['lowonganpersyaratan'],
        ];

        return view('lowongan/cetaklowongan', $data);
    }

    public function ubahstatus($lowonganid)
    {
        $cekLoker = $this->lowongan->find($lowonganid);
        if ($cekLoker['lowonganstatus'] == "Aktif") {
            $this->lowongan->update($lowonganid, [
                'lowonganstatus' => 'Tidak Aktif'
            ]);
        } else {
            $this->lowongan->update($lowonganid, [
                'lowonganstatus' => 'Aktif'
            ]);
        }

        $json = [
            'sukses' => 'Data berhasil dirubah'
        ];


        echo json_encode($json);
    }
}
