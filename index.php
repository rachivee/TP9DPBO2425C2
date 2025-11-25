<?php

// --- BLOK 1: PERSIAPAN (SETUP) ---
// Memanggil koneksi database
include_once("models/DB.php");

// Bagian 1: Setup untuk Pembalap
include_once("models/TabelPembalap.php");
include_once("views/ViewPembalap.php");
include_once("presenters/PresenterPembalap.php");

// Bagian 2: Setup untuk Hasil Balapan (Fitur Baru)
include_once("models/TabelHasilBalapan.php"); // Pastikan file ini sudah dibuat
include_once("views/ViewHasil.php");          // Pastikan file ini sudah dibuat
include_once("presenters/PresenterHasil.php");// Pastikan file ini sudah dibuat

// Menyiapkan Objek Database & View
$tabelPembalap = new TabelPembalap('localhost', 'mvp_db', 'root', '');
$viewPembalap = new ViewPembalap();

$tabelHasil = new TabelHasilBalapan('localhost', 'mvp_db', 'root', '');
$viewHasil = new ViewHasil();

// Menyiapkan Presenter (Pengelola Logika)
// Presenter Pembalap butuh tabelPembalap dan viewPembalap
$presenterPembalap = new PresenterPembalap($tabelPembalap, $viewPembalap);

// Presenter Hasil butuh tabelHasil, tabelPembalap (untuk dropdown nama), dan viewHasil
$presenterHasil = new PresenterHasil($tabelHasil, $tabelPembalap, $viewHasil);


// --- BLOK 2 & 3: POLISI LALU LINTAS (ROUTING) ---

// A. MENANGANI REQUEST TAMPILAN (GET)
// Cek apakah ada parameter 'screen' di URL? (contoh: index.php?screen=add)
if (isset($_GET['screen'])) {
    
    // --- RUTE PEMBALAP ---
    if ($_GET['screen'] == 'add') {
        // Tampilkan form tambah pembalap
        echo $presenterPembalap->tampilkanFormPembalap();
    }
    else if ($_GET['screen'] == 'edit' && isset($_GET['id'])) {
        // Tampilkan form edit pembalap (kirim ID agar data lama muncul)
        echo $presenterPembalap->tampilkanFormPembalap($_GET['id']);
    }
    
    // --- RUTE HASIL BALAPAN (BARU) ---
    else if ($_GET['screen'] == 'hasil') {
        // Tampilkan daftar hasil balapan
        echo $presenterHasil->tampilkanList();
    }
    else if ($_GET['screen'] == 'add_hasil') {
        // Tampilkan form tambah hasil balapan
        echo $presenterHasil->tampilkanForm();
    }
}

// B. MENANGANI REQUEST AKSI / DATA MASUK (POST)
// Cek apakah ada data yang dikirim lewat form? (name="action")
else if (isset($_POST['action'])) {

    $action = $_POST['action'];

    // --- AKSI UNTUK PEMBALAP ---
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
        
        // Setelah selesai, balik ke daftar pembalap
        header("Location: index.php");
        exit();
    }

    // --- AKSI UNTUK HASIL BALAPAN (BARU) ---
    else if ($action == 'add_hasil') {
        // Ambil data dari form hasil
        $nama_event = $_POST['nama_event'];
        $tanggal = $_POST['tanggal'];
        $id_pembalap = $_POST['id_pembalap'];
        $posisi = $_POST['posisi'];
        $poin = $_POST['poin'];

        // Simpan data
        $presenterHasil->simpanHasil($nama_event, $tanggal, $id_pembalap, $posisi, $poin);

        // Setelah selesai, balik ke daftar hasil
        header("Location: index.php?screen=hasil");
        exit();
    }

} 

// C. DEFAULT (JIKA TIDAK ADA REQUEST APA-APA)
else {
    // Tampilkan halaman utama (Daftar Pembalap)
    // Di sini kita tambahkan tombol navigasi kecil untuk pindah ke halaman Hasil Balapan
    echo '<div style="max-width:980px; margin: 10px auto; text-align:right;">
            <a href="index.php?screen=hasil" style="padding:10px; background:#eee; text-decoration:none; border-radius:5px;">
                Lihat Riwayat Balapan &rarr;
            </a>
          </div>';
          
    echo $presenterPembalap->tampilkanPembalap();
}

?>