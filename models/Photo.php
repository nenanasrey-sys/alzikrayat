<?php
// models/Photo.php

require_once __DIR__ . '/../config/database.php';

class Photo {
    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    // جلب جميع الصور مع اسم الناشر الأول والأخير
    public function getAll() {
        $sql = "SELECT photos.*, users.first_name, users.last_name 
                FROM photos 
                JOIN users ON photos.user_id = users.id 
                ORDER BY photos.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // جلب صورة واحدة مع بيانات الناشر
    public function getById($id) {
        $sql = "SELECT photos.*, users.first_name, users.last_name 
                FROM photos 
                JOIN users ON photos.user_id = users.id 
                WHERE photos.id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // حفظ صورة جديدة
    public function create($data) {
        $sql = "INSERT INTO photos (user_id, file_name, title, description) 
                VALUES (:user_id, :file_name, :title, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id'     => $data['user_id'],
            ':file_name'   => $data['file_name'] ?? $data['image'],
            ':title'       => $data['title'],
            ':description' => $data['description']
        ]);
    }

    // حذف صورة
    public function delete($id, $userId) {
        $photo = $this->getById($id);
        if ($photo && $photo['user_id'] == $userId) {
            $stmt = $this->db->prepare("DELETE FROM photos WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        }
        return false;
    }
}