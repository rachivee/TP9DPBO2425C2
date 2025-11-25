<?php
class HasilBalapan {
    public $id;
    public $nama_event;
    public $tanggal;
    public $id_pembalap;
    public $nama_pembalap; // Properti tambahan untuk join/tampilan
    public $posisi_finish;
    public $poin_didapat;

    public function __construct($id, $nama_event, $tanggal, $id_pembalap, $posisi_finish, $poin_didapat, $nama_pembalap = "") {
        $this->id = $id;
        $this->nama_event = $nama_event;
        $this->tanggal = $tanggal;
        $this->id_pembalap = $id_pembalap;
        $this->posisi_finish = $posisi_finish;
        $this->poin_didapat = $poin_didapat;
        $this->nama_pembalap = $nama_pembalap;
    }
}
?>