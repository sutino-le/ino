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

        $modelPsikotest = new ModelPsikotest();
        $cekTest = $modelPsikotest->dataTest(session()->userktp);

        foreach ($cekTest->getResultArray() as $rowTest) :
            $idtest = $rowTest['testid'];
            if ($rowTest['testkuncijawaban'] == $rowTest['testjawab']) {
                $modelPsikotest->update($idtest, [
                    'teststatus' => 'Benar'
                ]);
            } else {
                $modelPsikotest->update($idtest, [
                    'teststatus' => 'Salah'
                ]);
            }
        endforeach;

        $dataTest = $modelPsikotest->cekPsikotest(session()->userktp);

        $hasilTest = $modelPsikotest->hasilPsikotest(session()->userktp);

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Psikotest',
            'menu'          => 'lowongan',
            'submenu'       => 'psikotest',
            'statusapply'   => $statusapply,
            'dataktp'       => $dataTest,
            'hasilTest'     => $hasilTest
        ];

        return view('psikotest/viewdata', $data);
    }

    public function mulaitest($id)
    {
        $modelPsikotest = new ModelPsikotest();
        $dataTest = $modelPsikotest->cekPsikotest(session()->userktp);

        $modelSoal  = new ModelSoal();
        $cekDataSoal = $modelSoal->findAll();

        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Daftar Lowongan',
            'menu'          => 'lowongan',
            'submenu'       => 'psikotest',
            'tampildata'    => $cekDataSoal,
            'waktu'         => $id,
            'dataktp'       => $dataTest
        ];

        return view('psikotest/mulaitest', $data);
    }



    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $nomorktp       = $this->request->getVar('nomorktp');
            $tanggal        = $this->request->getVar('tanggal');
            $soal           = $this->request->getVar('soal');
            $kuncijawaban   = $this->request->getVar('kuncijawaban');
            $jawab          = $this->request->getVar('jawab');

            $jmldata = count($nomorktp);

            $modelPsikotest = new ModelPsikotest();
            for ($i = 0; $i < $jmldata; $i++) {
                $modelPsikotest->insert([
                    'testktp'           => $nomorktp[$i],
                    'testtanggal'       => $tanggal[$i],
                    'testpertid'        => $soal[$i],
                    'testkuncijawaban'  => $kuncijawaban[$i],
                    'testjawab'         => $jawab[$i],
                    'teststatus'        => ''
                ]);
            }

            $json = [
                'sukses' => 'Data berhasil disimpan'
            ];

            echo json_encode($json);
        }
    }


    public function lihathasil()
    {

        $modelPsikotest = new ModelPsikotest();
        $cekHasilTest = $modelPsikotest->detailPsikotes(session()->userktp);


        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Psikotest',
            'menu'          => 'lowongan',
            'submenu'       => 'psikotest',
            'tampilhasiltest'   => $cekHasilTest,
        ];

        return view('psikotest/hasiltest', $data);
    }
}