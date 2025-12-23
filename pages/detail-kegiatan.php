<?php include "config/koneksi.php"; 
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT k.*, c.nama_kategori, p.nama_pedoman, p.link_pedoman 
                                 FROM tb_kegiatan k
                                 LEFT JOIN tb_kategori c ON k.id_kategori = c.id_kategori
                                 LEFT JOIN tb_pedoman p ON k.id_pedoman = p.id_pedoman
                                 WHERE k.id_kegiatan='$id'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
    <?php include "navbar.php"; ?>
    <div class="container mt-5 pt-5">
        <h1><?= $data['nama_kegiatan']; ?></h1>
        <span class="badge bg-primary"><?= $data['nama_kategori']; ?></span>
        <hr>
        <p><?= $data['deskripsi_kegiatan']; ?></p>
        
        <div class="card bg-light p-3 mt-4">
            <h5>Informasi Tambahan</h5>
            <ul>
                <li><strong>Responden:</strong> <?= $data['responden']; ?></li>
                <li><strong>Level Estimasi:</strong> <?= $data['level_estimasi']; ?></li>
                <li><strong>Pedoman:</strong> 
                    <?php if($data['link_pedoman']) { ?>
                        <a href="<?= $data['link_pedoman']; ?>" target="_blank" class="btn btn-sm btn-success">Download Pedoman</a>
                    <?php } else { echo "Tidak ada pedoman"; } ?>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>