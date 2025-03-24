<?php
require_once MODELS_PATH . 'Model.php';

class HocPhanModel extends Model {
    protected $table = 'HocPhan';
    protected $primaryKey = 'MaHP';
    
    // Kiểm tra xem mã học phần đã tồn tại hay chưa
    public function checkExistById($id) {
        $id = escape_string($this->conn, $id);
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        $result = select_query($this->conn, $query);
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }
    
    // Lấy danh sách học phần mà sinh viên chưa đăng ký
    public function getUnregisteredCourses($masv) {
        $masv = escape_string($this->conn, $masv);
        $query = "SELECT hp.* FROM HocPhan hp
                 WHERE hp.MaHP NOT IN (
                     SELECT ctdk.MaHP 
                     FROM ChiTietDangKy ctdk 
                     JOIN DangKy dk ON ctdk.MaDK = dk.MaDK
                     WHERE dk.MaSV = '{$masv}'
                 )
                 ORDER BY hp.TenHP";
                 
        return select_query($this->conn, $query);
    }
    
    // Lấy danh sách học phần mà sinh viên đã đăng ký
    public function getRegisteredCourses($masv) {
        $masv = escape_string($this->conn, $masv);
        $query = "SELECT hp.*, dk.NgayDK, dk.MaDK 
                 FROM HocPhan hp
                 JOIN ChiTietDangKy ctdk ON hp.MaHP = ctdk.MaHP
                 JOIN DangKy dk ON ctdk.MaDK = dk.MaDK
                 WHERE dk.MaSV = '{$masv}'
                 ORDER BY hp.TenHP";
                 
        return select_query($this->conn, $query);
    }

    // Hủy đăng ký một học phần
    public function unenrollCourse($masv, $mahp) {
        $masv = escape_string($this->conn, $masv);
        $mahp = escape_string($this->conn, $mahp);
        
        // Tìm MaDK của sinh viên
        $query = "SELECT dk.MaDK FROM DangKy dk WHERE dk.MaSV = '{$masv}' LIMIT 1";
        $result = select_query($this->conn, $query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $madk = $row['MaDK'];
            
            // Xóa chi tiết đăng ký
            $query = "DELETE FROM ChiTietDangKy WHERE MaDK = '{$madk}' AND MaHP = '{$mahp}'";
            return execute_query($this->conn, $query);
        }
        
        return false;
    }

    // Hủy tất cả đăng ký học phần
    public function unenrollAllCourses($masv) {
        $masv = escape_string($this->conn, $masv);
        
        // Tìm MaDK của sinh viên
        $query = "SELECT dk.MaDK FROM DangKy dk WHERE dk.MaSV = '{$masv}' LIMIT 1";
        $result = select_query($this->conn, $query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $madk = $row['MaDK'];
            
            // Xóa tất cả chi tiết đăng ký
            $query = "DELETE FROM ChiTietDangKy WHERE MaDK = '{$madk}'";
            return execute_query($this->conn, $query);
        }
        
        return false;
    }

    // Đăng ký học phần cho sinh viên
    public function enrollStudentCourse($masv, $mahp) {
        $masv = escape_string($this->conn, $masv);
        $mahp = escape_string($this->conn, $mahp);
        
        // Kiểm tra xem đã có đăng ký nào cho sinh viên này chưa
        $query = "SELECT MaDK FROM DangKy WHERE MaSV = '{$masv}' LIMIT 1";
        $result = select_query($this->conn, $query);
        
        if ($result->num_rows > 0) {
            // Đã có đăng ký, lấy mã đăng ký
            $row = $result->fetch_assoc();
            $madk = $row['MaDK'];
        } else {
            // Chưa có, tạo đăng ký mới
            $currentDate = date('Y-m-d');
            $query = "INSERT INTO DangKy (NgayDK, MaSV) VALUES ('{$currentDate}', '{$masv}')";
            execute_query($this->conn, $query);
            $madk = get_insert_id($this->conn);
        }
        
        // Kiểm tra xem học phần đã được đăng ký chưa
        $query = "SELECT * FROM ChiTietDangKy WHERE MaDK = '{$madk}' AND MaHP = '{$mahp}'";
        $result = select_query($this->conn, $query);
        
        if ($result->num_rows > 0) {
            // Học phần đã được đăng ký
            return true;
        }
        
        // Thêm chi tiết đăng ký
        $query = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('{$madk}', '{$mahp}')";
        return execute_query($this->conn, $query);
    }

