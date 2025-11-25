<?php
include_once("KontrakViewHasil.php");

class ViewHasil implements KontrakViewHasil {

    public function tampilkanList($listHasil) {
        $template = file_get_contents(__DIR__ . '/../template/skin.html');

        // Navigasi & Judul (Seperti sebelumnya)
        $template = str_replace('<h1>Daftar Pembalap</h1>', '<h1>Riwayat Balapan</h1>', $template);
        $template = str_replace('<title>Pembalap — Daftar</title>', '<title>Hasil Balapan</title>', $template);
        
        $tombolBaru = '<a href="index.php" class="btn" style="border:1px solid #ccc; margin-right:5px;">&larr; Kembali</a>
                       <a href="index.php?screen=add_hasil" class="btn btn-add">+ Catat Hasil</a>';
        $template = preg_replace('/<a href="index\.php\?screen=add".*?<\/a>/', $tombolBaru, $template);

        // Header Tabel (Tambah Kolom Aksi)
        $headerBaru = '<thead><tr>
              <th class="col-id">No</th>
              <th>Grand Prix</th>
              <th>Tanggal</th>
              <th>Pembalap</th>
              <th>Posisi</th>
              <th>Poin</th>
              <th class="col-actions">Aksi</th> 
            </tr></thead>';
        $template = preg_replace('/<thead>.*?<\/thead>/s', $headerBaru, $template);

        // Body Tabel
        $tbody = '';
        $no = 1;
        foreach($listHasil as $h){
            $tbody .= '<tr>';
            $tbody .= '<td class="col-id">'. $no .'</td>';
            $tbody .= '<td>'. htmlspecialchars($h->nama_event) .'</td>';
            $tbody .= '<td>'. htmlspecialchars($h->tanggal) .'</td>';
            $tbody .= '<td><b>'. htmlspecialchars($h->nama_pembalap) .'</b></td>'; 
            $tbody .= '<td>'. htmlspecialchars($h->posisi_finish) .'</td>';
            $tbody .= '<td>+'. htmlspecialchars($h->poin_didapat) .'</td>';
            // Tombol Edit & Hapus
            $tbody .= '<td class="col-actions">
                        <a href="index.php?screen=edit_hasil&id='.$h->id.'" class="btn btn-edit">Edit</a>
                        <button onclick="confirmDelete('.$h->id.')" class="btn btn-delete">Hapus</button>
                       </td>';
            $tbody .= '</tr>';
            $no++;
        }

        // Script Hapus Khusus (Karena id nya beda logic dengan pembalap)
        $scriptHapus = "
        <script>
        function confirmDelete(id){
            if(confirm('Hapus data balapan ini?')){
                var f = document.createElement('form'); 
                f.method='POST'; f.action='index.php';
                var i1 = document.createElement('input'); i1.type='hidden'; i1.name='action'; i1.value='delete_hasil';
                var i2 = document.createElement('input'); i2.type='hidden'; i2.name='id'; i2.value=id;
                f.appendChild(i1); f.appendChild(i2);
                document.body.appendChild(f); f.submit();
            }
        }
        </script></body>";
        
        $template = str_replace('</body>', $scriptHapus, $template);
        $template = str_replace('</tbody>', $tbody . '</tbody>', $template); // PENTING: Fix bug kemarin
        $template = str_replace('Total:', 'Total Data: ' . count($listHasil), $template);

        return $template;
    }

    public function tampilkanForm($listPembalap, $data = null) {
        $template = file_get_contents(__DIR__ . '/../template/form_hasil.html');

        // Default values (kosong)
        $val_id = '';
        $val_event = '';
        $val_tanggal = '';
        $val_posisi = '';
        $val_poin = '';
        $val_id_pembalap = '';
        $form_action = 'add_hasil';
        $judul = 'Catat Hasil Balapan';

        // Jika mode edit (ada data)
        if ($data) {
            $form_action = 'edit_hasil';
            $judul = 'Edit Hasil Balapan';
            $val_id = $data['id'];
            $val_event = $data['nama_event'];
            $val_tanggal = $data['tanggal'];
            $val_posisi = $data['posisi_finish'];
            $val_poin = $data['poin_didapat'];
            $val_id_pembalap = $data['id_pembalap'];
        }

        // Replace Judul
        $template = str_replace('Catat Hasil Balapan', $judul, $template);

        // Replace Action Form
        $template = str_replace('value="add_hasil"', 'value="'.$form_action.'"', $template);
        
        // Inject ID (Hidden Input untuk Edit)
        $inputID = '<input type="hidden" name="id" value="'.$val_id.'">';
        $template = str_replace('<form method="post" action="index.php">', '<form method="post" action="index.php">'.$inputID, $template);

        // Replace Values (Kita pakai str_replace sederhana ke atribut name)
        // Hati-hati: ini cara cepat memanipulasi HTML statis
        $template = str_replace('name="nama_event" type="text"', 'name="nama_event" type="text" value="'.$val_event.'"', $template);
        $template = str_replace('name="tanggal" type="date"', 'name="tanggal" type="date" value="'.$val_tanggal.'"', $template);
        $template = str_replace('name="posisi" type="number"', 'name="posisi" type="number" value="'.$val_posisi.'"', $template);
        $template = str_replace('name="poin" type="number"', 'name="poin" type="number" value="'.$val_poin.'"', $template);

        // Dropdown Logic
        $options = '';
        foreach ($listPembalap as $p) {
            $selected = ($p['id'] == $val_id_pembalap) ? 'selected' : '';
            $options .= "<option value='{$p['id']}' $selected>{$p['nama']} ({$p['tim']})</option>";
        }
        $template = str_replace('DATA_PEMBALAP', $options, $template);

        return $template;
    }
}
?>