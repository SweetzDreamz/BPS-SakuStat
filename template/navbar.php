<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top" >
  <div class="container-fluid px-5 navbar-container">
    <a class="navbar-brand fw-bold" href="index.php">
        <img src="assets/img/bps.png" alt="contoh" width="30" height="30">
        <i class="fa-solid fa-chart-simple me-2"></i><i>BPS KOTA BOGOR</i>
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        
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
          <a class="nav-link" href="index.php?p=pedoman">Pedoman</a>
        </li>
      </ul>
    </div>
  </div>
</nav>