<?php
include "../../../config/koneksi.php";

if (isset($_POST['add_kategori'])) {
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    $cek_id = mysqli_query($koneksi, "SELECT id_kategori FROM tb_kategori WHERE id_kategori = '$id_kategori'");
    
    if (mysqli_num_rows($cek_id) > 0) {
        echo "<script>
                alert('Gagal! ID Kategori $id_kategori sudah terdaftar. Silahkan gunakan ID Kategori lain.');
                window.location.href = '../../index.php?page=data-kategori';
              </script>";
    } else {
        $query = "INSERT INTO tb_kategori (id_kategori, nama_kategori) 
                  VALUES ('$id_kategori', '$nama_kategori')";
        
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>
                    alert('Berhasil! Data kategori baru telah ditambahkan.');
                    window.location.href = '../../index.php?page=data-kategori';
                  </script>";
        } else {
            echo "<script>
                    alert('Error! Gagal menyimpan data: " . mysqli_error($koneksi) . "');
                    window.location.href = '../../index.php?page=data-kategori';
                  </script>";
        }
    }

} else {
    header("location:../../index.php?page=data-kategori");
}
?>