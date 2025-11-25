<?php
include_once("models/DB.php");
include_once("models/KontrakModelHasil.php"); // Load interface

class TabelHasilBalapan extends DB implements KontrakModelHasil { // Implement
    public function __construct($host, $db_name, $username, $password) {
        parent::__construct($host, $db_name, $username, $password);
    }

    public function getAllHasil() {
        $query = "SELECT h.*, p.nama as nama_pembalap 
                  FROM hasil_balapan h 
                  JOIN pembalap p ON h.id_pembalap = p.id 
                  ORDER BY h.tanggal DESC";
        $this->executeQuery($query);
        return $this->getAllResult();
    }

    public function addHasil($nama_event, $tanggal, $id_pembalap, $posisi, $poin) {
        $query = "INSERT INTO hasil_balapan (nama_event, tanggal, id_pembalap, posisi_finish, poin_didapat) 
                  VALUES (:gp, :tgl, :idp, :pos, :poin)";
        $this->executeQuery($query, [
            ':gp' => $nama_event, ':tgl' => $tanggal, ':idp' => $id_pembalap, 
            ':pos' => $posisi, ':poin' => $poin
        ]);
    }

    // --- TAMBAHAN UNTUK CRUD LENGKAP ---

    public function getHasilById($id) {
        $query = "SELECT * FROM hasil_balapan WHERE id = :id";
        $this->executeQuery($query, [':id' => $id]);
        $res = $this->getAllResult();
        return $res[0] ?? null;
    }

    public function updateHasil($id, $nama_event, $tanggal, $id_pembalap, $posisi, $poin) {
        $query = "UPDATE hasil_balapan 
                  SET nama_event = :gp, tanggal = :tgl, id_pembalap = :idp, posisi_finish = :pos, poin_didapat = :poin 
                  WHERE id = :id";
        $this->executeQuery($query, [
            ':id' => $id, ':gp' => $nama_event, ':tgl' => $tanggal, 
            ':idp' => $id_pembalap, ':pos' => $posisi, ':poin' => $poin
        ]);
    }

    public function deleteHasil($id) {
        $query = "DELETE FROM hasil_balapan WHERE id = :id";
        $this->executeQuery($query, [':id' => $id]);
    }
}
?>