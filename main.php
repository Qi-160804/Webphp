<?php include("../inc/top.php"); ?>

<div class="container-fluid">
    <!-- THÔNG BÁO -->
    <?php foreach(['thongbao' => ['success', 'check-circle', true], 'loi' => ['danger', 'exclamation-triangle', false]] as $key => [$type, $icon, $isSession]): 
        $msg = $isSession ? ($_SESSION[$key] ?? null) : ($$key ?? null);
        if(!empty($msg)): ?>
    <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-<?= $icon ?>-fill me-2"></i><?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php if($isSession) unset($_SESSION[$key]); endif; endforeach; ?>

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-primary mb-0"><i class="bi bi-people-fill me-2"></i>Quản lý người dùng</h4>
            <small class="text-muted">Quản lý thông tin và phân quyền người dùng hệ thống</small>
        </div>
        <div>
            <a class="btn btn-primary" href="index.php?action=them">
                <i class="bi bi-person-plus me-1"></i> Thêm người dùng
            </a>
        </div>
    </div>

    <!-- THỐNG KÊ -->
    <?php
    $tk = ['admin' => 0, 'staff' => 0, 'user' => 0, 'active' => 0, 'locked' => 0];
    foreach($nguoidung_list as $nd) {
        // Thống kê theo loại
        if($nd["loai"] == 1) $tk['admin']++;
        elseif($nd["loai"] == 2) $tk['staff']++;
        else $tk['user']++;
        
        // Thống kê trạng thái (chỉ cho staff và user)
        if($nd["loai"] != 1) {
            $nd["trangthai"] == 1 ? $tk['active']++ : $tk['locked']++;
        }
    }

    $cards = [
        ['bg' => 'primary', 'icon' => 'people-fill', 'title' => 'Tổng người dùng', 'value' => count($nguoidung_list)],
        ['bg' => 'danger', 'icon' => 'shield-fill', 'title' => 'Quản trị viên', 'value' => $tk['admin']],
        ['bg' => 'warning', 'icon' => 'person-gear', 'title' => 'Nhân viên', 'value' => $tk['staff']],
        ['bg' => 'info', 'icon' => 'person', 'title' => 'Khách hàng', 'value' => $tk['user']],
        ['bg' => 'success', 'icon' => 'check-circle-fill', 'title' => 'Đang hoạt động', 'value' => $tk['active']],
        ['bg' => 'secondary', 'icon' => 'lock-fill', 'title' => 'Đã khóa', 'value' => $tk['locked']]
    ];
    ?>

    <div class="row mb-4">
        <?php foreach($cards as $c): ?>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="card bg-<?= $c['bg'] ?> text-white shadow-sm border-0">
                <div class="card-body text-center py-3">
                    <i class="bi bi-<?= $c['icon'] ?> h5 mb-2"></i>
                    <h6 class="card-title small mb-2"><?= $c['title'] ?></h6>
                    <h5 class="mb-0 fw-bold"><?= number_format($c['value']) ?></h5>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- BẢNG DANH SÁCH -->
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Danh sách người dùng</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60" class="ps-4">ID</th>
                            <th>Thông tin</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th width="120" class="text-center">Loại quyền</th>
                            <th width="120" class="text-center">Trạng thái</th>
                            <th width="150" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($nguoidung_list)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-people display-4 text-muted d-block mb-3"></i>
                                <h5 class="text-muted">Chưa có người dùng nào</h5>
                                <a href="index.php?action=them" class="btn btn-primary mt-2">
                                    <i class="bi bi-person-plus me-1"></i>Thêm người dùng đầu tiên
                                </a>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($nguoidung_list as $nd): ?>
                            <tr>
                                <td class="align-middle ps-4 fw-bold text-muted"><?= $nd["id"] ?></td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white me-3">
                                            <?= strtoupper(substr($nd["hoten"], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-medium"><?= htmlspecialchars($nd["hoten"]) ?></div>
                                            <small class="text-muted">ID: <?= $nd["id"] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <i class="bi bi-envelope text-muted me-2"></i>
                                    <?= htmlspecialchars($nd["email"]) ?>
                                </td>
                                <td class="align-middle">
                                    <i class="bi bi-telephone text-muted me-2"></i>
                                    <?= htmlspecialchars($nd["sodienthoai"]) ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?php 
                                    $loai_labels = [
                                        1 => ['label' => 'Quản trị', 'class' => 'danger'],
                                        2 => ['label' => 'Nhân viên', 'class' => 'warning'],
                                        3 => ['label' => 'Khách hàng', 'class' => 'info']
                                    ];
                                    $loai = $nd["loai"];
                                    $label = $loai_labels[$loai] ?? ['label' => 'Khác', 'class' => 'secondary'];
                                    ?>
                                    <span class="badge bg-<?= $label['class'] ?>">
                                        <?= $label['label'] ?>
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <?php if($nd["loai"] != 1): ?>
                                        <span class="badge bg-<?= $nd['trangthai'] == 1 ? 'success' : 'danger' ?>">
                                            <i class="bi bi-<?= $nd['trangthai'] == 1 ? 'check-circle' : 'lock' ?> me-1"></i>
                                            <?= $nd['trangthai'] == 1 ? 'Hoạt động' : 'Đã khóa' ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">
                                            <i class="bi bi-shield-check me-1"></i>Mặc định
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <?php if($nd["loai"] != 1): ?>
                                            <?php if($nd["trangthai"] == 1): ?>
                                                <a href="?action=khoa&trangthai=0&mand=<?= $nd["id"] ?>" 
                                                   class="btn btn-outline-danger" title="Khóa tài khoản"
                                                   onclick="return confirm('Bạn có chắc muốn khóa tài khoản <?= htmlspecialchars($nd["hoten"]) ?>?')">
                                                    <i class="bi bi-lock"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="?action=khoa&trangthai=1&mand=<?= $nd["id"] ?>" 
                                                   class="btn btn-outline-success" title="Mở khóa tài khoản"
                                                   onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản <?= htmlspecialchars($nd["hoten"]) ?>?')">
                                                    <i class="bi bi-unlock"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}
.card {
    border-radius: 0.5rem;
}
.table th {
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}
</style>

<script>
// Tự động đóng alert sau 5 giây
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        bootstrap.Alert.getOrCreateInstance(alert).close();
    });
}, 5000);
</script>

<?php include("../inc/bottom.php"); ?>