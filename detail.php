<?php include("inc/top.php"); 

if (!$mhct): ?>
    <div class="text-center py-5 my-5">
        <h1 class="display-1 text-danger mb-4"><i class="fas fa-exclamation-triangle"></i></h1>
        <h3 class="text-danger mb-3">Sản phẩm không tồn tại!</h3>
        <a href="index.php" class="btn btn-primary btn-lg mt-3"><i class="fas fa-home me-2"></i>Quay về trang chủ</a>
    </div>
    <?php include("inc/bottom.php"); return; 
endif;

$discount = $mhct['giaban'] < $mhct['giagoc'] ? round((1 - $mhct['giaban']/$mhct['giagoc']) * 100) : 0;
$imagePath = "../" . htmlspecialchars($mhct['hinhanh']);
$defaultImage = "https://via.placeholder.com/600x600/f8f9fa/6c757d?text=Ảnh+sản+phẩm";
$finalImage = is_file($imagePath) ? $imagePath : $defaultImage;

$phu_imgs = [];
if (!empty($mhct['hinhphu'])) {
    $decoded = json_decode($mhct['hinhphu'], true);
    if (is_array($decoded)) $phu_imgs = array_slice($decoded, 0, 4);
}

$specs = [];
$has_real_specs = false;
if (!empty($mhct['thongso'])) {
    $decoded = json_decode($mhct['thongso'], true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && !empty($decoded)) {
        $specs = $decoded;
        $has_real_specs = true;
    } else {
        $thongso_trimmed = preg_replace('/^\[|\]$/', '', trim($mhct['thongso']));
        if (!empty($thongso_trimmed) && $thongso_trimmed !== '""') {
            foreach (explode(',', $thongso_trimmed) as $spec) {
                $spec = preg_replace('/^"|"$/', '', trim($spec));
                if (!empty($spec)) $specs[] = $spec;
            }
            if (!empty($specs)) $has_real_specs = true;
        }
    }
}

$rating = round(rand(40, 50) / 10, 1);
$reviewCount = rand(80, 450);
?>

