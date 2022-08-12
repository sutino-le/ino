<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLowonganApply;
use App\Models\ModelLowonganApplya;
use App\Models\ModelPsikotest;
use App\Models\ModelSoal;
use App\Models\ModelUsers;

class Psikotest extends BaseController
{
    public function index()
    {
        $modelApply = new ModelLowonganApply();

        $statusapply = $modelApply->cariData(session()->userktp);

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Psikotest',
            'statusapply'   => $statusapply
        ];

        return view('psikotest/viewdata', $data);
    }

    public function mulaitest($id)
    {
        $modelSoal  = new ModelSoal();
        $cekDataSoal = $modelSoal->findAll();

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Daftar Lowongan',
            'tampildata'    => $cekDataSoal,
            'waktu'         => $id
        ];

        return view('psikotest/mulaitest', $data);
    }



    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $modelSoal = new ModelSoal();
            $cekSoal = $modelSoal->findAll();

            $modelPsikotest = new ModelPsikotest();

            foreach ($cekSoal as $rowSoal) :
                $pertanyaan = "pertanyaan" . $rowSoal['testpertid'];
                $jawaban = "jawab" . $rowSoal['testpertid'];
                if ($rowSoal['testpertid'] == $this->request->getPost($pertanyaan) and $rowSoal['soaljaw'] == $this->request->getPost($jawaban)) {
                    $status = "Benar";
                }

                $this->$modelPsikotest->insert([
                    'testktp'               => $this->request->getPost('nomorktp'),
                    'testtanggal'              => $this->request->getPost('tanggal'),
                    'testpertid'           => $this->request->getPost($pertanyaan),
                    'testjawab'              => $this->request->getPost($jawaban),
                    'teststatus'              => $this->request->getPost($status)
                ]);

            endforeach;

            $json = [
                'sukses' => 'Data berhasil disimpan'
            ];


            echo json_encode($json);
        }
    }
}
