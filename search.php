<?php include("inc/top.php"); ?>

<style>
.card:hover{transform:translateY(-4px);box-shadow:0 10px 25px rgba(0,0,0,0.12)!important}
.card:hover img{transform:scale(1.05)}
.img-wrap{position:relative;padding-bottom:100%;overflow:hidden;background:#f8f9fa;border-radius:.5rem .5rem 0 0}
.img-wrap a{position:absolute;top:0;left:0;width:100%;height:100%;display:block}
.img-wrap img{width:100%;height:100%;object-fit:contain;padding:12px;background:#fff;transition:transform .3s}
.title{font-size:.95rem;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
</style>

<div class="container px-4 px-lg-5 my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Kết quả tìm kiếm cho: <span class="text-danger">"<?= htmlspecialchars($q) ?>"</span></h2>
        <p class="text-muted fs-5">Tìm thấy <strong class="text-danger"><?= count($ketqua_timkiem) ?></strong> sản phẩm</p>
    </div>

    <?php if (empty($ketqua_timkiem)): ?>
        <div class="text-center py-5">
            <i class="bi bi-search fs-1 text-muted mb-3"></i>
            <h5 class="text-muted">Không tìm thấy sản phẩm nào phù hợp</h5>
            <a href="index.php" class="btn btn-outline-primary mt-3">Quay về trang chủ</a>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
            <?php foreach ($ketqua_timkiem as $m): 
                $dc = $m['giaban'] < $m['giagoc'] ? round((1 - $m['giaban'] / $m['giagoc']) * 100) : 0;
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0" style="transition:all .3s">
                    <?php if ($dc): ?>
                    <span class="badge bg-danger position-absolute top-0 end-0 m-2" style="font-size:.75rem;z-index:1">Giảm <?= $dc ?>%</span>
                    <?php endif; ?>
                    
                    <div class="img-wrap">
                        <a href="index.php?action=detail&id=<?= $m['id'] ?>">
                            <img src="../<?= htmlspecialchars($m['hinhanh']) ?>" alt="<?= htmlspecialchars($m['tenmathang']) ?>">
                        </a>
                    </div>

                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="card-title text-center mb-2 title">
                            <a href="index.php?action=detail&id=<?= $m['id'] ?>" class="text-decoration-none text-dark fw-bold">
                                <?= htmlspecialchars($m['tenmathang']) ?>
                            </a>
                        </h6>
                        <div class="d-flex justify-content-center small text-warning mb-2">
                            <?php for ($i = 0; $i < 5; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                        </div>
                        <div class="text-center mt-auto">
                            <?php if ($dc): ?><del class="text-muted small"><?= number_format($m['giagoc']) ?>đ</del><br><?php endif; ?>
                            <div class="text-danger fw-bold" style="font-size:1.1rem"><?= number_format($m['giaban']) ?>đ</div>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?action=chovaogio&id=<?= $m['id'] ?>" class="btn btn-outline-primary w-100 fw-medium small">
                            <i class="bi bi-cart-plus"></i> Chọn mua
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-outline-secondary px-5"><i class="bi bi-house"></i> Về trang chủ</a>
        </div>
    <?php endif; ?>
</div>

<?php include("inc/bottom.php"); ?>