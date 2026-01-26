<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mt-0 mb-4">
        <div>
            <h1 class="mt-0 fs-3">Dashboard</h1>
            <p class="mb-0 text-secondary">Ringkasan statistik dan trafik SakuStat.</p>
        </div>
        <div class="text-end text-muted small">
            <i class="fa-regular fa-calendar me-1"></i> <?= date('d F Y'); ?>
        </div>
    </div>

    <?php
    // --- 1. FUNGSI HITUNG CEPAT (Optimasi Server) ---
    // Fungsi ini menggantikan mysqli_num_rows(SELECT *) yang berat
    function getCount($conn, $table){
        // Gunakan COUNT(*) agar database tidak perlu meload seluruh data
        $sql = mysqli_query($conn, "SELECT COUNT(*) as total FROM $table");
        return ($sql) ? mysqli_fetch_assoc($sql)['total'] : 0;
    }

    $jml_feedback   = getCount($koneksi, 'tb_feedback');
    $jml_kegiatan   = getCount($koneksi, 'tb_kegiatan');
    $jml_kasus      = getCount($koneksi, 'tb_kasusbatas');
    $jml_pedoman    = getCount($koneksi, 'tb_pedoman');
    $jml_pengunjung = getCount($koneksi, 'tb_pengunjung');

    // --- 2. LOGIKA CHART (SOLUSI FIX SQL STRICT MODE) ---
    // Strategi: Ambil format angka (Y-m) di SQL agar bisa di-grouping, 
    // lalu ubah jadi nama bulan di PHP.
    
    $query_chart = "SELECT DATE_FORMAT(tanggal, '%Y-%m') as periode, COUNT(*) as jumlah 
                    FROM tb_pengunjung 
                    GROUP BY DATE_FORMAT(tanggal, '%Y-%m') 
                    ORDER BY DATE_FORMAT(tanggal, '%Y-%m') ASC 
                    LIMIT 6";
    
    $result_chart = mysqli_query($koneksi, $query_chart);

    $labels = [];
    $data_chart = [];

    if($result_chart){
        while ($row = mysqli_fetch_assoc($result_chart)) {
            // $row['periode'] isinya misal "2025-01"
            
            // Ubah menjadi format Tanggal PHP agar bisa diformat jadi nama bulan
            // Kita tambahkan "-01" agar menjadi tanggal lengkap "2025-01-01"
            $timestamp = strtotime($row['periode'] . "-01");
            
            // Format ulang menjadi "January 2025" (F Y)
            $labels[] = date('F Y', $timestamp); 
            
            $data_chart[] = $row['jumlah'];
        }
    }
    ?>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow-sm h-100 dashboard-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 fw-bold text-uppercase">Total Kegiatan</div>
                        <div class="display-6 fw-bold"><?= $jml_kegiatan; ?></div>
                    </div>
                    <i class="fa-solid fa-list-check fa-3x opacity-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="index.php?page=data-kegiatan">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-danger text-white shadow-sm h-100 dashboard-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 fw-bold text-uppercase">Kasus Batas</div>
                        <div class="display-6 fw-bold"><?= $jml_kasus; ?></div>
                    </div>
                    <i class="fa-solid fa-scale-balanced fa-3x opacity-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="index.php?page=data-kasusbatas">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow-sm h-100 dashboard-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 fw-bold text-uppercase">Total Pedoman</div>
                        <div class="display-6 fw-bold"><?= $jml_pedoman; ?></div>
                    </div>
                    <i class="fa-solid fa-book-bookmark fa-3x opacity-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="index.php?page=data-pedoman">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow-sm h-100 dashboard-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 fw-bold text-uppercase">Feedback Masuk</div>
                        <div class="display-6 fw-bold"><?= $jml_feedback; ?></div>
                    </div>
                    <i class="fa-solid fa-comments fa-3x opacity-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="index.php?page=feedback">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4 shadow-sm border-0 h-100"> 
                <div class="card-header bg-white">
                    <i class="fas fa-chart-area me-1 text-primary"></i>
                    <b>Statistik Pengunjung (Per Bulan)</b>
                </div>
                <div class="card-body">
                    <canvas id="myAreaChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card mb-4 shadow-sm border-0 h-100"> 
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <div class="text-center mb-4 pb-4 border-bottom">
                        <h6 class="text-secondary text-uppercase fw-bold mb-1">Total Traffic</h6>
                        <h1 class="display-4 fw-bold text-dark my-0"><?= number_format($jml_pengunjung); ?></h1>
                        <p class="small text-muted mb-0">Total pengunjung sejak sistem dibuat</p>
                    </div>

                    <div>
                        <h6 class="fw-bold text-secondary mb-3">Aktivitas Terakhir</h6>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 pb-2">
                                Feedback Terbaru
                                <span class="badge bg-primary rounded-pill"><?= $jml_feedback; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 pt-2">
                                Data Diupdate
                                <span class="text-muted fw-bold"><?= date('d M Y'); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

<script>
    // Set default font
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels); ?>, 
            datasets: [{
                label: "Pengunjung",
                lineTension: 0.3,
                backgroundColor: "rgba(13, 110, 253, 0.05)", 
                borderColor: "rgba(13, 110, 253, 1)", 
                pointRadius: 5,
                pointBackgroundColor: "rgba(13, 110, 253, 1)",
                pointBorderColor: "rgba(255, 255, 255, 0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(13, 110, 253, 1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: <?= json_encode($data_chart); ?>, 
            }],
        },
        options: {
            scales: {
                xAxes: [{
                    time: { unit: 'date' },
                    gridLines: { display: false },
                    ticks: { maxTicksLimit: 7 }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        maxTicksLimit: 5,
                        padding: 10,
                        // Pastikan angka bulat di sumbu Y
                        callback: function(value) { if (value % 1 === 0) { return value; } }
                    },
                    gridLines: { color: "rgba(0, 0, 0, .125)" }
                }],
            },
            legend: { display: false }
        }
    });
</script>