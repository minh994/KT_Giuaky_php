<?php
require_once MODELS_PATH . 'Model.php';

class SinhVienModel extends Model {
    protected $table = 'SinhVien';
    protected $primaryKey = 'MaSV';
    
    // Lấy danh sách sinh viên kèm thông tin ngành học
    public function getAllWithMajor() {
        $query = "SELECT s.*, n.TenNganh 
                  FROM SinhVien s 
                  LEFT JOIN NganhHoc n ON s.MaNganh = n.MaNganh
                  ORDER BY s.MaSV";
        return select_query($this->conn, $query);
    }
    
    // Lấy thông tin chi tiết sinh viên với ngành học
    public function getDetailById($id) {
        $id = escape_string($this->conn, $id);
        $query = "SELECT s.*, n.TenNganh 
                  FROM SinhVien s 
                  LEFT JOIN NganhHoc n ON s.MaNganh = n.MaNganh
                  WHERE s.MaSV = '{$id}'
                  LIMIT 1";
        $result = select_query($this->conn, $query);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    // Tải lên hình ảnh sinh viên cải tiến
    public function uploadImage($file) {
        $default_image = UPLOAD_URL . "student_default.png";
        
        // Nếu không có file hoặc có lỗi
        if (!isset($file) || $file['error'] != 0 || empty($file['tmp_name'])) {
            return $default_image;
        }
        
        // Lấy thông tin file
        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        // Kiểm tra loại file
        $allowTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowTypes)) {
            return $default_image;
        }
        
        // Kiểm tra kích thước file (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            return $default_image;
        }
        
        // Tạo tên file ngẫu nhiên để tránh trùng lặp
        $newFileName = uniqid() . '.' . $imageFileType;
        $target_file = UPLOAD_PATH . $newFileName;
        
        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists(UPLOAD_PATH)) {
            if (!mkdir(UPLOAD_PATH, 0777, true)) {
                return $default_image;
            }
        }
        
        // Kiểm tra thư mục có quyền ghi
        if (!is_writable(UPLOAD_PATH)) {
            chmod(UPLOAD_PATH, 0777);
        }
        
        // Tải file lên
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            return UPLOAD_URL . $newFileName;
        }
        
        return $default_image;
    }

    // Kiểm tra mã sinh viên đã tồn tại chưa
    public function checkExistById($id) {
        $id = escape_string($this->conn, $id);
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        $result = select_query($this->conn, $query);
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }
}
?> 