<div class="p-5 mb-4 bg-light shadow-sm text-center">
    <div class="container-fluid py-5">
        <h1 class="display-4 fw-bold text-light">SAKU STAT</h1>
        
        <p class="col-md-8 fs-5 mx-auto text-light">Temukan kasus batas</p>
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <form action="index.php" method="GET">
                    <input type="hidden" name="p" value="search">
                    
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" name="keyword" placeholder="Cari Kegiatan dan Kasus Batas..." aria-label="Cari topik statistik" required>
                        <button class="btn btn-primary" type="submit" id="button-addon2">
                            <i class="fa-solid fa-magnifying-glass"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>