<?php
include "../../../config/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // 1. AMBIL NAMA GAMBAR DULU
    $query_cek = mysqli_query($koneksi, "SELECT cover_pedoman FROM tb_pedoman WHERE id_pedoman='$id'");
    
    // Pastikan data ditemukan
    if(mysqli_num_rows($query_cek) > 0){
        $data = mysqli_fetch_assoc($query_cek);
        $gambar = $data['cover_pedoman'];

        // 2. TENTUKAN LOKASI FILE
        // Kita gunakan path absolut agar lebih akurat daripada "../../../"
        // __DIR__ mengambil lokasi file del-pedoman.php saat ini
        // Lalu kita mundur ke folder assets
        $path_file = "../../../assets/img/cover-pedoman/" . $gambar;
        
        // Cek apakah variabel gambar tidak kosong DAN file fisiknya ada
        if (!empty($gambar) && file_exists($path_file)) {
            // Hapus file
            unlink($path_file);
        } 
        // Debugging (Opsional: Aktifkan jika masih gagal untuk melihat error)
        // else {
        //    echo "File tidak ditemukan di: " . realpath($path_file);
        //    die();
        // }
    }

    // 3. HAPUS DATA DI DATABASE
    $query_delete = "DELETE FROM tb_pedoman WHERE id_pedoman='$id'";
    $result = mysqli_query($koneksi, $query_delete);

    if ($result) {
        echo "<script>window.location.href='../../index.php?page=data-pedoman';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data database!'); window.location.href='../../index.php?page=data-pedoman';</script>";
    }
} else {
    // Jika tidak ada ID di URL
    echo "<script>window.location.href='../../index.php?page=data-pedoman';</script>";
}
?>