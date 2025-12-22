<?php
include "../../../config/koneksi.php";

if (isset($_POST['edit_kategori'])) {
    $id_lama = $_POST['id_lama']; 
    $id_baru = $_POST['id_kategori'];
    $nama    = $_POST['nama_kategori'];

        $query = "UPDATE tb_kategori SET 
                    id_kategori='$id_baru', 
                    nama_kategori='$nama' 
                  WHERE id_kategori='$id_lama'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data kategori berhasil diperbarui!');
                window.location.href = '../../index.php?page=data-kategori';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');
                window.location.href = '../../index.php?page=data-kategori';
              </script>";
    }
} else {
    header("location:../../index.php?page=data-kategori");
}
?>