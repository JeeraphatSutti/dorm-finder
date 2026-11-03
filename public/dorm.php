<?php
require_once __DIR__ . '/../src/db.php';
$st = db()->prepare('SELECT * FROM dorms WHERE id = ?');
$st->execute([(int)($_GET['id'] ?? 0)]);
$d = $st->fetch();
if (!$d) { http_response_code(404); echo 'ไม่พบหอพัก'; exit; }
?><!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h($d['name']) ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header><h1><?= h($d['name']) ?></h1><a href="index.php">← กลับ</a></header>
<main class="detail">
  <p class="area">📍 <?= h($d['area']) ?></p>
  <p class="price"><?= number_format($d['price']) ?> บาท/เดือน</p>
  <p><?= nl2br(h($d['description'])) ?></p>
  <ul>
    <li>WiFi: <?= $d['has_wifi'] ? '✅' : '❌' ?></li>
    <li>แอร์: <?= $d['has_aircon'] ? '✅' : '❌' ?></li>
    <li>ที่จอดรถ: <?= $d['has_parking'] ? '✅' : '❌' ?></li>
  </ul>
  <p>📞 <a href="tel:<?= h($d['phone']) ?>"><?= h($d['phone']) ?></a></p>
</main>
</body>
</html>
