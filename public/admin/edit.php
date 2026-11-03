<?php
require_once __DIR__ . '/../../src/db.php';
require_once __DIR__ . '/../../src/auth.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$d = ['name'=>'','area'=>'','price'=>'','description'=>'','phone'=>'','has_wifi'=>0,'has_aircon'=>0,'has_parking'=>0];
if ($id) {
    $st = db()->prepare('SELECT * FROM dorms WHERE id = ?');
    $st->execute([$id]);
    $d = $st->fetch() ?: exit('ไม่พบข้อมูล');
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $d = [
        'name' => trim($_POST['name'] ?? ''), 'area' => trim($_POST['area'] ?? ''),
        'price' => (int)($_POST['price'] ?? 0), 'description' => trim($_POST['description'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'has_wifi' => isset($_POST['has_wifi']) ? 1 : 0,
        'has_aircon' => isset($_POST['has_aircon']) ? 1 : 0,
        'has_parking' => isset($_POST['has_parking']) ? 1 : 0,
    ];
    if ($d['name'] === '') $errors[] = 'กรุณากรอกชื่อหอพัก';
    if ($d['area'] === '') $errors[] = 'กรุณากรอกย่าน';
    if ($d['price'] <= 0) $errors[] = 'ราคาต้องมากกว่า 0';
    if (!$errors) {
        if ($id) {
            db()->prepare('UPDATE dorms SET name=:name, area=:area, price=:price, description=:description, phone=:phone, has_wifi=:has_wifi, has_aircon=:has_aircon, has_parking=:has_parking WHERE id=:id')
                ->execute($d + ['id' => $id]);
        } else {
            db()->prepare('INSERT INTO dorms (name, area, price, description, phone, has_wifi, has_aircon, has_parking) VALUES (:name,:area,:price,:description,:phone,:has_wifi,:has_aircon,:has_parking)')
                ->execute($d);
        }
        header('Location: index.php'); exit;
    }
}
?><!DOCTYPE html>
<html lang="th"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $id ? 'แก้ไข' : 'เพิ่ม' ?>หอพัก</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><header><h1><?= $id ? 'แก้ไข' : 'เพิ่ม' ?>หอพัก</h1><a href="index.php">← กลับ</a></header>
<main><form method="post" class="admin-form">
<?php foreach ($errors as $e): ?><p style="color:#d33"><?= h($e) ?></p><?php endforeach; ?>
<input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
<input name="name" placeholder="ชื่อหอพัก" value="<?= h($d['name']) ?>" required>
<input name="area" placeholder="ย่าน" value="<?= h($d['area']) ?>" required>
<input name="price" type="number" min="1" placeholder="ราคา/เดือน" value="<?= h((string)$d['price']) ?>" required>
<textarea name="description" rows="4" placeholder="รายละเอียด"><?= h($d['description']) ?></textarea>
<input name="phone" placeholder="เบอร์โทร" value="<?= h($d['phone']) ?>">
<label><input type="checkbox" name="has_wifi" <?= $d['has_wifi'] ? 'checked' : '' ?>> WiFi</label>
<label><input type="checkbox" name="has_aircon" <?= $d['has_aircon'] ? 'checked' : '' ?>> แอร์</label>
<label><input type="checkbox" name="has_parking" <?= $d['has_parking'] ? 'checked' : '' ?>> ที่จอดรถ</label>
<button>บันทึก</button>
</form></main></body></html>
