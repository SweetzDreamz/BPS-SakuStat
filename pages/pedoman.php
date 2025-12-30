<?php
// 1. QUERY JOIN (Mengambil data pedoman + nama kategori)
$keyword = "";
// Default query
$query_str = "SELECT p.*, k.nama_kategori 
              FROM tb_pedoman p 
              LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
              ORDER BY p.id_pedoman DESC";

// Jika tombol cari ditekan
if (isset($_POST['cari_pedoman'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_POST['keyword']);
    $query_str = "SELECT p.*, k.nama_kategori 
                  FROM tb_pedoman p 
                  LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
                  WHERE p.nama_pedoman LIKE '%$keyword%' 
                  ORDER BY p.id_pedoman DESC";
}

$sql = mysqli_query($koneksi, $query_str);
?>

<style>
    /* 1. KARTU COMPACT */
    .card-pedoman {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        height: 180px; /* Tinggi TETAP agar kartu terlihat kecil & padat */
        transition: transform 0.2s, box-shadow 0.2s;
        background-color: #fff;
    }
    
    .card-pedoman:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border-color: var(--primary-color);
    }

    /* 2. SISI KIRI (COVER IMAGE) */
    .cover-col {
        height: 100%;
        background-color: #f1f1f1;
        position: relative;
    }
    
    .cover-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Gambar mengisi penuh area tanpa gepeng */
        object-position: top center;
    }

    /* 3. SISI KANAN (CONTENT) */
    .content-col {
        padding: 12px; /* Padding kecil agar muat */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Judul di atas, Tombol di bawah */
        height: 100%;
    }

    .judul-pedoman {
        font-size: 0.9rem; /* Font judul diperkecil */
        font-weight: 700;
        line-height: 1.3;
        color: #333;
        
        /* Batasi judul maksimal 2 baris, sisanya ... */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 4px;
    }

    .badge-kategori {
        font-size: 0.65rem;
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 4px;
        background-color: #f8f9fa;
        color: #6c757d;
        border: 1px solid #dee2e6;
        display: inline-block;
        width: fit-content;
    }

    /* Search Bar di Kanan Atas */
    .search-container { max-width: 250px; }
    .search-input { font-size: 0.85rem; border-radius: 50px 0 0 50px !important; padding-left: 15px; }
    .search-btn { border-radius: 0 50px 50px 0 !important; padding: 0 15px; }
</style>

<div class="container-fluid px-5 py-4 mb-5">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 border-bottom pb-3">
        <div class="mb-3 mb-md-0">
            <h3 class="fw-bold text-primary mb-0">
            Buku Pedoman
            </h3>
            <small class="text-muted">Kumpulan referensi teknis BPS.</small>
        </div>

        <form action="" method="POST" class="d-flex search-container shadow-sm">
            <input type="text" name="keyword" class="form-control border-0 search-input" placeholder="Cari pedoman..." value="<?= $keyword; ?>" autocomplete="off">
            <button type="submit" name="cari_pedoman" class="btn btn-primary btn-sm search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div class="row g-3">
        <?php
        if (mysqli_num_rows($sql) > 0) {
            while ($data = mysqli_fetch_assoc($sql)) {
                // LOGIKA GAMBAR COVER
                // Cek apakah ada file cover di folder
                $path_cover = "assets/img/cover-pedoman/" . $data['cover_pedoman'];
                
                if (!empty($data['cover_pedoman']) && file_exists($path_cover)) {
                    $img_src = $path_cover;
                } else {
                    // Gambar Default jika tidak ada cover
                    $img_src = "assets/img/pdf-placeholder.png"; 
                }
        ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card-pedoman">
                        <div class="row g-0 h-100">
                            
                            <div class="col-4 cover-col">
                                <img src="<?= $img_src; ?>" class="cover-img" alt="Cover">
                            </div>

                            <div class="col-8">
                                <div class="content-col">
                                    
                                    <div>
                                        <div class="judul-pedoman" title="<?= htmlspecialchars($data['nama_pedoman']); ?>">
                                            <?= htmlspecialchars($data['nama_pedoman']); ?>
                                        </div>
                                        
                                        <span class="badge-kategori">
                                            <i class="fa-solid fa-tag me-1"></i>
                                            <?= htmlspecialchars($data['nama_kategori'] ?? 'Umum'); ?>
                                        </span>
                                    </div>

                                    <div class="text-end mt-1">
                                        <?php if (!empty($data['link_pedoman'])) { ?>
                                            <a href="<?= $data['link_pedoman']; ?>" target="_blank" class="btn btn-primary btn-sm w-100 rounded-1 py-1" style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-book-open me-1"></i> Baca
                                            </a>
                                        <?php } else { ?>
                                            <button class="btn btn-light btn-sm w-100 rounded-1 py-1 border text-muted" disabled style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-lock me-1"></i> Locked
                                            </button>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        <?php 
            }
        } else {
        ?>
            <div class="col-12 text-center py-5">
                <div class="text-muted opacity-50 mb-2">
                    <i class="fa-solid fa-file-circle-xmark fa-3x"></i>
                </div>
                <h6 class="fw-bold text-secondary">Pedoman tidak ditemukan</h6>
                <a href="index.php?p=pedoman" class="btn btn-sm btn-primary rounded-pill px-4 mt-2">Reset</a>
            </div>
        <?php } ?>
    </div>

</div>