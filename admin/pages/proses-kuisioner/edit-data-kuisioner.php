<?php
include '../../../config/koneksi.php'; 

if (isset($_POST['edit_kuisioner'])) {
    // 1. AMBIL DATA
    $id_kuisioner   = $_POST['id_kuisioner'];
    $nama_kuisioner = mysqli_real_escape_string($koneksi, $_POST['nama_kuisioner']);
    $id_kegiatan    = mysqli_real_escape_string($koneksi, $_POST['id_kegiatan']);
    $link_kuisioner = mysqli_real_escape_string($koneksi, $_POST['link_kuisioner']);
    $cover_lama     = $_POST['cover_lama'];
    
    // Cek apakah user upload gambar baru?
    $filename = $_FILES['cover']['name'];

    // --- SKENARIO 1: ADA GAMBAR BARU ---
    if ($filename != "") {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
        $x = explode('.', $filename);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['cover']['tmp_name'];
        
        // Buat nama file baru yang unik (ID + Timestamp) agar tidak bentrok
        $nama_gambar_baru = $id_kuisioner . '_' . time() . '.' . $ekstensi;
        $target_dir = '../../../assets/img/cover-kuisioner/';
        $target_file = $target_dir . $nama_gambar_baru;

        // Validasi Ekstensi
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            
            // Coba Upload Dulu
            if (move_uploaded_file($file_tmp, $target_file)) {
                
                // JIKA UPLOAD SUKSES -> Hapus gambar lama
                if ($cover_lama != "" && $cover_lama != "default.png") {
                    $path_lama = $target_dir . $cover_lama;
                    if (file_exists($path_lama)) {
                        unlink($path_lama);
                    }
                }

                // Siapkan Query Update LENGKAP (Dengan Gambar)
                $query = "UPDATE tb_kuisioner SET 
                            nama_kuisioner  = '$nama_kuisioner', 
                            link_kuisioner  = '$link_kuisioner', 
                            id_kegiatan     = '$id_kegiatan', 
                            cover_kuisioner = '$nama_gambar_baru' 
                          WHERE id_kuisioner = '$id_kuisioner'";
            } else {
                // Jika move_uploaded_file gagal (misal folder tidak ada / permission denied)
                echo "<script>alert('Gagal mengupload gambar! Periksa folder penyimpanan.'); window.history.back();</script>";
                exit; // Stop proses, jangan update database
            }
        } else {
            echo "<script>alert('Ekstensi gambar tidak diperbolehkan! Hanya JPG, JPEG, PNG.'); window.history.back();</script>";
            exit;
        }
    } 
    // --- SKENARIO 2: TIDAK GANTI GAMBAR ---
    else {
        // Siapkan Query Update TANPA Gambar
        $query = "UPDATE tb_kuisioner SET 
                    nama_kuisioner = '$nama_kuisioner', 
                    link_kuisioner = '$link_kuisioner', 
                    id_kegiatan    = '$id_kegiatan' 
                  WHERE id_kuisioner = '$id_kuisioner'";
    }

    // 2. EKSEKUSI QUERY
    $result = mysqli_query($koneksi, $query);

    if ($result) {

        header("Location: ../../index.php?page=data-kuisioner");
        exit;
    } else {

        echo "<script>alert('Gagal Database: " . mysqli_error($koneksi) . "'); window.location.href='../../index.php?page=data-kuisioner';</script>";
    }
} else {
    echo "<script>window.history.back();</script>";
}
?>