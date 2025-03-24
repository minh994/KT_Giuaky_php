<div class="card">
    <div class="card-header bg-dark text-white">
        <h5>THÊM SINH VIÊN</h5>
    </div>
    <div class="card-body">
        <div class="mb-2">SinhVien</div>
        
        <form action="<?php echo BASE_URL; ?>/student/store" method="POST" enctype="multipart/form-data">
            <div class="mb-3 row">
                <label for="masv" class="col-sm-2 col-form-label">MaSV</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="masv" name="masv" maxlength="10" required>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="hoten" class="col-sm-2 col-form-label">HoTen</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="hoten" name="hoten" required>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="gioitinh" class="col-sm-2 col-form-label">GioiTinh</label>
                <div class="col-sm-4">
                    <select class="form-select" id="gioitinh" name="gioitinh">
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="ngaysinh" class="col-sm-2 col-form-label">NgaySinh</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" required>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="hinh" class="col-sm-2 col-form-label">Hinh</label>
                <div class="col-sm-4">
                    <input type="file" class="form-control" id="hinh" name="hinh" accept="image/*">
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="manganh" class="col-sm-2 col-form-label">MaNganh</label>
                <div class="col-sm-4">
                    <select class="form-select" id="manganh" name="manganh" required>
                        <option value="">-- Chọn ngành học --</option>
                        <?php if (isset($majors)): ?>
                            <?php foreach ($majors as $key => $value): ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-3 row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-success btn-sm">Create</button>
                </div>
            </div>
        </form>
        
        <div>
            <a href="<?php echo BASE_URL; ?>/student" class="text-decoration-none">QUAY LẠI</a>
        </div>
    </div>
</div>

<script>
// Hiển thị hình ảnh trước khi upload
document.getElementById('hinh').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Kiểm tra loại file
        const fileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!fileTypes.includes(file.type)) {
            alert('Vui lòng chọn file hình ảnh (jpg, jpeg, png, gif)');
            this.value = '';
            return;
        }
        
        // Kiểm tra kích thước file (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Kích thước file không được vượt quá 2MB');
            this.value = '';
            return;
        }
    }
});
</script> 