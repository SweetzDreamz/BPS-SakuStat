<?php
include '../../../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $img = $_GET['img'];

    if ($img != "" && $img != null && $img != "default.png") {
        $path_file = '../../../assets/img/cover-kuisioner/' . $img;
        if (file_exists($path_file)) {
            unlink($path_file);
        }
    }

    $query = "DELETE FROM tb_kuisioner WHERE id_kuisioner = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../../index.php?page=data-kuisioner");
        exit;
    } else {
        echo "<script>alert('Gagal Database: " . mysqli_error($koneksi) . "'); window.location.href='../../index.php?page=data-kuisioner';</script>";
    }
}
?>