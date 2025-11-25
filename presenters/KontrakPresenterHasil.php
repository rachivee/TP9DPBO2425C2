<?php
interface KontrakPresenterHasil {
    public function tampilkanList();
    public function tampilkanForm();
    public function tampilkanFormEdit($id);
    public function simpanHasil($gp, $tgl, $id_p, $pos, $poin);
    public function ubahHasil($id, $gp, $tgl, $id_p, $pos, $poin);
    public function hapusHasil($id);
}
?>