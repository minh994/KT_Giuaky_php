<?php
// Router đơn giản
class Router {
    private $routes = [];
    private $defaultController = 'StudentController';
    private $defaultAction = 'index';
    
    // Thêm route
    public function addRoute($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }
    
    // Xử lý route hiện tại
    public function dispatch() {
        // Lấy URI hiện tại
        $uri = $_SERVER['REQUEST_URI'];
        
        // Xóa query string nếu có
        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        
        // Xóa BASE_URL nếu có
        $uri = str_replace(BASE_URL, '', $uri);
        
        // Xóa dấu / ở đầu nếu có
        $uri = ltrim($uri, '/');
        
        // Nếu URI rỗng, sử dụng route mặc định
        if ($uri == '') {
            $controllerName = $this->defaultController;
            $action = $this->defaultAction;
            $params = [];
        } 
        // Nếu có route phù hợp, sử dụng controller và action được định nghĩa
        elseif (isset($this->routes[$uri])) {
            $controllerName = $this->routes[$uri]['controller'];
            $action = $this->routes[$uri]['action'];
            $params = [];
        } 
        // Nếu không có route phù hợp, phân tích URI
        else {
            $segments = explode('/', $uri);
            
            // Controller là phần tử đầu tiên hoặc mặc định
            $controllerPrefix = isset($segments[0]) && !empty($segments[0]) ? $segments[0] : 'student';
            $controllerName = ucfirst($controllerPrefix) . 'Controller';
            
            // Action là phần tử thứ hai hoặc mặc định
            $action = isset($segments[1]) && !empty($segments[1]) ? $segments[1] : $this->defaultAction;
            
            // Kiểm tra xem có route đã đăng ký cho uri này không
            $checkRoute = $controllerPrefix . '/' . $action;
            if (isset($this->routes[$checkRoute])) {
                $controllerName = $this->routes[$checkRoute]['controller'];
                $action = $this->routes[$checkRoute]['action'];
                $params = array_slice($segments, 2);
            } else {
                // Các phần tử còn lại là tham số
                $params = array_slice($segments, 2);
            }
        }
        
        // Kiểm tra xem controller có tồn tại không
        $controllerFile = CONTROLLERS_PATH . $controllerName . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            $controller = new $controllerName();
            
            // Kiểm tra xem action có tồn tại không
            if (method_exists($controller, $action)) {
                // Gọi action với tham số
                if (!empty($params)) {
                    call_user_func_array([$controller, $action], $params);
                } else {
                    $controller->$action();
                }
            } else {
                // Action không tồn tại
                header('HTTP/1.1 404 Not Found');
                echo "404 Not Found - Action '$action' không tồn tại";
            }
        } else {
            // Controller không tồn tại
            header('HTTP/1.1 404 Not Found');
            echo "404 Not Found - Controller '$controllerName' không tồn tại";
        }
    }
}
?> 