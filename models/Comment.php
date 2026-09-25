<?php
// models/Comment.php

require_once __DIR__ . '/../config/database.php';

class Comment {
    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    // جلب التعليقات مع مراعاة اسم العمود (comment أو content)
    public function getByPhotoId($photoId) {
        $sql = "SELECT comments.*, users.first_name, users.last_name 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE comments.photo_id = :photo_id 
                ORDER BY comments.id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':photo_id' => $photoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // إضافة تعليق جديد
    public function create($data) {
        // استخلاص نص التعليق سواء كان القادم comment أو content
        $text = $data['comment'] ?? $data['content'] ?? '';

        $sql = "INSERT INTO comments (photo_id, user_id, comment) 
                VALUES (:photo_id, :user_id, :comment)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':photo_id' => $data['photo_id'],
            ':user_id'  => $data['user_id'],
            ':comment'  => $text
        ]);
    }

    // حذف تعليق
    public function delete($id, $userId) {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            ':id'      => $id,
            ':user_id' => $userId
        ]);
    }
}