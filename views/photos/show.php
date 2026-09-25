<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($photo['title'] ?? 'Photo Details'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light py-4">

    <div class="container">
        <a href="/alzikrayat/public/photos" class="btn btn-outline-secondary mb-4">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Gallery
        </a>

        <div class="row g-4">
            <!-- عرض الصورة -->
            <div class="col-md-7">
                <?php $fileName = $photo['file_name'] ?? $photo['image'] ?? ''; ?>
                <img src="/alzikrayat/public/images/uploads/<?php echo htmlspecialchars($fileName); ?>" 
                     class="img-fluid rounded-4 shadow-sm w-100" 
                     alt="<?php echo htmlspecialchars($photo['title'] ?? ''); ?>">
            </div>

            <!-- تفاصيل الصورة والتعليقات -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h2 class="fw-bold mb-2"><?php echo htmlspecialchars($photo['title'] ?? ''); ?></h2>
                    
                    <?php 
                        // معالجة اسم صاحب الصورة
                        $uploaderName = trim(($photo['first_name'] ?? '') . ' ' . ($photo['last_name'] ?? ''));
                        if (empty($uploaderName)) {
                            $uploaderName = $photo['username'] ?? $photo['name'] ?? 'Anonymous';
                        }

                        // معالجة تاريخ النشر بدعم date_time أو created_at
                        $rawDate = $photo['date_time'] ?? $photo['created_at'] ?? null;
                        $formattedDate = $rawDate ? date('M d, Y', strtotime($rawDate)) : '';
                    ?>

                    <p class="text-muted small mb-3">
                        Uploaded by <strong><?php echo htmlspecialchars($uploaderName); ?></strong>
                        <?php if ($formattedDate): ?>
                            on <?php echo $formattedDate; ?>
                        <?php endif; ?>
                    </p>

                    <?php if (!empty($photo['description'])): ?>
                        <p class="mb-4"><?php echo nl2br(htmlspecialchars($photo['description'])); ?></p>
                        <hr>
                    <?php endif; ?>

                    <!-- قسم التعليقات -->
                    <h5 class="fw-bold mb-3">Comments</h5>

                    <div class="comments-list mb-4" style="max-height: 300px; overflow-y: auto;">
                        <?php if (empty($comments)): ?>
                            <p class="text-muted small">No comments yet. Be the first to comment!</p>
                        <?php else: ?>
                            <?php foreach ($comments as $comment): ?>
                                <?php 
                                    $commenterName = trim(($comment['first_name'] ?? '') . ' ' . ($comment['last_name'] ?? ''));
                                    if (empty($commenterName)) {
                                        $commenterName = $comment['username'] ?? $comment['name'] ?? 'User';
                                    }
                                    $commentText = $comment['comment'] ?? $comment['content'] ?? '';
                                ?>
                                <div class="bg-light p-3 rounded-3 mb-2">
                                    <strong class="d-block text-dark small"><?php echo htmlspecialchars($commenterName); ?></strong>
                                    <span class="text-secondary"><?php echo htmlspecialchars($commentText); ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- نموذج كتابة تعليق -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form action="/alzikrayat/public/comment/store" method="POST">
                            <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>">
                            <div class="input-group">
                                <input type="text" name="comment" class="form-class form-control" placeholder="Write a comment..." required>
                                <button type="submit" class="btn btn-primary">Post</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <p class="text-muted small">Please <a href="/alzikrayat/public/login">login</a> to leave a comment.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

</body>
</html>