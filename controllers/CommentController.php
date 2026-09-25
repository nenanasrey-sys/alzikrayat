<?php
// controllers/CommentController.php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Comment.php';

class CommentController extends Controller {

    public function store() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /alzikrayat/public/login');
            exit();
        }

        $photoId = $_POST['photo_id'] ?? null;
        $commentText = trim($_POST['comment'] ?? '');

        if ($photoId && !empty($commentText)) {
            $commentModel = new Comment();
            $commentModel->create([
                'photo_id' => $photoId,
                'user_id'  => $_SESSION['user_id'],
                'comment'  => $commentText
            ]);
        }

        header('Location: /alzikrayat/public/photo/' . $photoId);
        exit();
    }
}