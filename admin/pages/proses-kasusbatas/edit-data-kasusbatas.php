<?php
include "../../../config/koneksi.php";

if (isset($_POST['edit_kasusbatas'])) {
    $id          = $_POST['id_kasusbatas'];
    $id_kegiatan = mysqli_real_escape_string($koneksi, $_POST['id_kegiatan']);
    $situasi     = mysqli_real_escape_string($koneksi, $_POST['situasi']);
    $jawaban     = mysqli_real_escape_string($koneksi, $_POST['jawaban']);

    $query = "UPDATE tb_kasusbatas SET 
                id_kegiatan         = '$id_kegiatan',
                situasi_lapangan    = '$situasi',
                jawaban_kasusbatas  = '$jawaban'
              WHERE id_kasusbatas   = '$id'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data kasus batas berhasil diperbarui!'); window.location.href='../../index.php?page=data-kasusbatas';</script>";
    } else {
        echo "<script>alert('Gagal update database: " . mysqli_error($koneksi) . "'); window.location.href='../../index.php?page=data-kasusbatas';</script>";
    }
}
?>