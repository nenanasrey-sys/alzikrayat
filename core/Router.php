<?php
// core/Router.php

class Router {
    private $routes = [];

    public function add($method, $path, $handler) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch($requestUri, $requestMethod) {
        $uri = parse_url($requestUri, PHP_URL_PATH);
        
        // إزالة مسار المجلد الأساسي لتحديد المسار المطلوب بالضبط
        $basePath = '/alzikrayat/public';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        if ($uri == '' || $uri == '/') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($requestMethod)) {
                continue;
            }

            // تحويل المسارات مثل /photo/{id} إلى Regular Expression Pattern
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // إزالة التطابق الكلي

                $controllerName = $route['handler'][0];
                $actionName = $route['handler'][1];

                $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $controller = new $controllerName();
                    return call_user_func_array([$controller, $actionName], $matches);
                }
            }
        }

        // في حال عدم وجود المسار
        http_response_code(404);
        echo "<h1 style='text-align:center; margin-top:50px;'>404 - Page Not Found</h1>";
    }
}