</div>
    </section>
    
    <!-- Carousel + Tab Nổi bật / Xem nhiều -->
    <section class="py-5">            
        <div class="container-fluid px-4">
            <div class="row g-4">                    
                <div class="col-lg-6">
                    <?php include("inc/carousel.php"); ?>    
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header p-0">
                            <ul class="nav nav-tabs nav-justified" role="tablist" 
                                style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);">
                                <li class="nav-item">
                                    <a class="nav-link active text-white fw-semibold py-3" data-bs-toggle="tab" href="#menu1">Nổi bật</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white fw-semibold py-3" data-bs-toggle="tab" href="#menu2">Xem nhiều</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content card-body p-0">
                            <?php 
                            $xemnhieu_all = $mh->laymathangxemnhieu(5);
                            $noibat = array_slice($xemnhieu_all, 0, 3);
                            $badges = [
                                ['class' => 'bg-danger', 'text' => 'Top 1'],
                                ['class' => 'bg-warning', 'text' => 'Top 2'],
                                ['class' => 'bg-info', 'text' => 'Top 3']
                            ];
                            ?>

                            <!-- Tab Nổi bật -->
                            <div id="menu1" class="tab-pane active show p-4">
                                <div class="row g-4">
                                    <?php foreach($noibat as $i => $sp): ?>
                                    <div class="col-12 col-md-4">
                                        <a href="index.php?action=detail&id=<?=$sp['id']?>" class="text-decoration-none">
                                            <div class="card border-0 shadow-sm h-100 hover-lift transition text-center bg-white position-relative">
                                                <span class="badge <?=$badges[$i]['class']?> fs-6 px-2 py-1 position-absolute top-0 start-0 m-2"><?=$badges[$i]['text']?></span>
                                                <img src="../<?=htmlspecialchars($sp['hinhanh'])?>" class="card-img-top w-100" 
                                                     style="height:200px; object-fit:contain; background:#fff; border-radius:0.6rem; padding:15px; border:1px solid #eee;"
                                                     alt="<?=htmlspecialchars($sp['tenmathang'])?>">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title text-dark mb-2 line-clamp-2" style="height:50px;"><?=htmlspecialchars($sp['tenmathang'])?></h6>
                                                    <p class="text-danger fw-bold fs-5 mb-1"><?=number_format($sp['giaban'])?>đ</p>
                                                    <small class="text-muted d-block">Sản phẩm nổi bật</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Tab Xem nhiều -->
                            <div id="menu2" class="tab-pane fade p-4">
                                <div class="row g-4">
                                    <?php foreach($xemnhieu_all as $i => $sp): ?>
                                    <div class="col-12 col-md-4">
                                        <a href="index.php?action=detail&id=<?=$sp['id']?>" class="text-decoration-none">
                                            <div class="card border-0 shadow-sm h-100 hover-lift transition text-center bg-white position-relative">
                                                <span class="badge bg-secondary fs-6 px-2 py-1 position-absolute top-0 start-0 m-2">#<?=$i+1?></span>
                                                <img src="../<?=htmlspecialchars($sp['hinhanh'])?>" class="card-img-top w-100" 
                                                     style="height:200px; object-fit:contain; background:#fff; border-radius:0.6rem; padding:15px; border:1px solid #eee;"
                                                     alt="<?=htmlspecialchars($sp['tenmathang'])?>">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title text-dark mb-2 line-clamp-2" style="height:50px;"><?=htmlspecialchars($sp['tenmathang'])?></h6>
                                                    <p class="text-danger fw-bold fs-5 mb-1"><?=number_format($sp['giaban'])?>đ</p>
                                                    <small class="text-success d-block"><i class="bi bi-eye-fill me-1"></i>Đã xem: <?=number_format($sp['luotxem'])?> lần</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 

    <!-- Footer -->
    <?php
    require_once("../model/database.php");
    $db = DATABASE::connect();
    $footer_cfg = $db->query("SELECT * FROM cauhinh_footer WHERE id=1")->fetch(PDO::FETCH_ASSOC);
    ?>
    <footer class="py-5" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #1d4ed8 100%);">
        <div class="text-center mb-5">
            <a class="text-decoration-none" href="#top">
                <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-chevron-up fs-4 text-white"></i>
                </div>
            </a>
        </div>
        
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 text-white">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-warning rounded p-2 me-3">
                            <i class="bi bi-shop-window fs-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1"><?=htmlspecialchars($footer_cfg['ten_cua_hang'] ?? 'Tech Shop')?></h4>
                            <p class="mb-0 opacity-75"><?=htmlspecialchars($footer_cfg['mo_ta'] ?? 'Cửa hàng điện thoại và phụ kiện chất lượng')?></p>
                        </div>
                    </div>
                    <div class="ps-1">
                        <p class="mb-3"><span class="opacity-75"><?=nl2br(htmlspecialchars($footer_cfg['diachi'] ?? '18 Ung Văn Khiêm, phường Đông Xuyên, TP Long Xuyên, An Giang'))?></span></p>
                        <p class="mb-3"><span class="opacity-75"><?=htmlspecialchars($footer_cfg['dienthoai'] ?? '076 3841190')?></span></p>
                        <p class="mb-0"><span class="opacity-75"><?=htmlspecialchars($footer_cfg['email'] ?? 'abc@abc.com')?></span></p>
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <h5 class="text-white fw-bold mb-4">DANH MỤC HÀNG</h5>                   
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($danhmuc as $d): ?>
                        <a class="text-white text-decoration-none opacity-75 hover-opacity-100 py-1" href="?action=group&id=<?=$d["id"]?>"><?=$d["tendanhmuc"]?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <h5 class="text-white fw-bold mb-4">DỊCH VỤ KHÁCH HÀNG</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="index.php?action=introduce" class="text-white text-decoration-none opacity-75 hover-opacity-100 py-1">Về chúng tôi</a>
                        <a href="#" class="text-white text-decoration-none opacity-75 hover-opacity-100 py-1">Hướng dẫn mua hàng</a>
                        <a href="#" class="text-white text-decoration-none opacity-75 hover-opacity-100 py-1">Câu hỏi thường gặp</a>
                        <a href="#" class="text-white text-decoration-none opacity-75 hover-opacity-100 py-1">Liên hệ với chúng tôi</a>
                    </div>
                </div>
            </div>
            
            <hr class="my-5 border-white opacity-25">
            <div class="text-center">
                <p class="m-0 text-warning fw-bold fs-5">Copyright &copy; <?=htmlspecialchars($footer_cfg['ten_cua_hang'] ?? 'Tech Shop')?> <?=date("Y")?></p>
            </div>
        </div>
    </footer>

    <style>
        .nav-tabs .nav-link.active { background-color: #ffffff !important; color: #1e3a8a !important; border-bottom-color: #ffffff; }
        .hover-lift { transition: all 0.3s ease; position: relative; }
        .hover-lift:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.15)!important; z-index: 10; }
        .hover-lift:hover .position-absolute { z-index: 25; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; }
        .badge { font-size: 0.7rem !important; font-weight: 600; z-index: 20; }
        .position-absolute { z-index: 15; }
    </style>
</body>
</html>