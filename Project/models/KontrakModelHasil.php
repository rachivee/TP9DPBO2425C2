<?php
interface KontrakModelHasil {
    public function getAllHasil();
    public function addHasil($gp, $tgl, $id_p, $pos, $poin);
    public function getHasilById($id); // Untuk Edit
    public function updateHasil($id, $gp, $tgl, $id_p, $pos, $poin); // Untuk Edit
    public function deleteHasil($id); // Untuk Delete
}
?>