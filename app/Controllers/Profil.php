<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBiodataKtp;
use App\Models\ModelLevels;
use App\Models\ModelUsers;
use App\Models\ModelWilayah;
use Config\Services;

class Profil extends BaseController
{

    public function __construct()
    {
        $this->users    = new ModelUsers();
        $this->biodataKtp   = new ModelBiodataKtp();
        $this->wilayah    = new ModelWilayah();
    }



    public function index($admin)
    {
        //ambil tabel user
        $modelUser = new ModelUsers();
        $rowUser = $modelUser->find($admin);

        //ambil tabel biodata ktp
        $modelKtp = new ModelBiodataKtp();
        $rowKtp = $modelKtp->find($rowUser['userktp']);

        //ambil tabel wilayah
        $modelWilayah = new ModelWilayah();
        $rowWilayah = $modelWilayah->find($rowKtp['ktp_alamatid']);
        if ($rowWilayah > 0) {
            $data_wilayah = [
                'kelurahan'         => $rowWilayah['kelurahan'],
                'kecamatan'         => $rowWilayah['kecamatan'],
                'kota_kabupaten'    => $rowWilayah['kota_kabupaten'],
                'propinsi'          => $rowWilayah['propinsi'],
            ];
        } else {
            $data_wilayah = [
                'kelurahan'         => '',
                'kecamatan'         => '',
                'kota_kabupaten'    => '',
                'propinsi'    => '',
            ];
        }

        if ($rowKtp > 0) {
            $data = [
                'judul'             => 'Home',
                'subjudul'          => 'Profil',
                'validation'        => \Config\Services::validation(),
                'userid'            => $rowUser['userid'],
                'usernama'          => $rowUser['usernama'],
                'ktp_nomor'         => $rowKtp['ktp_nomor'],
                'ktp_nama'          => $rowKtp['ktp_nama'],
                'ktp_tempat_lahir'  => $rowKtp['ktp_tempat_lahir'],
                'ktp_tanggal_lahir' => $rowKtp['ktp_tanggal_lahir'],
                'ktp_kelamin'       => $rowKtp['ktp_kelamin'],
                'ktp_alamat'        => $rowKtp['ktp_alamat'],
                'ktp_rt'            => $rowKtp['ktp_rt'],
                'ktp_rw'            => $rowKtp['ktp_rw'],
                'ktp_alamatid'      => $rowKtp['ktp_alamatid'],
                'ktp_hp'            => $rowKtp['ktp_hp'],
                'ktp_email'         => $rowKtp['ktp_email'],
                'ktp_foto'          => $rowKtp['ktp_foto'],
                'kelurahan'         => $data_wilayah['kelurahan'],
                'kecamatan'         => $data_wilayah['kecamatan'],
                'kota_kabupaten'    => $data_wilayah['kota_kabupaten'],
                'propinsi'          => $data_wilayah['propinsi'],
            ];
        } else {
            $data = [
                'judul'             => 'Home',
                'subjudul'          => 'Profil',
                'validation'        => \Config\Services::validation(),
                'userid'            => $rowUser['userid'],
                'usernama'          => $rowUser['usernama'],
                'ktp_nomor'         => '',
                'ktp_nama'          => '',
                'ktp_tempat_lahir'  => '',
                'ktp_tanggal_lahir' => '',
                'ktp_kelamin'       => '',
                'ktp_alamat'        => '',
                'ktp_rt'            => '',
                'ktp_rw'            => '',
                'ktp_alamatid'      => '',
                'ktp_hp'            => '',
                'ktp_email'         => '',
                'ktp_foto'          => '',
                'kelurahan'         => $data_wilayah['kelurahan'],
                'kecamatan'         => $data_wilayah['kecamatan'],
                'kota_kabupaten'    => $data_wilayah['kota_kabupaten'],
                'propinsi'          => $data_wilayah['propinsi'],
            ];
        }
        return view('profil/viewdata', $data);
    }



    public function formeditfoto($userid)
    {

        $cekData        = $this->users->find($userid);
        $cekDataKtp        = $this->biodataKtp->find($cekData['userktp']);
        if ($cekData) {


            $data = [
                'userid'        => $cekData['userid'],
                'ktp_nomor'     => $cekDataKtp['ktp_nomor'],
                'ktp_foto'      => $cekDataKtp['ktp_foto'],
            ];

            $json = [
                'data' => view('profil/formeditfoto', $data)
            ];
        }
        echo json_encode($json);
    }

    public function updatefoto()
    {

        $userid          = $this->request->getVar('userid');
        $ktp_nomor       = $this->request->getVar('ktp_nomor');
        $gambar        = $this->request->getVar('gambar');



        $cekData            = $this->biodataKtp->find($ktp_nomor);
        if ($cekData['ktp_foto'] == '') {
            $pathGambarLama     = '';
        } else {
            $pathGambarLama     = $cekData['ktp_foto'];
        }

        $gambar = $_FILES['gambar']['name'];

        if ($gambar != NULL) {
            ($pathGambarLama == '' || $pathGambarLama == null) ? '' : unlink('upload/' . $pathGambarLama);

            $namaFileGambar     = $ktp_nomor;
            $fileGambar         = $this->request->getFile('gambar');
            $fileGambar->move('upload/', $namaFileGambar . '.' . $fileGambar->getExtension());

            $pathGambar         = $fileGambar->getName();
        } else {
            $pathGambar         = $pathGambarLama;
        }

        $this->biodataKtp->update($ktp_nomor, [
            'ktp_foto'           => $pathGambar,
        ]);

        return view('profil/viewdata/', $userid);
    }
}
