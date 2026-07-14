<?php

namespace App\Helpers;

/**
 * Simple Router
 * Xử lý routing URL → Controller@method với middleware support
 */
class Router
{
    private array $routes = [];

    /**
     * Đăng ký route GET
     */
    public function get(string $path, string $controller, string $method, array $middleware = []): void
    {
        $this->addRoute('GET', $path, $controller, $method, $middleware);
    }

    /**
     * Đăng ký route POST
     */
    public function post(string $path, string $controller, string $method, array $middleware = []): void
    {
        $this->addRoute('POST', $path, $controller, $method, $middleware);
    }

    /**
     * Thêm route vào danh sách
     */
    private function addRoute(string $httpMethod, string $path, string $controller, string $method, array $middleware): void
    {
        $path = trim($path, '/');
        $this->routes[] = [
            'httpMethod' => $httpMethod,
            'path' => $path,
            'controller' => $controller,
            'method' => $method,
            'middleware' => $middleware,
        ];
    }

    /**
     * Dispatch request tới controller phù hợp
     */
    public function dispatch(string $url, string $httpMethod): void
    {
        $url = trim($url, '/');

        foreach ($this->routes as $route) {
            // Chuyển path pattern thành regex
            $pattern = $this->convertToRegex($route['path']);

            if ($route['httpMethod'] === $httpMethod && preg_match($pattern, $url, $matches)) {
                // Chạy middleware trước
                foreach ($route['middleware'] as $middlewareClass) {
                    $middlewareInstance = new $middlewareClass();
                    if (!$middlewareInstance->handle()) {
                        return;
                    }
                }

                // Lấy params từ URL
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Tạo controller và gọi method
                $controllerClass = $route['controller'];
                $controller = new $controllerClass();
                $methodName = $route['method'];

                if (!empty($params)) {
                    call_user_func_array([$controller, $methodName], $params);
                } else {
                    $controller->$methodName();
                }
                return;
            }
        }

        // 404 Not Found
        http_response_code(404);
        View::render('errors/404', ['title' => '404 - Không tìm thấy']);
    }

    /**
     * Chuyển path pattern thành regex
     * Ví dụ: 'topup/{gameId}' → '#^topup/(?P<gameId>[^/]+)$#'
     */
    private function convertToRegex(string $path): string
    {
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
}
