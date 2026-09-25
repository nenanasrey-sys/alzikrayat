<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? 'Alzikrayat'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #1e293b;
        }

        body { 
            background-color: var(--bg-color); 
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-main);
        }

        /* Navbar راقي ونظيف */
        .custom-navbar {
            background: #ffffff !important;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }
        
        .navbar-brand {
            color: var(--primary-color) !important;
            letter-spacing: -0.5px;
        }

        /* أزرار متناسقة */
        .btn-custom-primary {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-custom-primary:hover {
            background-color: var(--primary-hover);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-custom-outline {
            border: 1px solid #cbd5e1;
            color: #64748b;
            transition: all 0.2s ease;
        }
        .btn-custom-outline:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        /* بطاقات الصور */
        .photo-card { 
            border-radius: 16px; 
            border: 1px solid #f1f5f9; 
            background: var(--card-bg);
            overflow: hidden; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
        }
        .photo-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08); 
        }

        /* حالة الصفحة الفارغة Empty State */
        .empty-state {
            background: #ffffff;
            border: 2px dashed #e2e8f0;
            border-radius: 20px;
            padding: 3rem 1.5rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="/alzikrayat/public/">Alzikrayat</a>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="/alzikrayat/public/photos/create" class="btn btn-custom-primary rounded-pill px-4 py-2 fw-semibold btn-sm">
                    <i class="fa-solid fa-plus me-1"></i> Upload Photo
                </a>
                <a href="/alzikrayat/public/logout" class="btn btn-custom-outline btn-sm rounded-pill px-3 py-2">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold fs-3 text-dark mb-0">Community Gallery</h2>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (empty($photos)): ?>
                <div class="col-12 text-center my-4">
                    <div class="empty-state max-w-md mx-auto">
                        <div class="mb-3">
                            <i class="fa-regular fa-images text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">No photos uploaded yet</h5>
                        <p class="text-muted small mb-4">Be the first to share a memory with the community!</p>
                        <a href="/alzikrayat/public/photos/create" class="btn btn-custom-primary rounded-pill px-4 btn-sm">
                            <i class="fa-solid fa-plus me-1"></i> Add First Photo
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <?php 
                        $fileName = $photo['file_name'] ?? $photo['image'] ?? 'default.jpg';
                        $authorName = trim(($photo['first_name'] ?? '') . ' ' . ($photo['last_name'] ?? ''));
                        if (empty($authorName)) {
                            $authorName = $photo['username'] ?? $photo['name'] ?? 'Anonymous';
                        }
                    ?>
                    <div class="col-md-4">
                        <div class="card photo-card h-100">
                            <img src="/alzikrayat/public/images/uploads/<?php echo htmlspecialchars($fileName); ?>" 
                                 class="card-img-top" 
                                 style="height: 240px; object-fit: cover;" 
                                 alt="<?php echo htmlspecialchars($photo['title'] ?? 'Photo'); ?>">
                            
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold text-dark mb-1"><?php echo htmlspecialchars($photo['title'] ?? 'Untitled'); ?></h5>
                                <p class="card-text text-muted small mb-4">By <span class="fw-medium text-dark"><?php echo htmlspecialchars($authorName); ?></span></p>
                                
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <a href="/alzikrayat/public/photo/<?php echo $photo['id']; ?>" class="btn btn-custom-outline btn-sm rounded-pill px-3">
                                        View & Comment
                                    </a>
                                    
                                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $photo['user_id']): ?>
                                        <a href="/alzikrayat/public/photo/<?php echo $photo['id']; ?>/delete" 
                                           class="btn btn-link text-danger btn-sm p-0 text-decoration-none" 
                                           onclick="return confirm('Are you sure you want to delete this photo?')">
                                            <i class="fa-regular fa-trash-can me-1"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>