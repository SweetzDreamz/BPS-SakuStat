<?php
include "../../../config/koneksi.php";

if (isset($_POST['edit_pedoman'])) {
    // 1. AMBIL DATA DARI FORM
    $id          = $_POST['id_pedoman'];
    $judul       = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $link        = mysqli_real_escape_string($koneksi, $_POST['link_drive']);
    $cover_lama  = $_POST['cover_lama'];

    // Siapkan variabel gambar
    $nama_file = $_FILES['cover']['name'];
    $ukuran    = $_FILES['cover']['size'];
    $file_tmp  = $_FILES['cover']['tmp_name'];
    $ekstensi_diperbolehkan = array('png','jpg','jpeg');

    // Cek apakah user mengganti gambar?
    if(!empty($nama_file)){
        // --- PROSES GANTI GAMBAR ---
        $dot = explode('.', $nama_file);
        $ekstensi = strtolower(end($dot));

        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if($ukuran < 2048000){ // Max 2MB
                
                // Gunakan format nama: ID_Timestamp.ext (Agar konsisten dengan Add)
                // Contoh: P001_17663322.jpg
                $nama_file_baru = $id . '_' . time() . '.' . $ekstensi;
                
                // 1. HAPUS GAMBAR LAMA FISIK (Jika ada)
                $path_lama = '../../../assets/img/cover-pedoman/'.$cover_lama;
                if($cover_lama != "" && file_exists($path_lama)){
                    unlink($path_lama);
                }

                // 2. UPLOAD GAMBAR BARU
                if(move_uploaded_file($file_tmp, '../../../assets/img/cover-pedoman/'.$nama_file_baru)){
                    
                    // 3. UPDATE DATABASE (DENGAN GAMBAR)
                    // Perhatikan nama kolom: nama_pedoman, link_pedoman, cover_pedoman
                    $query = "UPDATE tb_pedoman SET 
                                nama_pedoman='$judul', 
                                id_kategori='$id_kategori', 
                                link_pedoman='$link', 
                                cover_pedoman='$nama_file_baru' 
                              WHERE id_pedoman='$id'";
                } else {
                    echo "<script>alert('Gagal upload gambar baru!'); window.location.href='../../index.php?page=data-pedoman';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Ukuran file terlalu besar (Max 2MB)!'); window.location.href='../../index.php?page=data-pedoman';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format file salah (Harus JPG/PNG)!'); window.location.href='../../index.php?page=data-pedoman';</script>";
            exit;
        }
    } else {
        // --- PROSES TANPA GANTI GAMBAR ---
        // Kolom cover_pedoman TIDAK diupdate
        $query = "UPDATE tb_pedoman SET 
                    nama_pedoman='$judul', 
                    id_kategori='$id_kategori', 
                    link_pedoman='$link'
                  WHERE id_pedoman='$id'";
    }

    // Eksekusi Query
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>window.location.href='../../index.php?page=data-pedoman';</script>";
    } else {
        echo "<script>alert('Gagal update database: " . mysqli_error($koneksi) . "'); window.location.href='../../index.php?page=data-pedoman';</script>";
    }
}