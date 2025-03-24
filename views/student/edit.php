<?php
if (isset($student)): 
?>
<div class="card">
    <div class="card-header">
        <h1>Hiệu chỉnh thông tin sinh viên</h1>
        <p><?php echo $student['HoTen']; ?></p>
    </div>
    <div class="card-body">
        <form action="<?php echo BASE_URL; ?>/student/update" method="post" enctype="multipart/form-data">
            <input type="hidden" name="masv" value="<?php echo $student['MaSV']; ?>">
            <input type="hidden" name="current_hinh" value="<?php echo $student['Hinh']; ?>">
            
            <div class="mb-3">
                <label for="hoten" class="form-label">HoTen</label>
                <input type="text" class="form-control" id="hoten" name="hoten" value="<?php echo $student['HoTen']; ?>" required maxlength="50">
            </div>
            
            <div class="mb-3">
                <label class="form-label">GioiTinh</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gioitinh" id="nam" value="Nam" <?php echo $student['GioiTinh'] == 'Nam' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="nam">Nam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gioitinh" id="nu" value="Nữ" <?php echo $student['GioiTinh'] == 'Nữ' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="nu">Nữ</label>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="ngaysinh" class="form-label">NgaySinh</label>
                <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="<?php echo $student['NgaySinh']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="hinh" class="form-label">Hinh</label>
                <div class="row">
                    <div class="col-md-3">
                        <img src="<?php echo $student['Hinh']; ?>" alt="Hình sinh viên" class="img-thumbnail">
                    </div>
                    <div class="col-md-9">
                        <input type="file" class="form-control" id="hinh" name="hinh" accept="image/*">
                        <div class="form-text">Chỉ chọn file khi muốn thay đổi hình ảnh.</div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="manganh" class="form-label">MaNganh</label>
                <select class="form-select" id="manganh" name="manganh" required>
                    <option value="">-- Chọn ngành học --</option>
                    <?php if (isset($majors) && is_array($majors)): ?>
                        <?php foreach ($majors as $key => $value): ?>
                            <option value="<?php echo $key; ?>" <?php echo $student['MaNganh'] == $key ? 'selected' : ''; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?php echo BASE_URL; ?>/student" class="btn btn-secondary">Back to List</a>
            </div>
        </form>
    </div>
</div>
<?php else: ?>
<div class="alert alert-danger">
    <p class="text-center">Không tìm thấy thông tin sinh viên</p>
    <div class="text-center mt-3">
        <a href="<?php echo BASE_URL; ?>/student" class="btn btn-secondary">Back to List</a>
    </div>
</div>
<?php endif; ?> 