<?php

$current_page_label = "";

if($page == 'hasil-pencarian'){

    if(isset($_GET['keyword'])){
        $current_page_label = "Pencarian: " . htmlspecialchars($_GET['keyword']);
    } elseif(isset($_GET['kategori'])){

        $id_kat_bc = mysqli_real_escape_string($koneksi, $_GET['kategori']);
        $q_kat_bc  = mysqli_query($koneksi, "SELECT nama_kategori FROM tb_kategori WHERE id_kategori='$id_kat_bc'");
        $d_kat_bc  = mysqli_fetch_assoc($q_kat_bc);
        $current_page_label = "Kategori: " . ($d_kat_bc['nama_kategori'] ?? 'Tidak Diketahui');
    } else {
        $current_page_label = "Semua Kegiatan";
    }

} elseif ($page == 'detail-kegiatan') {
    // Label untuk Detail
    $current_page_label = "Detail Kegiatan";
    
    // Opsi Tambahan: Jika ingin menampilkan Judul Kegiatan di breadcrumb (Opsional)
    // $id_keg_bc = $_GET['id'];
    // $q_keg_bc = mysqli_query($koneksi, "SELECT nama_kegiatan FROM tb_kegiatan WHERE id_kegiatan='$id_keg_bc'");
    // $d_keg_bc = mysqli_fetch_assoc($q_keg_bc);
    // $current_page_label = substr($d_keg_bc['nama_kegiatan'], 0, 30) . "...";

} elseif ($page == 'pedoman') {
    $current_page_label = "Buku Pedoman";
}
?>

<?php if($page != 'home' && $page != ''){ ?>
<div class="bg-info bg-opacity-10 border-bottom border-primary py-1">
    <div class="container-fluid px-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    
                <span class="small">
                    <a href="index.php" class="text-decoration-none text-primary">
                        Beranda
                    </a>
                </span>
                </li>
                
                <li class="breadcrumb-item active text-muted" aria-current="page">
                    <span class="small"><?= $current_page_label; ?></span>
                </li>
            </ol>
        </nav>
    </div>
</div>
<?php } ?>