<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSuplierPagination;
use App\Models\ModelSuplier;
use CodeIgniter\Validation\Rules;
use Config\Services;

class Suplier extends BaseController
{
    public function formtambah()
    {
        $json = [
            'data' => view('suplier/modaltambah')
        ];

        echo json_encode($json);
    }

    public function simpan()
    {
        $supnama        = $this->request->getPost('supnama');
        $suptelp        = $this->request->getPost('suptelp');
        $supalamat      = $this->request->getPost('supalamat');
        $supnpwp        = $this->request->getPost('supnpwp');
        $suprekening    = $this->request->getPost('suprekening');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'supnama' => [
                'rules'     => 'required',
                'label'     => 'Nama Suplier',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ],
            'suptelp' => [
                'rules'     => 'required|is_unique[suplier.suptelp]',
                'label'     => 'Nomor Telp/Hp',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                    'is_unique' => '{field} tidak boleh ada yang sama'
                ]
            ],
            'supalamat' => [
                'rules'     => 'required',
                'label'     => 'Alamat',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ],
            'supnpwp' => [
                'rules'     => 'numeric',
                'label'     => 'NPWP',
                'errors'    => [
                    'numeric'  => '{field} tidak boleh kosong'
                ]
            ],
            'suprekening' => [
                'rules'     => 'numeric',
                'label'     => 'Rekening',
                'errors'    => [
                    'numeric'  => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $json = [
                'error' => [
                    'errSupNama'        => $validation->getError('supnama'),
                    'errSupTelp'        => $validation->getError('suptelp'),
                    'errSupAlamat'      => $validation->getError('supalamat'),
                    'errSupNpwp'        => $validation->getError('supnpwp'),
                    'errSupRekening'    => $validation->getError('suprekening'),
                ]
            ];
        } else {
            $modelSuplier = new ModelSuplier();

            $modelSuplier->insert([
                'supnama'       => $supnama,
                'suptelp'       => $suptelp,
                'supalamat'     => $supalamat,
                'supnpwp'       => $supnpwp,
                'suprekening'   => $suprekening
            ]);

            $rowData = $modelSuplier->ambilDataTerakhir()->getRowArray();

            $json = [
                'sukses'        => 'Data Suplier berhasil disimpan, ambil data terakhir ?',
                'namasuplier' => $rowData['supnama'],
                'idsuplier'   => $rowData['supid']
            ];
        }

        echo json_encode($json);
    }

    public function modalData()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('suplier/modaldata')
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelSuplierPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->supid . "', '" . $list->supnama . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->supid . "', '" . $list->supnama . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                $row[] = $no;
                $row[] = $list->supnama;
                $row[] = $list->suptelp;
                $row[] = $list->supalamat;
                $row[] = $tombolPilih . " " . $tombolHapus;
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

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelSuplier = new ModelSuplier();

            $modelSuplier->delete($id);

            $json = [
                'sukses' => 'Data Suplier berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }
}
