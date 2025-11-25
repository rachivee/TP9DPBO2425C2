# TP9DPBO2425C2

Saya Farah Maulida dengan NIM 2410024 mengerjakan Tugas Praktikum 9 dalam mata kuliah Desain dan Pemrograman Berbasis Objek untuk keberkahan-Nya maka saya tidak akan melakukan kecurangan seperti yang telah di spesifikasikan Aamiin.

# Aplikasi Manajemen Data Balapan 

Aplikasi ini adalah sistem manajemen data sederhana untuk mengelola data Pembalap dan Hasil Balapan (Grand Prix). Aplikasi ini dibangun menggunakan pola desain perangkat lunak Model-View-Presenter (MVP) dengan konsep Pemrograman Berorientasi Objek (OOP).

# Penjelasan Desain
Aplikasi ini memisahkan kode menjadi tiga lapisan utama agar kode lebih rapi, mudah dikelola, dan scalable:

1. Model (Data Layer)
Bertanggung jawab untuk urusan database.

Peran: Melakukan query SQL (SELECT, INSERT, UPDATE, DELETE).
Contoh: TabelPembalap.php dan TabelHasilBalapan.php.
Aturan: Model tidak boleh tahu apa-apa tentang HTML atau tampilan.

2. View (UI Layer)
Bertanggung jawab untuk apa yang dilihat pengguna.

Peran: Membaca template HTML (skin.html, dll) dan mengganti placeholder dengan data asli.
Contoh: ViewPembalap.php dan ViewHasil.php.
Aturan: View tidak boleh melakukan query ke database secara langsung. View hanya menerima data matang dari Presenter.

3. Presenter (Logic Layer)
Bertindak sebagai "otak" atau perantara.

Peran: Menerima perintah dari index.php, meminta data dari Model, lalu memberikan data tersebut ke View untuk ditampilkan.
Contoh: PresenterPembalap.php dan PresenterHasil.php.

# Alur Program
Semua interaksi pengguna diproses melalui satu pintu utama yaitu index.php.

1. Menampilkan Data (Request GET)
Contoh: Pengguna ingin melihat Daftar Hasil Balapan.

User membuka URL index.php?screen=hasil.
Index.php mengecek parameter screen.
Index.php memanggil method tampilkanList() pada PresenterHasil.
PresenterHasil meminta data dari TabelHasilBalapan (Model).
Model me-return array data dari database.
PresenterHasil melempar data tersebut ke ViewHasil.
ViewHasil merender HTML dan mengirimkannya ke browser User.

2. Menambah Data (Request POST)
Contoh: Pengguna mengisi Form Tambah Hasil Balapan dan klik "Simpan".

Form mengirim data via POST dengan name="action" value="add_hasil".
Index.php mendeteksi adanya $_POST['action'].
Index.php memanggil method simpanHasil() pada PresenterHasil.
PresenterHasil memvalidasi dan mengirim data ke TabelHasilBalapan (Model).
Model menjalankan query INSERT ke database.
Index.php melakukan redirect kembali ke halaman daftar.

# Dokumentasi
