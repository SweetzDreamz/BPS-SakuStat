<?php
include "../../../config/koneksi.php";

if (isset($_POST['edit_user'])) {
    $nip_lama = $_POST['nip_lama']; 
    $nip_baru = $_POST['nip'];
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $role     = $_POST['role'];
    $password = $_POST['password'];

    if (!empty($password)) {

        $query = "UPDATE tb_user SET 
                    nip='$nip_baru', 
                    nama='$nama', 
                    email='$email', 
                    role='$role', 
                    password='$password' 
                  WHERE nip='$nip_lama'";
    } else {

        $query = "UPDATE tb_user SET 
                    nip='$nip_baru', 
                    nama='$nama', 
                    email='$email', 
                    role='$role' 
                  WHERE nip='$nip_lama'";
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data pengguna berhasil diperbarui!');
                window.location.href = '../../index.php?page=data-pengguna';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');
                window.location.href = '../../index.php?page=data-pengguna';
              </script>";
    }
} else {
    header("location:../../index.php?page=data-pengguna");
}
?>