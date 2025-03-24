<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-check-circle me-2"></i>Đăng Kí Học Phần</h1>
    </div>
    <div class="card-body">
        <?php if (isset($courses) && $courses->num_rows > 0): ?>
            <div class="registration-details mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3">Thông tin Đăng kí</h4>
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Mã số sinh viên:</th>
                                <td><strong><?php echo $_SESSION['user_id']; ?></strong></td>
                            </tr>
                            <tr>
                                <th>Họ Tên Sinh Viên:</th>
                                <td><strong><?php echo $_SESSION['user_name']; ?></strong></td>
                            </tr>
                            <tr>
                                <th>Ngày Đăng Kí:</th>
                                <td><strong><?php echo date('d/m/Y'); ?></strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                        <div class="text-end">
                            <div class="mb-2">
                                <span class="course-count">Số học phần: <?php echo $courses->num_rows; ?></span>
                            </div>
                            <div>
                                <span class="credit-count">Tổng số tín chỉ: <?php echo $totalCredits; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Mã Học Phần</th>
                        <th>Tên Học Phần</th>
                        <th>Số Tín Chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($courses) && $courses->num_rows > 0): ?>
                        <?php $i = 1; ?>
                        <?php while ($course = $courses->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $course['MaHP']; ?></td>
                                <td><?php echo $course['TenHP']; ?></td>
                                <td><?php echo $course['SoTinChi']; ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/course/unenroll/<?php echo $course['MaHP']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Bạn có chắc muốn xóa học phần này?');">
                                        <i class="fas fa-trash-alt me-1"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-3">
                                <i class="fas fa-info-circle me-2"></i> Không có học phần nào được đăng ký
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <?php if (isset($courses) && $courses->num_rows > 0): ?>
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="<?php echo BASE_URL; ?>/course/list" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i> Trở về ghi danh
                        </a>
                        <a href="<?php echo BASE_URL; ?>/course/unenrollAll" 
                           class="btn btn-outline-danger ms-2"
                           onclick="return confirm('Bạn có chắc muốn xóa tất cả đăng ký? Hành động này không thể hoàn tác.');">
                            <i class="fas fa-times-circle me-1"></i> Xóa tất cả
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo BASE_URL; ?>/course/saveRegistration" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Lưu Đăng ký
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>/course/list" class="btn btn-primary">
                    <i class="fas fa-clipboard-list me-1"></i> Xem danh sách học phần
                </a>
            <?php endif; ?>
        </div>
    </div>
</div> 