<?php
include "../../../config/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "DELETE FROM tb_kasusbatas WHERE id_kasusbatas='$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>window.location.href='../../index.php?page=data-kasusbatas';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location.href='../../index.php?page=data-kasusbatas';</script>";
    }
} else {
    echo "<script>window.location.href='../../index.php?page=data-kasusbatas';</script>";
}
?>