<div class="container my-5">
    <div class="row g-4 g-lg-5">
        <!-- HÌNH ẢNH -->
        <div class="col-lg-6">
            <div class="position-sticky" style="top: 90px;">
                <?php if ($discount): ?>
                    <div style="position: absolute; top: 15px; left: 15px; background: #e74c3c; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; z-index: 10; box-shadow: 0 2px 8px rgba(231,76,60,0.3);">
                        -<?= $discount ?>%
                    </div>
                <?php endif; ?>
                
                <div style="position: relative; padding-bottom: 100%; overflow: hidden; background: #f8f9fa; border-radius: 1.2rem; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
                    <img id="mainImage" src="<?= $finalImage ?>" alt="<?= htmlspecialchars($mhct['tenmathang']) ?>"
                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; padding: 25px; background: white; transition: transform 0.3s ease; cursor: zoom-in;"
                         onerror="this.src='<?= $defaultImage ?>'; this.onerror=null;"
                         onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                         onclick="openImageModal(this.src)">
                </div>

                <div class="row g-2 mt-3">
                    <?php if (empty($phu_imgs)): 
                        for ($i = 0; $i < 4; $i++): ?>
                            <div class="col-3">
                                <div style="position: relative; padding-bottom: 100%; overflow: hidden; background: #f8f9fa; border-radius: 0.5rem; cursor: pointer; border: 2px solid <?= $i === 0 ? '#0984e3' : 'transparent' ?>;"
                                     onclick="document.getElementById('mainImage').src='<?= $finalImage ?>'; this.parentElement.parentElement.querySelectorAll('div').forEach(d=>d.style.borderColor='transparent'); this.style.borderColor='#0984e3';">
                                    <img src="<?= $finalImage ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; padding: 8px; background: white;">
                                </div>
                            </div>
                        <?php endfor; 
                    else: 
                        foreach ($phu_imgs as $i => $img_path): 
                            $thumb_src = file_exists("../" . $img_path) ? "../" . htmlspecialchars($img_path) : $defaultImage; ?>
                            <div class="col-3">
                                <div style="position: relative; padding-bottom: 100%; overflow: hidden; background: #f8f9fa; border-radius: 0.5rem; cursor: pointer; border: 2px solid <?= $i === 0 ? '#0984e3' : 'transparent' ?>; transition: all 0.2s ease;"
                                     onclick="document.getElementById('mainImage').src='<?= $thumb_src ?>'; this.parentElement.parentElement.querySelectorAll('div').forEach(d=>d.style.borderColor='transparent'); this.style.borderColor='#0984e3';">
                                    <img src="<?= $thumb_src ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; padding: 8px; background: white; transition: transform 0.3s ease;"
                                         onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" onerror="this.src='<?= $defaultImage ?>'; this.onerror=null;">
                                </div>
                            </div>
                        <?php endforeach; 
                        for ($i = count($phu_imgs); $i < 4; $i++): ?>
                            <div class="col-3">
                                <div style="position: relative; padding-bottom: 100%; overflow: hidden; background: #f8f9fa; border-radius: 0.5rem; cursor: pointer; border: 2px solid transparent;"
                                     onclick="document.getElementById('mainImage').src='<?= $finalImage ?>'; this.parentElement.parentElement.querySelectorAll('div').forEach(d=>d.style.borderColor='transparent'); this.style.borderColor='#0984e3';">
                                    <img src="<?= $finalImage ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; padding: 8px; background: white;">
                                </div>
                            </div>
                        <?php endfor; 
                    endif; ?>
                </div>
            </div>
        </div>

        <!-- THÔNG TIN -->
        <div class="col-lg-6">
            <h1 class="display-6 fw-bold text-dark mb-3" style="line-height: 1.3;">
                <?= htmlspecialchars($mhct['tenmathang']) ?>
            </h1>

            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="text-warning">
                    <?php 
                    $full = floor($rating);
                    $half = ($rating - $full) >= 0.5;
                    for ($i = 0; $i < $full; $i++) echo '<i class="fas fa-star"></i>';
                    if ($half) echo '<i class="fas fa-star-half-alt"></i>';
                    for ($i = ceil($rating); $i < 5; $i++) echo '<i class="far fa-star"></i>';
                    ?>
                </div>
                <span class="text-muted">(<?= $reviewCount ?> đánh giá)</span>
                <span class="text-success">
                    <i class="fas fa-check-circle"></i> 
                    <?= $mhct['soluongton'] > 0 ? "Còn {$mhct['soluongton']} sản phẩm" : "Hết hàng" ?>
                </span>
            </div>

            <div class="d-flex align-items-end gap-3 mb-4">
                <div>
                    <?php if ($discount): ?>
                        <div class="text-muted text-decoration-line-through fs-4"><?= number_format($mhct['giagoc']) ?>đ</div>
                    <?php endif; ?>
                    <div class="text-danger fw-bold" style="font-size: 2.2rem;"><?= number_format($mhct['giaban']) ?>đ</div>
                </div>
            </div>

            <?php if ($has_real_specs && !empty($specs)): ?>
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Thông số nổi bật</h5>
                <div>
                    <?php foreach ($specs as $spec): 
                        if (is_array($spec) || empty(trim($spec))) continue; ?>
                        <span style="background: linear-gradient(45deg, #6c5ce7, #a29bfe); color: white; padding: 8px 16px; border-radius: 25px; font-size: 0.875rem; margin: 4px; display: inline-block; box-shadow: 0 2px 6px rgba(108,92,231,0.3); font-weight: 500;">
                            <?= htmlspecialchars($spec) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="mb-5">
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-auto"><label class="form-label fw-medium">Số lượng:</label></div>
                    <div class="col-auto">
                        <div class="input-group" style="width: 140px;">
                            <button type="button" class="btn btn-outline-secondary" onclick="updateQty(-1)">−</button>
                            <input type="number" name="soluong" value="1" min="1" max="<?= $mhct['soluongton'] ?>" class="form-control text-center" id="qtyInput" readonly style="font-weight: 600;">
                            <button type="button" class="btn btn-outline-secondary" onclick="updateQty(1)">+</button>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <form method="post" action="index.php" style="display: inline;">
                        <input type="hidden" name="action" value="chovaogio">
                        <input type="hidden" name="id" value="<?= $mhct['id'] ?>">
                        <input type="hidden" name="soluong" value="1" id="themvaogioQty">
                        <button type="submit" class="btn px-5 fw-medium" style="background: linear-gradient(45deg, #0984e3, #74b9ff); color: white; border: none; padding: 12px 30px; border-radius: 30px; transition: all 0.3s ease;" 
                                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 15px rgba(9,132,227,0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''"
                                <?= $mhct['soluongton'] <= 0 ? 'disabled' : '' ?>>
                            <i class="fas fa-shopping-cart me-2"></i> <?= $mhct['soluongton'] <= 0 ? 'Hết hàng' : 'Thêm vào giỏ' ?>
                        </button>
                    </form>
                    
                    <form method="post" action="index.php" style="display: inline;">
                        <input type="hidden" name="action" value="muangay">
                        <input type="hidden" name="id" value="<?= $mhct['id'] ?>">
                        <input type="hidden" name="soluong" value="1" id="muangayQty">
                        <button type="submit" class="btn px-5 fw-medium" style="background: linear-gradient(45deg, #00b894, #55efc4); color: white; border: none; padding: 12px 30px; border-radius: 30px; transition: all 0.3s ease;" 
                                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 15px rgba(0,184,148,0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''"
                                <?= $mhct['soluongton'] <= 0 ? 'disabled' : '' ?>>
                            <i class="fas fa-bolt me-2"></i> Mua ngay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB CHI TIẾT -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs mb-3" style="border-bottom: 1px solid #dee2e6;">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#description" style="color: #0984e3; font-weight: 600; border: none; padding: 12px 20px;">Mô tả</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#reviews" style="color: #6c757d; font-weight: 500; border: none; padding: 12px 20px;">Đánh giá (<?= $reviewCount ?>)</a></li>
            </ul>
            <div class="tab-content p-4" style="border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 10px 10px; background: #fff;">
                <div class="tab-pane fade show active" id="description">
                    <div style="line-height: 1.9; color: #444;">
                        <?= $mhct['mota'] ? nl2br(htmlspecialchars($mhct['mota'])) : '<p class="text-muted">Chưa có mô tả.</p>' ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="reviews">
                    <div class="row mb-5">
                        <div class="col-md-4 text-center">
                            <div class="display-4 fw-bold text-primary"><?= number_format($rating, 1) ?></div>
                            <div class="text-warning mb-2"><?php for ($i = 0; $i < 5; $i++): ?><i class="fas fa-star"></i><?php endfor; ?></div>
                            <div class="text-muted">Dựa trên <?= $reviewCount ?> đánh giá</div>
                        </div>
                        <div class="col-md-8">
                            <?php foreach ([75,15,7,2,1] as $i => $pct): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-2"><?= 5-$i ?> <i class="fas fa-star text-warning"></i></div>
                                    <div class="progress flex-grow-1" style="height: 8px;"><div class="progress-bar bg-warning" style="width: <?= $pct ?>%"></div></div>
                                    <div class="ms-2 text-muted"><?= $pct ?>%</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php foreach ([['Nguyễn A', 5, 'Sản phẩm tuyệt vời!', '2 ngày trước'], ['Trần B', 4, 'Giao hàng nhanh.', '1 tuần trước']] as $r): ?>
                        <div class="border-bottom pb-4 mb-4">
                            <div class="d-flex">
                                <div style="width:50px;height:50px;border-radius:50%;background:linear-gradient(45deg,#fd79a8,#fab1a0);display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;margin-right:15px;">
                                    <?= substr($r[0], 0, 1) ?>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6 class="mb-0"><?= $r[0] ?></h6>
                                        <small class="text-muted"><?= $r[3] ?></small>
                                    </div>
                                    <div class="text-warning mb-2"><?php for ($i=0;$i<$r[1];$i++) echo '<i class="fas fa-star"></i>'; ?></div>
                                    <p class="mb-0"><?= $r[2] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- SẢN PHẨM LIÊN QUAN -->
    <?php if (!empty($mathang)): ?>
        <div class="mt-5">
            <h3 style="position: relative; padding-bottom: 15px; margin-bottom: 30px; font-weight: 700; color: #2d3436;">
                Sản phẩm liên quan
                <span style="position: absolute; bottom: 0; left: 0; width: 60px; height: 4px; background: linear-gradient(45deg, #0984e3, #74b9ff); border-radius: 2px;"></span>
            </h3>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach ($mathang as $m): if ($m['id'] == $mhct['id']) continue; ?>
                    <div class="col">
                        <a href="?action=detail&id=<?= $m['id'] ?>" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; transition: all 0.3s ease;"
                                 onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                                <div style="position: relative; padding-bottom: 80%; background: #f8f9fa;">
                                    <img src="../<?= htmlspecialchars($m['hinhanh']) ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; padding: 15px; background: white;">
                                    <?php if ($m['giaban'] < $m['giagoc']): ?>
                                        <span style="position: absolute; top: 8px; left: 8px; background: #e74c3c; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                            -<?= round((1 - $m['giaban']/$m['giagoc']) * 100) ?>%
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body p-3 d-flex flex-column">
                                    <h6 class="text-dark fw-bold mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.9rem;">
                                        <?= htmlspecialchars($m['tenmathang']) ?>
                                    </h6>
                                    <div class="mt-auto text-danger fw-bold"><?= number_format($m['giaban']) ?>đ</div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0"><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body text-center p-0"><img id="modalImage" src="" alt="" style="max-width: 100%; max-height: 80vh; object-fit: contain;"></div>
        </div>
    </div>
</div>

<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function updateQty(change) {
    const input = document.getElementById('qtyInput');
    let val = parseInt(input.value) + change;
    if (val >= 1 && val <= parseInt(input.max)) {
        input.value = val;
        document.getElementById('themvaogioQty').value = val;
        document.getElementById('muangayQty').value = val;
    }
}

document.getElementById('qtyInput').addEventListener('input', function(e) {
    let val = parseInt(e.target.value);
    if (isNaN(val) || val < 1) val = 1;
    if (val > parseInt(e.target.max)) val = parseInt(e.target.max);
    e.target.value = val;
    document.getElementById('themvaogioQty').value = val;
    document.getElementById('muangayQty').value = val;
});

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
        submitBtn.disabled = true;
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
});
</script>

<?php include("inc/bottom.php"); ?>