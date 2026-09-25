<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول / إنشاء حساب - الذكريات</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 20px 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #007bff; border: none; color: white; font-size: 16px; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .alert { padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
        .alert-error { background-color: #f8d7da; color: #721c24; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .toggle-btn { text-align: center; margin-top: 15px; background: none; color: #007bff; border: none; cursor: pointer; width: auto; display: block; margin-left: auto; margin-right: auto; }
    </style>
</head>
<body>

<div class="card">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- نموذج تسجيل الدخول -->
    <div id="login-form">
        <h2>تسجيل الدخول</h2>
        <form action="/alzikrayat/public/login/process" method="POST">
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">دخول</button>
        </form>
        <button class="toggle-btn" onclick="toggleForm()">ليس لديك حساب؟ إنشاء حساب جديد</button>
    </div>

    <!-- نموذج إنشاء حساب جديد -->
    <div id="register-form" style="display: none;">
        <h2>إنشاء حساب جديد</h2>
        <form action="/alzikrayat/public/register/process" method="POST">
            <div class="form-group">
                <label>الاسم الكامل</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">تسجيل</button>
        </form>
        <button class="toggle-btn" onclick="toggleForm()">لديك حساب بالفعل؟ تسجيل الدخول</button>
    </div>
</div>

<script>
function toggleForm() {
    const login = document.getElementById('login-form');
    const register = document.getElementById('register-form');
    if (login.style.display === 'none') {
        login.style.display = 'block';
        register.style.display = 'none';
    } else {
        login.style.display = 'none';
        register.style.display = 'block';
    }
}
</script>

</body>
</html>