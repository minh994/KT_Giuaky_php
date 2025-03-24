<div class="card">
    <div class="card-header">
        <h1>DANH SÁCH HỌC PHẦN</h1>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Mã Học Phần</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($courses) && $courses->num_rows > 0): ?>
                    <?php while ($course = $courses->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $course['MaHP']; ?></td>
                            <td><?php echo $course['TenHP']; ?></td>
                            <td><?php echo $course['SoTinChi']; ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>/course/register/<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>" class="btn btn-sm btn-success <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>">Đăng ký</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Không có học phần nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if (!isset($_SESSION['user_id'])): ?>
<div class="alert alert-warning mt-3">
    <p>Bạn cần <a href="<?php echo BASE_URL; ?>/login">đăng nhập</a> để đăng ký học phần.</p>
</div>
<?php endif; ?> 