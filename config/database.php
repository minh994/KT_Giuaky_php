<?php
// Thông tin kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = ""; // Thay đổi mật khẩu nếu cần
$dbname = "Test1";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Hàm bảo vệ dữ liệu ngăn chặn SQL injection
function escape_string($conn, $string) {
    return $conn->real_escape_string($string);
}

// Hàm thực thi truy vấn select và trả về kết quả
function select_query($conn, $query) {
    $result = $conn->query($query);
    if (!$result) {
        die("Lỗi truy vấn: " . $conn->error);
    }
    return $result;
}

// Hàm thực thi các truy vấn không trả về kết quả (INSERT, UPDATE, DELETE)
function execute_query($conn, $query) {
    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        echo "Lỗi: " . $query . "<br>" . $conn->error;
        return false;
    }
}

// Hàm lấy ID của bản ghi vừa chèn
function get_insert_id($conn) {
    return $conn->insert_id;
}
?> 