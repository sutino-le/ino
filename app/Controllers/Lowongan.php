<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLowongan;
use App\Models\ModelLowonganApply;
use App\Models\ModelLowonganPagination;
use Config\Services;


class Lowongan extends BaseController
{


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Lowongan',
            'menu'          => 'masterhr',
            'submenu'       => 'lowongan',
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
            'subjudul'      => 'Lowongan - Input',
            'menu'          => 'masterhr',
            'submenu'       => 'lowongan',
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
                $modelLowongan = new ModelLowongan();
                $modelLowongan->insert([
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
        $modelLowongan = new ModelLowongan();
        $cekLoker = $modelLowongan->find($lowonganid);
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Lowongan - Edit',
            'menu'          => 'masterhr',
            'submenu'       => 'lowongan',
            'lowonganjob'           =>  $cekLoker['lowonganjob'],
            'lowongandeskripsi'     =>  $cekLoker['lowongandeskripsi'],
            'lowonganpersyaratan'   =>  $cekLoker['lowonganpersyaratan'],
        ];

        return view('lowongan/formedit', $data);
    }

    public function hapusdata($lowonganid)
    {
        $modelLowongan = new ModelLowongan();
        $modelLowongan->delete($lowonganid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }

    public function cetaklowongan($lowonganid)
    {
        $modelLowongan = new ModelLowongan();
        $cekLoker = $modelLowongan->find($lowonganid);
        $data = [
            'lowonganjob'           =>  $cekLoker['lowonganjob'],
            'lowongandeskripsi'     =>  $cekLoker['lowongandeskripsi'],
            'lowonganpersyaratan'   =>  $cekLoker['lowonganpersyaratan'],
        ];

        return view('lowongan/cetaklowongan', $data);
    }

    public function ubahstatus($lowonganid)
    {
        $modelLowongan = new ModelLowongan();

        $cekLoker = $modelLowongan->find($lowonganid);
        if ($cekLoker['lowonganstatus'] == "Aktif") {
            $modelLowongan->update($lowonganid, [
                'lowonganstatus' => 'Tidak Aktif'
            ]);
        } else {
            $modelLowongan->update($lowonganid, [
                'lowonganstatus' => 'Aktif'
            ]);
        }

        $json = [
            'sukses' => 'Data berhasil dirubah'
        ];


        echo json_encode($json);
    }

    public function lowongandaftar()
    {
        $status = "Aktif";
        $modelLowongan  = new ModelLowongan();
        $cekDataLoker = $modelLowongan->cariData($status);

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Daftar Lowongan',
            'menu'          => 'lowongan',
            'submenu'       => 'lowongankerja',
            'tampildata'    => $cekDataLoker,
        ];

        return view('lowongan/lowongandaftar', $data);
    }

    public function lowonganapply()
    {
        if ($this->request->isAJAX()) {
            $lowonganid = $this->request->getPost('lowonganid');
            $applytanggal = date('Y-m-d');
            $modelApply = new ModelLowonganApply();

            // $userktp = session()->userktp;

            // // cek dulu udah pernah ngelamar belom
            // $cekData = $modelApply->cekApply($userktp, $lowonganid);


            $modelApply->insert([
                'applyktp'      => session()->userktp,
                'applylowid'    => $lowonganid,
                'applytanggal'  => $applytanggal,
                'applystatus'   => 'Submit'
            ]);

            $json = [
                'sukses' => 'Anda berhasil submit'
            ];

            echo json_encode($json);
        }
    }
}
