<?php

include_once(__DIR__ . "/KontrakPresenter.php");
include_once(__DIR__ . "/../models/TabelPembalap.php");
include_once(__DIR__ . "/../models/Pembalap.php");
include_once(__DIR__ . "/../views/ViewPembalap.php");

class PresenterPembalap implements KontrakPresenter
{
    private $tabelPembalap;
    private $viewPembalap;
    private $listPembalap = [];

    public function __construct($tabelPembalap, $viewPembalap)
    {
        $this->tabelPembalap = $tabelPembalap;
        $this->viewPembalap = $viewPembalap;
        $this->initListPembalap();
    }

    public function initListPembalap()
    {
        $data = $this->tabelPembalap->getAllPembalap();
        $this->listPembalap = [];
        foreach ($data as $item) {
            $this->listPembalap[] = new Pembalap(
                $item['id'], $item['nama'], $item['tim'], 
                $item['negara'], $item['poinMusim'], $item['jumlahMenang']
            );
        }
    }

    public function tampilkanPembalap(): string
    {
        return $this->viewPembalap->tampilPembalap($this->listPembalap);
    }

    public function tampilkanFormPembalap($id = null): string
    {
        $data = null;
        if ($id !== null) {
            // Presenter memanggil Model untuk mengambil data pembalap berdasarkan ID
            $data = $this->tabelPembalap->getPembalapById($id); 
        }
        // Data dikirim ke View untuk di-render ke form
        return $this->viewPembalap->tampilFormPembalap($data);
    }

    // Implementasi metode CRUD
    public function tambahPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        $this->tabelPembalap->addPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang);
    }

    public function ubahPembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        $this->tabelPembalap->updatePembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang);
    }

    public function hapusPembalap($id): void {
        $this->tabelPembalap->deletePembalap($id);
    }
}

?>