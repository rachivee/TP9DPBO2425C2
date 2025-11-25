<?php
include_once("models/HasilBalapan.php");

class PresenterHasil {
    private $tabelHasil;
    private $tabelPembalap;
    private $view;

    public function __construct($tabelHasil, $tabelPembalap, $view) {
        $this->tabelHasil = $tabelHasil;
        $this->tabelPembalap = $tabelPembalap;
        $this->view = $view;
    }

    public function tampilkanList() {
        $data = $this->tabelHasil->getAllHasil();
        $listObjek = [];
        foreach ($data as $row) {
            // Pastikan konstruktor HasilBalapan sesuai
            $listObjek[] = new HasilBalapan(
                $row['id'], $row['nama_event'], $row['tanggal'], 
                $row['id_pembalap'], $row['posisi_finish'], $row['poin_didapat'], 
                $row['nama_pembalap']
            );
        }
        return $this->view->tampilkanList($listObjek);
    }

    // CREATE (Form Kosong)
    public function tampilkanForm() {
        $listPembalap = $this->tabelPembalap->getAllPembalap();
        return $this->view->tampilkanForm($listPembalap);
    }

    // UPDATE (Form Terisi)
    public function tampilkanFormEdit($id) {
        $listPembalap = $this->tabelPembalap->getAllPembalap();
        $dataHasil = $this->tabelHasil->getHasilById($id);
        return $this->view->tampilkanForm($listPembalap, $dataHasil);
    }

    public function simpanHasil($gp, $tgl, $id_p, $pos, $poin) {
        $this->tabelHasil->addHasil($gp, $tgl, $id_p, $pos, $poin);
    }

    public function ubahHasil($id, $gp, $tgl, $id_p, $pos, $poin) {
        $this->tabelHasil->updateHasil($id, $gp, $tgl, $id_p, $pos, $poin);
    }

    public function hapusHasil($id) {
        $this->tabelHasil->deleteHasil($id);
    }
}
?>