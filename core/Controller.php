<?php
// core/Controller.php

class Controller {
    // دالة لتمرير البيانات وعرض الـ View المناسب
    protected function view($viewPath, $data = []) {
        extract($data);
        
        $file = __DIR__ . '/../views/' . $viewPath . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            die("View file not found: " . $viewPath);
        }
    }
}