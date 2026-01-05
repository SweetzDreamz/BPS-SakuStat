<?php
include "../../../config/koneksi.php";

if (isset($_POST['add_user'])) {
    $nip      = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $cek_nip = mysqli_query($koneksi, "SELECT nip FROM tb_user WHERE nip = '$nip'");
    
    if (mysqli_num_rows($cek_nip) > 0) {
        echo "<script>
                alert('Gagal! NIP $nip sudah terdaftar. Silahkan gunakan NIP lain.');
                window.location.href = '../../index.php?page=data-pengguna';
              </script>";
    } else {
        $query = "INSERT INTO tb_user (nip, nama, password) 
                  VALUES ('$nip', '$nama', '$password')";
        
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>
                    window.location.href = '../../index.php?page=data-pengguna';
                  </script>";
        } else {
            echo "<script>
                    alert('Error! Gagal menyimpan data: " . mysqli_error($koneksi) . "');
                    window.location.href = '../../index.php?page=data-pengguna';
                  </script>";
        }
    }

} else {
    header("location:../../index.php?page=data-pengguna");
}
?>