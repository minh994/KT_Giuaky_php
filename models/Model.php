<?php
// Lớp Model cơ sở
class Model {
    protected $conn;
    protected $table;
    protected $primaryKey = 'id';
    
    public function __construct() {
        global $conn;
        
        // Nếu biến $conn chưa tồn tại, nạp file database.php
        if (!isset($conn)) {
            require_once CONFIG_PATH . 'database.php';
        }
        
        // Gán kết nối
        $this->conn = $conn;
        
        // Kiểm tra kết nối
        if (!$this->conn) {
            die("Lỗi kết nối cơ sở dữ liệu trong Model");
        }
    }
    
    // Lấy tất cả bản ghi
    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        return select_query($this->conn, $query);
    }
    
    // Lấy một bản ghi theo khóa chính
    public function getById($id) {
        $id = escape_string($this->conn, $id);
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = select_query($this->conn, $query);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    // Thêm một bản ghi mới
    public function create($data) {
        $columns = [];
        $values = [];
        
        foreach ($data as $column => $value) {
            $columns[] = $column;
            $values[] = "'" . escape_string($this->conn, $value) . "'";
        }
        
        $columns_str = implode(", ", $columns);
        $values_str = implode(", ", $values);
        
        $query = "INSERT INTO {$this->table} ({$columns_str}) VALUES ({$values_str})";
        
        if (execute_query($this->conn, $query)) {
            return $this->conn->insert_id;
        }
        
        return false;
    }
    
    // Cập nhật một bản ghi
    public function update($id, $data) {
        $id = escape_string($this->conn, $id);
        $sets = [];
        
        foreach ($data as $column => $value) {
            $sets[] = "{$column} = '" . escape_string($this->conn, $value) . "'";
        }
        
        $sets_str = implode(", ", $sets);
        
        $query = "UPDATE {$this->table} SET {$sets_str} WHERE {$this->primaryKey} = '{$id}'";
        
        return execute_query($this->conn, $query);
    }
    
    // Xóa một bản ghi
    public function delete($id) {
        $id = escape_string($this->conn, $id);
        $query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        
        return execute_query($this->conn, $query);
    }
}
?> 