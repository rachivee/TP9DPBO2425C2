<?php

class ViewHasil {

    // Menampilkan Tabel Riwayat Balapan
    public function tampilkanList($listHasil) {
        
        // 1. Load template utama (skin.html)
        // Pastikan file skin.html ada di folder template
        $template = file_get_contents(__DIR__ . '/../template/skin.html');

        // 2. Ganti Judul Halaman
        $template = str_replace('<h1>Daftar Pembalap</h1>', '<h1>Riwayat Balapan</h1>', $template);
        $template = str_replace('<title>Pembalap — Daftar</title>', '<title>Hasil Balapan — Daftar</title>', $template);

        // 3. Ganti Tombol "Tambah Pembalap" jadi "Catat Hasil"
        // Kita cari tombol lama di skin.html dan ganti dengan tombol baru yang mengarah ke screen=add_hasil
        $tombolBaru = '<a href="index.php?screen=add_hasil" class="btn btn-add">+ Catat Hasil</a>';
        $template = preg_replace('/<a href="index\.php\?screen=add".*?<\/a>/', $tombolBaru, $template);

        // 4. Ganti Header Tabel (Bagian <thead>)
        // Kita timpa kolom-kolom Pembalap dengan kolom Hasil Balapan
        $headerBaru = '
          <thead>
            <tr>
              <th class="col-id">No</th>
              <th>Grand Prix</th>
              <th>Tanggal</th>
              <th>Pembalap</th>
              <th>Posisi</th>
              <th>Poin</th>
            </tr>
          </thead>
        ';
        // Regex untuk mencari tag <thead> sampai </thead> dan menggantinya
        $template = preg_replace('/<thead>.*?<\/thead>/s', $headerBaru, $template);

        // 5. Buat Baris Data (<tbody>)
        $tbody = '';
        
        if (empty($listHasil)) {
            // Jika data kosong, tampilkan pesan
            $tbody .= '<tr><td colspan="6" style="text-align:center; padding:20px;">Belum ada data hasil balapan.</td></tr>';
        } else {
            $no = 1;
            foreach($listHasil as $h){
                $tbody .= '<tr>';
                $tbody .= '<td class="col-id">'. $no .'</td>';
                $tbody .= '<td>'. htmlspecialchars($h->nama_event) .'</td>';
                $tbody .= '<td>'. htmlspecialchars($h->tanggal) .'</td>';
                // nama_pembalap didapat dari JOIN di Model
                $tbody .= '<td><b>'. htmlspecialchars($h->nama_pembalap) .'</b></td>'; 
                $tbody .= '<td>'. htmlspecialchars($h->posisi_finish) .'</td>';
                $tbody .= '<td>+'. htmlspecialchars($h->poin_didapat) .'</td>';
                $tbody .= '</tr>';
                $no++;
            }
        }

        // 6. Masukkan baris data ke template
        $template = str_replace('', $tbody, $template);

        // 7. Update Total Data di bagian bawah tabel
        $template = str_replace('Total:', 'Total Data: ' . count($listHasil), $template);

        return $template;
    }

    // Menampilkan Form Input Hasil
    public function tampilkanForm($listPembalap) {
        // 1. Load template form khusus hasil balapan
        // Pastikan Anda sudah membuat file template/form_hasil.html sebelumnya
        $template = file_get_contents(__DIR__ . '/../template/form_hasil.html');

        // 2. Buat opsi dropdown (Looping data pembalap)
        $options = '';
        foreach ($listPembalap as $p) {
            $id = $p['id'];
            $nama = htmlspecialchars($p['nama']);
            $tim = htmlspecialchars($p['tim']);
            
            $options .= "<option value='$id'>$nama ($tim)</option>";
        }

        // 3. Masukkan opsi ke dalam penanda di HTML
        // Pastikan di form_hasil.html tertulis: DATA_PEMBALAP_DISINI
        $template = str_replace('DATA_PEMBALAP_DISINI', $options, $template);

        return $template;
    }
}
?>