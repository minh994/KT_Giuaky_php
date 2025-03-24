<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-clipboard-check me-2"></i>Thông Tin Học Phần Đã Lưu</h1>
    </div>
    <div class="card-body">
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i> Đăng ký học phần thành công!
        </div>
        
        <div class="registration-details mb-4">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">Thông tin Đăng kí</h4>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Mã số sinh viên:</th>
                            <td><strong><?php echo $registration['MaSV']; ?></strong></td>
                        </tr>
                        <tr>
                            <th>Họ Tên Sinh Viên:</th>
                            <td><strong><?php echo $registration['HoTen']; ?></strong></td>
                        </tr>
                        <tr>
                            <th>Ngành Học:</th>
                            <td><strong><?php echo $registration['TenNganh']; ?></strong></td>
                        </tr>
                        <tr>
                            <th>Ngày Đăng Kí:</th>
                            <td><strong><?php echo date('d/m/Y', strtotime($registration['NgayDK'])); ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <h4 class="mb-3"><i class="fas fa-clipboard-list me-2"></i>Kết quả sau khi đăng ký học phần:</h4>
        
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Mã Đăng Ký</th>
                        <th>Ngày Đăng Ký</th>
                        <th>Mã Sinh Viên</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td><?php echo $registration['MaDK']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($registration['NgayDK'])); ?></td>
                        <td><?php echo $registration['MaSV']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <h4 class="mb-3"><i class="fas fa-book-open me-2"></i>Chi tiết các học phần đã đăng ký:</h4>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Mã Học Phần</th>
                        <th>Tên Học Phần</th>
                        <th>Số Tín Chỉ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($details->num_rows > 0): ?>
                        <?php $i = 1; $totalCredits = 0; ?>
                        <?php while ($detail = $details->fetch_assoc()): ?>
                            <?php $totalCredits += $detail['SoTinChi']; ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $detail['MaHP']; ?></td>
                                <td><?php echo $detail['TenHP']; ?></td>
                                <td><?php echo $detail['SoTinChi']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tr class="table-info">
                            <td colspan="3" class="text-end"><strong>Tổng số tín chỉ:</strong></td>
                            <td><strong><?php echo $totalCredits; ?></strong></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Không có học phần nào được đăng ký</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 text-center">
            <a href="<?php echo BASE_URL; ?>/student" class="btn btn-primary me-2">
                <i class="fas fa-home me-1"></i> Về trang chủ
            </a>
            <a href="<?php echo BASE_URL; ?>/course/enrolled" class="btn btn-success">
                <i class="fas fa-check-circle me-1"></i> Xem học phần đã đăng ký
            </a>
        </div>
    </div>
</div> 