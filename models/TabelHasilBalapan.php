<?php
include_once("models/DB.php");

class TabelHasilBalapan extends DB {
    public function __construct($host, $db_name, $username, $password) {
        parent::__construct($host, $db_name, $username, $password);
    }

    public function getAllHasil() {
        // Kita JOIN dengan tabel pembalap supaya dapat namanya
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
}
?>