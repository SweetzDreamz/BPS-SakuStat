<?php
include "../../../config/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM tb_kegiatan WHERE id_kegiatan='$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='../../index.php?page=data-kegiatan';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data! Mungkin data sedang digunakan di tabel lain.'); window.location.href='../../index.php?page=data-kegiatan';</script>";
    }
} else {
    echo "<script>window.location.href='../../index.php?page=data-kegiatan';</script>";
}
?>