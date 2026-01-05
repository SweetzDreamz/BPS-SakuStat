<?php
include "../../../config/koneksi.php";

$id = $_GET['id'];

if (!empty($id)) {

    $query = mysqli_query($koneksi, "DELETE FROM tb_kategori WHERE id_kategori='$id'");

    if ($query) {

        echo "<script>
                window.location.href = '../../index.php?page=data-kategori';
              </script>";
    } else {

        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location.href = '../../index.php?page=data-kategori';
              </script>";
    }
} else {
    header("location:../../index.php?page=data-kategori");
}
?>