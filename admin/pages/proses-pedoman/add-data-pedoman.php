<?php
include "../../../config/koneksi.php";

if (isset($_POST['add_pedoman'])) {
    // 1. AMBIL DATA DARI FORM HTML
    $judul       = mysqli_real_escape_string($koneksi, $_POST['judul']);       
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']); 
    $link        = mysqli_real_escape_string($koneksi, $_POST['link_drive']);  


    // 2. LOGIKA ID OTOMATIS (P001, P002, dst)
    $query_id = mysqli_query($koneksi, "SELECT max(id_pedoman) as max_id FROM tb_pedoman");
    $data_id  = mysqli_fetch_array($query_id);
    $last_id  = $data_id['max_id'];

    if ($last_id) {
        // Ambil angka dari string "P001" -> "001" -> 1
        $urutan = (int) substr($last_id, 1); 
        $urutan++; 
    } else {
        // Jika tabel kosong, mulai dari 1
        $urutan = 1;
    }
    // Format ulang ke P00X
    $id_baru = "P" . sprintf("%03s", $urutan);


    // 3. LOGIKA UPLOAD GAMBAR
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
                
                $nama_file_baru = $id_baru . '_' . time() . '.' . $ekstensi;
                
                // DEFINISI FOLDER TUJUAN
                $folder_tujuan = '../../../assets/img/cover-pedoman/';
                
                // --- PERBAIKAN PENTING: CEK & BUAT FOLDER OTOMATIS ---
                if (!file_exists($folder_tujuan)) {
                    // Buat folder jika belum ada (Recursive = true)
                    mkdir($folder_tujuan, 0755, true); 
                }
                // -----------------------------------------------------

                // Pindah file
                if(move_uploaded_file($file_tmp, $folder_tujuan . $nama_file_baru)){
                    $nama_file_db = "'$nama_file_baru'"; 
                } else {
                    // Debugging Error PHP
                    $error = error_get_last();
                    echo "<script>alert('Gagal upload! Folder tujuan mungkin tidak ada. Detail: " . $error['message'] . "'); window.location.href='../../index.php?page=data-pedoman';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Ukuran terlalu besar!'); window.location.href='../../index.php?page=data-pedoman';</script>";
                exit;
            }
        }
    }


    // 4. INSERT KE DATABASE
    $query = "INSERT INTO tb_pedoman (id_pedoman, nama_pedoman, id_kategori, link_pedoman, cover_pedoman) 
              VALUES ('$id_baru', '$judul', '$id_kategori', '$link', $nama_file_db)";
    
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>window.location.href='../../index.php?page=data-pedoman';</script>";
    } else {
        echo "<script>alert('Gagal Database: " . mysqli_error($koneksi) . "'); window.location.href='../../index.php?page=data-pedoman';</script>";
    }
}
?>