<?php
// Lớp Controller cơ sở
class Controller {
    // Phương thức render view
    protected function render($view, $data = []) {
        // Trích xuất dữ liệu thành các biến riêng lẻ
        extract($data);
        
        // Bắt đầu output buffering
        ob_start();
        
        // Hiển thị header
        include(VIEWS_PATH . 'shared/header.php');
        
        // Hiển thị view chính
        include(VIEWS_PATH . $view . '.php');
        
        // Hiển thị footer
        include(VIEWS_PATH . 'shared/footer.php');
        
        // Lấy nội dung và kết thúc output buffering
        $content = ob_get_clean();
        
        // Hiển thị nội dung
        echo $content;
    }
    
    // Phương thức redirect
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . $url);
        exit;
    }
    
    // Phương thức lấy thông báo
    protected function setMessage($type, $message) {
        $_SESSION['message'] = [
            'type' => $type,
            'text' => $message
        ];
    }
    
    // Phương thức lấy thông báo và xóa nó khỏi session
    protected function getMessage() {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            return $message;
        }
        return null;
    }
}
?> 