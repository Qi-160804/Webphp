
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Tech Shop - Điện thoại & Phụ kiện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        .navbar-nav { gap: 8px; }
        .user-actions { gap: 12px; }
        .search-container { max-width: 500px; margin: 0 auto; }
        .nav-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #1d4ed8 100%) !important; border-bottom: 3px solid rgba(255, 255, 255, 0.15); box-shadow: 0 4px 20px rgba(30, 58, 138, 0.4); padding: 1rem 0; }
        .brand-text { font-weight: 800; font-size: 1.6rem; background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); letter-spacing: 0.5px; margin-right: 2rem; }
        .brand-icon { background: linear-gradient(135deg, #fbbf24, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-right: 8px; }
        .nav-link-style { color: #e0e7ff !important; font-weight: 600; padding: 10px 20px !important; border-radius: 8px; transition: all 0.3s ease; margin: 0 4px; }
        .nav-active { background: rgba(255, 255, 255, 0.15); box-shadow: 0 4px 12px rgba(255, 255, 255, 0.15); }
        .dropdown-style { background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%) !important; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); margin-top: 8px; padding: 6px 0; }
        .dropdown-item-style { transition: all 0.2s ease; background-color: transparent !important; margin: 2px 6px; border-radius: 6px; }
        .search-input { background: rgba(255,255,255,0.18); border: none; color: white; border-radius: 25px 0 0 25px; padding: 10px 20px; }
        .btn-hover { font-weight: 600; border-radius: 8px; transition: all 0.3s ease; white-space: nowrap; }
        .cart-badge { top: -6px; right: -6px; font-size: 0.65rem; padding: 3px 5px; min-width: 18px; height: 18px; display: flex; align-items-center; justify-content: center; border: 1.5px solid white; box-shadow: 0 0 0 1.5px #1e40af; z-index: 1000; animation: pulse 2s infinite; }
        @media (max-width: 991.98px) {
            .search-container { order: 3; margin-top: 1rem; width: 100%; }
            .user-actions { justify-content: center; margin-top: 1rem; }
        }
    </style>
</head>
<body id="top">
    <nav class="navbar navbar-expand-lg navbar-dark shadow nav-gradient">
        <div class="container">
            <a class="navbar-brand fw-bold flex-shrink-0 brand-text" href="index.php">
                <i class="bi bi-phone brand-icon"></i>Tech Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-style nav-active" href="index.php" 
                           onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(0)';">
                            <i class="bi bi-house-door me-2"></i>Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-style" href="index.php?action=introduce"
                           onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(255,255,255,0.1)';"
                           onmouseout="this.style.background='transparent'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="bi bi-info-circle me-2"></i>Về chúng tôi  
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-link-style" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                           onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(255,255,255,0.1)';"
                           onmouseout="this.style.background='transparent'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="bi bi-grid-3x3-gap me-2"></i>Danh mục
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg dropdown-style">
                            <?php foreach ($danhmuc as $d): ?>
                            <li>
                                <a class="dropdown-item text-white py-2 px-3 dropdown-item-style" href="?action=group&id=<?=$d["id"]?>"
                                   onmouseover="this.style.backgroundColor='#1e40af';" onmouseout="this.style.backgroundColor='transparent';">
                                    <i class="bi bi-arrow-right-short me-2"></i><?=htmlspecialchars($d["tendanhmuc"])?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
                
                <form method="GET" action="index.php" class="search-container">
                    <input type="hidden" name="action" value="timkiem">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control search-input" placeholder="Tìm kiếm sản phẩm..." value="<?=htmlspecialchars($_GET['q'] ?? '')?>">
                        <button type="submit" class="btn btn-warning" style="border-radius: 0 25px 25px 0; padding: 0 24px;">
                            <i class="bi bi-search fw-bold"></i>
                        </button>
                    </div>
                </form>
                
                <div class="d-flex align-items-center user-actions ms-3">
                    <?php if(isset($_SESSION["khachhang"])): ?>
                    <div class="d-flex align-items-center text-warning fw-bold me-2">
                        <i class="bi bi-person-circle me-2"></i>
                        <span class="d-none d-md-inline"><?=htmlspecialchars($_SESSION["khachhang"]["hoten"])?></span>
                    </div>
                    <a href="index.php?action=dangxuat" class="btn btn-outline-light border-2 px-3 btn-hover"
                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(255,255,255,0.15)'; this.style.background='rgba(255,255,255,0.1)';"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.background='transparent';">
                        <i class="bi bi-box-arrow-right me-1"></i>Thoát
                    </a>
                    <?php else: ?>
                    <a href="index.php?action=dangnhap" class="btn btn-outline-light border-2 px-3 btn-hover"
                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(255,255,255,0.15)'; this.style.background='rgba(255,255,255,0.1)';"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.background='transparent';">
                        <i class="bi bi-person me-1"></i>Đăng nhập
                    </a>
                    <?php endif; ?>
                    
                    <div class="position-relative">
                        <a href="index.php?action=giohang" class="btn btn-outline-light border-2 px-3 btn-hover"
                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(255,255,255,0.15)'; this.style.background='rgba(255,255,255,0.1)';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.background='transparent';">
                            <i class="bi bi-cart3 me-1"></i>Giỏ hàng
                            <span class="badge bg-danger text-white rounded-pill position-absolute cart-badge">
                                <?=demhangtronggio()?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <section class="py-5">            
        <div class="container px-4 px-lg-5 mt-1">