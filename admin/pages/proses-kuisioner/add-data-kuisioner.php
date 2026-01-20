<?php
include '../../../config/koneksi.php'; 

if (isset($_POST['add_kuisioner'])) {
    // 1. AMBIL DATA DARI FORM HTML
    $nama_kuisioner = mysqli_real_escape_string($koneksi, $_POST['nama_kuisioner']);       
    $id_kegiatan    = mysqli_real_escape_string($koneksi, $_POST['id_kegiatan']); 
    $link_kuisioner = mysqli_real_escape_string($koneksi, $_POST['link_kuisioner']);  

    // 2. LOGIKA ID OTOMATIS (K001, K002, dst)
    $query_id = mysqli_query($koneksi, "SELECT max(id_kuisioner) as max_id FROM tb_kuisioner");
    $data_id  = mysqli_fetch_array($query_id);
    $last_id  = $data_id['max_id'];

    if ($last_id) {
        // Ambil angka dari string "K001" -> "001" -> 1
        $urutan = (int) substr($last_id, 1); 
        $urutan++; 
    } else {
        // Jika tabel kosong, mulai dari 1
        $urutan = 1;
    }
    // Format ulang ke K00X (Prefix K untuk Kuisioner)
    $id_baru = "K" . sprintf("%03s", $urutan);

    // 3. LOGIKA UPLOAD GAMBAR
    $nama_file_db = "NULL";

    if(isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $nama_file = $_FILES['cover']['name'];
        $ukuran    = $_FILES['cover']['size'];
        $file_tmp  = $_FILES['cover']['tmp_name'];
        $ekstensi_diperbolehkan = array('png','jpg','jpeg');
        
        $dot = explode('.', $nama_file);
        $ekstensi = strtolower(end($dot));

        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if($ukuran < 2048000){ 
                
                // Rename file: K001_173922.png (ID Baru + Timestamp)
                $nama_file_baru = $id_baru . '_' . time() . '.' . $ekstensi;
                
                $target_dir = '../../../assets/img/cover-kuisioner/';
                
                if(move_uploaded_file($file_tmp, $target_dir . $nama_file_baru)){
                    $nama_file_db = "'$nama_file_baru'";
                } else {
                    echo "<script>alert('Gagal upload gambar! Periksa permission folder.'); window.location.href='../../index.php?page=data-kuisioner';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Ukuran gambar terlalu besar (Max 2MB)!'); window.location.href='../../index.php?page=data-kuisioner';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format gambar harus JPG atau PNG!'); window.location.href='../../index.php?page=data-kuisioner';</script>";
            exit;
        }
    }

    // 4. INSERT KE DATABASE
    $query = "INSERT INTO tb_kuisioner (id_kuisioner, nama_kuisioner, id_kegiatan, link_kuisioner, cover_kuisioner) 
              VALUES ('$id_baru', '$nama_kuisioner', '$id_kegiatan', '$link_kuisioner', $nama_file_db)";
    
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../../index.php?page=data-kuisioner");
        exit;
    } else {
        echo "<script>alert('Gagal Database: " . mysqli_error($koneksi) . "'); window.location.href='../../index.php?page=data-kuisioner';</script>";
    }
}
?>