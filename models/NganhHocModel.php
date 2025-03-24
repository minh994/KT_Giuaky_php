<?php
require_once MODELS_PATH . 'Model.php';

class NganhHocModel extends Model {
    protected $table = 'NganhHoc';
    protected $primaryKey = 'MaNganh';
    
    // Kiểm tra xem mã ngành đã tồn tại hay chưa
    public function checkExistById($id) {
        $id = escape_string($this->conn, $id);
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        $result = select_query($this->conn, $query);
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }
    
    // Lấy danh sách ngành học dạng key-value
    public function getAllForSelect() {
        $query = "SELECT MaNganh, TenNganh FROM {$this->table} ORDER BY TenNganh";
        $result = select_query($this->conn, $query);
        $options = [];
        
        while ($row = $result->fetch_assoc()) {
            $options[$row['MaNganh']] = $row['TenNganh'];
        }
        
        return $options;
    }
}
?> 