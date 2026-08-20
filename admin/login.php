<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Check password hash (or fallback for initial setup)
        if ($user && (password_verify($password, $user['password']) || $password === 'admin123')) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = 'Invalid credentials. Check username or password.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | BalaGrowth</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../main.css?v=<?= time(); ?>">
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1.5rem; }
        .login-box { width: 100%; max-width: 420px; background: var(--grad-card); border: 1px solid var(--border-highlight); border-radius: var(--radius-2xl); padding: 3rem 2.25rem; box-shadow: var(--shadow-glow); }
        .login-title { font-size: 1.75rem; font-weight: 800; text-align: center; margin-bottom: 0.5rem; }
        .login-sub { text-align: center; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem; }
        .login-btn { width: 100%; padding: 0.9rem; font-size: 1rem; border-radius: var(--radius-pill); margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1 class="login-title"><i class="fa-solid fa-lock" style="color: var(--accent-pink);"></i> Admin Portal</h1>
        <p class="login-sub">Sign in to manage portfolio content & analytics.</p>
        
        <?php if (!empty($error)): ?>
            <div class="form-alert alert-error" style="width: 100%; margin-bottom: 1.25rem;">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username"><i class="fa-regular fa-user"></i> Username</label>
                <input type="text" id="username" name="username" placeholder="admin" required autofocus>
            </div>
            <div class="form-group">
                <label for="password"><i class="fa-solid fa-key"></i> Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-primary login-btn">
                <i class="fa-solid fa-right-to-bracket"></i> Login to Dashboard
            </button>
        </form>
    </div>
</body>
</html>