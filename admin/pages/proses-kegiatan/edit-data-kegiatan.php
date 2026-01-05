<?php
include "../../../config/koneksi.php";

if (isset($_POST['edit_kegiatan'])) {
    // 1. AMBIL DATA
    $id        = $_POST['id_kegiatan'];
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_kegiatan']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $kategori  = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $pedoman   = mysqli_real_escape_string($koneksi, $_POST['id_pedoman']);
    $responden = mysqli_real_escape_string($koneksi, $_POST['responden']);
    $estimasi  = mysqli_real_escape_string($koneksi, $_POST['level_estimasi']);

    // 2. QUERY UPDATE
    $query = "UPDATE tb_kegiatan SET 
                nama_kegiatan       = '$nama',
                deskripsi_kegiatan  = '$deskripsi',
                responden           = '$responden',
                level_estimasi      = '$estimasi',
                id_kategori         = '$kategori',
                id_pedoman          = '$pedoman'
              WHERE id_kegiatan     = '$id'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>window.location.href='../../index.php?page=data-kegiatan';</script>";
    } else {
        echo "<script>alert('Gagal update database: " . mysqli_error($koneksi) . "'); window.location.href='../../index.php?page=data-kegiatan';</script>";
    }
}
?>