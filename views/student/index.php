<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1>TRANG SINH VIÊN</h1>
        <a href="<?php echo BASE_URL; ?>/student/create" class="btn btn-primary">Add Student</a>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>MaSV</th>
                    <th>HoTen</th>
                    <th>GioiTinh</th>
                    <th>NgaySinh</th>
                    <th>Hinh</th>
                    <th>MaNganh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($students) && $students->num_rows > 0): ?>
                    <?php while ($student = $students->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $student['MaSV']; ?></td>
                            <td><?php echo $student['HoTen']; ?></td>
                            <td><?php echo $student['GioiTinh']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($student['NgaySinh'])); ?></td>
                            <td>
                                <img src="<?php echo $student['Hinh']; ?>" alt="Hình sinh viên" class="img-thumbnail" style="max-width: 80px;">
                            </td>
                            <td><?php echo $student['TenNganh']; ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>/student/edit/<?php echo $student['MaSV']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?php echo BASE_URL; ?>/student/detail/<?php echo $student['MaSV']; ?>" class="btn btn-sm btn-info">Details</a>
                                <a href="<?php echo BASE_URL; ?>/student/delete/<?php echo $student['MaSV']; ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có sinh viên nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div> 