<?php include("inc/top.php"); ?>

<style>
.card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.12) !important; }
.card:hover img { transform: scale(1.05); }
.explore-link:hover .bg-warning { background: #f59e0b !important; transform: translateX(5px); transition: all 0.3s ease; }
</style>

<?php foreach ($danhmuc as $d): 
    $displayedProducts = array_slice(array_filter($mathang, fn($m) => $m['danhmuc_id'] == $d['id']), 0, 4);
?>
    <div class="my-5">
        <h3 class="mb-4">
            <a href="index.php?action=group&id=<?= $d['id'] ?>" class="text-info text-decoration-none fw-semibold">
                <?= htmlspecialchars($d['tendanhmuc']) ?>
            </a>
        </h3>

        <?php if ($displayedProducts): ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
                <?php foreach ($displayedProducts as $m): 
                    $discount = $m['giaban'] < $m['giagoc'] ? round((1 - $m['giaban']/$m['giagoc']) * 100) : 0;
                ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0" style="transition: all 0.3s ease;">
                            <?php if ($discount): ?>
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2" style="font-size: 0.75rem; z-index: 1;">
                                    Giảm <?= $discount ?>%
                                </span>
                            <?php endif; ?>

                            <div style="position: relative; padding-bottom: 100%; overflow: hidden; background: #f8f9fa; border-radius: 0.5rem 0.5rem 0 0;">
                                <a href="index.php?action=detail&id=<?= $m['id'] ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: block;">
                                    <img src="../<?= htmlspecialchars($m['hinhanh']) ?>" alt="<?= htmlspecialchars($m['tenmathang']) ?>"
                                         style="width: 100%; height: 100%; object-fit: contain; padding: 12px; background: white; transition: transform 0.3s ease;">
                                </a>
                            </div>

                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="card-title text-center mb-2" style="font-size: 0.95rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <a href="index.php?action=detail&id=<?= $m['id'] ?>" class="text-decoration-none text-dark fw-bold">
                                        <?= htmlspecialchars($m['tenmathang']) ?>
                                    </a>
                                </h6>

                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <?php for ($i = 0; $i < 5; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                                </div>

                                <div class="text-center mt-auto">
                                    <?php if ($discount): ?>
                                        <del class="text-muted small"><?= number_format($m['giagoc']) ?>đ</del><br>
                                    <?php endif; ?>
                                    <div class="text-danger fw-bold" style="font-size: 1.1rem;">
                                        <?= number_format($m['giaban']) ?>đ
                                    </div>
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

            <div class="text-center mt-4 pt-3">
                <a href="index.php?action=group&id=<?= $d['id'] ?>" class="explore-link text-decoration-none">
                    <div class="d-flex align-items-center justify-content-center gap-2 text-warning fw-semibold">
                        <span class="bg-warning bg-opacity-10 px-3 py-2 rounded-pill">
                            Khám phá thêm <?= htmlspecialchars($d['tendanhmuc']) ?>
                        </span>
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-arrow-right fs-6"></i>
                        </div>
                    </div>
                </a>
            </div>
        <?php else: ?>
            <p class="text-muted fst-italic">Danh mục hiện chưa có sản phẩm.</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php include("inc/bottom.php"); ?>