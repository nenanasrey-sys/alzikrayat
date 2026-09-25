<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .hero-section {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
            border-radius: 0 0 40px 40px; color: white; padding: 90px 0 110px 0;
            box-shadow: 0 20px 40px rgba(168, 85, 247, 0.2);
        }
        .btn-gradient {
            background: linear-gradient(45deg, #f43f5e, #fb923c); color: white;
            border: none; font-weight: 600; padding: 12px 30px; border-radius: 50px;
            transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(244, 63, 94, 0.3);
        }
        .btn-gradient:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(244, 63, 94, 0.4); color: white; }
        .stat-card { background: white; border-radius: 20px; padding: 25px; border: none; transition: transform 0.3s ease; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .stat-card:hover { transform: translateY(-8px); }
        .icon-box { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 15px; }
        .gallery-card { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: all 0.3s ease; }
        .gallery-card:hover { transform: scale(1.03); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="/alzikrayat/public/" style="background: linear-gradient(45deg, #ec4899, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="fa-solid fa-camera-retro me-2 text-warning"></i>Alzikrayat
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-white fw-bold">Hi <?php echo htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['name'] ?? ($_SESSION['user']['first_name'] ?? $_SESSION['first_name'] ?? 'User')); ?></span>
                    <a href="/alzikrayat/public/logout" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
                <?php else: ?>
                    <span class="text-white-50"><i class="fa-regular fa-user me-1"></i> Please Login</span>
                    <a href="/alzikrayat/public/login" class="btn btn-outline-light btn-sm rounded-pill px-3">Login / Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center position-relative">
        <div class="container">
            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm">✨ Photo Sharing Platform</span>
            <h1 class="display-3 fw-bold mb-3">Capture, Share & Cherish Your Memories</h1>
            <p class="lead max-w-2xl mx-auto opacity-90 mb-4 fs-5">A custom web application designed to preserve your special moments in high resolution.</p>
            <a href="/alzikrayat/public/photos" class="btn btn-gradient fs-5"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>Explore Platform</a>
        </div>
    </section>

    <div class="container" style="margin-top: -50px;">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary me-3"><i class="fa-solid fa-images"></i></div>
                    <div><h3 class="fw-bold mb-0 text-dark">1,240+</h3><p class="text-muted mb-0 small">Memories Uploaded</p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card d-flex align-items-center">
                    <div class="icon-box bg-danger bg-opacity-10 text-danger me-3"><i class="fa-solid fa-users"></i></div>
                    <div><h3 class="fw-bold mb-0 text-dark">450+</h3><p class="text-muted mb-0 small">Active Photographers</p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card d-flex align-items-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success me-3"><i class="fa-solid fa-comments"></i></div>
                    <div><h3 class="fw-bold mb-0 text-dark">3,890+</h3><p class="text-muted mb-0 small">Community Comments</p></div>
                </div>
            </div>
        </div>
    </div>

    <section class="container my-5 py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h6 class="text-primary fw-bold text-uppercase tracking-wider">Discover</h6>
                <h2 class="fw-bold text-dark">Featured Photo Albums</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card gallery-card h-100">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" class="card-img-top" style="height: 240px; object-fit: cover;">
                    <div class="card-body"><span class="badge bg-info text-dark mb-2">Nature</span><h5 class="card-title fw-bold">Sunset Vibes</h5><p class="card-text text-muted small">Beautiful coastal views captured during summer.</p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card gallery-card h-100">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=600&q=80" class="card-img-top" style="height: 240px; object-fit: cover;">
                    <div class="card-body"><span class="badge bg-warning text-dark mb-2">Celebration</span><h5 class="card-title fw-bold">Graduation Moments</h5><p class="card-text text-muted small">Unforgettable achievements and milestone memories.</p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card gallery-card h-100">
                    <img src="https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=600&q=80" class="card-img-top" style="height: 240px; object-fit: cover;">
                    <div class="card-body"><span class="badge text-white mb-2" style="background-color: #8b5cf6;">Events</span><h5 class="card-title fw-bold">Tech Gathering</h5><p class="card-text text-muted small">Exploring modern web development & creative design.</p></div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-4 text-center">
        <div class="container"><p class="mb-0 text-white-50">&copy; 2026 Alzikrayat Photo Sharing. All rights reserved.</p></div>
    </footer>

</body>
</html>