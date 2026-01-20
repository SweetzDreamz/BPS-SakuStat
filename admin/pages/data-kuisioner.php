<div class="container-fluid px-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-clipboard-list me-1"></i>
                <b>Data Kuisioner</b>
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKuisioner">
                <i class="fa-solid fa-plus me-1"></i> Tambah Kuisioner
            </button>
        </div>  
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th>ID</th>
                            <th width="10%">Cover</th>
                            <th>Nama Kuisioner</th>
                            <th>Kegiatan Terkait</th>
                            <th>Link Kuisioner</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT k.*, keg.nama_kegiatan 
                                  FROM tb_kuisioner k 
                                  LEFT JOIN tb_kegiatan keg ON k.id_kegiatan = keg.id_kegiatan 
                                  ORDER BY k.id_kuisioner DESC";
                        
                        $sql = mysqli_query($koneksi, $query);

                        while ($data = mysqli_fetch_assoc($sql)) { 
                            $gambar = $data['cover_kuisioner'];
                            if ($gambar == null || $gambar == "") {
                                $imgSrc = "../assets/img/cover-kuisioner/default.png"; 
                            } else {
                                $imgSrc = "../assets/img/cover-kuisioner/" . $gambar;
                            }
                        ?>
                            <tr>
                                <td class="small"><?= $no++; ?></td>
                                <td class="small"><?= $data['id_kuisioner']; ?></td>
                                <td class="text-center">
                                    <img src="<?= $imgSrc; ?>" alt="Cover" style="width: 50px; height: 70px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                </td>
                                <td class="small"><?= $data['nama_kuisioner']; ?></td>
                                <td class="small">
                                    <?php 
                                        if($data['nama_kegiatan']) {
                                            echo $data['nama_kegiatan'];
                                        } else {
                                            echo '<span class="badge bg-secondary">Umum / Tidak ada kegiatan</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?= $data['link_kuisioner']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-link"></i> Buka
                                    </a>
                                </td>
                                
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#edit-kuisioner<?= $data['id_kuisioner']; ?>" 
                                            title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    
                                    <a href="pages/proses-kuisioner/del-data-kuisioner.php?id=<?= $data['id_kuisioner']; ?>&img=<?= $data['cover_kuisioner']; ?>" 
                                       class="btn btn-danger btn-sm btn-hapus" 
                                       title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                    <div class="modal fade text-start" id="edit-kuisioner<?= $data['id_kuisioner']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Kuisioner</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                
                                                <form action="pages/proses-kuisioner/edit-data-kuisioner.php" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_kuisioner" value="<?= $data['id_kuisioner']; ?>">
                                                        <input type="hidden" name="cover_lama" value="<?= $data['cover_kuisioner']; ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Nama Kuisioner</label>
                                                            <input type="text" name="nama_kuisioner" class="form-control" value="<?= $data['nama_kuisioner']; ?>" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Kegiatan</label>
                                                            <select name="id_kegiatan" class="form-select" required>
                                                                <option value="">-- Pilih Kegiatan --</option>
                                                                <?php
                                                                $sqlKeg_edit = mysqli_query($koneksi, "SELECT * FROM tb_kegiatan ORDER BY nama_kegiatan ASC");
                                                                while($keg_edit = mysqli_fetch_assoc($sqlKeg_edit)){
                                                                    $selected = ($keg_edit['id_kegiatan'] == $data['id_kegiatan']) ? "selected" : "";
                                                                    echo "<option value='".$keg_edit['id_kegiatan']."' $selected>".$keg_edit['nama_kegiatan']."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Link Kuisioner</label>
                                                            <input type="text" name="link_kuisioner" class="form-control" value="<?= $data['link_kuisioner']; ?>" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Ganti Cover <small class="text-muted fw-normal">(Biarkan kosong jika tidak diganti)</small></label>
                                                            <br>
                                                            <img src="<?= $imgSrc; ?>" width="80" class="mb-2 border rounded">
                                                            <input type="file" name="cover" class="form-control" accept=".jpg, .jpeg, .png">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" name="edit_kuisioner" class="btn btn-primary btn-simpan">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                                </div>
                                        </div>
                                    </div>
                                    </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahKuisioner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa-solid fa-clipboard-list me-2"></i>Tambah Kuisioner Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="pages/proses-kuisioner/add-data-kuisioner.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kuisioner</label>
                        <input type="text" name="nama_kuisioner" class="form-control" placeholder="Contoh: Kuisioner Kepuasan Pelanggan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kegiatan</label>
                        <select name="id_kegiatan" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Kegiatan --</option>
                            <?php
                            $sqlKeg_add = mysqli_query($koneksi, "SELECT * FROM tb_kegiatan ORDER BY nama_kegiatan ASC");
                            while($keg_add = mysqli_fetch_assoc($sqlKeg_add)){
                                echo "<option value='".$keg_add['id_kegiatan']."'>".$keg_add['nama_kegiatan']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Link Kuisioner</label>
                        <input type="text" name="link_kuisioner" class="form-control" placeholder="https://forms.google.com/..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Cover <small class="text-muted">(Format: JPG, PNG)</small></label>
                        <input type="file" name="cover" class="form-control" accept=".jpg, .jpeg, .png" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_kuisioner" class="btn btn-primary btn-simpan">Simpan Data</button>
                </div>
            </form>
            </div>
    </div>
</div>