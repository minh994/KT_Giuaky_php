<?php
if (isset($student)): 
?>
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Thông tin sinh viên</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="<?php echo $student['Hinh']; ?>" alt="Hình sinh viên" class="img-thumbnail" style="max-width: 150px;">
                </div>
                <dl class="row">
                    <dt class="col-sm-4">Mã SV:</dt>
                    <dd class="col-sm-8"><?php echo $student['MaSV']; ?></dd>
                    
                    <dt class="col-sm-4">Họ tên:</dt>
                    <dd class="col-sm-8"><?php echo $student['HoTen']; ?></dd>
                    
                    <dt class="col-sm-4">Ngành:</dt>
                    <dd class="col-sm-8"><?php echo isset($student['TenNganh']) ? $student['TenNganh'] : $student['MaNganh']; ?></dd>
                </dl>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Học phần đã đăng ký</h5>
            </div>
            <div class="card-body">
                <?php if (isset($registeredCourses) && $registeredCourses->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while ($course = $registeredCourses->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $course['TenHP']; ?>
                                <span class="badge bg-primary rounded-pill"><?php echo $course['SoTinChi']; ?> tín chỉ</span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center">Chưa đăng ký học phần nào</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h1>ĐĂNG KÝ HỌC PHẦN</h1>
            </div>
            <div class="card-body">
                <?php if (isset($unregisteredCourses) && $unregisteredCourses->num_rows > 0): ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Mã học phần</th>
                                <th>Tên học phần</th>
                                <th>Số tín chỉ</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($course = $unregisteredCourses->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $course['MaHP']; ?></td>
                                    <td><?php echo $course['TenHP']; ?></td>
                                    <td><?php echo $course['SoTinChi']; ?></td>
                                    <td>
                                        <form action="<?php echo BASE_URL; ?>/course/enrollCourse" method="post">
                                            <input type="hidden" name="masv" value="<?php echo $student['MaSV']; ?>">
                                            <input type="hidden" name="mahp" value="<?php echo $course['MaHP']; ?>">
                                            <button type="submit" class="btn btn-sm btn-success">Đăng ký</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p class="text-center">Không còn học phần nào để đăng ký</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL; ?>/student" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
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