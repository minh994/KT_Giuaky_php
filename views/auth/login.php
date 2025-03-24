<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h1>ĐĂNG NHẬP</h1>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>/auth/authenticate" method="post">
                    <div class="mb-3">
                        <label for="masv" class="form-label">MaSV</label>
                        <input type="text" class="form-control" id="masv" name="masv" required maxlength="10" placeholder="Nhập mã sinh viên">
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="alert alert-info mt-3">
            <p class="mb-0">Sử dụng mã sinh viên để đăng nhập. Có thể sử dụng một trong các mã sau:</p>
            <ul class="mt-2">
                <li>0123456789</li>
                <li>9876543210</li>
            </ul>
        </div>
    </div>
</div> 