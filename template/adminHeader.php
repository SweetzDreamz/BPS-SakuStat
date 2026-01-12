<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator | SakuStat</title>
    
    <link rel="icon" type="image/png" href="../assets/img/bps.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="../assets/css/admin.css?v=<?php echo time(); ?>"> 

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="admin-panel">

<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header d-flex align-items-center py-3"> <img src="../assets/img/bps.png" alt="Logo" width="35" class="me-2">
            <div>
                <h6 class="mb-0 fw-bold">SAKU STAT</h6>
                <small class="text-white-50" style="font-size: 0.65rem;">Administrator Panel</small>
            </div>
        </div>

        <ul class="list-unstyled components">
            <?php $page = isset($_GET['page']) ? $_GET['page'] : ''; ?>

            <li class="<?php echo ($page == '' || $page == 'dashboard') ? 'active' : ''; ?>">
                <a href="index.php">
                    <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                </a>
            </li>

            <li class="px-3 pt-3 pb-1 text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Data Utama</li>

            <li class="<?php echo ($page == 'data-kategori') ? 'active' : ''; ?>">
                <a href="index.php?page=data-kategori">
                    <i class="fa-solid fa-tags me-2"></i> Kategori
                </a>
            </li>

            <li class="<?php echo ($page == 'data-pedoman') ? 'active' : ''; ?>">
                <a href="index.php?page=data-pedoman">
                    <i class="fa-solid fa-book me-2"></i> Pedoman
                </a>
            </li>

            <li class="<?php echo ($page == 'data-kuisioner') ? 'active' : ''; ?>">
                <a href="index.php?page=data-kuisioner">
                    <i class="fa-solid fa-file me-2"></i> Kuisioner
                </a>
            </li>

            <li class="<?php echo ($page == 'data-kegiatan') ? 'active' : ''; ?>">
                <a href="index.php?page=data-kegiatan">
                    <i class="fa-solid fa-list-check me-2"></i> Kegiatan
                </a>
            </li>

            <li class="<?php echo ($page == 'data-kasusbatas') ? 'active' : ''; ?>">
                <a href="index.php?page=data-kasusbatas">
                    <i class="fa-solid fa-scale-balanced me-2"></i> Kasus Batas
                </a>
            </li>
            
            <li class="px-3 pt-3 pb-1 text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Lainnya</li>

            <li class="<?php echo ($page == 'data-pengguna') ? 'active' : ''; ?>">
                <a href="index.php?page=data-pengguna">
                    <i class="fa-solid fa-users me-2"></i> Pengguna
                </a>
            </li>

            <?php 
                $menu_masukan_active = ($page == 'feedback' || $page == 'pertanyaan'); 
            ?>
            <li class="<?php echo $menu_masukan_active ? 'active' : ''; ?>">
                <a href="#masukanSubmenu" data-bs-toggle="collapse" aria-expanded="<?php echo $menu_masukan_active ? 'true' : 'false'; ?>" class="dropdown-toggle">
                    <i class="fa-solid fa-envelope-open-text me-2"></i> Menu Masukan
                </a>
                <ul class="collapse list-unstyled <?php echo $menu_masukan_active ? 'show' : ''; ?>" id="masukanSubmenu">
                    <li class="<?php echo ($page == 'feedback') ? 'active' : ''; ?>">
                        <a href="index.php?page=feedback">
                            <i class="fa-solid fa-comments me-2"></i> Feedback
                        </a>
                    </li>
                    <li class="<?php echo ($page == 'data-pertanyaan.php') ? 'active' : ''; ?>">
                        <a href="index.php?page=data-pertanyaan">
                            <i class="fa-solid fa-circle-question me-2"></i> Pertanyaan
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>

    <div id="content">
        
        <nav class="navbar navbar-expand-lg navbar-admin mb-4 py-2"> <div class="container-fluid">
                
                <button type="button" id="sidebarCollapse" class="btn btn-light text-primary shadow-sm btn-sm">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                    <i class="fa-solid fa-user small"></i>
                                </div>
                                <span class="fw-bold me-1 small">
                                    <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Admin'; ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item small" href="../index.php" target="_blank"><i class="fa-solid fa-globe me-2 text-muted"></i> Lihat Website</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger small btn-logout" href="logout.php"><i class="fa-solid fa-power-off me-2"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>