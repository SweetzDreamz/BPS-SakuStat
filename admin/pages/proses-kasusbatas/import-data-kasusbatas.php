<?php
// 1. Hubungkan Koneksi Database
include "../../../config/koneksi.php";

// 2. Hubungkan Autoload Composer
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

if (isset($_POST['import_data'])) {

    // Validasi file ada atau tidak
    if (isset($_FILES['file_excel']['name']) && $_FILES['file_excel']['name'] != "") {
        
        $file_tmp = $_FILES['file_excel']['tmp_name'];
        $file_name = $_FILES['file_excel']['name'];
        
        // Cek Ekstensi File
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Tentukan Pembaca (Reader) berdasarkan Ekstensi
        if ($ext == 'xlsx') {
            $reader = new Xlsx();
        } elseif ($ext == 'xls') {
            $reader = new Xls();
        } elseif ($ext == 'csv') {
            $reader = new Csv();
            $reader->setDelimiter(','); // Paksa pemisah koma (sesuai file tes1.csv Anda)
        } else {
            echo "<script>alert('Format file salah! Harus .xlsx, .xls, atau .csv'); window.location.href='../../index.php?page=data-kasusbatas';</script>";
            exit;
        }

        try {
            // Load file menggunakan Reader yang tepat
            $spreadsheet = $reader->load($file_tmp);
            $sheet = $spreadsheet->getActiveSheet();
            
            // Ubah data sheet menjadi Array (Format: A, B, C...)
            $dataArray = $sheet->toArray(null, true, true, true);
            
            $berhasil = 0;
            $gagal = 0;
            $total_baris = 0;

            // Looping data
            foreach ($dataArray as $key => $row) {
                // Lewati Baris ke-1 (Judul Kolom)
                if ($key == 1) continue;
                
                $total_baris++;

                // Bersihkan data dari spasi berlebih
                $situasi     = trim($row['A']);
                $jawaban     = trim($row['B']);
                $id_kegiatan = trim($row['C']);

                // DEBUGGING KHUSUS: 
                // Jika masih 0 data, uncomment baris bawah ini untuk melihat apa yang dibaca sistem:
                // var_dump($row); die(); 

                // Validasi: Pastikan Situasi dan Jawaban TIDAK KOSONG
                if (!empty($situasi) && !empty($jawaban)) {
                    
                    // Escape string untuk keamanan SQL
                    $situasi_sql = mysqli_real_escape_string($koneksi, $situasi);
                    $jawaban_sql = mysqli_real_escape_string($koneksi, $jawaban);
                    $id_keg_sql  = mysqli_real_escape_string($koneksi, $id_kegiatan);

                    // Query Insert
                    $query = "INSERT INTO tb_kasusbatas (situasi_lapangan, jawaban_kasusbatas, id_kegiatan) 
                              VALUES ('$situasi_sql', '$jawaban_sql', '$id_keg_sql')";
                    
                    if (mysqli_query($koneksi, $query)) {
                        $berhasil++;
                    } else {
                        $gagal++;
                        // Opsional: Catat error SQL jika gagal
                        // echo mysqli_error($koneksi); 
                    }
                } else {
                    // Jika kolom kosong, dianggap gagal/skip
                     // $gagal++; // Aktifkan jika ingin menghitung baris kosong sebagai gagal
                }
            }

            // Pesan Alert Javascript
            $pesan = "Proses Selesai!\\nTotal Dibaca: $total_baris Baris\\nBerhasil: $berhasil\\nGagal: $gagal";
            
            echo "<script>
                    alert('$pesan'); 
                    window.location.href='../../index.php?page=data-kasusbatas';
                  </script>";

        } catch (Exception $e) {
            echo "<script>alert('Error Sistem: " . $e->getMessage() . "'); window.location.href='../../index.php?page=data-kasusbatas';</script>";
        }

    } else {
        echo "<script>alert('File belum dipilih!'); window.location.href='../../index.php?page=data-kasusbatas';</script>";
    }
}
?>