<?php include("inc/top.php"); ?>

<style>
.card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.12) !important; }
.card:hover img { transform: scale(1.05); }
</style>

<div class="my-5">
    <h3 class="mb-4 text-info fw-semibold"><?= htmlspecialchars($tendm) ?></h3>

    <?php if (!empty($mathang)): ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
            <?php foreach ($mathang as $m): 
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

        <?php if (isset($total_pages) && $total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?action=group&id=<?= $danhmuc_id ?>&page=<?= $page - 1 ?>">
                            <i class="bi bi-caret-left-fill"></i>
                        </a>
                    </li>

                    <?php 
                    $start = max(1, $page - 2);
                    $end = min($total_pages, $page + 2);
                    for ($i = $start; $i <= $end; $i++): 
                    ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?action=group&id=<?= $danhmuc_id ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?action=group&id=<?= $danhmuc_id ?>&page=<?= $page + 1 ?>">
                            <i class="bi bi-caret-right-fill"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>

    <?php else: ?>
        <div class="text-center py-5">
            <p class="text-muted fst-italic fs-5">Danh mục này hiện chưa có mặt hàng. Vui lòng xem danh mục khác...</p>
            <a href="index.php" class="btn btn-outline-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Quay về trang chủ
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include("inc/bottom.php"); ?>