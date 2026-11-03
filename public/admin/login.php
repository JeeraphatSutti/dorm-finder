<?php
require_once __DIR__ . '/../../src/db.php';
require_once __DIR__ . '/../../src/auth.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    if (hash_equals(ADMIN_USER, $_POST['user'] ?? '') && hash_equals(ADMIN_PASS_HASH_PLAIN, $_POST['pass'] ?? '')) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        header('Location: index.php'); exit;
    }
    $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
}
?><!DOCTYPE html>
<html lang="th"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>เข้าสู่ระบบแอดมิน</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><header><h1>เข้าสู่ระบบแอดมิน</h1><a href="../index.php">← หน้าเว็บ</a></header>
<main><form method="post" class="admin-form">
<?php if ($error): ?><p style="color:#d33"><?= h($error) ?></p><?php endif; ?>
<input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
<input name="user" placeholder="ชื่อผู้ใช้" required>
<input name="pass" type="password" placeholder="รหัสผ่าน" required>
<button>เข้าสู่ระบบ</button>
</form></main></body></html>
