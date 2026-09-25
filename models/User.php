<?php
// models/User.php

class User {
    private $db;

    public function __construct() {
        global $pdo;
        if (!$pdo) {
            require_once __DIR__ . '/../config/database.php';
            global $pdo;
        }
        $this->db = $pdo;
    }

    // البحث عن مستخدم بواسطة البريد الإلكتروني
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // إنشاء مستخدم جديد
    public function create($name, $email, $password) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
    }
}