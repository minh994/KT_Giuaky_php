<?php
require_once CONTROLLERS_PATH . 'Controller.php';
require_once MODELS_PATH . 'SinhVienModel.php';

class AuthController extends Controller {
    private $studentModel;
    
    public function __construct() {
        $this->studentModel = new SinhVienModel();
    }
    
    // Hiển thị form đăng nhập
    public function login() {
        // Nếu đã đăng nhập, chuyển hướng về trang chủ
        if (isset($_SESSION['user_id'])) {
            $this->redirect('student');
            return;
        }
        
        $data = [
            'page_title' => 'Đăng nhập'
        ];
        
        $this->render('auth/login', $data);
    }
    
    // Xử lý đăng nhập
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $masv = isset($_POST['masv']) ? $_POST['masv'] : '';
            
            if (!$masv) {
                $this->setMessage('error', 'Vui lòng nhập mã sinh viên');
                $this->redirect('login');
                return;
            }
            
            // Kiểm tra sinh viên tồn tại
            $student = $this->studentModel->getById($masv);
            
            if ($student) {
                // Đăng nhập thành công
                $_SESSION['user_id'] = $student['MaSV'];
                $_SESSION['user_name'] = $student['HoTen'];
                
                $this->setMessage('success', 'Đăng nhập thành công');
                $this->redirect('student');
            } else {
                // Đăng nhập thất bại
                $this->setMessage('error', 'Mã sinh viên không tồn tại');
                $this->redirect('login');
            }
        }
    }
    
    // Đăng xuất
    public function logout() {
        // Xóa session
        session_unset();
        session_destroy();
        
        // Chuyển hướng về trang đăng nhập
        $this->redirect('login');
    }
}
?> 