<?php
if (isset($student)): 
?>
<div class="card">
    <div class="card-header">
        <h1>Thông tin chi tiết</h1>
        <p>SinhVien</p>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $student['Hinh']; ?>" alt="Hình sinh viên" class="img-fluid rounded">
            </div>
            <div class="col-md-8">
                <dl class="row">
                    <dt class="col-sm-3">Họ tên:</dt>
                    <dd class="col-sm-9"><?php echo $student['HoTen']; ?></dd>
                    
                    <dt class="col-sm-3">Giới tính:</dt>
                    <dd class="col-sm-9"><?php echo $student['GioiTinh']; ?></dd>
                    
                    <dt class="col-sm-3">Ngày sinh:</dt>
                    <dd class="col-sm-9"><?php echo date('d/m/Y', strtotime($student['NgaySinh'])); ?></dd>
                    
                    <dt class="col-sm-3">Mã ngành:</dt>
                    <dd class="col-sm-9"><?php echo $student['MaNganh']; ?></dd>
                    
                    <dt class="col-sm-3">Tên ngành:</dt>
                    <dd class="col-sm-9"><?php echo $student['TenNganh']; ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="<?php echo BASE_URL; ?>/student/edit/<?php echo $student['MaSV']; ?>" class="btn btn-warning">Edit</a>
        <a href="<?php echo BASE_URL; ?>/student/delete/<?php echo $student['MaSV']; ?>" class="btn btn-danger">Delete</a>
        <a href="<?php echo BASE_URL; ?>/student" class="btn btn-secondary">Back to List</a>
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