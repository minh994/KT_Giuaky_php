<?php
if (isset($student)): 
?>
<div class="card">
    <div class="card-header">
        <h1>XÓA THÔNG TIN</h1>
        <p>Are you sure you want to delete this?</p>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $student['Hinh']; ?>" alt="Hình sinh viên" class="img-fluid rounded">
            </div>
            <div class="col-md-8">
                <dl class="row">
                    <dt class="col-sm-3">HoTen</dt>
                    <dd class="col-sm-9"><?php echo $student['HoTen']; ?></dd>
                    
                    <dt class="col-sm-3">GioiTinh</dt>
                    <dd class="col-sm-9"><?php echo $student['GioiTinh']; ?></dd>
                    
                    <dt class="col-sm-3">NgaySinh</dt>
                    <dd class="col-sm-9"><?php echo date('d/m/Y', strtotime($student['NgaySinh'])); ?></dd>
                    
                    <dt class="col-sm-3">MaNganh</dt>
                    <dd class="col-sm-9"><?php echo $student['MaNganh']; ?></dd>
                </dl>
            </div>
        </div>
        
        <form action="<?php echo BASE_URL; ?>/student/delete/<?php echo $student['MaSV']; ?>" method="post" class="mt-4">
            <input type="hidden" name="confirm" value="yes">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="<?php echo BASE_URL; ?>/student" class="btn btn-secondary">Back to List</a>
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