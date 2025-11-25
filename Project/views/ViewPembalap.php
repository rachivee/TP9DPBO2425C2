<?php

include_once ("KontrakView.php");
include_once ("models/Pembalap.php");

class ViewPembalap implements KontrakView{

    public function __construct(){
        // Konstruktor kosong
    }

    // Method untuk menampilkan daftar pembalap
    public function tampilPembalap($listPembalap): string {
        // Build table rows
        $tbody = '';
        $no = 1;
        foreach($listPembalap as $pembalap){
            $tbody .= '<tr>';
            $tbody .= '<td class="col-id">'. $no .'</td>';
            $tbody .= '<td>'. htmlspecialchars($pembalap->getNama()) .'</td>';
            $tbody .= '<td>'. htmlspecialchars($pembalap->getTim()) .'</td>';
            $tbody .= '<td>'. htmlspecialchars($pembalap->getNegara()) .'</td>';
            $tbody .= '<td>'. htmlspecialchars($pembalap->getPoinMusim()) .'</td>';
            $tbody .= '<td>'. htmlspecialchars($pembalap->getJumlahMenang()) .'</td>';
            $tbody .= '<td class="col-actions">
                    <a href="index.php?screen=edit&id='. $pembalap->getId() .'" class="btn btn-edit">Edit</a>
                    <button data-id="'. $pembalap->getId() .'" class="btn btn-delete">Hapus</button>
                  </td>';
            $tbody .= '</tr>';
            $no++;
        }

        // Load the page template and inject rows + total count
        $templatePath = __DIR__ . '/../template/skin.html';
        $template = '';
        if (file_exists($templatePath)) {
            $template = file_get_contents($templatePath);
            $template = str_replace('<!-- PHP will inject rows here -->', $tbody, $template);
            $total = count($listPembalap);
            $template = str_replace('Total:', 'Total: ' . $total, $template);
            return $template;
        }

        // Fallback: just return the rows if template is missing
        return $tbody;
    }

    // Method untuk menampilkan form tambah/ubah pembalap
    public function tampilFormPembalap($data = null): string {
        $template = file_get_contents(__DIR__ . '/../template/form.html');
        
        if ($data) {
            // 1. Ganti aksi dari 'add' menjadi 'edit' dan isi ID Pembalap
            $template = str_replace(
                'value="add" id="pembalap-action" data-field', // String target di form.html
                'value="edit" id="pembalap-action" data-field', // String pengganti (action: edit)
                $template
            );
            
            $template = str_replace(
                'value="" id="pembalap-id" data-field', // String target di form.html
                'value="' . htmlspecialchars($data['id']) . '" id="pembalap-id" data-field', // String pengganti (isi ID)
                $template
            );
            
            // 2. Isi nilai-nilai form lainnya. Pastikan string pencarian (search) cocok 100% dengan form.html.
            $template = str_replace(
                'id="nama" name="nama" type="text" placeholder="Nama pembalap" required data-field', 
                'id="nama" name="nama" type="text" placeholder="Nama pembalap" required data-field value="' . htmlspecialchars($data['nama']) . '"', 
                $template
            );
            
            $template = str_replace(
                'id="tim" name="tim" type="text" placeholder="Nama tim" required data-field', 
                'id="tim" name="tim" type="text" placeholder="Nama tim" required data-field value="' . htmlspecialchars($data['tim']) . '"', 
                $template
            );
            
            $template = str_replace(
                'id="negara" name="negara" type="text" placeholder="Negara (mis. Indonesia)" data-field', 
                'id="negara" name="negara" type="text" placeholder="Negara (mis. Indonesia)" data-field value="' . htmlspecialchars($data['negara']) . '"', 
                $template
            );
            
            $template = str_replace(
                'id="poinMusim" name="poinMusim" type="number" min="0" step="1" placeholder="0" data-field', 
                'id="poinMusim" name="poinMusim" type="number" min="0" step="1" placeholder="0" data-field value="' . htmlspecialchars($data['poinMusim']) . '"', 
                $template
            );
            
            $template = str_replace(
                'id="jumlahMenang" name="jumlahMenang" type="number" min="0" step="1" placeholder="0" data-field', 
                'id="jumlahMenang" name="jumlahMenang" type="number" min="0" step="1" placeholder="0" data-field value="' . htmlspecialchars($data['jumlahMenang']) . '"', 
                $template
            );
        }
        return $template;
    }
}

?>