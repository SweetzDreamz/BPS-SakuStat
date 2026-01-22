<div class="container-fluid pt-3 px-5 mb-5 hasil-pencarian-container">
    <div class="row">
        <div class="col-md-12 mb-3 mt-2">
            
            <?php
            // 1. TANGKAP DATA
            $keyword          = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $kategori         = isset($_GET['kategori']) ? $_GET['kategori'] : '';
            $filter_responden = isset($_GET['responden']) ? $_GET['responden'] : [];
            $filter_level     = isset($_GET['level']) ? $_GET['level'] : [];

            $batas          = 10; 
            $halaman        = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
            $halaman_awal   = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

            // 2. LOGIKA SMART SEARCH
            function build_smart_query($conn, $keyword, $column_name) {
                $words = explode(" ", $keyword);
                $stopwords = ['dan', 'atau', 'yg', 'yang', 'di', 'ke', 'dari', 'ini', 'itu', 'jika', 'maka','bagaimana','apakah','dimana'];
                $conditions = [];
                
                foreach ($words as $word) {
                    $word = trim($word);
                    if (!empty($word) && !in_array(strtolower($word), $stopwords) && strlen($word) > 1) {
                        $word_clean = mysqli_real_escape_string($conn, $word);
                        $conditions[] = "$column_name LIKE '%$word_clean%'";
                    }
                }

                if (empty($conditions)) {
                    $k_aman = mysqli_real_escape_string($conn, $keyword);
                    return "$column_name LIKE '%$k_aman%'";
                }
                return "(" . implode(" AND ", $conditions) . ")";
            }

            // B. Filter Tambahan
            $extra_filter = "";
            if($kategori){
                $extra_filter .= " AND k.id_kategori = '".mysqli_real_escape_string($koneksi, $kategori)."'";
            }
            if(!empty($filter_responden)){
                $resp_str = implode("','", array_map(function($item) use ($koneksi) { return mysqli_real_escape_string($koneksi, $item); }, $filter_responden));
                $extra_filter .= " AND k.responden IN ('$resp_str')";
            }
            if(!empty($filter_level)){
                $level_str = implode("','", array_map(function($item) use ($koneksi) { return mysqli_real_escape_string($koneksi, $item); }, $filter_level));
                $extra_filter .= " AND k.level_estimasi IN ('$level_str')";
            }

            // C. Susun Query
            if(!empty($keyword)) {
                $q_kegiatan_nama = build_smart_query($koneksi, $keyword, 'k.nama_kegiatan');
                $q_kegiatan_desc = build_smart_query($koneksi, $keyword, 'k.deskripsi_kegiatan');
                $where_kegiatan = " WHERE ($q_kegiatan_nama OR $q_kegiatan_desc) " . $extra_filter;

                $q_kasus_situasi = build_smart_query($koneksi, $keyword, 'kb.situasi_lapangan');
                $q_kasus_jawab   = build_smart_query($koneksi, $keyword, 'kb.jawaban_kasusbatas');
                $where_kasus = " WHERE ($q_kasus_situasi OR $q_kasus_jawab) " . $extra_filter;
            } else {
                $where_kegiatan = " WHERE 1=1 " . $extra_filter;
                $where_kasus    = " WHERE 0=1 "; 
            }

            // D. Query UNION
            $query_base = "
                (
                    SELECT 
                        k.id_kegiatan AS id_link,
                        k.nama_kegiatan AS judul_utama,
                        k.deskripsi_kegiatan AS deskripsi_tampil,
                        k.responden,
                        k.level_estimasi,
                        c.nama_kategori,
                        'Kegiatan' AS tipe_hasil
                    FROM tb_kegiatan k
                    LEFT JOIN tb_kategori c ON k.id_kategori = c.id_kategori
                    $where_kegiatan
                )
                UNION
                (
                    SELECT 
                        k.id_kegiatan AS id_link,
                        k.nama_kegiatan AS judul_utama,
                        kb.situasi_lapangan AS deskripsi_tampil,
                        k.responden,
                        k.level_estimasi,
                        c.nama_kategori,
                        'Kasus Batas' AS tipe_hasil
                    FROM tb_kasusbatas kb
                    JOIN tb_kegiatan k ON kb.id_kegiatan = k.id_kegiatan
                    LEFT JOIN tb_kategori c ON k.id_kategori = c.id_kategori
                    $where_kasus
                )
            ";

            $label_info = $keyword ? "Hasil pencarian cerdas: <b>'$keyword'</b>" : "Daftar Data";

            $sql_total = mysqli_query($koneksi, $query_base);
            $jumlah_data = mysqli_num_rows($sql_total);
            $total_halaman = ceil($jumlah_data / $batas);

            $query_final = $query_base . " ORDER BY tipe_hasil ASC, judul_utama ASC LIMIT $halaman_awal, $batas";
            $result = mysqli_query($koneksi, $query_final);
            ?>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h5 class="mb-1"><?= $label_info; ?></h5>
                    <p class="text-muted small mb-0">
                        Menampilkan <?= mysqli_num_rows($result); ?> dari total <?= $jumlah_data; ?> data gabungan.
                    </p>
                </div>
                <button type="button" class="btn btn-outline-success btn-sm p-2" data-bs-toggle="modal" data-bs-target="#modalFilter">
                    <i class="fa-solid fa-filter me-1"></i>
                </button>
            </div>

        </div>

        <div class="col-md-12">
            <?php if(mysqli_num_rows($result) > 0){ ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered">
                        <tbody>
                            <?php while($data = mysqli_fetch_array($result)){ 
                                $bg_badge = ($data['tipe_hasil'] == 'Kegiatan') ? 'bg-primary' : 'bg-danger';
                                $icon_badge = ($data['tipe_hasil'] == 'Kegiatan') ? 'fa-list-check' : 'fa-scale-balanced';
                            ?>
                                <tr class="border-bottom">
                                    <td class="px-4 py-4">
                                        <div class="mb-2">
                                            <h4 class="mb-0 fs-5">
                                                <a href="index.php?p=detail-kegiatan&id=<?= $data['id_link']; ?>" class="text-decoration-none text-dark fw-bold">
                                                    <?= $data['judul_utama']; ?>
                                                </a>
                                            </h4>
                                        </div>

                                        <div class="text-muted mb-3" style="font-size: 0.95rem; line-height: 1.6;">
                                            <?php if($data['tipe_hasil'] == 'Kasus Batas'): ?>
                                                <strong class="text-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Kasus:</strong> 
                                            <?php endif; ?>
                                            
                                            <?php 
                                                $desc = strip_tags($data['deskripsi_tampil']);
                                                $desc_cut = substr($desc, 0, 300); 
                                                echo $desc_cut . "..."; 
                                            ?>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-end flex-wrap gap-2">
                                            
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                
                                                <span class="badge <?= $bg_badge; ?> rounded-1 py-2 px-3">
                                                    <i class="fa-solid <?= $icon_badge; ?> me-1"></i> <?= $data['tipe_hasil']; ?>
                                                </span>

                                                <span class="badge bg-info bg-opacity-10 text-info border border-info py-2 px-3">
                                                    <i class="fa-solid fa-tag me-1"></i> <?= $data['nama_kategori']; ?>
                                                </span>
                                                
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary py-2 px-3">
                                                    <i class="fa-solid fa-user-group me-1"></i> <?= $data['responden']; ?>
                                                </span>
                                                
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success py-2 px-3">
                                                    <i class="fa-solid fa-layer-group me-1"></i> <?= $data['level_estimasi']; ?>
                                                </span>
                                            </div>

                                            <div class="mt-2 mt-md-0">
                                                <a href="index.php?p=detail-kegiatan&id=<?= $data['id_link']; ?>" class="btn btn-outline-primary btn-sm rounded-1 px-3 text-nowrap">
                                                    Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i>
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
                        <?php
                        $params = $_GET;
                        unset($params['halaman']);
                        unset($params['p']); 
                        $query_str = http_build_query($params);
                        ?>
                        <li class="page-item <?= ($halaman <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?p=hasil-pencarian&<?= $query_str; ?>&halaman=<?= $halaman - 1; ?>">
                                <i class="fa-solid fa-chevron-left small"></i>
                            </a>
                        </li>
                        <?php for($x = 1; $x <= $total_halaman; $x++){ ?>
                            <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?p=hasil-pencarian&<?= $query_str; ?>&halaman=<?= $x; ?>">
                                    <?= $x; ?>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?p=hasil-pencarian&<?= $query_str; ?>&halaman=<?= $halaman + 1; ?>">
                                <i class="fa-solid fa-chevron-right small"></i>
                            </a>
                        </li>
                    </ul>
                </nav>

            <?php } else { ?>
                <div class="alert alert-warning py-5 text-center">
                    <i class="fa-solid fa-magnifying-glass mb-3 fs-1 opacity-50"></i><br>
                    <h5 class="fw-bold">Tidak ditemukan hasil.</h5>
                    <p class="mb-0">Cobalah kata kunci lain yang lebih umum.</p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom-2 pb-2">
                <h5 class="modal-title fw-bold" id="modalFilterLabel">Filter Pencarian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="index.php" method="GET">
                <input type="hidden" name="p" value="hasil-pencarian"> <?php if($kategori): ?>
                    <input type="hidden" name="kategori" value="<?= $kategori; ?>">
                <?php endif; ?>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Judul Kegiatan / Isi Kasus</label>
                            <input type="text" name="keyword" class="form-control" placeholder="Cari Kegiatan atau Kasus..." value="<?= htmlspecialchars($keyword); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Responden</label>
                            <div class="card card-body bg-light border-0 p-3" style="max-height: 200px; overflow-y: auto;">
                                <?php
                                $q_resp = mysqli_query($koneksi, "SELECT DISTINCT responden FROM tb_kegiatan WHERE responden IS NOT NULL AND responden != '' ORDER BY responden ASC");
                                if(mysqli_num_rows($q_resp) > 0){
                                    while($r = mysqli_fetch_assoc($q_resp)){
                                        $checked = (in_array($r['responden'], $filter_responden)) ? 'checked' : '';
                                        echo '<div class="form-check mb-1">
                                                <input class="form-check-input" type="checkbox" name="responden[]" value="'.$r['responden'].'" id="resp_'.$r['responden'].'" '.$checked.'>
                                                <label class="form-check-label small" for="resp_'.$r['responden'].'">'.$r['responden'].'</label>
                                              </div>';
                                    }
                                } else { echo '<small class="text-muted">Data tidak tersedia</small>'; }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Level Estimasi</label>
                            <div class="card card-body bg-light border-0 p-3" style="max-height: 200px; overflow-y: auto;">
                                <?php
                                $q_lvl = mysqli_query($koneksi, "SELECT DISTINCT level_estimasi FROM tb_kegiatan WHERE level_estimasi IS NOT NULL AND level_estimasi != '' ORDER BY level_estimasi ASC");
                                if(mysqli_num_rows($q_lvl) > 0){
                                    while($l = mysqli_fetch_assoc($q_lvl)){
                                        $checked = (in_array($l['level_estimasi'], $filter_level)) ? 'checked' : '';
                                        echo '<div class="form-check mb-1">
                                                <input class="form-check-input" type="checkbox" name="level[]" value="'.$l['level_estimasi'].'" id="lvl_'.$l['level_estimasi'].'" '.$checked.'>
                                                <label class="form-check-label small" for="lvl_'.$l['level_estimasi'].'">'.$l['level_estimasi'].'</label>
                                              </div>';
                                    }
                                } else { echo '<small class="text-muted">Data tidak tersedia</small>'; }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-0">
                    <a href="index.php?p=hasil-pencarian" class="btn btn-light text-muted border">Reset</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-filter me-2"></i>Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>