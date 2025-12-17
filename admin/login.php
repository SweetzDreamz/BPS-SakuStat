<?php
session_start();
include "../config/koneksi.php";

if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    header("location:index.php");
    exit;
}

$pesan = "";

if (isset($_POST['login'])) {
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE nip='$nip' AND password='$password'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($query);
        
        $_SESSION['nip'] = $data['nip'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['status'] = "login";

        header("location:index.php");
    } else {
        $pesan = "NIP atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - SAKU STAT</title>
    <link rel="icon" type="image/png" href="../assets/img/bps.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    
    
</head>
<body class="login-page">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                
                <div class="card card-login bg-white">
                    <div class="login-header">
                        <h4 class="fw-bold text-primary">SakuStat</h4>
                        <p class="text-muted small mb-0">Administrator</p>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        <?php if($pesan != ""): ?>
                            <div class="alert alert-danger text-center py-2 fs-6" role="alert">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> <?php echo $pesan; ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label ms-2 small text-muted fw-bold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0 rounded-start-pill ps-3"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="text" name="nip" class="form-control border-start-0 ps-2" placeholder="Masukkan NIP anda" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label ms-2 small text-muted fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0 rounded-start-pill ps-3"><i class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-2" placeholder="********" required>
                                </div>
                            </div>

                            <button type="submit" name="login" class="btn btn-primary w-100 btn-login shadow mb-3">
                                MASUK <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                            </button>
                            
                            <div class="text-center">
                                <a href="../index.php" class="text-decoration-none small text-muted">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>