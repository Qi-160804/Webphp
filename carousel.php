<?php
$hero_product_1 = [
    'id' => 13, 
    'ten' => 'iPhone 16 Pro',
    'mota_ngan' => 'Trang bị chip A18 Pro và nút Capture Button mới.',
    'anh_banner' => '../images/carousel/h2.jpg' 
];
$hero_product_2 = [
    'id' => 18, 
    'ten' => 'Samsung Galaxy Z Flip6',
    'mota_ngan' => 'Kỷ nguyên Galaxy Gập và biểu tượng của phong cách sống năng động.',
    'anh_banner' => '../images/carousel/h1.jpg' 
];
?>

<div id="heroProductCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroProductCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroProductCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    </div>

    <div class="carousel-inner" style="border-radius: 1.2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">

        <div class="carousel-item active">
            <img src="<?= $hero_product_1['anh_banner'] ?>" 
                 class="d-block w-100" 
                 alt="<?= $hero_product_1['ten'] ?>" 
                 style="object-fit: cover; min-height: 400px; max-height: 500px;">
            
            <div class="carousel-caption d-none d-md-block text-start mb-4">
                <h2 class="fw-bold text-shadow"><?= $hero_product_1['ten'] ?></h2>
                <p class="fs-5 text-shadow"><?= $hero_product_1['mota_ngan'] ?></p>
                <a href="index.php?action=detail&id=<?= $hero_product_1['id'] ?>" class="btn btn-warning btn-lg fw-bold px-4 shadow-lg">
                    Khám phá ngay
                </a>
            </div>
        </div>

        <div class="carousel-item">
            <img src="<?= $hero_product_2['anh_banner'] ?>" 
                 class="d-block w-100" 
                 alt="<?= $hero_product_2['ten'] ?>" 
                 style="object-fit: cover; min-height: 400px; max-height: 500px;">
            
            <div class="carousel-caption d-none d-md-block text-start mb-4">
                <h2 class="fw-bold text-shadow"><?= $hero_product_2['ten'] ?></h2>
                <p class="fs-5 text-shadow"><?= $hero_product_2['mota_ngan'] ?></p>
                <a href="index.php?action=detail&id=<?= $hero_product_2['id'] ?>" class="btn btn-warning btn-lg fw-bold px-4 shadow-lg">
                    Mua ngay
                </a>
            </div>
        </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroProductCarousel" data-bs-slide="slide">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroProductCarousel" data-bs-slide="slide">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<style>
    .text-shadow {
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.7);
    }
    .carousel-caption {
        /* Đảm bảo chữ không bị che khuất bởi indicators */
        bottom: 2.5rem; 
    }
</style>