<?php
// Định nghĩa các hằng số
define('BASE_URL', '/Kiemtra');
define('ROOT_PATH', dirname(__DIR__));

// Thiết lập múi giờ
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Cài đặt hiển thị lỗi (development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cấu hình đường dẫn
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers/');
define('MODELS_PATH', ROOT_PATH . '/models/');
define('VIEWS_PATH', ROOT_PATH . '/views/');
define('CONFIG_PATH', ROOT_PATH . '/config/');
define('PUBLIC_PATH', ROOT_PATH . '/public/');

// Cấu hình tải ảnh
define('UPLOAD_PATH', PUBLIC_PATH . 'uploads/');
define('UPLOAD_URL', BASE_URL . '/public/uploads/');
?> 