<?php
// controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController {
    
    // عرض صفحة تسجل الدخول وإنشاء حساب
    public function showAuthForm() {
        require_once __DIR__ . '/../views/auth.php';
    }

    // معالجة تسجيل الدخول
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'يرجى إدخال البريد الإلكتروني وكلمة المرور';
                header('Location: /alzikrayat/public/login');
                exit;
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header('Location: /alzikrayat/public/');
                exit;
            } else {
                $_SESSION['error'] = 'بيانات الدخول غير صحيحة';
                header('Location: /alzikrayat/public/login');
                exit;
            }
        }
    }

    // معالجة إنشاء حساب جديد
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'جميع الحقول مطلوبة';
                header('Location: /alzikrayat/public/login');
                exit;
            }

            $userModel = new User();
            
            // التحقق من عدم تكرار البريد
            if ($userModel->findByEmail($email)) {
                $_SESSION['error'] = 'البريد الإلكتروني مستخدم بالفعل';
                header('Location: /alzikrayat/public/login');
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $created = $userModel->create($name, $email, $hashedPassword);

            if ($created) {
                $_SESSION['success'] = 'تم إنشاء الحساب بنجاح، يمكنك تسجيل الدخول الآن';
                header('Location: /alzikrayat/public/login');
                exit;
            } else {
                $_SESSION['error'] = 'حدث خطأ أثناء إنشاء الحساب';
                header('Location: /alzikrayat/public/login');
                exit;
            }
        }
    }

    // تسجيل الخروج
    public function logout() {
        session_destroy();
        header('Location: /alzikrayat/public/login');
        exit;
    }
}