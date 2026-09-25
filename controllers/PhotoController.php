<?php
// controllers/PhotoController.php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Photo.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../config/database.php';
class PhotoController extends Controller {

    // عرض معرض الصور
    public function index() {
        $photoModel = new Photo();
        $photos = $photoModel->getAll();

        $this->view('photos/index', [
            'title' => 'Alzikrayat - Gallery',
            'photos' => $photos
        ]);
    }

    // عرض صفحة رفع صورة جديدة
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/login');
            exit();
        }

        $this->view('photos/create', [
            'title' => 'Alzikrayat - Upload Photo'
        ]);
    }

    // معالجة رفع الصورة إلى السيرفر
    public function store() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /alzikrayat/public/login');
            exit();
        }

        $title       = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($title) || empty($_FILES['image']['name'])) {
            $_SESSION['error'] = 'Title and image file are required.';
            header('Location: /alzikrayat/public/photos/create');
            exit();
        }

        // رفع الملف لحافظة public/images/uploads/
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = __DIR__ . '/../public/images/uploads/' . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $photoModel = new Photo();
            $photoModel->create([
                'user_id'     => $_SESSION['user_id'],
                'file_name'   => $fileName,
                'title'       => $title,
                'description' => $description
            ]);

            $_SESSION['success'] = 'Photo uploaded successfully!';
            header('Location: /alzikrayat/public/photos');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to upload image file.';
            header('Location: /alzikrayat/public/photos/create');
            exit();
        }
    }

    // عرض تفاصيل صورة واحدة مع تعليقاتها
    public function show($id) {
        $photoModel = new Photo();
        $photo = $photoModel->getById($id);

        if (!$photo) {
            header('Location: /alzikrayat/public/photos');
            exit();
        }

        $commentModel = new Comment();
        $comments = $commentModel->getByPhotoId($id);

        $this->view('photos/show', [
            'title' => 'Photo - ' . htmlspecialchars($photo['title']),
            'photo' => $photo,
            'comments' => $comments
        ]);
    }

    // تعديل صورة
    public function edit($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/login');
            exit();
        }

        $photoModel = new Photo();
        $photo = $photoModel->getById($id);

        if (!$photo || $photo['user_id'] != $_SESSION['user_id']) {
            header('Location: /alzikrayat/public/photos');
            exit();
        }

        $this->view('photos/edit', [
            'title' => 'Edit Photo',
            'photo' => $photo
        ]);
    }

    // حذف صورة
    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/login');
            exit();
        }

        $photoModel = new Photo();
        $photo = $photoModel->getById($id);

        if ($photo && $photo['user_id'] == $_SESSION['user_id']) {
            // حذف الصورة من القرص الصلب
            $filePath = __DIR__ . '/../public/images/uploads/' . $photo['file_name'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // حذف سجل قاعدة البيانات
            $photoModel->delete($id, $_SESSION['user_id']);
            $_SESSION['success'] = 'Photo deleted successfully.';
        }

        header('Location: /alzikrayat/public/photos');
        exit();
    }
}