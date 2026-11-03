<?php

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $path = __DIR__ . '/../data/dorm.sqlite';
        $isNew = !file_exists($path);
        $pdo = new PDO('sqlite:' . $path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        if ($isNew) {
            $pdo->exec('CREATE TABLE dorms (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                area TEXT NOT NULL,
                price INTEGER NOT NULL,
                description TEXT,
                phone TEXT,
                has_wifi INTEGER DEFAULT 0,
                has_aircon INTEGER DEFAULT 0,
                has_parking INTEGER DEFAULT 0,
                image_url TEXT
            )');
            seed($pdo);
        }
    }
    return $pdo;
}

function seed(PDO $pdo): void {
    $rows = [
        ['บ้านสุขใจ', 'รามอินทรา', 3500, 'ห้องกว้าง ใกล้ MRT เดินไม่เกิน 5 นาที', '081-111-1111', 1, 1, 0],
        ['หอพักสบายดี', 'รามอินทรา', 4500, 'ห้องใหม่ มีเฟอร์นิเจอร์ครบ', '081-222-2222', 1, 1, 1],
        ['หอพักนักศึกษา A', 'ลาดพร้าว', 3000, 'ราคาประหยัด เหมาะกับนักศึกษา', '081-333-3333', 1, 0, 0],
        ['ลาดพร้าวเพลส', 'ลาดพร้าว', 5200, 'ใกล้ห้างและรถไฟฟ้า มีที่จอดรถ', '081-444-4444', 1, 1, 1],
        ['หอพักริมคลอง', 'บางเขน', 2800, 'เงียบสงบ ร่มรื่น', '081-555-5555', 0, 0, 1],
        ['บางเขนโฮม', 'บางเขน', 3900, 'ห้องแอร์ มี WiFi ฟรี', '081-666-6666', 1, 1, 0],
    ];
    $st = $pdo->prepare('INSERT INTO dorms (name, area, price, description, phone, has_wifi, has_aircon, has_parking) VALUES (?,?,?,?,?,?,?,?)');
    foreach ($rows as $r) $st->execute($r);
}

function h(?string $s): string {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}
