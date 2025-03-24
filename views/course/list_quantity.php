<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-clipboard-list me-2"></i>DANH SÁCH HỌC PHẦN</h1>
    </div>
    <div class="card-body">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Bạn cần <a href="<?php echo BASE_URL; ?>/login" class="alert-link">đăng nhập</a> để đăng ký học phần.
            </div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mã Học Phần</th>
                        <th>Tên Học Phần</th>
                        <th>Số Tín Chỉ</th>
                        <th>Số lượng dự kiến</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($courses) && $courses->num_rows > 0): ?>
                        <?php while ($course = $courses->fetch_assoc()): ?>
                            <?php 
                                $statusClass = 'status-available';
                                $statusText = 'Còn trống';
                                
                                if ($course['SoLuong'] <= 20) {
                                    $statusClass = 'status-limited';
                                    $statusText = 'Sắp đầy';
                                }
                                
                                if ($course['SoLuong'] <= 0) {
                                    $statusClass = 'status-full';
                                    $statusText = 'Đã đầy';
                                }
                            ?>
                            <tr>
                                <td><?php echo $course['MaHP']; ?></td>
                                <td><?php echo $course['TenHP']; ?></td>
                                <td><?php echo $course['SoTinChi']; ?></td>
                                <td><?php echo $course['SoLuong']; ?></td>
                                <td><span class="<?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                                <td>
                                    <?php if ($course['SoLuong'] > 0): ?>
                                        <a href="<?php echo BASE_URL; ?>/course/register/<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>" 
                                           class="btn btn-sm btn-success <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>">
                                            <i class="fas fa-plus-circle me-1"></i> Đăng ký
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            <i class="fas fa-ban me-1"></i> Đã đầy
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Không có học phần nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 