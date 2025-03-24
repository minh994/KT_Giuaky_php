<?php
// Bắt đầu phiên làm việc
session_start();

// Nạp các file cấu hình
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'config/router.php';

// Khởi tạo router
$router = new Router();

// Định nghĩa các route cụ thể
$router->addRoute('login', 'AuthController', 'login');
$router->addRoute('logout', 'AuthController', 'logout');
$router->addRoute('register', 'AuthController', 'register');
$router->addRoute('student', 'StudentController', 'index');
$router->addRoute('course', 'CourseController', 'index');
$router->addRoute('course/list', 'CourseController', 'listForRegistration');
$router->addRoute('auth/authenticate', 'AuthController', 'authenticate');
$router->addRoute('course/register', 'CourseController', 'register');
$router->addRoute('course/enrollCourse', 'CourseController', 'enrollCourse');

// Thêm các route cho StudentController
$router->addRoute('student/create', 'StudentController', 'create');
$router->addRoute('student/store', 'StudentController', 'store');
$router->addRoute('student/edit', 'StudentController', 'edit');
$router->addRoute('student/update', 'StudentController', 'update');
$router->addRoute('student/delete', 'StudentController', 'delete');
$router->addRoute('student/detail', 'StudentController', 'detail');

// Route cho các chức năng đăng ký học phần
$router->addRoute('course/enrolled', 'CourseController', 'enrolled');
$router->addRoute('course/unenroll', 'CourseController', 'unenroll');
$router->addRoute('course/unenrollAll', 'CourseController', 'unenrollAll');

// Route cho chức năng lưu đăng ký và hiển thị kết quả
$router->addRoute('course/saveRegistration', 'CourseController', 'saveRegistration');
$router->addRoute('course/registrationResult', 'CourseController', 'registrationResult');
$router->addRoute('course/listWithQuantity', 'CourseController', 'listWithQuantity');

// Điều hướng request hiện tại
$router->dispatch();
?> 