<?php
include_once("models/HasilBalapan.php");

class PresenterHasil {
    private $tabelHasil;
    private $tabelPembalap; // Butuh ini buat dropdown
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
            $listObjek[] = new HasilBalapan(
                $row['id'], $row['nama_event'], $row['tanggal'], 
                $row['id_pembalap'], $row['posisi_finish'], $row['poin_didapat'], 
                $row['nama_pembalap'] // Ambil dari hasil join
            );
        }
        return $this->view->tampilkanList($listObjek);
    }

    public function tampilkanForm() {
        // Ambil semua pembalap buat isi dropdown
        $listPembalap = $this->tabelPembalap->getAllPembalap();
        return $this->view->tampilkanForm($listPembalap);
    }

    public function simpanHasil($gp, $tgl, $id_p, $pos, $poin) {
        $this->tabelHasil->addHasil($gp, $tgl, $id_p, $pos, $poin);
    }
}
?>