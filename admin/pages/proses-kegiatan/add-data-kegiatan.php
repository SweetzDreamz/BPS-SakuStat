<?php
include "../../../config/koneksi.php";

if (isset($_POST['add_kegiatan'])) {
    // 1. AMBIL DATA DARI FORM HTML
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_kegiatan']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $kategori  = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $pedoman   = mysqli_real_escape_string($koneksi, $_POST['id_pedoman']);
    $responden = mysqli_real_escape_string($koneksi, $_POST['responden']);
    $estimasi  = mysqli_real_escape_string($koneksi, $_POST['level_estimasi']);

    // 2. LOGIKA ID OTOMATIS (KG001, KG002, dst)
    $query_id = mysqli_query($koneksi, "SELECT max(id_kegiatan) as max_id FROM tb_kegiatan");
    $data_id  = mysqli_fetch_array($query_id);
    $last_id  = $data_id['max_id'];

    if ($last_id) {
        $urutan = (int) substr($last_id, 2); 
        $urutan++;
    } else {
        $urutan = 1;
    }
    $id_baru = "KG" . sprintf("%03s", $urutan);

    // 3. INSERT KE DATABASE
    $query = "INSERT INTO tb_kegiatan (id_kegiatan, nama_kegiatan, deskripsi_kegiatan, responden, level_estimasi, id_kategori, id_pedoman) 
              VALUES ('$id_baru', '$nama', '$deskripsi', '$responden', '$estimasi', '$kategori', '$pedoman')";
    
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Berhasil! Kegiatan ditambahkan dengan ID: $id_baru'); window.location.href='../../index.php?page=data-kegiatan';</script>";
    } else {
        echo "<script>alert('Gagal Database: " . mysqli_error($koneksi) . "'); window.location.href='../../index.php?page=data-kegiatan';</script>";
    }
}
?>