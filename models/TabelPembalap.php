<?php

include_once ("models/DB.php");
include_once ("KontrakModel.php");

class TabelPembalap extends DB implements KontrakModel {

    public function __construct($host, $db_name, $username, $password) {
        parent::__construct($host, $db_name, $username, $password);
    }

    public function getAllPembalap(): array {
        $query = "SELECT * FROM pembalap";
        $this->executeQuery($query);
        return $this->getAllResult();
    }

    public function getPembalapById($id): ?array {
        $this->executeQuery("SELECT * FROM pembalap WHERE id = :id", ['id' => $id]);
        $results = $this->getAllResult();
        return $results[0] ?? null;
    }

    // Implementasi method Create
    public function addPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        $query = "INSERT INTO pembalap (nama, tim, negara, poinMusim, jumlahMenang) 
                  VALUES (:nama, :tim, :negara, :poin, :menang)";
        $params = [
            ':nama' => $nama,
            ':tim' => $tim,
            ':negara' => $negara,
            ':poin' => $poinMusim,
            ':menang' => $jumlahMenang
        ];
        $this->executeQuery($query, $params);
    }

    // Implementasi method Update
    public function updatePembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        $query = "UPDATE pembalap 
                  SET nama = :nama, tim = :tim, negara = :negara, poinMusim = :poin, jumlahMenang = :menang 
                  WHERE id = :id";
        $params = [
            ':id' => $id,
            ':nama' => $nama,
            ':tim' => $tim,
            ':negara' => $negara,
            ':poin' => $poinMusim,
            ':menang' => $jumlahMenang
        ];
        $this->executeQuery($query, $params);
    }

    // Implementasi method Delete
    public function deletePembalap($id): void {
        $query = "DELETE FROM pembalap WHERE id = :id";
        $params = [':id' => $id];
        $this->executeQuery($query, $params);
    }
}

?>