<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
  <div class="container-fluid px-5 navbar-container">
    
    <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="assets/img/bps.png" alt="Logo BPS" width="38" height="30" class="d-inline-block align-text-top me-2">
        
        <div class="d-flex flex-column text-start">
            <span class="fw-bold" style="font-size: 0.65rem; line-height: 1.1; letter-spacing: 0.5px;">BADAN PUSAT STATISTIK</span>
            <span class="fw-bold" style="font-size: 0.85rem; line-height: 1.1;">KOTA BOGOR</span>
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto gap-3">
        
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php?p=home">Beranda</a>
        </li>  
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kategori
          </a>
          <ul class="dropdown-menu">
              <?php
              $sql_nav = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY nama_kategori DESC");
              while($nav = mysqli_fetch_assoc($sql_nav)){
              ?>
                  <li>
                      <a class="dropdown-item" href="index.php?p=hasil-pencarian&kategori=<?= $nav['id_kategori']; ?>">
                          <?= $nav['nama_kategori']; ?>
                      </a>
                  </li>
                  
              <?php } ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="index.php?p=hasil-pencarian">Lihat Semua</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?p=feedback">Feedback</a>
        </li>
      </ul>
    </div>
  </div>
</nav>