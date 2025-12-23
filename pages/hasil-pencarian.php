<div class="container-fluid pt-3 px-5 mb-5">
    <div class="row">
        <div class="col-md-12 mb-3 mt-2">
            <?php

            // 1. TANGKAP DATA & PERSIAPAN PAGINATION
            $keyword   = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $kategori  = isset($_GET['kategori']) ? $_GET['kategori'] : '';
            
            // Konfigurasi Pagination
            $batas   = 10; 
            $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
            $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

            // 2. QUERY DASAR (UNTUK MENGHITUNG TOTAL)
            $query_base = "SELECT k.*, c.nama_kategori 
                           FROM tb_kegiatan k
                           LEFT JOIN tb_kategori c ON k.id_kategori = c.id_kategori
                           WHERE 1=1"; 

            // Tambahkan Filter
            if($keyword){
                $keyword_aman = mysqli_real_escape_string($koneksi, $keyword);
                $query_base .= " AND (k.nama_kegiatan LIKE '%$keyword_aman%' OR k.deskripsi_kegiatan LIKE '%$keyword_aman%')";
                $label_info = "Menampilkan hasil pencarian: <b>'$keyword'</b>";
            } 
            elseif($kategori){
                $kategori_aman = mysqli_real_escape_string($koneksi, $kategori);
                $query_base .= " AND k.id_kategori = '$kategori_aman'";
                
                // Ambil nama kategori untuk label
                $cek_kat = mysqli_query($koneksi, "SELECT nama_kategori FROM tb_kategori WHERE id_kategori='$kategori_aman'");
                $data_kat = mysqli_fetch_assoc($cek_kat);
                $label_info = "Kategori: <b>".$data_kat['nama_kategori']."</b>";
            } 
            else {
                $label_info = "Semua Daftar Kegiatan";
            }

            // Eksekusi Query untuk Hitung Total Data
            $sql_total = mysqli_query($koneksi, $query_base);
            $jumlah_data = mysqli_num_rows($sql_total);
            $total_halaman = ceil($jumlah_data / $batas);


            // 3. QUERY FINAL (DENGAN LIMIT PAGINATION)
            $query_final = $query_base . " ORDER BY k.id_kegiatan DESC LIMIT $halaman_awal, $batas";
            $result = mysqli_query($koneksi, $query_final);
            $nomor = $halaman_awal + 1;
            ?>

            <h5><?= $label_info; ?></h5>
            <p class="text-muted small">
                Menampilkan <?= mysqli_num_rows($result); ?> dari total <?= $jumlah_data; ?> data.
            </p>
        </div>

        <div class="col-md-12">
            <?php if(mysqli_num_rows($result) > 0){ ?>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered">
                        <tbody>
                            <?php while($data = mysqli_fetch_array($result)){ ?>
                                
                                <tr class="border-bottom">
                                    <td class="px-4 py-4">
                                        <h4 class="mb-2">
                                            <a href="index.php?p=detail-kegiatan&id=<?= $data['id_kegiatan']; ?>" class="text-decoration-none text-primary">
                                                <?= $data['nama_kegiatan']; ?>
                                            </a>
                                        </h4>
                                        
                                        <p class="text-muted mb-3" style="font-size: 0.95rem; line-height: 1.6;">
                                            <?= substr($data['deskripsi_kegiatan'], 0, 250); ?>...
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <div>
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info">
                                                    <i class="fa-solid fa-tag me-1"></i> <?= $data['nama_kategori']; ?>
                                                </span>
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info">
                                                    <?= $data['level_estimasi'] ;?>
                                                </span>
                                            </div>
                                            <div>
                                                <a href="index.php?p=detail-kegiatan&id=<?= $data['id_kegiatan']; ?>" class="btn btn-secondary btn-sm rounded-1 px-3">
                                                    Selengkapnya
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-end">
                        
                        <li class="page-item <?= ($halaman <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?p=hasil-pencarian&keyword=<?= $keyword; ?>&kategori=<?= $kategori; ?>&halaman=<?= $halaman - 1; ?>">
                                <i class="fa-solid fa-chevron-left small"></i>
                            </a>
                        </li>

                        <?php for($x = 1; $x <= $total_halaman; $x++){ ?>
                            <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?p=hasil-pencarian&keyword=<?= $keyword; ?>&kategori=<?= $kategori; ?>&halaman=<?= $x; ?>">
                                    <?= $x; ?>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?p=hasil-pencarian&keyword=<?= $keyword; ?>&kategori=<?= $kategori; ?>&halaman=<?= $halaman + 1; ?>">
                                <i class="fa-solid fa-chevron-right small"></i>
                            </a>
                        </li>
                        
                    </ul>
                </nav>

            <?php } else { ?>
                <div class="alert alert-warning py-4 text-center">
                    <i class="fa-solid fa-magnifying-glass mb-2 fs-3"></i><br>
                    Data tidak ditemukan. Silakan coba kata kunci lain.
                </div>
            <?php } ?>
        </div>
    </div>
</div>