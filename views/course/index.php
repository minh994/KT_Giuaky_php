<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1>DANH SÁCH HỌC PHẦN</h1>
        <div>
            <a href="<?php echo BASE_URL; ?>/course/list" class="btn btn-success">Đăng ký học phần</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Mã học phần</th>
                    <th>Tên học phần</th>
                    <th>Số tín chỉ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($courses) && $courses->num_rows > 0): ?>
                    <?php while ($course = $courses->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $course['MaHP']; ?></td>
                            <td><?php echo $course['TenHP']; ?></td>
                            <td><?php echo $course['SoTinChi']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Không có học phần nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div> 