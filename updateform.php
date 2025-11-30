<?php include("../inc/top.php"); ?>
<div>
<h3>Cập nhật mặt hàng</h3>
<form method="post" action="index.php" enctype="multipart/form-data">
<input type="hidden" name="action" value="xulysua">
<input type="hidden" name="txtid" value="<?php echo $m["id"]; ?>">

<div class="my-3">    
	<label>Hãng sản xuất</label>    
	<select class="form-control" name="optdanhmuc">
		<?php foreach ($danhmuc as $dm ) { ?>
			<option value="<?php echo $dm["id"]; ?>" <?php if($dm["id"] == $m["danhmuc_id"]) echo "selected"; ?>><?php echo $dm["tendanhmuc"]; ?></option>
		<?php } ?>
	</select>
</div>

<div class="my-3">    
	<label>Tên hàng</label>    
	<input class="form-control" type="text" name="txttenhang" required value="<?php echo $m["tenmathang"]; ?>">
</div> 

<div class="my-3">    
	<label>Mô tả</label>    
	<textarea class="form-control" name="txtmota" id="txtmota" required><?php echo $m["mota"]; ?></textarea>
</div> 

<!-- THÊM Ô NHẬP THỦ CÔNG THÔNG SỐ NỔI BẬT -->
<div class="my-3">
    <label class="form-label text-primary fw-bold">Thông số nổi bật (mỗi dòng 1 thông số)</label>
    <textarea class="form-control" name="txtthongso" rows="6" placeholder="6.7 inch Super Retina XDR
Chip A17 Pro
Camera 48MP + 12MP
Pin 4422mAh
iOS 17
Titan nhẹ"><?php 
        if (!empty($m['thongso'])) {
            $specs = json_decode($m['thongso'], true);
            if (is_array($specs)) {
                echo htmlspecialchars(implode("\n", $specs));
            }
        }
    ?></textarea>
    <small class="text-success">Để trống = giữ nguyên thông số cũ trong CSDL</small>
</div>

<div class="my-3">    
	<label>Giá gốc</label>    
	<input class="form-control" type="number" name="txtgiagoc" value="<?php echo $m["giagoc"]; ?>" required>
</div> 

<div class="my-3">    
	<label>Giá bán</label>    
	<input class="form-control" type="number" name="txtgiaban" value="<?php echo $m["giaban"]; ?>" required>
</div> 

<div class="my-3">    
	<label>Số lượng tồn</label>    
	<input class="form-control" type="number" name="txtsoluongton" value="<?php echo $m["soluongton"]; ?>" required>
</div> 

<div class="my-3">    
	<label>Lượt xem</label>    
	<input class="form-control" type="number" name="txtluotxem" value="<?php echo $m["luotxem"]; ?>" required>
</div> 

<div class="my-3">    
	<label>Lượt mua</label>    
	<input class="form-control" type="number" name="txtluotmua" value="<?php echo $m["luotmua"]; ?>" required>
</div> 

<!-- ẢNH CHÍNH -->
<div class="my-3">
    <label class="form-label fw-bold">Hình ảnh chính</label><br>
    <input type="hidden" name="txthinhcu" value="<?php echo $m["hinhanh"]; ?>">
    <img src="../../<?php echo $m["hinhanh"]; ?>" width="80" height="80" class="img-thumbnail me-2" style="object-fit: cover;">
    <a data-bs-toggle="collapse" data-bs-target="#changeMain" class="text-primary">Đổi ảnh chính</a>
    <div id="changeMain" class="collapse mt-2">
        <input type="file" class="form-control" name="filehinhanh" accept="image/*">
        <small class="text-muted">Chỉ chọn 1 ảnh làm ảnh chính</small>
    </div>
</div>

<!-- ẢNH PHỤ (NHIỀU ẢNH) -->
<div class="my-3">
    <label class="form-label fw-bold text-success">Ảnh phụ (tối đa 4 ảnh)</label>
    <input type="file" class="form-control" name="filehinhphu[]" multiple accept="image/*">
    <small class="text-muted">Giữ <kbd>Ctrl</kbd> (Windows) hoặc <kbd>Cmd</kbd> (Mac) để chọn nhiều ảnh</small>
</div>

<!-- HIỂN THỊ ẢNH PHỤ CŨ (NẾU CÓ) -->
<?php if (!empty($m['hinhphu'])): 
    $old_phu = json_decode($m['hinhphu'], true);
    if (is_array($old_phu) && count($old_phu) > 0): ?>
    <div class="mt-2">
        <small class="text-info">Ảnh phụ hiện tại (click <span class="text-danger">×</span> để xóa):</small><br>
        <?php foreach ($old_phu as $i => $img): 
            $fullpath = "../../" . $img;
            if (file_exists($fullpath)): ?>
                <div class="d-inline-block position-relative me-2 mb-2">
                    <img src="../../<?= htmlspecialchars($img) ?>" width="80" height="80" class="img-thumbnail" style="object-fit: cover;">
                    <a href="index.php?action=xoahinhphu&id=<?= $m['id'] ?>&img=<?= $i ?>&return=sua" 
                       class="position-absolute top-0 end-0 btn btn-danger btn-sm rounded-circle p-1" 
                       style="width:24px; height:24px; font-size:10px; line-height:1;"
                       onclick="return confirm('Xóa ảnh này?')">
                        ×
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; endif; ?>

<div class="my-3">
	<input class="btn btn-primary" type="submit" value="Lưu">
	<input class="btn btn-warning" type="reset" value="Hủy">
</div>
</form>
</div>

<script>
    ClassicEditor
        .create( document.querySelector( '#txtmota' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<?php include("../inc/bottom.php"); ?>