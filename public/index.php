<?php
// public/index.php

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Router.php';

$router = new Router();

// 1. المسارات العامة
$router->add('GET', '/', ['HomeController', 'index']);

// 2. مسارات الحسابات
$router->add('GET', '/login', ['AuthController', 'showAuthForm']);
$router->add('POST', '/login/process', ['AuthController', 'login']);
$router->add('POST', '/register/process', ['AuthController', 'register']);
$router->add('GET', '/logout', ['AuthController', 'logout']);

// 3. مسارات الصور
$router->add('GET', '/photos', ['PhotoController', 'index']);
$router->add('GET', '/photos/create', ['PhotoController', 'create']);
$router->add('POST', '/photo/store', ['PhotoController', 'store']);
$router->add('GET', '/photo/{id}', ['PhotoController', 'show']);
$router->add('GET', '/photo/{id}/delete', ['PhotoController', 'delete']);

// 4. مسارات التعليقات
$router->add('POST', '/comment/store', ['CommentController', 'store']);

// معالجة واستخراج المسار الصافي (URI Cleanup)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']);

// استبعاد مسار المجلد الفرعي إن وجد
if (strpos($requestUri, $scriptName) === 0) {
    $requestUri = substr($requestUri, strlen($scriptName));
}

// ضمان أن المسار يبدأ بـ /
if (empty($requestUri)) {
    $requestUri = '/';
}

$requestMethod = $_SERVER['REQUEST_METHOD'];

// التوجيه
$router->dispatch($requestUri, $requestMethod);