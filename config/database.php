<?php
// config/database.php

$host = 'localhost';
$dbname = 'alzikrayat'; // تأكدي من أن اسم قاعدة البيانات في phpMyAdmin مطبق هنا
$username = 'root';
$password = ''; // افتراضياً تكون فارغة في XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}