<?php
include "../../../config/koneksi.php";

if (isset($_POST['add_kategori'])) {
    
    // 1. AMBIL DATA DARI FORM (Hanya Nama Kategori)
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    // 2. LOGIKA ID OTOMATIS (K001, K002, dst)
    // Cari ID terbesar yang ada saat ini (Misal: K005)
    $query_id = mysqli_query($koneksi, "SELECT max(id_kategori) as max_id FROM tb_kategori");
    $data_id  = mysqli_fetch_array($query_id);
    $last_id  = $data_id['max_id']; // Hasil: "K005"

    if ($last_id) {
        // Ambil angka dari string "K005" -> "005" -> 5
        $urutan = (int) substr($last_id, 1); 
        $urutan++; // Tambah 1 -> 6
    } else {
        // Jika tabel masih kosong, mulai dari 1
        $urutan = 1;
    }

    // Format ulang angka menjadi 3 digit dengan awalan "K" -> "K006"
    $id_baru = "K" . sprintf("%03s", $urutan);

    // 3. PROSES INSERT
    $query = "INSERT INTO tb_kategori (id_kategori, nama_kategori) 
              VALUES ('$id_baru', '$nama_kategori')";
    
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect tanpa alert PHP (karena sudah ditangani SweetAlert di frontend)
        // atau tetap pakai redirect biasa jika JS frontend gagal.
        header("location:../../index.php?page=data-kategori");
    } else {
        echo "<script>
                alert('Error! Gagal menyimpan data: " . mysqli_error($koneksi) . "');
                window.location.href = '../../index.php?page=data-kategori';
              </script>";
    }

} else {
    header("location:../../index.php?page=data-kategori");
}
?>