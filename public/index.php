<?php
require_once __DIR__ . '/../src/search.php';
$dorms = search_dorms($_GET);
?><!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ค้นหาหอพัก</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header><h1>🏠 ค้นหาหอพัก</h1><a href="admin/">แอดมิน</a></header>
<main>
  <form id="search-form" method="get">
    <input type="text" name="q" placeholder="ชื่อหอพัก หรือย่าน เช่น รามอินทรา" value="<?= h($_GET['q'] ?? '') ?>">
    <select name="max_price">
      <option value="">ราคาไม่จำกัด</option>
      <?php foreach ([3000, 4000, 5000] as $v): ?>
        <option value="<?= $v ?>" <?= ((int)($_GET['max_price'] ?? 0) === $v) ? 'selected' : '' ?>>ไม่เกิน <?= number_format($v) ?> บาท</option>
      <?php endforeach; ?>
    </select>
    <label><input type="checkbox" name="has_wifi" value="1" <?= !empty($_GET['has_wifi']) ? 'checked' : '' ?>> WiFi</label>
    <label><input type="checkbox" name="has_aircon" value="1" <?= !empty($_GET['has_aircon']) ? 'checked' : '' ?>> แอร์</label>
    <label><input type="checkbox" name="has_parking" value="1" <?= !empty($_GET['has_parking']) ? 'checked' : '' ?>> ที่จอดรถ</label>
    <button type="submit">ค้นหา</button>
  </form>
  <p id="count">พบ <?= count($dorms) ?> แห่ง</p>
  <section id="results" class="grid">
    <?php foreach ($dorms as $d): ?>
      <a class="card" href="dorm.php?id=<?= (int)$d['id'] ?>">
        <h2><?= h($d['name']) ?></h2>
        <p class="area">📍 <?= h($d['area']) ?></p>
        <p class="price"><?= number_format($d['price']) ?> บาท/เดือน</p>
      </a>
    <?php endforeach; ?>
  </section>
</main>
<script type="module" src="assets/js/search.js"></script>
</body>
</html>
