<?php
require_once CONTROLLERS_PATH . 'Controller.php';
require_once MODELS_PATH . 'SinhVienModel.php';
require_once MODELS_PATH . 'NganhHocModel.php';

class StudentController extends Controller {
    private $studentModel;
    private $majorModel;
    
    public function __construct() {
        $this->studentModel = new SinhVienModel();
        $this->majorModel = new NganhHocModel();
    }
    
    // Hiển thị danh sách sinh viên
    public function index() {
        $students = $this->studentModel->getAllWithMajor();
        $data = [
            'page_title' => 'Danh sách sinh viên',
            'students' => $students
        ];
        $this->render('student/index', $data);
    }
    
    // Hiển thị form thêm sinh viên mới
    public function create() {
        $majors = $this->majorModel->getAllForSelect();
        $data = [
            'page_title' => 'Thêm sinh viên mới',
            'majors' => $majors
        ];
        $this->render('student/create', $data);
    }
    
    // Xử lý thêm sinh viên mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $masv = isset($_POST['masv']) ? trim($_POST['masv']) : '';
            $hoten = isset($_POST['hoten']) ? trim($_POST['hoten']) : '';
            $gioitinh = isset($_POST['gioitinh']) ? $_POST['gioitinh'] : 'Nam';
            $ngaysinh = isset($_POST['ngaysinh']) ? $_POST['ngaysinh'] : '';
            $manganh = isset($_POST['manganh']) ? $_POST['manganh'] : '';
            
            // Kiểm tra các trường bắt buộc
            $errors = [];
            
            if (empty($masv)) {
                $errors[] = 'Mã sinh viên không được để trống';
            } elseif (strlen($masv) > 10) {
                $errors[] = 'Mã sinh viên không được vượt quá 10 ký tự';
            } elseif ($this->studentModel->checkExistById($masv)) {
                $errors[] = 'Mã sinh viên đã tồn tại';
            }
            
            if (empty($hoten)) {
                $errors[] = 'Họ tên không được để trống';
            }
            
            if (empty($ngaysinh)) {
                $errors[] = 'Ngày sinh không được để trống';
            }
            
            if (empty($manganh)) {
                $errors[] = 'Vui lòng chọn ngành học';
            } elseif (!$this->majorModel->checkExistById($manganh)) {
                $errors[] = 'Ngành học không tồn tại';
            }
            
            // Nếu có lỗi
            if (!empty($errors)) {
                $this->setMessage('error', implode('<br>', $errors));
                $this->redirect('student/create');
                return;
            }
            
            // Xử lý hình ảnh
            $hinh = $this->studentModel->uploadImage($_FILES['hinh']);
            
            // Tạo dữ liệu mới
            $data = [
                'MaSV' => $masv,
                'HoTen' => $hoten,
                'GioiTinh' => $gioitinh,
                'NgaySinh' => $ngaysinh,
                'Hinh' => $hinh,
                'MaNganh' => $manganh
            ];
            
            // Thêm sinh viên vào cơ sở dữ liệu
            if ($this->studentModel->create($data)) {
                $this->setMessage('success', 'Thêm sinh viên thành công');
                $this->redirect('student');
            } else {
                $this->setMessage('error', 'Thêm sinh viên thất bại');
                $this->redirect('student/create');
            }
        } else {
            $this->redirect('student/create');
        }
    }
    
    // Hiển thị form sửa sinh viên
    public function edit($id = null) {
        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        
        if (!$id) {
            $this->setMessage('error', 'Không tìm thấy sinh viên');
            $this->redirect('student');
        }
        
        $student = $this->studentModel->getById($id);
        if (!$student) {
            $this->setMessage('error', 'Không tìm thấy sinh viên');
            $this->redirect('student');
        }
        
        $majors = $this->majorModel->getAllForSelect();
        $data = [
            'page_title' => 'Sửa thông tin sinh viên',
            'student' => $student,
            'majors' => $majors
        ];
        
        $this->render('student/edit', $data);
    }
    
    // Xử lý cập nhật sinh viên
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $masv = isset($_POST['masv']) ? $_POST['masv'] : '';
            $hoten = isset($_POST['hoten']) ? $_POST['hoten'] : '';
            $gioitinh = isset($_POST['gioitinh']) ? $_POST['gioitinh'] : '';
            $ngaysinh = isset($_POST['ngaysinh']) ? $_POST['ngaysinh'] : '';
            $manganh = isset($_POST['manganh']) ? $_POST['manganh'] : '';
            
            // Cập nhật hình ảnh nếu có
            $hinh = isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0 ? 
                    $this->studentModel->uploadImage($_FILES['hinh']) : 
                    $_POST['current_hinh'];
            
            $data = [
                'HoTen' => $hoten,
                'GioiTinh' => $gioitinh,
                'NgaySinh' => $ngaysinh,
                'Hinh' => $hinh,
                'MaNganh' => $manganh
            ];
            
            if ($this->studentModel->update($masv, $data)) {
                $this->setMessage('success', 'Cập nhật sinh viên thành công');
                $this->redirect('student');
            } else {
                $this->setMessage('error', 'Cập nhật sinh viên thất bại');
                $this->redirect('student/edit/' . $masv);
            }
        }
    }
    
    // Hiển thị chi tiết sinh viên
    public function detail($id = null) {
        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        
        if (!$id) {
            $this->setMessage('error', 'Không tìm thấy sinh viên');
            $this->redirect('student');
        }
        
        $student = $this->studentModel->getDetailById($id);
        if (!$student) {
            $this->setMessage('error', 'Không tìm thấy sinh viên');
            $this->redirect('student');
        }
        
        $data = [
            'page_title' => 'Thông tin chi tiết sinh viên',
            'student' => $student
        ];
        
        $this->render('student/detail', $data);
    }
    
    // Xử lý xóa sinh viên
    public function delete($id = null) {
        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        
        if (!$id) {
            $this->setMessage('error', 'Không tìm thấy sinh viên');
            $this->redirect('student');
        }
        
        // Lấy thông tin sinh viên trước khi xóa
        $student = $this->studentModel->getById($id);
        if (!$student) {
            $this->setMessage('error', 'Không tìm thấy sinh viên');
            $this->redirect('student');
        }
        
        if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
            if ($this->studentModel->delete($id)) {
                $this->setMessage('success', 'Xóa sinh viên thành công');
            } else {
                $this->setMessage('error', 'Xóa sinh viên thất bại');
            }
            $this->redirect('student');
        } else {
            $data = [
                'page_title' => 'Xác nhận xóa sinh viên',
                'student' => $student
            ];
            
            $this->render('student/delete', $data);
        }
    }
}
?> 