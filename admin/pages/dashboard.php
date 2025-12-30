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
    // --- 1. LOGIKA QUERY DATA ---
    $sql_feedback = mysqli_query($koneksi, "SELECT * FROM tb_feedback");
    $jml_feedback = mysqli_num_rows($sql_feedback);


    $sql_kegiatan = mysqli_query($koneksi, "SELECT * FROM tb_kegiatan");
    $jml_kegiatan = mysqli_num_rows($sql_kegiatan);

    $sql_kasus = mysqli_query($koneksi, "SELECT * FROM tb_kasusbatas");
    $jml_kasus = mysqli_num_rows($sql_kasus);


    $sql_pedoman = mysqli_query($koneksi, "SELECT * FROM tb_pedoman");
    $jml_pedoman = mysqli_num_rows($sql_pedoman);

    $sql_pengunjung = mysqli_query($koneksi, "SELECT * FROM tb_pengunjung");
    $jml_pengunjung = mysqli_num_rows($sql_pengunjung);

    $query_chart = "SELECT DATE_FORMAT(tanggal, '%M %Y') as bulan, COUNT(*) as jumlah 
                    FROM tb_pengunjung 
                    GROUP BY DATE_FORMAT(tanggal, '%Y-%m') 
                    ORDER BY tanggal ASC 
                    LIMIT 6";
    $result_chart = mysqli_query($koneksi, $query_chart);

    $labels = [];
    $data_chart = [];

    while ($row = mysqli_fetch_assoc($result_chart)) {
        $labels[] = $row['bulan']; 
        $data_chart[] = $row['jumlah'];
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
                    <a class="small text-white stretched-link text-decoration-none" href="index.php?p=data-kasusbatas">Lihat Detail</a>
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
                    <a class="small text-white stretched-link text-decoration-none" href="index.php?p=data-pedoman">Lihat Detail</a>
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
                    <a class="small text-white stretched-link text-decoration-none" href="index.php?p=data-feedback">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        
        <div class="col-xl-8">
            <div class="card mb-4 shadow-sm border-0 h-100"> <div class="card-header bg-white">
                    <i class="fas fa-chart-area me-1 text-primary"></i>
                    <b>Statistik Pengunjung (Per Bulan)</b>
                </div>
                <div class="card-body">
                    <canvas id="myAreaChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card mb-4 shadow-sm border-0 h-100"> <div class="card-body p-4 d-flex flex-column justify-content-center">
                    
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
                        callback: function(value) { if (value % 1 === 0) { return value; } }
                    },
                    gridLines: { color: "rgba(0, 0, 0, .125)" }
                }],
            },
            legend: { display: false }
        }
    });
</script>