<?php
include "../../../config/koneksi.php";

if (isset($_POST['add_kasusbatas'])) {
    // 1. AMBIL DATA DARI FORM
    $id_kegiatan = mysqli_real_escape_string($koneksi, $_POST['id_kegiatan']);
    $situasi     = mysqli_real_escape_string($koneksi, $_POST['situasi']);
    $jawaban     = mysqli_real_escape_string($koneksi, $_POST['jawaban']);

    // 2. INSERT KE DATABASE
    $query = "INSERT INTO tb_kasusbatas (situasi_lapangan, jawaban_kasusbatas, id_kegiatan) 
              VALUES ('$situasi', '$jawaban', '$id_kegiatan')";
    
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Berhasil! Kasus batas ditambahkan.'); window.location.href='../../index.php?page=data-kasusbatas';</script>";
    } else {
        echo "<script>alert('Gagal Database: " . mysqli_error($koneksi) . "'); window.location.href='../../index.php?page=data-kasusbatas';</script>";
    }
}
?>