    // Cải thiện phương thức lưu đăng ký thông tin
    public function saveRegistration($masv) {
        $masv = escape_string($this->conn, $masv);
        
        try {
            // Bắt đầu transaction
            $this->conn->begin_transaction();
            
            // Lấy thông tin sinh viên
            require_once MODELS_PATH . 'SinhVienModel.php';
            $studentModel = new SinhVienModel();
            $student = $studentModel->getDetailById($masv);
            
            if (!$student) {
                throw new Exception("Không tìm thấy thông tin sinh viên");
            }
            
            // Lấy mã đăng ký hiện tại
            $query = "SELECT MaDK FROM DangKy WHERE MaSV = '{$masv}' LIMIT 1";
            $result = select_query($this->conn, $query);
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $madk = $row['MaDK'];
                
                // Kiểm tra xem có học phần đã đăng ký không
                $query = "SELECT COUNT(*) as count FROM ChiTietDangKy WHERE MaDK = '{$madk}'";
                $result = select_query($this->conn, $query);
                $row = $result->fetch_assoc();
                
                if ($row['count'] == 0) {
                    throw new Exception("Chưa có học phần nào được đăng ký");
                }
                
                // Cập nhật NgayDK
                $currentDate = date('Y-m-d');
                $query = "UPDATE DangKy SET NgayDK = '{$currentDate}' WHERE MaDK = '{$madk}'";
                execute_query($this->conn, $query);
                
                // Cập nhật số lượng học phần
                $this->updateCourseQuantities($madk);
                
                // Commit transaction
                $this->conn->commit();
                
                return $madk;
            } else {
                throw new Exception("Chưa có đăng ký nào cho sinh viên này");
            }
        } catch (Exception $e) {
            // Rollback transaction nếu có lỗi
            $this->conn->rollback();
            
            // Log lỗi hoặc hiển thị lỗi
            error_log("Lỗi khi lưu đăng ký: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật số lượng dự kiến học phần
    private function updateCourseQuantities($madk) {
        $madk = escape_string($this->conn, $madk);
        
        // Lấy danh sách học phần đã đăng ký
        $query = "SELECT MaHP FROM ChiTietDangKy WHERE MaDK = '{$madk}'";
        $result = select_query($this->conn, $query);
        
        while ($row = $result->fetch_assoc()) {
            $mahp = $row['MaHP'];
            
            // Kiểm tra cột SoLuong có tồn tại không
            $checkQuery = "SHOW COLUMNS FROM HocPhan LIKE 'SoLuong'";
            $checkResult = $this->conn->query($checkQuery);
            
            if ($checkResult->num_rows > 0) {
                // Cột SoLuong tồn tại, giảm số lượng dự kiến của học phần
                $query = "UPDATE HocPhan SET SoLuong = GREATEST(SoLuong - 1, 0) WHERE MaHP = '{$mahp}'";
                execute_query($this->conn, $query);
            }
        }
        
        return true;
    }

    // Lấy thông tin đăng ký chi tiết
    public function getRegistrationDetails($madk) {
        $madk = escape_string($this->conn, $madk);
        
        // Lấy thông tin đăng ký
        $query = "SELECT dk.*, sv.HoTen, sv.MaNganh, nh.TenNganh 
                  FROM DangKy dk 
                  JOIN SinhVien sv ON dk.MaSV = sv.MaSV 
                  JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                  WHERE dk.MaDK = '{$madk}'";
        $result = select_query($this->conn, $query);
        
        if ($result->num_rows == 0) {
            return null;
        }
        
        $registration = $result->fetch_assoc();
        
        // Lấy chi tiết học phần đã đăng ký
        $query = "SELECT ctdk.*, hp.TenHP, hp.SoTinChi 
                  FROM ChiTietDangKy ctdk 
                  JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP 
                  WHERE ctdk.MaDK = '{$madk}'";
        $details = select_query($this->conn, $query);
        
        return [
            'registration' => $registration,
            'details' => $details
        ];
    }

    // Lấy danh sách học phần với số lượng
    public function getAllWithQuantity() {
        $query = "SELECT * FROM {$this->table} ORDER BY TenHP";
        return select_query($this->conn, $query);
    }
}
?> 