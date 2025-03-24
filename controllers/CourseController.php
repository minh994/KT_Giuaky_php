<?php
require_once CONTROLLERS_PATH . 'Controller.php';
require_once MODELS_PATH . 'HocPhanModel.php';
require_once MODELS_PATH . 'SinhVienModel.php';

class CourseController extends Controller {
    private $courseModel;
    private $studentModel;
    
    public function __construct() {
        $this->courseModel = new HocPhanModel();
        $this->studentModel = new SinhVienModel();
    }
    
    // Hiển thị danh sách học phần
    public function index() {
        $courses = $this->courseModel->getAll();
        $data = [
            'page_title' => 'Danh sách học phần',
            'courses' => $courses
        ];
        $this->render('course/index', $data);
    }
    
    // Hiển thị form đăng ký học phần
    public function register($studentId = null) {
        if (!$studentId && isset($_GET['id'])) {
            $studentId = $_GET['id'];
        }
        
        if (!$studentId) {
            $this->setMessage('error', 'Không tìm thấy sinh viên');
            $this->redirect('student');
        }
        
        // Kiểm tra sinh viên tồn tại
        $student = $this->studentModel->getById($studentId);
        if (!$student) {
            $this->setMessage('error', 'Không tìm thấy sinh viên');
            $this->redirect('student');
        }
        
        // Lấy danh sách học phần chưa đăng ký
        $unregisteredCourses = $this->courseModel->getUnregisteredCourses($studentId);
        
        // Lấy danh sách học phần đã đăng ký
        $registeredCourses = $this->courseModel->getRegisteredCourses($studentId);
        
        $data = [
            'page_title' => 'Đăng ký học phần',
            'student' => $student,
            'unregisteredCourses' => $unregisteredCourses,
            'registeredCourses' => $registeredCourses
        ];
        
        $this->render('course/register', $data);
    }
    
    // Xử lý đăng ký học phần
    public function enrollCourse() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $masv = isset($_POST['masv']) ? $_POST['masv'] : '';
            $mahp = isset($_POST['mahp']) ? $_POST['mahp'] : '';
            
            if (!$masv || !$mahp) {
                $this->setMessage('error', 'Thông tin đăng ký không đầy đủ');
                $this->redirect('course/register/' . $masv);
                return;
            }
            
            // Sử dụng model để đăng ký học phần thay vì truy vấn trực tiếp
            if ($this->courseModel->enrollStudentCourse($masv, $mahp)) {
                $this->setMessage('success', 'Đăng ký học phần thành công');
            } else {
                $this->setMessage('error', 'Đăng ký học phần thất bại');
            }
            
            $this->redirect('course/register/' . $masv);
        }
    }
    
    // Hiển thị danh sách học phần để sinh viên đăng ký
    public function list() {
        $courses = $this->courseModel->getAll();
        $data = [
            'page_title' => 'Danh sách học phần để đăng ký',
            'courses' => $courses
        ];
        $this->render('course/list', $data);
    }
    
    // Hiển thị danh sách học phần để sinh viên đăng ký (Route riêng)
    public function listForRegistration() {
        // Gọi phương thức list()
        $this->list();
    }
    
    // Hiển thị danh sách học phần đã đăng ký
    public function enrolled() {
        // Kiểm tra người dùng đã đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $this->setMessage('error', 'Bạn cần đăng nhập để xem học phần đã đăng ký');
            $this->redirect('login');
            return;
        }
        
        $studentId = $_SESSION['user_id'];
        
        // Lấy danh sách học phần đã đăng ký
        $registeredCourses = $this->courseModel->getRegisteredCourses($studentId);
        
        // Tính tổng số tín chỉ
        $totalCredits = 0;
        $result = $registeredCourses;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalCredits += $row['SoTinChi'];
            }
            // Reset con trỏ kết quả
            $result->data_seek(0);
        }
        
        $data = [
            'page_title' => 'Học phần đã đăng ký',
            'courses' => $registeredCourses,
            'totalCredits' => $totalCredits
        ];
        
        $this->render('course/enrolled', $data);
    }
    
    // Xóa đăng ký một học phần
    public function unenroll($courseId = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->setMessage('error', 'Bạn cần đăng nhập để hủy đăng ký học phần');
            $this->redirect('login');
            return;
        }
        
        if (!$courseId) {
            $this->setMessage('error', 'Không tìm thấy học phần');
            $this->redirect('course/enrolled');
            return;
        }
        
        $studentId = $_SESSION['user_id'];
        
        // Xóa đăng ký học phần
        if ($this->courseModel->unenrollCourse($studentId, $courseId)) {
            $this->setMessage('success', 'Hủy đăng ký học phần thành công');
        } else {
            $this->setMessage('error', 'Hủy đăng ký học phần thất bại');
        }
        
        $this->redirect('course/enrolled');
    }
    
    // Xóa tất cả đăng ký học phần
    public function unenrollAll() {
        if (!isset($_SESSION['user_id'])) {
            $this->setMessage('error', 'Bạn cần đăng nhập để hủy đăng ký học phần');
            $this->redirect('login');
            return;
        }
        
        $studentId = $_SESSION['user_id'];
        
        // Xóa tất cả đăng ký học phần
        if ($this->courseModel->unenrollAllCourses($studentId)) {
            $this->setMessage('success', 'Hủy tất cả đăng ký học phần thành công');
        } else {
            $this->setMessage('error', 'Hủy đăng ký học phần thất bại');
        }
        
        $this->redirect('course/enrolled');
    }
    
    // Lưu đăng ký học phần
    public function saveRegistration() {
        if (!isset($_SESSION['user_id'])) {
            $this->setMessage('error', 'Bạn cần đăng nhập để lưu đăng ký học phần');
            $this->redirect('login');
            return;
        }
        
        $studentId = $_SESSION['user_id'];
        
        // Lưu thông tin đăng ký
        $registrationId = $this->courseModel->saveRegistration($studentId);
        
        if ($registrationId) {
            $this->setMessage('success', 'Lưu đăng ký học phần thành công');
            $this->redirect('course/registrationResult/' . $registrationId);
        } else {
            $this->setMessage('error', 'Lưu đăng ký học phần thất bại');
            $this->redirect('course/enrolled');
        }
    }
    
    // Hiển thị kết quả đăng ký
    public function registrationResult($registrationId = null) {
        if (!$registrationId) {
            $this->setMessage('error', 'Không tìm thấy thông tin đăng ký');
            $this->redirect('course/enrolled');
            return;
        }
        
        // Lấy thông tin chi tiết đăng ký
        $registrationData = $this->courseModel->getRegistrationDetails($registrationId);
        
        if (!$registrationData) {
            $this->setMessage('error', 'Không tìm thấy thông tin đăng ký');
            $this->redirect('course/enrolled');
            return;
        }
        
        $data = [
            'page_title' => 'Kết quả đăng ký học phần',
            'registration' => $registrationData['registration'],
            'details' => $registrationData['details']
        ];
        
        $this->render('course/registration_result', $data);
    }
    
    // Hiển thị danh sách học phần với số lượng dự kiến
    public function listWithQuantity() {
        $courses = $this->courseModel->getAllWithQuantity();
        $data = [
            'page_title' => 'Danh sách học phần với số lượng dự kiến',
            'courses' => $courses
        ];
        $this->render('course/list_quantity', $data);
    }
}
?> 