<?php
include_once("models/DB.php");

// Bagian 1: Setup untuk Pembalap
include_once("models/TabelPembalap.php");
include_once("views/ViewPembalap.php");
include_once("presenters/PresenterPembalap.php");

// Bagian 2: Setup untuk Hasil Balapan (Fitur Baru)
include_once("models/TabelHasilBalapan.php"); 
include_once("views/ViewHasil.php");
include_once("presenters/PresenterHasil.php");

$tabelPembalap = new TabelPembalap('localhost', 'mvp_db', 'root', '');
$viewPembalap = new ViewPembalap();

$tabelHasil = new TabelHasilBalapan('localhost', 'mvp_db', 'root', '');
$viewHasil = new ViewHasil();

$presenterPembalap = new PresenterPembalap($tabelPembalap, $viewPembalap);

$presenterHasil = new PresenterHasil($tabelHasil, $tabelPembalap, $viewHasil);

if (isset($_GET['screen'])) {

    if ($_GET['screen'] == 'add') {
        echo $presenterPembalap->tampilkanFormPembalap();
    }
    else if ($_GET['screen'] == 'edit' && isset($_GET['id'])) {
        echo $presenterPembalap->tampilkanFormPembalap($_GET['id']);
    }
    else if ($_GET['screen'] == 'hasil') {
        echo $presenterHasil->tampilkanList();
    }
    else if ($_GET['screen'] == 'add_hasil') {
        echo $presenterHasil->tampilkanForm();
    }
    else if ($_GET['screen'] == 'edit_hasil' && isset($_GET['id'])) {
        echo $presenterHasil->tampilkanFormEdit($_GET['id']);
    }
}else if (isset($_POST['action'])) {

    $action = $_POST['action'];
    if ($action == 'add' || $action == 'edit' || $action == 'delete') {
        
        $nama = $_POST['nama'] ?? '';
        $tim = $_POST['tim'] ?? '';
        $negara = $_POST['negara'] ?? '';
        $poinMusim = $_POST['poinMusim'] ?? 0;
        $jumlahMenang = $_POST['jumlahMenang'] ?? 0;
        $id = $_POST['id'] ?? null;

        if ($action == 'add') {
            $presenterPembalap->tambahPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang);
        } elseif ($action == 'edit') {
            $presenterPembalap->ubahPembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang);
        } elseif ($action == 'delete') {
            $presenterPembalap->hapusPembalap($id);
        }
 
        header("Location: index.php");
        exit();
    }

    if ($action == 'add_hasil') {
        $presenterHasil->simpanHasil($_POST['nama_event'], $_POST['tanggal'], $_POST['id_pembalap'], $_POST['posisi'], $_POST['poin']);
        header("Location: index.php?screen=hasil");
        exit();
    }
    else if ($action == 'edit_hasil') {
        $presenterHasil->ubahHasil($_POST['id'], $_POST['nama_event'], $_POST['tanggal'], $_POST['id_pembalap'], $_POST['posisi'], $_POST['poin']);
        header("Location: index.php?screen=hasil");
        exit();
    }
    else if ($action == 'delete_hasil') {
        $presenterHasil->hapusHasil($_POST['id']);
        header("Location: index.php?screen=hasil");
        exit();
    }

} else {
    echo '<div style="max-width:980px; margin: 10px auto; text-align:right;">
            <a href="index.php?screen=hasil" style="padding:10px; background:#eee; text-decoration:none; border-radius:5px;">
                Lihat Riwayat Balapan &rarr;
            </a>
          </div>';
          
    echo $presenterPembalap->tampilkanPembalap();
}

?>