<?php
require_once __DIR__ . '/../../src/db.php';
require_once __DIR__ . '/../../src/auth.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    if (($_POST['action'] ?? '') === 'logout') { session_destroy(); header('Location: login.php'); exit; }
    if (($_POST['action'] ?? '') === 'delete') {
        db()->prepare('DELETE FROM dorms WHERE id = ?')->execute([(int)$_POST['id']]);
        header('Location: index.php'); exit;
    }
}
$dorms = db()->query('SELECT * FROM dorms ORDER BY id DESC')->fetchAll();
?><!DOCTYPE html>
<html lang="th"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>จัดการหอพัก</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><header><h1>จัดการหอพัก</h1>
<form method="post" style="all:unset"><input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>"><input type="hidden" name="action" value="logout"><button>ออกจากระบบ</button></form></header>
<main>
<p><a href="edit.php"><button type="button">+ เพิ่มหอพัก</button></a></p>
<table><tr><th>ชื่อ</th><th>ย่าน</th><th>ราคา</th><th></th></tr>
<?php foreach ($dorms as $d): ?>
<tr><td><?= h($d['name']) ?></td><td><?= h($d['area']) ?></td><td><?= number_format($d['price']) ?></td>
<td><a href="edit.php?id=<?= (int)$d['id'] ?>">แก้ไข</a>
<form method="post" style="display:inline" onsubmit="return confirm('ลบหอพักนี้?')">
<input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$d['id'] ?>"><button class="danger">ลบ</button></form></td></tr>
<?php endforeach; ?>
</table></main></body></html>
